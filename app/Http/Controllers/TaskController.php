<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'short_description' => 'nullable|string|max:100',
            'priority' => 'required|in:baja,normal,urgente',
            'progress' => 'required|in:sin_empezar,en_curso,finalizado',
        ]);

        $task->update($validated);

        return redirect()
            ->route('projects.show', $task->project_id)
            ->with('success', 'Tarea actualizada correctamente.');
    }

    public function misTareas(Request $request)
    {
        $user = Auth::user();

        // Asegura que obtenemos los proyectos vinculados al email del usuario
        $proyectos = Project::where(function ($query) use ($user) {
            $query->whereIn('id', function ($subquery) use ($user) {
                $subquery->select('project_id')
                         ->from('project_user_emails')
                         ->where('email', $user->email);
            })
            ->orWhere('owner_email', $user->email);
        })->get();


        $projectId = $request->input('project_id');
        $tareas = collect();

        if ($projectId) {
            $tareas = Task::where('project_id', $projectId)
                ->where('user_id', $user->id)
                ->get();
        }

        return view('tasks.mine', compact('proyectos', 'tareas', 'projectId'));
    }
}
