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

        // Fetch Sprints for the Jira-like UI
        $sprints = \App\Models\Sprint::with('tasks')->where('project_id', $project->id)->orderBy('start_date', 'desc')->get();

        return view('sprint', compact('project', 'backlogs', 'allBacklogs', 'sprints'));
    }

    public function kanban(Request $request)
    {
        $project = $this->getActiveProject();
        
        // Fetch active sprint
        $activeSprint = \App\Models\Sprint::with('tasks')
            ->where('project_id', $project->id)
            ->where('status', 'Active')
            ->orderBy('start_date', 'desc')
            ->first();

        // If no active sprint, just get the latest one
        if (!$activeSprint) {
            $activeSprint = \App\Models\Sprint::with('tasks')
                ->where('project_id', $project->id)
                ->orderBy('start_date', 'desc')
                ->first();
        }

        $query = KanbanTask::where('project_id', $project->id);
        
        // If there's an active sprint, we probably want to show its tasks, 
        // or all tasks if we filter by sprint. The image says "Filter by sprint ini".
        // Let's pass $activeSprint to the view.

        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $tasks = $query->with('sprint')->get();
        $kanbanBoards = \App\Models\KanbanBoard::where('project_id', $project->id)->orderBy('order')->get();
        return view('kanban', compact('project', 'tasks', 'kanbanBoards', 'activeSprint'));
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

        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('document_name', 'like', "%{$search}%")
                  ->orWhere('revision_code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('personnel_name', 'like', "%{$search}%");
            });
        }

        $revisions = $query->paginate(10)->withQueryString();
        $allRevisionsCount = ClientRevision::where('project_id', $project->id)->count();
        $openRevisionsCount = ClientRevision::where('project_id', $project->id)->where('status', 'Open')->count();
        $closeRevisionsCount = ClientRevision::where('project_id', $project->id)->where('status', 'Close')->count();

        return view('dashboard', compact(
            'project', 'revisions', 'allRevisionsCount', 'openRevisionsCount', 'closeRevisionsCount'
        ));
    }

    public function documents(Request $request)
    {
        $project = $this->getActiveProject();
        $query = ProjectDocument::where('project_id', $project->id);

        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }

        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%{$search}%");
        }
        
        $documents = $query->latest()->paginate(10)->withQueryString();

        $categories = ProjectDocument::where('project_id', $project->id)
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->get();

        return view('documents', compact('project', 'documents', 'categories'));
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

        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }

        $members = $query->paginate(10)->withQueryString();
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
        
        // Fetch historical data from database
        $progresses = \App\Models\ProjectProgress::where('project_id', $project->id)
            ->orderBy('order_index')
            ->get();

        // If empty (legacy project), seed it automatically
        if ($progresses->isEmpty()) {
            $monthsList = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $defaultPlanned = [0, 5, 12, 25, 45, 62, 75, 88, 95, 100, 100, 100];
            $defaultActual = [0, 3, 10, 20, 35, null, null, null, null, null, null, null];
            
            foreach ($monthsList as $i => $m) {
                \App\Models\ProjectProgress::create([
                    'project_id' => $project->id,
                    'period' => $m,
                    'order_index' => $i + 1,
                    'planned_percentage' => $defaultPlanned[$i],
                    'actual_percentage' => $defaultActual[$i]
                ]);
            }
            $progresses = \App\Models\ProjectProgress::where('project_id', $project->id)
                ->orderBy('order_index')
                ->get();
        }

        $months = $progresses->pluck('period')->toArray();
        $plannedData = $progresses->pluck('planned_percentage')->toArray();
        $actualDataDb = $progresses->pluck('actual_percentage')->toArray();
        
        // For the "Current" period, we want to inject the real-time $overallProgress.
        // We find the first null index, or if all are filled, the last index.
        $actualData = [];
        $currentInjected = false;
        foreach ($actualDataDb as $val) {
            if ($val === null && !$currentInjected) {
                $actualData[] = $overallProgress;
                $currentInjected = true;
            } else if ($val !== null) {
                $actualData[] = $val;
            }
        }
        
        // If it was fully populated without nulls, we update the very last one.
        if (!$currentInjected && count($actualData) > 0) {
            $actualData[count($actualData) - 1] = $overallProgress;
        }
        
        return view('scurve', compact('project', 'disciplines', 'months', 'plannedData', 'actualData'));
    }

    public function globalSearch(Request $request)
    {
        $project = $this->getActiveProject();
        $query = $request->query('q', '');
        
        if (empty(trim($query))) {
            return response()->json([]);
        }

        $results = [];

        // 1. Kanban Tasks
        $tasks = KanbanTask::where('project_id', $project->id)
            ->where('title', 'like', "%{$query}%")
            ->take(5)->get();
        foreach($tasks as $t) {
            $results[] = [
                'type' => 'Kanban Task',
                'title' => $t->title,
                'url' => route('dashboard.kanban', ['search' => $query]),
                'icon' => 'fa-tasks',
                'color' => 'text-blue-500'
            ];
        }

        // 2. Sprint Backlogs
        $sprints = SprintBacklog::where('project_id', $project->id)
            ->where(function($q) use ($query) {
                $q->where('drawings_title', 'like', "%{$query}%")
                  ->orWhere('personnel_name', 'like', "%{$query}%");
            })->take(5)->get();
        foreach($sprints as $s) {
            $results[] = [
                'type' => 'Sprint Backlog',
                'title' => $s->drawings_title,
                'url' => route('dashboard.sprint', ['search' => $query]),
                'icon' => 'fa-list-check',
                'color' => 'text-emerald-500'
            ];
        }

        // 3. Logbook / Revisions
        $revisions = ClientRevision::where('project_id', $project->id)
            ->where(function($q) use ($query) {
                $q->where('document_name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })->take(5)->get();
        foreach($revisions as $r) {
            $results[] = [
                'type' => 'Logbook / Revision',
                'title' => $r->document_name,
                'url' => route('dashboard.logbook', ['search' => $query]),
                'icon' => 'fa-book',
                'color' => 'text-orange-500'
            ];
        }

        // 4. Documents
        $docs = ProjectDocument::where('project_id', $project->id)
            ->where('title', 'like', "%{$query}%")
            ->take(5)->get();
        foreach($docs as $d) {
            $results[] = [
                'type' => 'Document',
                'title' => $d->title,
                'url' => route('dashboard.documents', ['search' => $query]),
                'icon' => 'fa-file-lines',
                'color' => 'text-indigo-500'
            ];
        }

        // 5. Team Members
        $members = ProjectMember::where('project_id', $project->id)
            ->where('name', 'like', "%{$query}%")
            ->take(5)->get();
        foreach($members as $m) {
            $results[] = [
                'type' => 'Team Member',
                'title' => $m->name,
                'url' => route('dashboard.team', ['search' => $query]),
                'icon' => 'fa-user',
                'color' => 'text-purple-500'
            ];
        }

        return response()->json($results);
    }

    public function comments(Request $request)
    {
        $project = $this->getActiveProject();
        $query = ProjectComment::where('project_id', $project->id);

        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('document_code', 'like', "%{$search}%")
                  ->orWhere('text', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%");
            });
        }

        $commentsList = $query->orderBy('date', 'desc')->paginate(10)->withQueryString();
        
        $openCommentsCount = ProjectComment::where('project_id', $project->id)->where('status', 'OPEN')->count();
        $closedCommentsCount = ProjectComment::where('project_id', $project->id)->where('status', 'CLOSE')->count();
        $totalCommentsCount = ProjectComment::where('project_id', $project->id)->count();

        return view('comments', compact('project', 'commentsList', 'openCommentsCount', 'closedCommentsCount', 'totalCommentsCount'));
    }
}
