<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Calendario Avisos</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<!-- FullCalendar Spanish -->
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/locales/es.global.min.js"></script>

<style>
:root {
    --color-primary: #091342;
    --color-secondary: #081136;
    --color-tertiary: #070f2e;
    --color-text-white: white;
    --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    padding-top: 90px;
    padding-bottom: 70px;
    min-height: 100vh;
    background-color: var(--color-primary);
    font-family: var(--font-family);
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

/* Flex para separar izquierda, centro y derecha */
.navbar-left,
.navbar-center,
.navbar-right {
    display: flex;
    align-items: center;
}

/* Centro centrado absoluto para RingMind */
.navbar-center {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}

/* Logo texto RingMind */
.navbar-center .logo {
    color: white;
    font-size: 1.8rem;
    font-weight: bold;
}

/* Botones derecha */
.navbar-right {
    margin-left: auto;
    gap: 0.5rem;
}

/* Botones planos, sin fondo ni animación */
.navbar-right .nav-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: none;
    color: white;
    border: none;
    padding: 0.5rem 0.8rem;
    font-size: 1rem;
    cursor: pointer;
    text-decoration: none;
}

.navbar-right .nav-btn:hover {
    background: none;
    color: white;
    transform: none;
}

/* Contenedor calendario */
.container-calendar {
    max-width: 1100px;
    margin: 0 auto;
    padding: 1rem;
}

/* Botones de acciones */
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
.btn-custom:hover {
    background-color: #666565;
    color: var(--color-text-white);
}

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
    background-color: var(--color-secondary);
    font-weight: bold;
    color: white;
    padding: 0.8rem;
    width: 100%;
    font-size: 0.95rem;
    left: 0;
    position:absolute;
}

/* Otros ajustes FullCalendar */
.fc .fc-timegrid, 
.fc .fc-timegrid-event, 
.fc .fc-list-table {
    color: black;
}
.fc .fc-col-header-cell-cushion {
    color: red;
}
.fc .fc-timegrid-slot-label-cushion {
    color: white;
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <!-- Izquierda: Logo -->
    <div class="navbar-left">
        <a href="#">
            <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
        </a>
    </div>

    <!-- Centro: RingMind -->
    <div class="navbar-center">
        <div class="logo">RingMind</div>
    </div>

    <!-- Derecha: Botones -->
    <div class="navbar-right">
        <a href="<?= base_url('profesor/horarios'); ?>" class="nav-btn">
            <i class="fas fa-clock"></i> Visualizar horarios
        </a>

        <form action="<?= base_url('/logout'); ?>" method="post">
            <?= csrf_field(); ?>
            <button type="submit" class="nav-btn">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </button>
        </form>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container-calendar text-center">
    <div class="flex flex-col md:flex-row justify-center gap-4 mb-4">
        <a href="<?= base_url('avisos/crear') ?>" class="btn-custom">
            <i class="fas fa-plus-circle"></i> Crear Aviso
        </a>
        <a href="<?= base_url('/cambiar-colegio') ?>" class="btn-custom">
            <i class="fas fa-school"></i> Cambiar de colegio
        </a>
    </div>

    <div id="calendar"></div>
</div>

<!-- Footer -->
<footer class="footer">
    Tesis timbre automático 2025 <br>
    Marquez Juan - Mondino Xiomara
</footer>

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
        allDaySlot: false, 
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '<?= base_url("avisos/listarJson"); ?>',
        slotLabelFormat: [
            { hour: '2-digit', minute: '2-digit', hour12: false }
        ],
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

</body>
</html>
