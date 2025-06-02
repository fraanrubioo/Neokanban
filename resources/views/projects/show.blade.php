<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Proyecto: {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 text-right">
            <a href="{{ route('tasks.create', $project) }}" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                + Nueva Tarea
            </a>
        </div>

        <h3 class="text-lg font-semibold mb-2">Tareas asignadas</h3>

        @if ($project->tasks->isEmpty())
            <p class="text-gray-600">Este proyecto no tiene tareas todavía.</p>
        @else
            <div class="space-y-4">
                @foreach ($project->tasks as $task)
                    <div class="container mb-3">
                        <div class="row align-items-center bg-white shadow rounded p-4">
                            <!-- Columna izquierda: info de la tarea -->
                            <div class="col-md-9">
                                <h4 class="text-md fw-bold">{{ $task->name }}</h4>
                                <p class="text-sm text-muted mb-1">
                                    {{ \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') }}
                                    → {{ \Carbon\Carbon::parse($task->end_date)->format('d/m/Y') }}
                                </p>
                                <p class="text-sm text-secondary">
                                    Asignada a: {{ $task->user->name ?? 'Usuario no encontrado' }}
                                </p>
                            </div>

                           <!-- Columna derecha: botón eliminar -->
                            <div class="col-md-3 text-end">
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta tarea?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        Eliminar Tarea
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
