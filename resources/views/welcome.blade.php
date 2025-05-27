<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Aplicación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logo-verde-sinfondo.png') }}" type="image/x-icon">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('images/logo-verde-sinfondo.png') }}" alt="Logo" style="height: 40px;" class="me-2">
            <span class="fw-bold">NeoKanban</span>
        </a>
        <div class="ms-auto">
            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="container hero-section">
    <div class="row w-100">
        <!-- Texto -->
        <div class="col-12 col-md-6 col-xl-6 d-flex flex-column justify-content-center">
            <h1 class="display-5 fw-bold mb-3">Captura, organiza y gestiona tus tareas desde un solo lugar</h1>
            <p class="text-muted mb-4">NeoKanban es una herramienta de gestión de proyectos que utiliza la metodología Kanban, creada para optimizar la organización 
                y la cooperación en los equipos de trabajo. Su función principal es un tablero visual que organiza las tareas en tres categorías: pendientes, en progreso 
                y finalizadas. Cada actividad posibilita la adición de observaciones para optimizar la comunicación entre los miembros del equipo.
                <br/><br/>
                Asimismo, la aplicación proporciona un calendario interactivo que permite ver las fechas de entrega de todas las tareas, lo que simplifica 
                la organización y el monitoreo del proyecto. Asimismo, cuenta con un registro de tareas que proporciona una perspectiva clara y estructurada 
                de todas las actividades, permitiendo su ágil identificación y manejo.
                <br/><br/>
                Una parte importante es la sección del equipo, donde se pueden ver a todos los miembros del proyecto y sus roles asignados. 
                Para optimizar la accesibilidad y la colaboración, NeoKanban incorpora almacenamiento en la nube, facilitando a los usuarios 
                la opción de guardar y compartir archivos de forma efectiva y segura.
            </p>
        </div>
        <!-- Imagen -->
        <div class="col-12 col-md-6 col-xl-6 text-center">
            <img src="{{ asset('images/logo-verde-sinfondo.png') }}" alt="Imagen principal" class="hero-image img-fluid">
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>