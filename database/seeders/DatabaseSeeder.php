<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\ClientRevision;
use App\Models\KanbanTask;
use App\Models\SprintBacklog;
use App\Models\ProjectDocument;
use App\Models\ProjectMember;
use App\Models\ProjectComment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::factory()->create([
            'name' => 'Admin Eloogbook',
            'email' => 'admin@eloogbook.com',
            'password' => bcrypt('password'),
        ]);

        // Create some additional random users
        User::factory(5)->create();

        // Create 1 main project that matches the previous template exactly
        $project = Project::factory()->create([
            'code' => '5197',
            'name' => 'DED Coal Terminal - Kalimantan Timur',
            'type' => 'Detailed Engineering Design',
        ]);

        // Create related data for the project using factories
        ClientRevision::factory(30)->create(['project_id' => $project->id]);
        KanbanTask::factory(15)->create(['project_id' => $project->id]);
        SprintBacklog::factory(12)->create(['project_id' => $project->id]);
        ProjectDocument::factory(10)->create(['project_id' => $project->id]);
        ProjectMember::factory(8)->create(['project_id' => $project->id]);
        ProjectComment::factory(15)->create(['project_id' => $project->id]);
        
        // Optionally create more random projects to populate other pages
        Project::factory(3)->create()->each(function ($p) {
            ClientRevision::factory(10)->create(['project_id' => $p->id]);
            KanbanTask::factory(8)->create(['project_id' => $p->id]);
            SprintBacklog::factory(5)->create(['project_id' => $p->id]);
            ProjectDocument::factory(5)->create(['project_id' => $p->id]);
            ProjectMember::factory(4)->create(['project_id' => $p->id]);
            ProjectComment::factory(5)->create(['project_id' => $p->id]);
        });
    }
}
