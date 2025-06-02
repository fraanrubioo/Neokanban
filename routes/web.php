<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CalendarController;
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

Route::post('/invitar', [App\Http\Controllers\InviteController::class, 'send'])->name('invite.send');

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
