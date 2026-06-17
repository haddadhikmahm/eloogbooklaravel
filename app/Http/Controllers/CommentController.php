<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectComment;
use App\Models\Project;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'document_code' => 'required|string|max:255',
            'text' => 'required|string',
            'author_name' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:OPEN,CLOSE',
            'date' => 'nullable|date',
        ]);

        $project = \App\Models\Project::find(session('active_project_id')) ?? \App\Models\Project::first();
        $authorName = $request->author_name ?: 'Unknown';
        $initials = strtoupper(substr($authorName, 0, 2));

        ProjectComment::create([
            'project_id' => $project->id,
            'document_code' => $request->document_code,
            'text' => $request->text,
            'author_name' => $authorName,
            'author_initials' => $initials,
            'status' => $request->status ?? 'OPEN',
            'date' => $request->date ?? now(),
        ]);

        return redirect()->back()->with('success', 'Comment added.');
    }

    public function updateStatus(Request $request, ProjectComment $projectComment)
    {
        $request->validate([
            'status' => 'required|string|in:OPEN,CLOSE',
        ]);

        $projectComment->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Comment status updated.');
    }

    public function destroy(ProjectComment $projectComment)
    {
        $projectComment->delete();
        return redirect()->back()->with('success', 'Comment deleted.');
    }
}
