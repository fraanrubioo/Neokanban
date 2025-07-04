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

        <div class="mb-4 text-end">
            <a href="{{ route('tasks.create', $project) }}" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                + Nueva Tarea
            </a>
        </div>

        <h3 class="text-lg font-semibold mb-4">Tareas asignadas</h3>

        @if ($project->tasks->isEmpty())
            <p class="text-muted">Este proyecto no tiene tareas todavía.</p>
        @else
            <div class="row g-4">
                @foreach ($project->tasks as $task)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $task->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{ \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') }}
                                    → {{ \Carbon\Carbon::parse($task->end_date)->format('d/m/Y') }}
                                </h6>
                                <p class="card-text mb-1">
                                    <strong>Asignada a:</strong> {{ $task->user->name ?? 'Usuario no encontrado' }}
                                </p>
                                <p class="card-text mb-1">
                                    <strong>Descripción:</strong> {{ $task->short_description }}
                                </p>
                                <p class="card-text mb-1">
                                    <strong>Prioridad:</strong>
                                    <span style="
                                        padding: 4px 8px;
                                        border-radius: 4px;
                                        background-color:
                                            @if($task->priority === 'urgente') #fecaca;
                                            @elseif($task->priority === 'normal') #fef08a;
                                            @else #bbf7d0;
                                            @endif;
                                        color:
                                            @if($task->priority === 'urgente') #991b1b;
                                            @elseif($task->priority === 'normal') #78350f;
                                            @else #065f46;
                                            @endif;
                                    ">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </p>
                                <p class="card-text mb-3">
                                    <strong>Progreso:</strong>
                                    <span style="
                                        padding: 4px 8px;
                                        border-radius: 4px;
                                        background-color:
                                            @if($task->progress === 'finalizado') #fecaca;
                                            @elseif($task->progress === 'en_curso') #bbf7d0;
                                            @else #bfdbfe;
                                            @endif;
                                        color:
                                            @if($task->progress === 'finalizado') #991b1b;
                                            @elseif($task->progress === 'en_curso') #065f46;
                                            @else #1e40af;
                                            @endif;
                                    ">
                                        {{ str_replace('_', ' ', ucfirst($task->progress)) }}
                                    </span>
                                </p>

                                @if (Auth::user()->email === $project->owner_email)
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta tarea?');" class="mt-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100 mb-2">
                                            Eliminar Tarea
                                        </button>
                                    </form>

                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary w-100">
                                        Editar Tarea
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
