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
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|string|max:255',
        ]);

        $projectId = session('active_project_id');
        $project = $projectId ? Project::find($projectId) : Project::first();
        
        $file = $request->file('document');

        $path = $file->store('documents', 'public');
        
        $title = $request->title ?: $file->getClientOriginalName();
        $type = strtoupper($file->getClientOriginalExtension());
        $sizeBytes = $file->getSize();
        $sizeMb = round($sizeBytes / 1024 / 1024, 2);
        $sizeStr = $sizeMb . ' MB';
        if ($sizeBytes < 1048576) {
            $sizeStr = round($sizeBytes / 1024, 0) . ' KB';
        }

        ProjectDocument::create([
            'project_id' => $project->id,
            'category' => $request->category ?? 'Supporting Documents',
            'title' => $title,
            'description' => $request->description,
            'tags' => $request->tags,
            'file_type' => $type ?: 'FILE',
            'file_size' => $sizeStr,
            'file_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Document uploaded successfully.');
    }

    public function destroy(ProjectDocument $projectDocument)
    {
        if ($projectDocument->file_path && \Storage::disk('public')->exists($projectDocument->file_path)) {
            \Storage::disk('public')->delete($projectDocument->file_path);
        }
        $projectDocument->delete();
        return redirect()->back()->with('success', 'Document deleted.');
    }

    public function download(ProjectDocument $projectDocument)
    {
        if ($projectDocument->file_path && \Storage::disk('public')->exists($projectDocument->file_path)) {
            $extension = strtolower($projectDocument->file_type);
            $downloadName = $projectDocument->title;
            if ($extension && $extension !== 'file' && !str_ends_with(strtolower($downloadName), '.' . $extension)) {
                $downloadName .= '.' . $extension;
            }
            return response()->download(storage_path('app/public/' . $projectDocument->file_path), $downloadName);
        }
        return redirect()->back()->with('error', 'File not found.');
    }
}
