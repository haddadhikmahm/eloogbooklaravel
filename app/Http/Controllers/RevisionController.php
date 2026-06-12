<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientRevision;
use App\Models\Project;

class RevisionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'document_name' => 'required|string|max:255',
            'revision_code' => 'required|string|max:50',
            'description' => 'required|string',
            'personnel_name' => 'required|string|max:255',
            'status' => 'required|string|in:Open,Close',
        ]);

        $project = Project::first();

        ClientRevision::create([
            'project_id' => $project->id,
            'date' => $request->date,
            'document_name' => $request->document_name,
            'revision_code' => $request->revision_code,
            'description' => $request->description,
            'personnel_name' => $request->personnel_name,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Revision created successfully.');
    }

    public function updateStatus(Request $request, ClientRevision $clientRevision)
    {
        $request->validate([
            'status' => 'required|string|in:Open,Close',
        ]);

        $clientRevision->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Revision status updated.');
    }

    public function destroy(ClientRevision $clientRevision)
    {
        $clientRevision->delete();
        return redirect()->back()->with('success', 'Revision deleted.');
    }
}
