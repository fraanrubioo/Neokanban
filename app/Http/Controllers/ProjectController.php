<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectUserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $userEmail = auth()->user()->email;

        // Proyectos creados por el usuario
        $ownProjects = \App\Models\Project::where('owner_email', $userEmail)->get();

        // Proyectos en los que ha sido invitado
        $invitedProjectIds = \App\Models\ProjectUserEmail::where('email', $userEmail)->pluck('project_id');
        $invitedProjects = \App\Models\Project::whereIn('id', $invitedProjectIds)->get();

        // Unimos los proyectos sin duplicados
        $projects = $ownProjects->merge($invitedProjects);

        return view('dashboard', compact('projects'));
    }


    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'owner_email' => Auth::user()->email,
        ]);

        return redirect()->route('projects.index')->with('success', 'Proyecto creado correctamente.');
    }

    public function show(Project $project)
    {
        $project->load('tasks.user');
    
        return view('projects.show', compact('project'));
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Proyecto eliminado correctamente.');
    }
}
