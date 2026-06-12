<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\RevisionController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CommentController;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
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

    // Kanban CRUD
    Route::post('/kanban', [KanbanController::class, 'store'])->name('kanban.store');
    Route::put('/kanban/{kanbanTask}', [KanbanController::class, 'updateStatus'])->name('kanban.updateStatus');
    Route::delete('/kanban/{kanbanTask}', [KanbanController::class, 'destroy'])->name('kanban.destroy');

    // Revision CRUD (Logbook)
    Route::post('/revisions', [RevisionController::class, 'store'])->name('revisions.store');
    Route::put('/revisions/{clientRevision}', [RevisionController::class, 'updateStatus'])->name('revisions.updateStatus');
    Route::delete('/revisions/{clientRevision}', [RevisionController::class, 'destroy'])->name('revisions.destroy');

    // Sprint Backlog CRUD
    Route::post('/sprints', [SprintController::class, 'store'])->name('sprints.store');
    Route::put('/sprints/{sprintBacklog}', [SprintController::class, 'updateStatus'])->name('sprints.updateStatus');
    Route::delete('/sprints/{sprintBacklog}', [SprintController::class, 'destroy'])->name('sprints.destroy');

    // Documents CRUD
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('/documents/{projectDocument}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    // Comments CRUD
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{projectComment}', [CommentController::class, 'updateStatus'])->name('comments.updateStatus');
    Route::delete('/comments/{projectComment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Team CRUD
    Route::post('/team', [\App\Http\Controllers\TeamController::class, 'store'])->name('team.store');
    Route::delete('/team/{projectMember}', [\App\Http\Controllers\TeamController::class, 'destroy'])->name('team.destroy');
});
