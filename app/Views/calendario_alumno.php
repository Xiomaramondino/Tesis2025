<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Calendario - Alumnos</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/locales/es.global.min.js"></script>

<style>
:root {
    --color-primary: #091342;
    --color-secondary: #081136;
    --color-tertiary: #070f2e;
    --color-text-white: #ffffff;
}

body {
    margin: 0;
    padding-top: 80px;
    background-color: var(--color-primary);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: var(--color-text-white);
}

/* Navbar */
.navbar {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: var(--color-secondary);
    padding: 1rem 2rem;
    position: fixed;
    top: 0;
    z-index: 1000;
}
.navbar .logo {
    color: var(--color-text-white);
    font-size: 1.8rem;
    font-weight: bold;
}
.navbar-left img { height: 40px; }
.navbar-right {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.navbar-right form button {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    font-size: 1rem;
}

/* Contenedor calendario */
.container-calendar {
    max-width: 1100px;
    margin: 0 auto;
    padding: 1rem;
}

/* FullCalendar */
.fc .fc-toolbar-title { color: white; }
.fc .fc-button { background-color: var(--color-tertiary); color: white; border: none; }
.fc .fc-button:hover { background-color: #333; }
.fc .fc-daygrid-event { color: white; border: none; }
.fc-event.alumnos { background-color: #28a745; }
.fc-event.profesores { background-color: #007bff; }

.footer {
    text-align: center;
    background-color: var(--color-secondary);
    font-weight: bold;
    color: white;
    padding: 0.8rem;
    width: 100%;
    position: relative; /* ya no fijo */
    bottom: 0;
    margin-top: 2rem;
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-left">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" alt="Logo">
    </div>
    <div class="logo">RingMind</div>
    <div class="navbar-right">
    <a href="<?= base_url('/horarios_lector'); ?>" class="btn-volver">
    <i class="fas fa-arrow-left"></i> Volver
</a>

    </div>
</nav>

<!-- Contenedor principal -->
<div class="container-calendar">
    <div id="calendar"></div>
</div>

<!-- Script FullCalendar -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        timeZone: 'local',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '<?= base_url("avisos/listarJson"); ?>', // endpoint filtrado para alumno
        eventClassNames: function(arg) {
            if(arg.event.extendedProps.tipo === 'alumnos') return ['alumnos'];
            if(arg.event.extendedProps.tipo === 'profesores') return ['profesores'];
        },
        eventClick: function(info) {
            alert("Aviso: " + info.event.title + "\nTipo: " + info.event.extendedProps.tipo);
        }
    });
    calendar.render();
});
</script>

<!-- Footer -->
<footer class="footer">
    Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara
</footer>

</body>
</html>
