<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SprintBacklog;
use App\Models\Project;

class SprintController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'drawings_title' => 'required|string|max:255',
            'discipline' => 'required|string|max:255',
            'personnel_name' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'status' => 'required|string|in:To Do,Progress,Review,Done',
        ]);

        $project = Project::first();

        SprintBacklog::create([
            'project_id' => $project->id,
            'drawings_title' => $request->drawings_title,
            'discipline' => $request->discipline,
            'personnel_name' => $request->personnel_name,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Backlog created successfully.');
    }

    public function updateStatus(Request $request, SprintBacklog $sprintBacklog)
    {
        $request->validate([
            'status' => 'required|string|in:To Do,Progress,Review,Done',
        ]);

        $sprintBacklog->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Backlog status updated.');
    }

    public function destroy(SprintBacklog $sprintBacklog)
    {
        $sprintBacklog->delete();
        return redirect()->back()->with('success', 'Backlog deleted.');
    }
}
