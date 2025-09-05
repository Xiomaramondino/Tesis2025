<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Calendario Avisos</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<style>
    body {
        padding-top: 90px;
        padding-bottom: 70px;
        min-height: 100vh;
        background-color: #091342;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: white;
    }

    .navbar {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #081136;
        padding: 1rem 2rem;
        position: fixed;
        top: 0;
        z-index: 1000;
    }
    .navbar .logo { color: white; font-size: 1.8rem; font-weight: bold; }
    .navbar-buttons .volver-btn {
        background: transparent; color: white; border: none; cursor: pointer;
    }
    .navbar-buttons .volver-btn:hover { color: #d4b8e0; }

    .container-calendar {
        max-width: 1100px;
        margin: 0 auto;
    }

    .btn-main {
        background-color: #070f2e;
        color: white;
        border: none;
        border-radius: 1rem;
        padding: 0.8rem 1.5rem;
        font-size: 1.1rem;
        font-weight: 500;
        transition: background-color 0.3s ease, transform 0.3s ease;
        cursor: pointer;
    }
    .btn-main:hover { background-color: #333; transform: translateY(-2px); }

    /* FullCalendar estilos */
    #calendar {
        background-color: #081136;
        border-radius: 1.5rem;
        height: 700px;  /* muy importante */
        padding: 1rem;
        color: white;
    }

    .fc .fc-toolbar-title { color: white; }
    .fc .fc-button { background-color: #070f2e; color: white; border: none; }
    .fc .fc-button:hover { background-color: #333; }
    .fc .fc-daygrid-event { color: white; border: none; }
    .fc-event.alumnos { background-color: #28a745; }
    .fc-event.profesores { background-color: #007bff; }
    .fc-event.solo_creador { background-color: #6c757d; }

    .footer {
        text-align: center;
        background-color: #081136;
        font-weight: bold;
        color: white;
        padding: 0.8rem;
        width: 100%;
        font-size: 0.95rem;
        position: fixed;
        bottom: 0;
        left: 0;
    }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo" />
    <div class="logo">RingMind</div>
    <div class="navbar-buttons">
        <form action="<?= base_url('/logout'); ?>" method="post">
            <button type="submit" class="volver-btn">Cerrar sesión</button>
        </form>
    </div>
</nav>

<div class="container-calendar mt-4 text-center">
    <a href="<?= base_url('avisos/crear') ?>" class="btn btn-main mb-3">
        <i class="fas fa-plus-circle"></i> Crear Aviso
    </a>

    <!-- Calendario -->
    <div id="calendar"></div>
</div>

<footer class="footer">
    Tesis timbre automático 2025 <br>
    Marquez Juan - Mondino Xiomara
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        height: '100%',
        events: [
            <?php if(!empty($avisos)): ?>
                <?php foreach($avisos as $aviso): ?>
                    {
                        title: "<?= esc($aviso->titulo) ?>",
                        start: "<?= date('Y-m-d\TH:i', strtotime($aviso->fecha)) ?>",
                        extendedProps: {
                            curso: "<?= $aviso->idcurso ? esc($aviso->idcurso) : 'Todos los cursos' ?>",
                            visibilidad: "<?= esc($aviso->visibilidad) ?>"
                        },
                        className: "<?= $aviso->visibilidad ?>"
                    },
                <?php endforeach; ?>
            <?php endif; ?>
        ],
        eventClick: function(info) {
            alert(
                "Título: " + info.event.title + "\n" +
                "Curso: " + info.event.extendedProps.curso + "\n" +
                "Visibilidad: " + info.event.extendedProps.visibilidad
            );
        }
    });

    calendar.render();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
