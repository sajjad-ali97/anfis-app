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
        // 1) HTS (Var10)
        $hts = app(\App\Services\Anfis\HtsService::class)
            ->calculate((int) $validated['pavement_age'], $project->maintenance_date);
        $hts = 363;

        // 2) ترتيب 13 مدخل حسب Excel الر
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


        // 4) خزّنها بالسيشن واعمل redirect للنتائج
        session()->put("anfis.cost.project_{$project->id}", $cost);

        return redirect()->route('projects.results', $project);
    }

    public function results(Project $project)
    {
        $cost = session("anfis.cost.project_{$project->id}");

        return view('projects.results', compact('project', 'cost'));
    }
}
