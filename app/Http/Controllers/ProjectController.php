<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:150'],
            'governorate'      => ['required', 'string', 'max:80'],
            'road_name'        => ['required', 'string', 'max:150'],
            'maintenance_date' => ['required', 'date'],
        ]);

        Project::create($validated);

        return redirect()
            ->route('projects.create')
            ->with('success', 'تم إنشاء المشروع بنجاح ✅');
    }
}
