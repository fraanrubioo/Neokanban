<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $message->subject }}
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

                <!-- Vista del mensaje -->
                <div class="col-md-9 col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <p class="mb-2"><strong>Proyecto:</strong> {{ $message->project->name }}</p>
                            <p class="mb-2"><strong>De:</strong> {{ $message->sender->name }} ({{ $message->sender->email }})</p>
                            <p class="mb-4"><strong>Para:</strong> {{ $message->recipient->name }} ({{ $message->recipient->email }})</p>

                            <hr class="my-4">

                            <p class="whitespace-pre-line">{{ $message->body }}</p>

                            <br/>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">← Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
