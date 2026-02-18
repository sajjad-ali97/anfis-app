<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectInputsRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Models\CalculationGauge;
use App\Models\Calculation;
use App\Models\CalculationSensitivity;
use App\Models\CalculationExplanation;

class ProjectController extends Controller
{
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
        $hts = app(\App\Services\Anfis\HtsService::class)
            ->calculate((int) $validated['pavement_age'], $project->maintenance_date);
        // $hts = 363;

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
}
