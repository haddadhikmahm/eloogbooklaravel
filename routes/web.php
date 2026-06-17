<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\RevisionController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\KanbanBoardController;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'processForgotPassword'])->name('password.email');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/sprint', [DashboardController::class, 'sprint'])->name('dashboard.sprint');
    Route::get('/kanban', [DashboardController::class, 'kanban'])->name('dashboard.kanban');
    Route::get('/logbook', [DashboardController::class, 'logbook'])->name('dashboard.logbook');
    Route::get('/documents', [DashboardController::class, 'documents'])->name('dashboard.documents');
    Route::get('/team', [DashboardController::class, 'team'])->name('dashboard.team');
    Route::get('/scurve', [DashboardController::class, 'scurve'])->name('dashboard.scurve');
    Route::get('/comments', [DashboardController::class, 'comments'])->name('dashboard.comments');
    // Global Search
    Route::get('/api/global-search', [DashboardController::class, 'globalSearch'])->name('global.search');

    // Projects CRUD
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/switch/{project}', [ProjectController::class, 'switch'])->name('projects.switch');

    // Kanban Boards CRUD
    Route::post('/kanban-boards', [KanbanBoardController::class, 'store'])->name('kanban-boards.store');
    Route::delete('/kanban-boards/{kanbanBoard}', [KanbanBoardController::class, 'destroy'])->name('kanban-boards.destroy');
    Route::put('/kanban-boards/{kanbanBoard}/move', [KanbanBoardController::class, 'move'])->name('kanban-boards.move');

    // Kanban CRUD
    Route::post('/kanban', [KanbanController::class, 'store'])->name('kanban.store');
    Route::put('/kanban/{kanbanTask}', [KanbanController::class, 'updateStatus'])->name('kanban.updateStatus');
    Route::delete('/kanban/{kanbanTask}', [KanbanController::class, 'destroy'])->name('kanban.destroy');

    // Revision CRUD (Logbook)
    Route::post('/revisions', [RevisionController::class, 'store'])->name('revisions.store');
    Route::put('/revisions/{clientRevision}', [RevisionController::class, 'updateStatus'])->name('revisions.updateStatus');
    Route::delete('/revisions/{clientRevision}', [RevisionController::class, 'destroy'])->name('revisions.destroy');

    // Sprint Backlog CRUD (Legacy)
    Route::post('/sprints', [SprintController::class, 'store'])->name('sprints.store');
    Route::put('/sprints/{sprintBacklog}', [SprintController::class, 'updateStatus'])->name('sprints.updateStatus');
    Route::delete('/sprints/{sprintBacklog}', [SprintController::class, 'destroy'])->name('sprints.destroy');

    // New Sprint Management
    Route::post('/sprints/manage', [SprintController::class, 'storeNewSprint'])->name('sprints.manage.store');
    Route::delete('/sprints/manage/{sprint}', [SprintController::class, 'destroySprint'])->name('sprints.manage.destroy');
    Route::post('/sprints/manage/{sprint}/tasks', [SprintController::class, 'storeSprintTask'])->name('sprints.manage.storeTask');

    // Documents CRUD
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('/documents/{projectDocument}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('/documents/{projectDocument}/download', [DocumentController::class, 'download'])->name('documents.download');

    // Comments CRUD
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{projectComment}', [CommentController::class, 'updateStatus'])->name('comments.updateStatus');
    Route::delete('/comments/{projectComment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Team CRUD
    Route::post('/team', [\App\Http\Controllers\TeamController::class, 'store'])->name('team.store');
    Route::delete('/team/{projectMember}', [\App\Http\Controllers\TeamController::class, 'destroy'])->name('team.destroy');
    Route::post('/team/bulk-delete', [\App\Http\Controllers\TeamController::class, 'bulkDestroy'])->name('team.bulkDestroy');
});
