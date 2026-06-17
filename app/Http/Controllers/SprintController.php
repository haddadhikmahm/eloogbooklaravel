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

    public function storeNewSprint(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'goal' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'required|string',
        ]);

        $project = Project::first();

        \App\Models\Sprint::create([
            'project_id' => $project->id,
            'name' => $request->name,
            'goal' => $request->goal,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Sprint created successfully.');
    }

    public function storeSprintTask(Request $request, \App\Models\Sprint $sprint)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tag' => 'nullable|string|max:255',
            'assignee' => 'nullable|string|max:255',
            'points' => 'nullable|integer',
            'status' => 'required|string',
        ]);

        $project = Project::first();
        $taskCount = \App\Models\KanbanTask::where('project_id', $project->id)->count() + 1;

        \App\Models\KanbanTask::create([
            'project_id' => $project->id,
            'sprint_id' => $sprint->id,
            'title' => $request->title,
            'status' => $request->status,
            'task_code' => '#T-' . str_pad($taskCount, 2, '0', STR_PAD_LEFT),
            'tag' => $request->tag,
            'assignee' => $request->assignee,
            'points' => $request->points,
        ]);

        return redirect()->back()->with('success', 'Task added to sprint successfully.');
    }

    public function destroySprint(\App\Models\Sprint $sprint)
    {
        $sprint->delete();
        return redirect()->back()->with('success', 'Sprint deleted successfully.');
    }
}
