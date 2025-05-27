<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invitar a colaboradores') }}
        </h2>
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/invite.css') }}">
    @endpush

    <div class="invite-container">
        <h2>Invitar a colaboradores</h2>

        @if (session('success'))
            <div class="message-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('invite.send') }}">
            @csrf

            <label for="email">Correo electrónico del colaborador</label>
            <input id="email" name="email" type="email" required placeholder="ejemplo@correo.com">

            @error('email')
                <p class="text-error">{{ $message }}</p>
            @enderror

            <div style="text-align: right;">
                <button type="submit" class="btn-invite">
                    Enviar invitación
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
