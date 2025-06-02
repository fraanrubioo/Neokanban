<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear nuevo proyecto') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded p-6">
                <form method="POST" action="{{ route('projects.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700">Nombre del proyecto</label>
                        <input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-success">
                            Crear proyecto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
