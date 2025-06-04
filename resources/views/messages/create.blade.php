<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Enviar mensaje
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container px-4">
            <div class="row justify-content-center">
                <!-- Sidebar de carpetas -->
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="list-group shadow-sm">
                        <a href="{{ route('messages.create') }}" class="list-group-item list-group-item-action text-white fw-bold active">
                            Redactar mensaje
                        </a>
                        <a href="{{ route('messages.inbox') }}" class="list-group-item list-group-item-action">
                            Bandeja de entrada
                        </a>
                        <a href="{{ route('messages.sent') }}" class="list-group-item list-group-item-action">
                            Enviados
                        </a>
                    </div>
                </div>

                <!-- Formulario -->
                <div class="col-md-9 col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form method="POST" action="{{ route('messages.store') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- Proyecto -->
                                <div class="mb-4">
                                    <label for="project_id" class="form-label">Proyecto</label>
                                    <select id="project_id" name="project_id" class="form-select" required>
                                        <option value="">Selecciona un proyecto</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Destinatario -->
                                <div class="mb-4">
                                    <label for="recipient_id" class="form-label">Destinatario</label>
                                    <select id="recipient_id" name="recipient_id" class="form-select" required>
                                        <option value="">Selecciona un destinatario</option>
                                    </select>
                                </div>

                                <!-- Asunto -->
                                <div class="mb-4">
                                    <label for="subject" class="form-label">Asunto</label>
                                    <input type="text" id="subject" name="subject" class="form-control" required>
                                </div>

                                <!-- Mensaje -->
                                <div class="mb-4">
                                    <label for="body" class="form-label">Mensaje</label>
                                    <textarea id="body" name="body" rows="5" class="form-control" required></textarea>
                                </div>

                                <!-- Archivo adjunto -->
                                <div class="mb-4">
                                    <label for="attachment" class="form-label">Archivo adjunto</label>
                                    <input type="file" name="attachment" id="attachment" class="form-control">
                                </div>

                                <!-- Botón -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">
                                        Enviar mensaje
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('project_id').addEventListener('change', function () {
            const projectId = this.value;
            const recipientSelect = document.getElementById('recipient_id');
            recipientSelect.innerHTML = '<option>Cargando...</option>';

            fetch(`/messages/project-users/${projectId}`)
                .then(response => response.json())
                .then(data => {
                    recipientSelect.innerHTML = '<option value="">Selecciona un destinatario</option>';
                    data.forEach(user => {
                        recipientSelect.innerHTML += `<option value="${user.id}">${user.name} (${user.email})</option>`;
                    });
                });
        });
    </script>
    @endpush
</x-app-layout>
