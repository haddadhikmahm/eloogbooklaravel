<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KanbanTask;
use App\Models\Project;

class KanbanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        $project = Project::first();

        KanbanTask::create([
            'project_id' => $project->id,
            'title' => $request->title,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Task created successfully.');
    }

    public function updateStatus(Request $request, KanbanTask $kanbanTask)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $kanbanTask->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Task status updated.');
    }

    public function destroy(KanbanTask $kanbanTask)
    {
        $kanbanTask->delete();
        return redirect()->back()->with('success', 'Task deleted.');
    }
}
