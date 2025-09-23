<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Calendario - RingMind (Directivo)</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

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
    background-color: var(--color-secondary);
    padding: 1rem 2rem;
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    z-index: 1000;
}
.navbar img { height: 40px; }
.navbar .logo { 
    color: var(--color-text-white); 
    font-size: 1.8rem; 
    font-weight: bold; 
    position: absolute; 
    left: 50%; 
    transform: translateX(-50%); 
}
.volver-btn { 
    background: transparent; 
    border: none; 
    color: var(--color-text-white); 
    font-size: 1rem; 
    cursor: pointer; 
    text-decoration: none; 
    display: flex; 
    align-items: center; 
    gap: 0.5rem; 
}
.volver-btn:hover { color: #d4b8e0; }

/* Contenedor calendario */
.container-calendar {
    max-width: 1100px;
    margin: 0 auto;
    padding: 1rem;
}

/* Botones */
.btn-custom {
    background-color: var(--color-tertiary);
    color: var(--color-text-white);
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}
.btn-custom:hover { background-color: #666565; color: var(--color-text-white); }

/* FullCalendar */
.fc .fc-toolbar-title { color: white; }
.fc .fc-button { background-color: var(--color-tertiary); color: white; border: none; }
.fc .fc-button:hover { background-color: #333; }
.fc .fc-daygrid-event { color: white; border: none; }
.fc-event.alumnos { background-color: #28a745; }
.fc-event.profesores { background-color: #007bff; }
.fc-event.solo_creador { background-color: #6c757d; }

/* Footer */
.footer {
    text-align: center;
    background-color: #081136;
    font-weight: bold;
    color: white;
    padding: 0.8rem;
    width: 100%;
    margin-top: 2rem;
    font-size: 0.95rem;
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" alt="Logo">
    <div class="logo">RingMind</div>
    <a href="<?= base_url('gestionar_usuarios') ?>" class="volver-btn"><i class="fas fa-arrow-left"></i> Volver</a>
</nav>

<!-- Contenido principal -->
<div class="container-calendar text-center">
    <div class="flex flex-col md:flex-row justify-center gap-4 mb-4">
        <a href="<?= base_url('avisos/crear') ?>" class="btn-custom">
            <i class="fas fa-plus-circle"></i> Crear Aviso
        </a>
    </div>

    <div id="calendar"></div>
</div>

<!-- Modal Detalle Aviso -->
<div class="modal fade" id="detalleAvisoModal" tabindex="-1" aria-labelledby="detalleAvisoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-dark">
      <div class="modal-header bg-secondary text-white">
        <h5 class="modal-title" id="detalleAvisoLabel">Detalle del Aviso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p><strong>Título:</strong> <span id="avisoTitulo"></span></p>
        <p><strong>Descripción:</strong> <span id="avisoDescripcion"></span></p>
        <p><strong>Tipo:</strong> <span id="avisoTipo"></span></p>
        <p><strong>Fecha Inicio:</strong> <span id="avisoInicio"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="editarAvisoBtn">Editar</button>
        <button type="button" class="btn btn-danger" id="eliminarAvisoBtn">Eliminar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

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
        events: '<?= base_url("avisos/listarJson"); ?>', // Endpoint filtrado para directivo
        eventClassNames: function(arg) {
            if(arg.event.extendedProps.tipo === 'alumnos') return ['alumnos'];
            if(arg.event.extendedProps.tipo === 'profesores') return ['profesores'];
            if(arg.event.extendedProps.tipo === 'solo_creador') return ['solo_creador'];
        },
        eventClick: function(info) {
            document.getElementById('avisoTitulo').innerText = info.event.title;
            document.getElementById('avisoDescripcion').innerText = info.event.extendedProps.descripcion || 'Sin descripción';
            document.getElementById('avisoTipo').innerText = info.event.extendedProps.tipo;
            document.getElementById('avisoInicio').innerText = info.event.start 
            ? info.event.start.toLocaleString('es-AR', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            })
            : '';

            document.getElementById('editarAvisoBtn').dataset.id = info.event.id;
            document.getElementById('eliminarAvisoBtn').dataset.id = info.event.id;

            var detalleModal = new bootstrap.Modal(document.getElementById('detalleAvisoModal'));
            detalleModal.show();
        }
    });

    calendar.render();

    document.getElementById('editarAvisoBtn').addEventListener('click', function() {
        var idAviso = this.dataset.id;
        window.location.href = '<?= base_url("avisos/editar/"); ?>' + idAviso;
    });

    document.getElementById('eliminarAvisoBtn').addEventListener('click', function() {
        var idAviso = this.dataset.id;
        if(confirm("¿Seguro que quieres eliminar este aviso?")) {
            fetch('<?= base_url("avisos/eliminar/"); ?>' + idAviso, { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Aviso eliminado');
                    calendar.refetchEvents();
                    var modal = bootstrap.Modal.getInstance(document.getElementById('detalleAvisoModal'));
                    modal.hide();
                } else {
                    alert('Error al eliminar aviso');
                }
            });
        }
    });
});
</script>

<!-- Footer -->
<footer class="footer">
    Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara
</footer>

</body>
</html>
