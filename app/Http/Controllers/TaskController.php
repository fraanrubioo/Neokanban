<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Project $project)
    {
        $users = User::all(); // o los relacionados al proyecto
        return view('tasks.create', compact('project', 'users'));
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'required|exists:users,id',
            'short_description' => 'nullable|string|max:100',
            'priority' => 'required|in:baja,normal,urgente',
            'progress' => 'required|in:sin_empezar,en_curso,finalizado',
        ]);

        $validated['project_id'] = $project->id;

        Task::create($validated);

        return redirect()->route('projects.show', $project)->with('success', 'Tarea creada correctamente.');
    }


    public function destroy(Task $task)
    {
        $project = $task->project; // opcional, si luego quieres redirigir
        $task->delete();

        return redirect()->route('projects.show', $project)->with('success', 'Tarea eliminada correctamente.');
    }

}
