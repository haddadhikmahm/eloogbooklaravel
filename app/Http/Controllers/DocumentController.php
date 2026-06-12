<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDocument;
use App\Models\Project;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|file|max:10240', // 10MB max
            'category' => 'nullable|string|max:255',
        ]);

        $project = Project::first();
        $file = $request->file('document');

        // Simple mock of file upload for this prototype
        // In reality you would use $file->store('documents')
        
        $title = $file->getClientOriginalName();
        $type = strtoupper($file->getClientOriginalExtension());
        $sizeBytes = $file->getSize();
        $sizeMb = round($sizeBytes / 1024 / 1024, 1);
        $sizeStr = $sizeMb . ' MB';

        ProjectDocument::create([
            'project_id' => $project->id,
            'category' => $request->category ?? 'Supporting Documents',
            'title' => $title,
            'file_type' => $type ?: 'FILE',
            'file_size' => $sizeStr,
        ]);

        return redirect()->back()->with('success', 'Document uploaded successfully.');
    }

    public function destroy(ProjectDocument $projectDocument)
    {
        $projectDocument->delete();
        return redirect()->back()->with('success', 'Document deleted.');
    }
}
