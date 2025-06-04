<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Añadir tarea al proyecto: {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded p-6">
            <form method="POST" action="{{ route('tasks.store', $project) }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block font-medium text-sm text-gray-700">Nombre de la tarea</label>
                    <input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="start_date" class="block font-medium text-sm text-gray-700">Fecha de inicio</label>
                    <input id="start_date" name="start_date" type="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('start_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="end_date" class="block font-medium text-sm text-gray-700">Fecha de finalización</label>
                    <input id="end_date" name="end_date" type="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('end_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="user_id" class="block font-medium text-sm text-gray-700">Asignar a</label>
                    <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Selecciona un usuario</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción breve -->
                <div class="mb-4">
                    <label for="short_description" class="form-label">Descripción breve</label>
                    <input type="text" name="short_description" id="short_description" class="form-control" maxlength="100" placeholder="Máx. 100 caracteres">
                </div>

                <!-- Prioridad -->
                <div class="mb-4">
                    <label for="priority" class="form-label">Prioridad</label>
                    <select name="priority" id="priority" class="form-select">
                        <option value="baja">Baja</option>
                        <option value="normal" selected>Normal</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>

                <!-- Progreso -->
                <div class="mb-4">
                    <label for="progress" class="form-label">Progreso</label>
                    <select name="progress" id="progress" class="form-select">
                        <option value="sin_empezar" selected>Sin empezar</option>
                        <option value="en_curso">En curso</option>
                        <option value="finalizado">Finalizado</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn btn-success">
                        Crear tarea
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
