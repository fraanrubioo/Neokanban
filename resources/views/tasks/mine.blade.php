<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Tareas
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <form method="GET" class="mb-6">
            <label for="project_id" class="block mb-2 font-semibold">Selecciona un proyecto:</label>
            <select name="project_id" id="project_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Elegir proyecto --</option>
                @foreach ($proyectos as $proyecto)
                    <option value="{{ $proyecto->id }}" {{ $projectId == $proyecto->id ? 'selected' : '' }}>
                        {{ $proyecto->name }}
                    </option>
                @endforeach
            </select>
        </form>

        @if ($tareas->isEmpty())
            <p class="text-gray-600">No tienes tareas asignadas en este proyecto.</p>
        @else
            <div class="row g-4">
                @foreach ($tareas as $task)
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

                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary w-100 mt-auto">
                                    Editar Tarea
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
