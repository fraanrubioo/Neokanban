<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProjectController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/calendario', [CalendarController::class, 'index'])
    ->middleware(['auth'])
    ->name('calendar');

Route::get('/invitar', function () {
    return view('invite');
})->middleware(['auth'])->name('invite');

Route::get('/invitar', [InviteController::class, 'showForm'])->middleware(['auth'])->name('invite');
Route::post('/invitar', [InviteController::class, 'send'])->middleware(['auth'])->name('invite.send');

Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/sent', [MessageController::class, 'sent'])->name('messages.sent');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::get('/messages/project-users/{project}', [MessageController::class, 'getProjectUsers']);
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});

Route::post('/upload-media', [MediaController::class, 'upload'])->name('media.upload');

// Para obtener usuarios del proyecto por AJAX
Route::get('/mensajes/usuarios/{projectId}', [MessageController::class, 'getProjectUsers'])->name('messages.project.users');

Route::middleware('auth')->group(function () {
    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Proyectos (solo index, create, store, show)
    Route::resource('projects', ProjectController::class)->only([
    'index', 'create', 'store', 'show', 'destroy'
    ]);

    // Tareas (crear dentro de un proyecto)
    Route::get('projects/{project}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

});

require __DIR__.'/auth.php';
