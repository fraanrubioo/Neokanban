<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        // Añadir manualmente al owner si existe como usuario
        $owner = User::where('email', $project->owner_email)->first();
        if ($owner && !$users->contains('id', $owner->id)) {
            $users->push($owner);
        }

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'recipient_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'attachment' => 'nullable|file|max:5120', // hasta 5 MB
        ]);

        $message = new Message();
        $message->project_id = $validated['project_id'];
        $message->sender_id = Auth::id();
        $message->recipient_id = $validated['recipient_id'];
        $message->subject = $validated['subject'];
        $message->body = $validated['body'];

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $message->attachment = $path;
        }

        $message->save();

        return redirect()->route('messages.sent')->with('success', 'Mensaje enviado correctamente.');
    }

    public function show(Message $message)
    {
        if ($message->recipient_id !== Auth::id() && $message->sender_id !== Auth::id()) {
            abort(403);
        }

        return view('messages.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        if (Auth::id() !== $message->recipient_id && Auth::id() !== $message->sender_id) {
            abort(403);
        }

        $message->delete();

        return redirect()->back()->with('success', 'Mensaje eliminado correctamente.');
    }

}
