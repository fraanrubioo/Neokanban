<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendario de Tareas') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    @push('styles')
        <!-- FullCalendar CSS -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
        <!-- FullCalendar JS + Plugins -->
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const calendarEl = document.getElementById('calendar');

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth', // Semana por defecto
                    locale: 'es',
                    height: 'auto',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek,dayGridDay' // vistas
                    },
                    events: [
                        {
                            title: 'Entrega Proyecto Laravel',
                            start: '2025-05-15',
                            end: '2025-05-15',
                            color: '#0d6efd'
                        },
                        {
                            title: 'Examen final',
                            start: '2025-05-18',
                            color: '#dc3545'
                        }
                    ]
                });

                calendar.render();
            });
        </script>
    @endpush
</x-app-layout>
