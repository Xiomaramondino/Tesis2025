<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Avisos - Calendario Profesor</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

    <style>
        body { background-color: #1e1e2f; color: white; }
        .fc-event { background-color: #6f42c1; border: none; color: white; }
        .fc-event.alumno { background-color: #28a745; }
        .fc-event.profesor { background-color: #007bff; }
        .fc-event.solo_creador { background-color: #6c757d; }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4 text-center" style="color:#d4b8e0;">Calendario de Avisos</h2>

    <div class="mb-3 text-center">
        <a href="<?= base_url('avisos/crear') ?>" class="btn btn-primary">Crear Aviso</a>
    </div>

    <div id="calendar"></div>
</div>

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
        events: [
            <?php if(!empty($avisos)): ?>
                <?php foreach($avisos as $aviso): ?>
                    {
                        title: "<?= esc($aviso->titulo) ?>",
                        start: "<?= date('Y-m-d\TH:i', strtotime($aviso->fecha)) ?>",
                        description: "<?= esc($aviso->descripcion) ?>",
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
                "Descripción: " + info.event.extendedProps.description + "\n" +
                "Curso: " + info.event.extendedProps.curso + "\n" +
                "Visibilidad: " + info.event.extendedProps.visibilidad
            );
        }
    });

    calendar.render();
});
</script>
</body>
</html>
