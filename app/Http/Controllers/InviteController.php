<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectUserEmail;

class InviteController extends Controller
{
    /**
     * Muestra el formulario para invitar a colaboradores.
     */
    public function showForm()
    {
        // Solo proyectos creados por el usuario autenticado
        $projects = Project::where('owner_email', auth()->user()->email)->get();

        return view('invite', compact('projects'));
    }

    /**
     * Envía la invitación al usuario por correo (o simplemente guarda en BD).
     */
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'project_id' => 'required|exists:projects,id',
        ]);

        // Verificamos si ya está invitado
        $yaInvitado = \App\Models\ProjectUserEmail::where('project_id', $request->project_id)
            ->where('email', $request->email)
            ->exists();

        if ($yaInvitado) {
            return redirect()->back()->withErrors(['email' => 'Ese usuario ya está invitado a este proyecto.'])->withInput();
        }

        // Si no está invitado, lo creamos
        ProjectUserEmail::create([
            'project_id' => $request->project_id,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Invitación enviada correctamente.');
    }

}
