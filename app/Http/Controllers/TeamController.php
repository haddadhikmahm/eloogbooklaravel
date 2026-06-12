<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectMember;
use App\Models\Project;

class TeamController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'discipline' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'access_level' => 'required|string|in:Full Access,Edit & Upload,View Only',
        ]);

        $project = Project::first();
        
        $words = explode(' ', $request->name);
        $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
        
        // Random color
        $colors = ['#008DDF', '#1B9934', '#FFA600', '#D32F2F', '#7E57C2'];
        $color = $colors[array_rand($colors)];

        ProjectMember::create([
            'project_id' => $project->id,
            'name' => $request->name,
            'email' => $request->email,
            'initials' => $initials,
            'color_hex' => $color,
            'discipline' => $request->discipline,
            'role' => $request->role,
            'access_level' => $request->access_level,
            'active_documents' => 0,
        ]);

        // Increment count
        $project->increment('personnel_count');

        return redirect()->back()->with('success', 'Member added.');
    }

    public function destroy(ProjectMember $projectMember)
    {
        $project = Project::find($projectMember->project_id);
        $projectMember->delete();
        
        if ($project) {
            $project->decrement('personnel_count');
        }

        return redirect()->back()->with('success', 'Member deleted.');
    }
}
