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
        $projects = \App\Models\Project::where('owner_email', auth()->user()->email)->get();
    
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
