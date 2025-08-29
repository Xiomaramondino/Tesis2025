<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Gestión de timbres - Horarios</title>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
  body {
    margin: 0;
    padding-top: 70px;
    background-color: #091342;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #e0e0e0;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
  }

  .navbar {
    width: 100%;
    background-color: #081136;
    padding: 1rem 2rem;
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-sizing: border-box;
    z-index: 1000;
  }
  .navbar .logo {
    color: white;
    font-size: 1.9rem;
    font-weight: bold;
  }
  .volver-btn {
    background: transparent;
    border: none;
    color: white;
    font-size: 1rem;
    cursor: pointer;
    text-decoration: none;
    padding: 0.3rem 0.8rem;
    transition: color 0.3s ease;
  }
  .volver-btn:hover {
    color: #d4b8e0;
  }

  .card {
    background: #081136;
    border-radius: 1.5rem;
    padding: 2rem 2.5rem;
    max-width: 700px;
    margin: 2rem auto 4rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
    width: 90%;
  }

  .card-title {
    text-align: center;
    font-weight: 700;
    margin-bottom: 2rem;
    color: white;
  }

  .horarios-list {
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
  }

  .horario-card {
    background: #070f2e;
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(163, 143, 193, 0.25);
    padding: 1.2rem 1.8rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    color: white;
  }
  .horario-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(163, 143, 193, 0.6);
  }

  .horario-info p {
    margin: 0.15rem 0;
    font-size: 1.05rem;
    line-height: 1.3;
  }

  .horario-actions a {
    margin-left: 1rem;
    padding: 0.4rem 1rem;
    border-radius: 0.6rem;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    user-select: none;
    text-decoration: none;
    color: #f0eaff;
    transition: background-color 0.25s ease;
  }

  .btn-edit {
    background-color: #7158e2;
  }
  .btn-edit:hover {
    background-color: #5534b8;
  }

  .btn-delete {
    background-color: #e24363;
  }
  .btn-delete:hover {
    background-color: #a7283f;
  }
  .btn-add {
    margin-top: 1.5rem;
    background-color: #070f2e;
    color: white;
    border: none;
    border-radius: 1rem;
    padding: 0.9rem 1.8rem;
    font-size: 1.2rem;
    font-weight: 500;
    width: 100%;
    max-width: 350px;
    display: block;
    margin-left: auto;
    margin-right: auto;
    cursor: pointer;
  }
  .btn-add:hover {
    background-color: #666565;
  }

  .footer {
    text-align: center;
    background-color: #081136;
    font-weight: bold;
    color: white;
    padding: 0.8rem;
    width: 100%;
    position: relative;
    bottom: 0;
    margin-top: auto;
    font-size: 0.95rem;
  }

  .form-control {
     width: 100%;
      padding: 0.6rem 1rem;
      background-color: transparent;
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 8px;
      color: white;
      font-size: 1rem;
      margin-bottom: 1rem;
      transition: all 0.3s ease;
    }

    .form-control::placeholder {
      color: #bbb;
    }

    .form-control:focus {
      background-color: rgba(255, 255, 255, 0.08);
      color: #bbb;
      border: 1px solid #6f42c1;
      box-shadow: 0 0 10px #6f42c1;
      caret-color: #bbb;
    }

    input:-webkit-autofill,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:active {
      -webkit-text-fill-color: #fff;
      transition: background-color 9999s ease-in-out 0s;
      -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset;
      caret-color: #fff;
    }

    input:-moz-autofill {
      box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset;
      -moz-text-fill-color: #fff;
      caret-color: #fff;
    }
 /* Para los inputs de tipo date y time */
input[type="date"],
input[type="time"] {
    color: white; /* texto */
}

/* Forzar color de los iconos en Chrome/Edge */
input[type="date"]::-webkit-calendar-picker-indicator,
input[type="time"]::-webkit-calendar-picker-indicator {
    filter: invert(1); /* convierte a blanco */
    cursor: pointer;
}

/* Para Firefox, se puede usar color del texto */
input[type="date"]::-moz-focus-inner,
input[type="time"]::-moz-focus-inner {
    color: white;
}
.alert {
            margin-top: 20px;
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);
            font-size: 1rem;
        }

        .alert-success {
            background-color: rgba(72, 187, 120, 0.15);
            border: 1.5px solid rgba(72, 187, 120, 0.6);
            color: #48bb78;
        }

        .alert-danger {
            background-color: rgba(220, 38, 38, 0.15);
            border: 1.5px solid rgba(220, 38, 38, 0.6);
            color: #dc2626;
        }
        .alert .close-btn {
            background: none;
            border: none;
            color: inherit;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0;
            margin-left: 1rem;
            line-height: 1;
        }
</style>
</head>
<body>

<nav class="navbar sticky-top">
  <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
  <div class="logo">RingMind</div>

  <form action="<?= base_url('/gestionar_usuarios'); ?>" method="get">
    <button type="submit" class="volver-btn">Volver</button>
  </form>
</nav>

