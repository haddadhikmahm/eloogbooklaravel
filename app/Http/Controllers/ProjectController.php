<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
        ]);

        Project::create($validated);

        return back()->with('success', 'Project created successfully');
    }

    public function switch(Project $project)
    {
        session(['active_project_id' => $project->id]);
        return back()->with('success', 'Switched to project: ' . $project->name);
    }
}
