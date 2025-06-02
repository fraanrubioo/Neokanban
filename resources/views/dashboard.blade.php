<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tus Proyectos') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 text-right">
            <a href="{{ route('projects.create') }}" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo Proyecto
            </a>
        </div>

        @forelse ($projects as $project)
            <div class="container mb-4">
    <div class="row align-items-center bg-white shadow-sm rounded p-4">
        <!-- Columna izquierda: info del proyecto -->
        <div class="col-md-9">
            <h3 class="text-lg font-semibold">{{ $project->name }}</h3>
            <p class="text-sm text-gray-500">Creado por: {{ $project->owner_email }}</p>
            <a href="{{ route('projects.show', $project) }}" class="text-primary text-sm">Ver detalles</a>
        </div>

        <!-- Columna derecha: botón eliminar -->
        <div class="col-md-3 text-end">
            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este proyecto?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    Eliminar Proyecto
                </button>
            </form>
        </div>
    </div>
</div>

            
        @empty
            <p class="text-gray-600">Aún no tienes proyectos creados.</p>
        @endforelse
    </div>
</x-app-layout>
