<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
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

        return redirect()
            ->route('projects.inputs.create', $project)
            ->with('success', __('ui.inputs_saved_temp'));
    }
}