<div class="card" role="main" aria-label="Gestión de horarios y eventos">

  <!-- Botón para ver feriados -->
  <button class="btn-add" onclick="window.location.href='<?= base_url('feriados/ver') ?>'">
    Ver feriados del año
  </button>

  <!-- Formulario para agregar evento especial -->
  <div class="card" style="margin-top:1rem;">
    <h2 class="card-title" style="margin-top:2rem; margin-bottom:1rem; text-align:center; color:#d4b8e0;">Agregar Evento Especial</h2>

    <?php if (session()->getFlashdata('success_evento')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= session()->getFlashdata('success_evento') ?>
          <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label="Cerrar">&times;</button>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error_evento')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= session()->getFlashdata('error_evento') ?>
          <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label="Cerrar">&times;</button>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('eventos_especiales/agregar') ?>" method="post">
      <div>
        <label for="fecha">Fecha:</label>
        <input class="form-control" type="date" id="fecha" name="fecha" required>
      </div>
      <div>
        <label for="hora">Hora:</label>
        <input class="form-control" type="time" id="hora" name="hora" required>
      </div>
      <div>
        <label for="descripcion">Descripción:</label>
        <input class="form-control" type="text" id="descripcion" name="descripcion" required>
      </div>
      <button type="submit" class="btn-add">Agregar Evento Especial</button>
    </form>
  </div>

  <!-- Lista de eventos especiales -->
  <?php if (!empty($eventosEspeciales)) : ?>
    <h2 style="margin-top:2rem; margin-bottom:1rem; text-align:center; color:#d4b8e0;">Eventos Especiales Activos</h2>
    <?php foreach ($eventosEspeciales as $evento) : ?>
      <div class="horario-card">
        <div class="horario-info">
          <p><strong>Evento:</strong> <?= htmlspecialchars($evento->descripcion) ?></p>
          <p><strong>Fecha:</strong> <?= htmlspecialchars($evento->fecha) ?></p>
          <p><strong>Hora:</strong> <?= htmlspecialchars($evento->hora) ?></p>
        </div>
        <div class="horario-actions">
          <a href="<?= base_url('eventos_especiales/delete/' . $evento->id) ?>" 
             class="btn-delete" 
             onclick="return confirm('¿Estás seguro de eliminar este evento especial?')">
             Eliminar
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else : ?>
      <h2 class="card-title" style="color:#d4b8e0;">Eventos Especiales</h2>
      <p style="color:white; text-align:center;">No hay eventos especiales activos.</p>
  <?php endif; ?>


  <!-- Mensajes para horarios normales -->
  <?php if (session()->getFlashdata('success_horario')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:2rem;">
          <?= session()->getFlashdata('success_horario') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error_horario')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:2rem;">
          <?= session()->getFlashdata('error_horario') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
  <?php endif; ?>

  <h2 style="margin-top:2rem; margin-bottom:1rem; text-align:center; color:#d4b8e0;">Eventos Activos</h2>
  <div class="horarios-list">
    <?php 
      $dias = [1=>'Lunes',2=>'Martes',3=>'Miércoles',4=>'Jueves',5=>'Viernes',6=>'Sábado',7=>'Domingo'];
      
      if (!empty($data)) { 
        foreach ($data as $row) { ?>
          <div class="horario-card">
            <div class="horario-info">
              <p><strong>Evento:</strong> <?= htmlspecialchars($row['evento']) ?></p>
              <p><strong>Hora:</strong> <?= htmlspecialchars($row['hora']) ?></p>
              <p><strong>Día:</strong> <?= $dias[$row['iddia']] ?? 'Desconocido' ?></p>
            </div>
            <div class="horario-actions">
              <a href="<?= base_url('horarios/editar/' . $row['idhorario']) ?>" class="btn-edit">Modificar</a>
              <a href="<?= base_url('horarios/delete/' . $row['idhorario']) ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este horario?')">Eliminar</a>
            </div>
          </div>
      <?php } 
      } else { ?>
          <p style="color:white; text-align:center;">No hay eventos activos.</p>
      <?php } ?>
  </div>

  <?php
  // Comprobar si hay dispositivos asociados
  $session = session();
  $idcolegio = $session->get('idcolegio');
  $db = \Config\Database::connect();
  $dispositivo = $db->table('dispositivo')->where('idcolegio', $idcolegio)->get()->getRow();
  ?>

  <!-- Botón Agregar Horario -->
  <?php if ($dispositivo): ?>
      <button class="btn-add" onclick="window.location.href='<?= base_url('horarios/agregar') ?>'">
          Agregar horario
      </button>
  <?php else: ?>
      <button class="btn-add" disabled>
          Agregar horario
      </button>
      <p style="color:#f87171; text-align:center; margin-top:0.5rem; font-weight:bold;">
          No tienes ningún dispositivo asociado a tu colegio, no puedes agregar horarios.
      </p>
  <?php endif; ?>

</div>

<footer class="footer">
  <p>Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara</p>
</footer>

</body>
</html>
