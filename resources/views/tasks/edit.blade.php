<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Tarea: {{ $task->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded shadow">

            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $task->name) }}" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Fecha de inicio</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $task->start_date) }}" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Fecha de fin</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $task->end_date) }}" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Descripción breve</label>
                    <input type="text" name="short_description" value="{{ old('short_description', $task->short_description) }}" maxlength="100" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Prioridad</label>
                    <select name="priority" class="w-full border rounded px-3 py-2">
                        <option value="baja" {{ $task->priority === 'baja' ? 'selected' : '' }}>Baja</option>
                        <option value="normal" {{ $task->priority === 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="urgente" {{ $task->priority === 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Progreso</label>
                    <select name="progress" class="w-full border rounded px-3 py-2">
                        <option value="sin_empezar" {{ $task->progress === 'sin_empezar' ? 'selected' : '' }}>Sin empezar</option>
                        <option value="en_curso" {{ $task->progress === 'en_curso' ? 'selected' : '' }}>En curso</option>
                        <option value="finalizado" {{ $task->progress === 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                    </select>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
