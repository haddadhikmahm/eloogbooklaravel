<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\ClientRevision;
use App\Models\KanbanTask;
use App\Models\SprintBacklog;
use App\Models\ProjectDocument;
use App\Models\ProjectMember;
use App\Models\ProjectComment;

class DashboardController extends Controller
{
    private function getActiveProject()
    {
        return Project::find(session('active_project_id')) ?? Project::first();
    }

    public function index()
    {
        $project = $this->getActiveProject();
        
        // Dynamic stats
        $totalDocuments = ProjectDocument::where('project_id', $project->id)->count();
        $waitingReview = ClientRevision::where('project_id', $project->id)->where('status', 'Open')->count();
        $openCommentsCount = ProjectComment::where('project_id', $project->id)->where('status', 'OPEN')->count();
        
        $comments = ProjectComment::where('project_id', $project->id)->orderBy('date', 'desc')->take(5)->get();

        // Progress per Discipline
        $disciplines = SprintBacklog::selectRaw('
            discipline,
            COUNT(*) as total_docs,
            SUM(CASE WHEN status = "Done" THEN 1 ELSE 0 END) as done_docs
        ')->where('project_id', $project->id)
          ->groupBy('discipline')
          ->get()
          ->map(function ($item) {
              $item->percentage = $item->total_docs > 0 ? round(($item->done_docs / $item->total_docs) * 100) : 0;
              return $item;
          });

        return view('main', compact(
            'project', 'comments', 'totalDocuments', 'waitingReview', 'openCommentsCount', 'disciplines'
        ));
    }

    public function sprint(Request $request)
    {
        $project = $this->getActiveProject();
        $query = SprintBacklog::where('project_id', $project->id);

        if ($search = $request->query('search')) {
            $query->where('drawings_title', 'like', "%{$search}%")
                  ->orWhere('discipline', 'like', "%{$search}%")
                  ->orWhere('personnel_name', 'like', "%{$search}%");
        }

        $backlogs = $query->paginate(10)->withQueryString();
        
        // Calculate totals for Goal Block
        $allBacklogs = SprintBacklog::where('project_id', $project->id)->get();

        return view('sprint', compact('project', 'backlogs', 'allBacklogs'));
    }

    public function kanban(Request $request)
    {
        $project = $this->getActiveProject();
        $query = KanbanTask::where('project_id', $project->id);

        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $tasks = $query->get();
        $kanbanBoards = \App\Models\KanbanBoard::where('project_id', $project->id)->orderBy('order')->get();
        return view('kanban', compact('project', 'tasks', 'kanbanBoards'));
    }

    public function logbook(Request $request)
    {
        $project = $this->getActiveProject();
        $query = ClientRevision::where('project_id', $project->id);

        if ($status = $request->query('status')) {
            if (strtolower($status) !== 'all') {
                $query->where('status', $status);
            }
        }

        $revisions = $query->paginate(10)->withQueryString();
        $allRevisionsCount = ClientRevision::where('project_id', $project->id)->count();
        $openRevisionsCount = ClientRevision::where('project_id', $project->id)->where('status', 'Open')->count();
        $closeRevisionsCount = ClientRevision::where('project_id', $project->id)->where('status', 'Close')->count();

        return view('dashboard', compact(
            'project', 'revisions', 'allRevisionsCount', 'openRevisionsCount', 'closeRevisionsCount'
        ));
    }

    public function documents()
    {
        $project = $this->getActiveProject();
        $documents = ProjectDocument::where('project_id', $project->id)->get();
        return view('documents', compact('project', 'documents'));
    }

    public function team(Request $request)
    {
        $project = $this->getActiveProject();
        $query = ProjectMember::where('project_id', $project->id);

        if ($discipline = $request->query('discipline')) {
            if (strtolower($discipline) !== 'all personnel') {
                $query->where('discipline', $discipline);
            }
        }

        $members = $query->get();
        return view('team', compact('project', 'members'));
    }

    public function scurve()
    {
        $project = $this->getActiveProject();
        
        // Progress per Discipline (reuse calculation)
        $disciplines = SprintBacklog::selectRaw('
            discipline,
            COUNT(*) as total_docs,
            SUM(CASE WHEN status = "Done" THEN 1 ELSE 0 END) as done_docs
        ')->where('project_id', $project->id)
          ->groupBy('discipline')
          ->get()
          ->map(function ($item) {
              $item->percentage = $item->total_docs > 0 ? round(($item->done_docs / $item->total_docs) * 100) : 0;
              return $item;
          });

        // Calculate overall percentage based on disciplines if not set
        $totalDocs = $disciplines->sum('total_docs');
        $doneDocs = $disciplines->sum('done_docs');
        $overallProgress = $totalDocs > 0 ? round(($doneDocs / $totalDocs) * 100) : ($project->completion_percentage ?? 0);
        $project->completion_percentage = $overallProgress;
        
        // Mock data for S-Curve Chart
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $plannedData = [0, 5, 12, 25, 45, 62, 75, 88, 95, 100, 100, 100];
        
        // Actual data up to current progress
        $actualData = [0, 3, 10, 20, 35, $overallProgress];
        
        return view('scurve', compact('project', 'disciplines', 'months', 'plannedData', 'actualData'));
    }
}
