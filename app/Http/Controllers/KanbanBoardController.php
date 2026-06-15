<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KanbanBoard;
use App\Models\Project;
use App\Models\KanbanTask;

class KanbanBoardController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $project = Project::find(session('active_project_id')) ?? Project::first();
        $maxOrder = KanbanBoard::where('project_id', $project->id)->max('order');

        KanbanBoard::create([
            'project_id' => $project->id,
            'name' => $request->name,
            'order' => $maxOrder !== null ? $maxOrder + 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Board created successfully.');
    }

    public function destroy(KanbanBoard $kanbanBoard)
    {
        // Delete all tasks associated with this board name
        KanbanTask::where('project_id', $kanbanBoard->project_id)
                  ->where('status', $kanbanBoard->name)
                  ->delete();

        $kanbanBoard->delete();

        return redirect()->back()->with('success', 'Board and its tasks deleted.');
    }

    public function move(Request $request, KanbanBoard $kanbanBoard)
    {
        $request->validate([
            'direction' => 'required|in:left,right',
        ]);

        $project_id = $kanbanBoard->project_id;
        $currentOrder = $kanbanBoard->order;

        if ($request->direction === 'left') {
            $swapBoard = KanbanBoard::where('project_id', $project_id)
                                    ->where('order', '<', $currentOrder)
                                    ->orderBy('order', 'desc')
                                    ->first();
        } else {
            $swapBoard = KanbanBoard::where('project_id', $project_id)
                                    ->where('order', '>', $currentOrder)
                                    ->orderBy('order', 'asc')
                                    ->first();
        }

        if ($swapBoard) {
            $kanbanBoard->update(['order' => $swapBoard->order]);
            $swapBoard->update(['order' => $currentOrder]);
            return redirect()->back()->with('success', 'Board moved successfully.');
        }

        return redirect()->back()->with('error', 'Cannot move board further.');
    }
}
