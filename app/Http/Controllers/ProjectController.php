<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Project;
use App\Http\Requests\StoreProjectInputsRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Models\CalculationGauge;
use App\Models\Calculation;
use App\Models\CalculationSensitivity;
use App\Models\CalculationExplanation;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class ProjectController extends Controller
{


    public function index()
    {
        $projects = Project::query()
            ->latest('id')
            ->get();

        return view('pages.projects', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());

        return redirect()
            ->route('projects.inputs.create', $project)
            ->with('success', __('ui.project_created_success'));
    }
    public function inputsCreate(Project $project)
    {
        return view('projects.inputs', compact('project'));
    }

    public function inputsStore(StoreProjectInputsRequest $request, Project $project)
    {
        $validated = $request->validated();


        // 1) HtsService استخراج عدد الايام التي حرارتها اعلى من 40 من خلال عمر الطريق باستخدام
        // $hts = app(\App\Services\Anfis\HtsService::class)
        //     ->calculate((int) $validated['pavement_age'], $project->maintenance_date);
        $hts = 581;

        // 2) ترتيب المدخلات من الفورم بحسب الترتيب الاساسي لمنطق الحساب ماتلاب
        $ordered13 = [
            (float) $validated['pavement_area'],      // Var1
            (int)   $validated['pavement_age'],       // Var2
            (int)   $validated['road_condition'],     // Var3
            (float) $validated['asphalt_thickness'],  // Var4
            (int)   $validated['pavement_type'],      // Var5
            (int)   $validated['maintenance_type'],   // Var6
            (int)   $validated['traffic_volume'],     // Var7
            (int)   $validated['aadt_heavy'],         // Var8
            (int)   $validated['road_class'],         // Var9
            (float) $hts,                             // Var10 (HTS/CTS)
            (int)   $validated['soil_strength'],      // Var11
            (int)   $validated['median_islands'],     // Var12
            (int)   $validated['drainage_system'],    // Var13
        ];

        // 3) حساب الكلفة
        $cost = app(\App\Services\Anfis\AnfisService::class)->predictCost($ordered13);

        // 4) تنفيذ الحسابات الي يحتاجها الكيج
        $gauge = app(\App\Services\Anfis\CostGaugeService::class)
            ->evaluate($cost, $validated['pavement_area']);



        // 4) خزّنها بالسيشن واعمل redirect للنتائج
        session()->put("anfis.cost.project_{$project->id}", $cost);

        //5) تحديد نسبة تاثير المدخلات السبعة على الكلفة النهائية
        $featureIndexes = [
            'pavement_area'     => 0,
            'pavement_age'      => 1,
            'road_condition'    => 2,
            'asphalt_thickness' => 3,
            'pavement_type'     => 4,
            'maintenance_type'  => 5,
            'traffic_volume'    => 6,
            'aadt_heavy'        => 7,
            'hts'               => 9,
            'soil_strength'     => 10,
        ];


        $sensitivity = app(\App\Services\XAI\SensitivityService::class)
            ->analyze($ordered13, $featureIndexes);

        //6) استخراج الاسباب نصيا وتوليدها
        $inputsAssoc = [
            'pavement_area'     => $ordered13[0],
            'pavement_age'      => (int)$ordered13[1],
            'road_condition'    => (int)$ordered13[2],
            'asphalt_thickness' => $ordered13[3],
            'pavement_type'     => (int)$ordered13[4],
            'maintenance_type'  => (int)$ordered13[5],
            'traffic_volume'    => (int)$ordered13[6],
            'aadt_heavy'        => (int)$ordered13[7],
            'hts'               => $ordered13[9],
            'soil_strength'     => (int)$ordered13[10],
        ];
        $explanation = app(\App\Services\XAI\ExplanationService::class)
            ->generate($gauge, $sensitivity, $inputsAssoc);

        // ===================================================================================


        //7) خزّن calculation

        $calculation = Calculation::create([

            'project_id' => $project->id,

            'pavement_area_m2'      => $validated['pavement_area'],
            'pavement_age_code'     => $validated['pavement_age'],
            'pci_code'              => $validated['road_condition'],
            'asphalt_thickness_cm'  => $validated['asphalt_thickness'],
            'pavement_type_code'    => $validated['pavement_type'],
            'maintenance_type_code' => $validated['maintenance_type'],
            'aadt_code'             => $validated['traffic_volume'],
            'aadt_heavy_code'       => $validated['aadt_heavy'],
            'road_class_code'       => $validated['road_class'],
            'hts_days_over_45'      => $hts,
            'soil_strength_code'    => $validated['soil_strength'],
            'median_islands'        => $validated['median_islands'],
            'drainage_system'       => $validated['drainage_system'],

            'estimated_cost'        => (int) round($cost),
        ]);


        //8) خزّن الكيج

        CalculationGauge::create([

            'calculation_id' => $calculation->id,

            'a' => $gauge->a,

            'label_key' => $gauge->label_key,
            'label'     => $gauge->label, // اختياري

            'range_min'   => $gauge->range_used['min'],
            'range_max'   => $gauge->range_used['max'],
            'range_color' => $gauge->range_used['color'],

            'min' => $gauge->min,
            'max' => $gauge->max,

            'ranges_json' => $gauge->ranges,
        ]);

        //9)خزّن الحساسية
        CalculationSensitivity::create([
            'calculation_id' => $calculation->id,
            'bar_data' => $sensitivity->bar_data,
            'debug_payload' => $sensitivity->debug_payload,
            'top_n' => config('sensitivity.top_n'),
            'perturb_percent' => config('sensitivity.continuous_perturbation_percent'),
        ]);

        //9)خزّن الاسباب
        CalculationExplanation::create([
            'calculation_id' => $calculation->id,
            'summary_ar' => $explanation->summary_ar,
            'summary_en' => $explanation->summary_en,
            'reasons_ar' => $explanation->reasons_ar,
            'reasons_en' => $explanation->reasons_en,
            'debug_payload' => $explanation->debug_payload,
        ]);


        return redirect()->route('projects.results', $calculation);
    }

    public function results(Calculation $calculation)
    {
        $calculation->load([
            'project',
            'gauge',
            'sensitivity',
            'explanation'
        ]);

        return view('projects.results', compact('calculation'));
    }
    public function report(Project $project)
    {
        $isAr = app()->getLocale() === 'ar';

        // آخر Calculation فقط + العلاقات
        $calculation = $project->latestCalculation()
            ->with(['gauge', 'sensitivity', 'explanation'])
            ->firstOrFail();

        // Labels (تحويل الأكواد إلى نصوص)
        $labels = $this->labels($isAr);

        $inputsTable = $this->buildInputsTable($calculation, $labels, $isAr);

        // ====== Gauge ======
        $gauge = $calculation->gauge;
        $gaugeRanges = $gauge?->ranges_json ?? [];
        $aValue = (float)($gauge?->a ?? 0);
        $gMin = (int)($gauge?->min ?? 0);
        $gMax = (int)($gauge?->max ?? 100);

        // ====== Bar chart ======
        $barData = $calculation->sensitivity?->bar_data ?? [];

        // ضمان ترتيب تنازلي حسب impact_percent
        usort($barData, fn($a, $b) => (float)($b['impact_percent'] ?? 0) <=> (float)($a['impact_percent'] ?? 0));

        $barLabels = array_map(
            fn($r) => $isAr ? ($r['label_ar'] ?? $r['key'] ?? '-') : ($r['label_en'] ?? $r['key'] ?? '-'),
            $barData
        );
        $barValues = array_map(fn($r) => (float)($r['impact_percent'] ?? 0), $barData);

        $topOne = $barData[0] ?? null;

        return view('projects.report', compact(
            'project',
            'calculation',
            'inputsTable',
            'gauge',
            'gaugeRanges',
            'aValue',
            'gMin',
            'gMax',
            'barLabels',
            'barValues',
            'topOne',
            'isAr'
        ));
    }


    public function reportPdf(Request $request, Project $project)
    {
        $isAr = app()->getLocale() === 'ar';

        $calculation = $project->latestCalculation()
            ->with(['gauge', 'sensitivity', 'explanation'])
            ->firstOrFail();

        // صور Plotly المرسلة من الصفحة (data-uri)
        $gaugePng = (string) $request->input('gauge_png', '');
        $barPng   = (string) $request->input('bar_png', '');

        // ✅ Fallback فقط: إذا مو JPEG نحوله (حتى ما نستهلك السيرفر بدون داعي)
        $gaugePng = $this->ensureJpegDataUri($gaugePng);
        $barPng   = $this->ensureJpegDataUri($barPng);

        $labels = $this->labels($isAr);
        $inputsTable = $this->buildInputsTable($calculation, $labels, $isAr);

        $summary = $isAr
            ? ($calculation->explanation?->summary_ar ?? '')
            : ($calculation->explanation?->summary_en ?? '');

        $reasons = $isAr
            ? ($calculation->explanation?->reasons_ar ?? [])
            : ($calculation->explanation?->reasons_en ?? []);

        if (!is_array($reasons)) $reasons = [];

        $barData = $calculation->sensitivity?->bar_data ?? [];
        usort($barData, fn($a, $b) => (float)($b['impact_percent'] ?? 0) <=> (float)($a['impact_percent'] ?? 0));

        $topOne = $barData[0] ?? null;
        $topLabel = $topOne
            ? ($isAr ? ($topOne['label_ar'] ?? $topOne['key'] ?? '-') : ($topOne['label_en'] ?? $topOne['key'] ?? '-'))
            : null;

        $topPct = $topOne ? (float)($topOne['impact_percent'] ?? 0) : null;

        $data = [
            'project' => $project,
            'calculation' => $calculation,
            'inputsTable' => $inputsTable,
            'isAr' => $isAr,
            'reportDate' => now(),

            'summary' => $summary,
            'reasons' => $reasons,

            'topLabel' => $topLabel,
            'topPct' => $topPct,

            'gaugePng' => $gaugePng,
            'barPng' => $barPng,
        ];

        $html = view('projects.report_pdf', $data)->render();

        $mpdf = $this->makeMpdf($isAr);
        $mpdf->WriteHTML($html);

        $name = 'ANFIS-Report-Project-' . $project->id . '.pdf';

        return response($mpdf->Output($name, 'S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $name . '"');
    }


    private function ensureJpegDataUri(string $dataUri): string
    {
        $dataUri = trim($dataUri);

        if ($dataUri === '') return '';

        // إذا أصلاً JPEG، لا تسوي شي (أفضل أداء)
        if (str_starts_with($dataUri, 'data:image/jpeg;base64,') || str_starts_with($dataUri, 'data:image/jpg;base64,')) {
            return $dataUri;
        }

        // إذا PNG نحوله إلى JPEG (حل مشكلة alpha)
        if (str_starts_with($dataUri, 'data:image/png;base64,')) {
            return $this->convertPngDataUriToJpeg($dataUri);
        }

        // إذا WebP (أحياناً بعض البيئات) نحوله كذلك
        if (str_starts_with($dataUri, 'data:image/webp;base64,')) {
            return $this->convertImageDataUriToJpeg($dataUri);
        }

        // أي نوع آخر: جرّب تحويل عام (إذا فشل يرجّعه مثل ما هو)
        return $this->convertImageDataUriToJpeg($dataUri);
    }

    private function convertPngDataUriToJpeg(string $dataUri, int $quality = 92): string
    {
        if (!str_starts_with($dataUri, 'data:image/png;base64,')) {
            return $dataUri;
        }

        $base64 = substr($dataUri, strlen('data:image/png;base64,'));
        $binary = base64_decode($base64);
        if ($binary === false) return $dataUri;

        $img = @imagecreatefromstring($binary);
        if (!$img) return $dataUri;

        $w = imagesx($img);
        $h = imagesy($img);

        // إزالة الشفافية بخلفية بيضاء
        $bg = imagecreatetruecolor($w, $h);
        $white = imagecolorallocate($bg, 255, 255, 255);
        imagefill($bg, 0, 0, $white);
        imagecopy($bg, $img, 0, 0, 0, 0, $w, $h);

        ob_start();
        imagejpeg($bg, null, $quality);
        $jpgBinary = ob_get_clean();

        imagedestroy($img);
        imagedestroy($bg);

        if (!$jpgBinary) return $dataUri;

        return 'data:image/jpeg;base64,' . base64_encode($jpgBinary);
    }

    private function convertImageDataUriToJpeg(string $dataUri, int $quality = 92): string
    {
        // data:[mime];base64,....
        if (!str_starts_with($dataUri, 'data:image/') || !str_contains($dataUri, ';base64,')) {
            return $dataUri;
        }

        [$meta, $b64] = explode(',', $dataUri, 2) + [null, null];
        if (!$b64) return $dataUri;

        $binary = base64_decode($b64);
        if ($binary === false) return $dataUri;

        $img = @imagecreatefromstring($binary);
        if (!$img) return $dataUri;

        $w = imagesx($img);
        $h = imagesy($img);

        $bg = imagecreatetruecolor($w, $h);
        $white = imagecolorallocate($bg, 255, 255, 255);
        imagefill($bg, 0, 0, $white);
        imagecopy($bg, $img, 0, 0, 0, 0, $w, $h);

        ob_start();
        imagejpeg($bg, null, $quality);
        $jpgBinary = ob_get_clean();

        imagedestroy($img);
        imagedestroy($bg);

        if (!$jpgBinary) return $dataUri;

        return 'data:image/jpeg;base64,' . base64_encode($jpgBinary);
    }

    // =============================
    // Helpers
    // =============================

    private function makeMpdf(bool $isAr): Mpdf
    {
        // mPDF temp dir (مهم لويندوز)
        $tempDir = storage_path('app/mpdf');
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0775, true);
        }

        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $fontsPath = resource_path('fonts');

        // تحقق من وجود الخطوط
        if (!File::exists($fontsPath . DIRECTORY_SEPARATOR . 'Cairo-Regular.ttf')) {
            abort(500, "Cairo-Regular.ttf not found in: {$fontsPath}");
        }
        if (!File::exists($fontsPath . DIRECTORY_SEPARATOR . 'Cairo-Bold.ttf')) {
            abort(500, "Cairo-Bold.ttf not found in: {$fontsPath}");
        }

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'tempDir' => $tempDir,

            'fontDir' => array_merge($fontDirs, [$fontsPath]),
            'fontdata' => $fontData + [
                'cairo' => [
                    'R' => 'Cairo-Regular.ttf',
                    'B' => 'Cairo-Bold.ttf',
                ],
            ],
            'default_font' => 'cairo',
            'default_font_size' => 11,

            'autoScriptToLang' => true,
            'autoLangToFont' => true,

            // margins
            'margin_left' => 12,
            'margin_right' => 12,
            'margin_top' => 12,
            'margin_bottom' => 12,

            // for embedded base64 images
            'showImageErrors' => true,
        ]);

        if ($isAr) {
            $mpdf->SetDirectionality('rtl');
        }

        return $mpdf;
    }

    private function buildInputsTable($calculation, array $labels, bool $isAr): array
    {
        return [
            ['label' => $isAr ? 'مساحة الرصف (م²)' : 'Pavement Area (m²)',      'value' => number_format((float)$calculation->pavement_area_m2, 2)],
            ['label' => $isAr ? 'عمر الرصف' : 'Pavement Age',                    'value' => $labels['pavement_age'][$calculation->pavement_age_code] ?? $calculation->pavement_age_code],
            ['label' => $isAr ? 'حالة الطريق (PCI)' : 'Road Condition (PCI)',    'value' => $labels['pci'][$calculation->pci_code] ?? $calculation->pci_code],
            ['label' => $isAr ? 'سمك الأسفلت (سم)' : 'Asphalt Thickness (cm)',   'value' => number_format((float)$calculation->asphalt_thickness_cm, 2)],
            ['label' => $isAr ? 'نوع الرصف' : 'Pavement Type',                   'value' => $labels['pavement_type'][$calculation->pavement_type_code] ?? $calculation->pavement_type_code],
            ['label' => $isAr ? 'نوع الصيانة' : 'Maintenance Type',              'value' => $labels['maintenance'][$calculation->maintenance_type_code] ?? $calculation->maintenance_type_code],
            ['label' => $isAr ? 'حجم المرور (AADT)' : 'Traffic Volume (AADT)',   'value' => $labels['aadt'][$calculation->aadt_code] ?? $calculation->aadt_code],
            ['label' => $isAr ? 'مرور الشاحنات الثقيلة' : 'AADT Heavy',          'value' => $labels['aadt_heavy'][$calculation->aadt_heavy_code] ?? $calculation->aadt_heavy_code],
            ['label' => $isAr ? 'تصنيف الطريق' : 'Road Class',                   'value' => $labels['road_class'][$calculation->road_class_code] ?? $calculation->road_class_code],
            ['label' => $isAr ? 'HTS (أيام > 45°C)' : 'HTS (days > 45°C)',       'value' => (int)$calculation->hts_days_over_45],
            ['label' => $isAr ? 'قوة التربة' : 'Soil Strength',                  'value' => $labels['soil'][$calculation->soil_strength_code] ?? $calculation->soil_strength_code],
            ['label' => $isAr ? 'جزر وسطية' : 'Median Islands',                  'value' => $labels['yesno'][$calculation->median_islands] ?? $calculation->median_islands],
            ['label' => $isAr ? 'نظام تصريف' : 'Drainage System',                'value' => $labels['yesno'][$calculation->drainage_system] ?? $calculation->drainage_system],
        ];
    }

    private function labels(bool $isAr): array
    {
        return [
            'pavement_age' => $isAr
                ? [1 => 'جديد', 2 => 'متوسط', 3 => 'قديم']
                : [1 => 'New', 2 => 'Medium', 3 => 'Old'],

            'pci' => $isAr
                ? [1 => 'مقبول', 2 => 'سيء', 3 => 'سيء جداً']
                : [1 => 'Fair', 2 => 'Poor', 3 => 'Very Poor'],

            'pavement_type' => $isAr
                ? [1 => 'أسفلت', 2 => 'مزيج']
                : [1 => 'Asphalt', 2 => 'Mix'],

            'maintenance' => $isAr
                ? [1 => 'وقائية', 2 => 'اعتيادية', 3 => 'طارئة']
                : [1 => 'Preventive', 2 => 'Routine', 3 => 'Emergency'],

            'aadt' => $isAr
                ? [1 => 'منخفض', 2 => 'متوسط', 3 => 'مرتفع']
                : [1 => 'Low', 2 => 'Medium', 3 => 'High'],

            'aadt_heavy' => $isAr
                ? [1 => 'منخفض', 2 => 'متوسط', 3 => 'مرتفع']
                : [1 => 'Low', 2 => 'Medium', 3 => 'High'],

            'road_class' => $isAr
                ? [1 => 'رئيسي', 2 => 'ثانوي']
                : [1 => 'Main', 2 => 'Secondary'],

            'soil' => $isAr
                ? [1 => 'ضعيفة', 2 => 'متوسطة', 3 => 'قوية']
                : [1 => 'Weak', 2 => 'Medium', 3 => 'Strong'],

            'yesno' => $isAr
                ? [0 => 'لا', 1 => 'نعم']
                : [0 => 'No', 1 => 'Yes'],
        ];
    }
}
