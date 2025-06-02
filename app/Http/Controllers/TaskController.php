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
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'required|exists:users,id',
        ]);

        Task::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => $request->user_id,
            'project_id' => $project->id,
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'Tarea creada correctamente.');
    }

    public function destroy(Task $task)
    {
        $project = $task->project; // opcional, si luego quieres redirigir
        $task->delete();

        return redirect()->route('projects.show', $project)->with('success', 'Tarea eliminada correctamente.');
    }

}
