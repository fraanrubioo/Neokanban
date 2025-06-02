<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        // Obtener solo las tareas asignadas al usuario autenticado
        $tasks = Task::where('user_id', Auth::id())
            ->get()
            ->map(function ($task) {
                return [
                    'title' => $task->name,
                    'start' => $task->start_date,
                    'end'   => $task->end_date,
                    'color' => '#198754' // verde bootstrap
                ];
            });

        return view('calendar', ['tasks' => $tasks]);
    }
}
