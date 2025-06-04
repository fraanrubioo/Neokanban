<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Correo interno
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container px-4">
            <div class="row justify-content-center">
                <!-- Sidebar de carpetas -->
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="list-group shadow-sm">
                        <a href="{{ route('messages.create') }}" class="list-group-item list-group-item-action text-success fw-bold">
                            Redactar mensaje
                        </a>
                        <a href="{{ route('messages.inbox') }}" class="list-group-item list-group-item-action active">
                            Bandeja de entrada
                        </a>
                        <a href="{{ route('messages.sent') }}" class="list-group-item list-group-item-action">
                            Enviados
                        </a>
                    </div>
                </div>

                <!-- Lista de mensajes -->
                <div class="col-md-9 col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Mensajes recibidos</h5>

                            @if ($messages->isEmpty())
                                <div class="alert alert-info mt-3">No tienes mensajes.</div>
                            @else
                                <table class="table table-hover mt-3">
                                    <thead>
                                        <tr>
                                            <th>De</th>
                                            <th>Asunto</th>
                                            <th>Fecha</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($messages as $message)
                                            <tr>
                                                <td onclick="window.location='{{ route('messages.show', $message) }}'" style="cursor:pointer;">
                                                    {{ $message->sender->name ?? 'Desconocido' }}
                                                </td>
                                                <td onclick="window.location='{{ route('messages.show', $message) }}'" style="cursor:pointer;">
                                                    {{ $message->subject }}
                                                </td>
                                                <td onclick="window.location='{{ route('messages.show', $message) }}'" style="cursor:pointer;">
                                                    {{ $message->created_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td class="text-end">
                                                    <form action="{{ route('messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este mensaje?');" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-sm bg-transparent border-none p-0 m-0" title="Eliminar mensaje">
                                                            ✕
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
