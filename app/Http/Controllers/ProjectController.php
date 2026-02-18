<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectInputsRequest;
use App\Http\Requests\StoreProjectRequest;

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

        // حالياً: حفظ مؤقت بالسيشن (حسب اتفاقنا)
        session()->put("anfis.inputs.project_{$project->id}", $validated);

        // 1) HtsService استخراج عدد الايام التي حرارتها اعلى من 40 من خلال عمر الطريق باستخدام
        $hts = app(\App\Services\Anfis\HtsService::class)
            ->calculate((int) $validated['pavement_age'], $project->maintenance_date);
        $hts = 363;

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



        return redirect()->route('projects.results', $project);
    }

    public function results(Project $project)
    {
        $cost = session("anfis.cost.project_{$project->id}");

        return view('projects.results', compact('project', 'cost'));
    }
}
