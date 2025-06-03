<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mensajes enviados
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
                        <a href="{{ route('messages.inbox') }}" class="list-group-item list-group-item-action">
                            Bandeja de entrada
                        </a>
                        <a href="{{ route('messages.sent') }}" class="list-group-item list-group-item-action active">
                            Enviados
                        </a>
                    </div>
                </div>

                <!-- Lista de mensajes enviados -->
                <div class="col-md-9 col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Mensajes enviados</h5>

                            @if ($messages->isEmpty())
                                <div class="alert alert-info mt-3">No has enviado ningún mensaje.</div>
                            @else
                                <table class="table table-hover mt-3">
                                    <thead>
                                        <tr>
                                            <th scope="col">Para</th>
                                            <th scope="col">Asunto</th>
                                            <th scope="col">Fecha</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($messages as $message)
                                            <tr onclick="window.location='{{ route('messages.show', $message) }}'" style="cursor:pointer;">
                                                <td>{{ $message->recipient->name ?? 'Desconocido' }}</td>
                                                <td>{{ $message->subject }}</td>
                                                <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                                <td><i class="bi bi-chevron-right"></i></td>
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
