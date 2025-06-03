<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function inbox()
    {
        $messages = Message::where('recipient_id', Auth::id())->latest()->get();
        return view('messages.inbox', compact('messages'));
    }

    public function sent()
    {
        $messages = Message::where('sender_id', Auth::id())->latest()->get();
        return view('messages.sent', compact('messages'));
    }

    public function create()
    {
        // Mostrar solo los proyectos donde el usuario es owner o ha sido invitado
        $projects = Project::where('owner_email', Auth::user()->email)
            ->orWhereHas('invitedUsers', function ($q) {
                $q->where('email', Auth::user()->email);
            })->get();

        return view('messages.create', compact('projects'));
    }

    public function getProjectUsers($projectId)
    {
        $project = Project::findOrFail($projectId);

        // Obtener los usuarios invitados
        $users = $project->users()->get();

        // Crear una colección y añadir al owner manualmente si existe en la tabla de usuarios
        $owner = \App\Models\User::where('email', $project->owner_email)->first();

        if ($owner && !$users->contains('id', $owner->id)) {
            $users->push($owner);
        }

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'recipient_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Message::create([
            'project_id' => $request->project_id,
            'sender_id' => Auth::id(),
            'recipient_id' => $request->recipient_id,
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        return redirect()->route('messages.sent')->with('success', 'Mensaje enviado correctamente.');
    }

    public function show(Message $message)
    {
        if ($message->recipient_id !== Auth::id() && $message->sender_id !== Auth::id()) {
            abort(403);
        }

        return view('messages.show', compact('message'));
    }
}
