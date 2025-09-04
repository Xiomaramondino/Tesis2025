<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Gestión de timbres - Horarios</title>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVwL4S/T6jL4xP5U5O5+V5aX5tG3p6+rFp5S5b3c4z5p0+V5k5p5D3+w5u5z5O5" crossorigin="anonymous" />
<style>
  :root {
    --color-primary: #091342;
    --color-secondary: #081136;
    --color-tertiary: #070f2e;
    --color-accent: #7158e2;
    --color-accent-hover: #5534b8;
    --color-danger: #e24363;
    --color-danger-hover: #a7283f;
    --color-success: #48bb78;
    --color-text-light: #e0e0e0;
    --color-text-white: white;
  }

  body {
    margin: 0;
    padding-top: 70px; /* Espacio para la navbar fija */
    background-color: var(--color-primary);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: var(--color-text-light);
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
  }

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
    box-sizing: border-box;
    z-index: 1000;
  }
  
  .navbar .logo {
    color: var(--color-text-white);
    font-size: 1.9rem;
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  .navbar img {
    height: 40px;
  }
  
  .volver-btn {
    background: transparent;
    border: none;
    color: var(--color-text-white);
    font-size: 1rem;
    cursor: pointer;
    text-decoration: none;
    padding: 0.3rem 0.8rem;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .volver-btn:hover {
    color: #d4b8e0;
  }
  
  /* Mantén los estilos existentes para el resto de la página */

  .card-container {
    background: var(--color-secondary);
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
    color: var(--color-text-white);
    font-size: 2rem;
  }

  .card-subtitle {
    margin-top: 2rem;
    margin-bottom: 1rem;
    text-align: center;
    color: #d4b8e0;
    font-weight: 600;
  }

  .horarios-list {
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
  }

  .horario-card {
    background: var(--color-tertiary);
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(163, 143, 193, 0.25);
    padding: 1.2rem 1.8rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    color: var(--color-text-white);
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
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-edit {
    background-color: var(--color-accent);
  }

  .btn-edit:hover {
    background-color: var(--color-accent-hover);
  }

  .btn-delete {
    background-color: var(--color-danger);
  }

  .btn-delete:hover {
    background-color: var(--color-danger-hover);
  }

  .btn-main {
    margin-top: 1.5rem;
    background-color: var(--color-tertiary);
    color: var(--color-text-white);
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
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  .btn-main:hover {
    background-color: #666565;
    transform: translateY(-2px);
  }

  .btn-main:disabled {
    background-color: #333;
    cursor: not-allowed;
    color: #999;
  }

  .footer {
    text-align: center;
    background-color: var(--color-secondary);
    font-weight: bold;
    color: var(--color-text-white);
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
    color: var(--color-text-white);
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
    border: 1px solid var(--color-accent);
    box-shadow: 0 0 10px var(--color-accent);
    caret-color: #bbb;
  }

  input:-webkit-autofill,
  input:-webkit-autofill:focus,
  input:-webkit-autofill:hover,
  input:-webkit-autofill:active {
    -webkit-text-fill-color: var(--color-text-white);
    transition: background-color 9999s ease-in-out 0s;
    -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset;
    caret-color: var(--color-text-white);
  }

  input[type="date"],
  input[type="time"] {
    color: var(--color-text-white);
  }

  input[type="date"]::-webkit-calendar-picker-indicator,
  input[type="time"]::-webkit-calendar-picker-indicator {
    filter: invert(1);
    cursor: pointer;
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
    animation: fadeIn 0.5s ease-out;
  }

  .alert-success {
    background-color: rgba(72, 187, 120, 0.15);
    border: 1.5px solid rgba(72, 187, 120, 0.6);
    color: var(--color-success);
  }

  .alert-danger {
    background-color: rgba(220, 38, 38, 0.15);
    border: 1.5px solid rgba(220, 38, 38, 0.6);
    color: var(--color-danger);
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
    opacity: 0.8;
    transition: opacity 0.3s ease;
  }

  .alert .close-btn:hover {
    opacity: 1;
  }

  .disabled-message {
    color: var(--color-danger);
    text-align: center;
    margin-top: 0.5rem;
    font-weight: bold;
    font-size: 0.9rem;
  }

  .empty-state-message {
    color: var(--color-text-light);
    text-align: center;
    font-size: 1.1rem;
    margin-top: 1rem;
    opacity: 0.8;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>
</head>
<body>

<nav class="navbar sticky-top">
  <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" height="40px" alt="Logo">
  <div class="logo">RingMind</div>
  <a href="<?= base_url('/gestionar_usuarios'); ?>" class="volver-btn">
    <i class="fas fa-arrow-left"></i> Volver
  </a>
</nav>

<?php
  // Verificar si hay dispositivo asociado al idcolegio
  $session = session();
  $idcolegio = $session->get('idcolegio');
  $db = \Config\Database::connect();
  $dispositivo = $db->table('dispositivo')->where('idcolegio', $idcolegio)->get()->getRow();
?>

<div class="card-container" role="main" aria-label="Gestión de horarios y eventos">

  <h1 class="card-title">Gestión de Timbres</h1>

  <button class="btn-main" onclick="window.location.href='<?= base_url('feriados/ver') ?>'" <?= $dispositivo ? '' : 'disabled' ?>>
    <i class="fas fa-calendar-alt"></i> Ver Feriados del Año
  </button>
  <?php if (!$dispositivo): ?>
    <p class="disabled-message">No tienes un dispositivo asociado, no puedes ver los feriados.</p>
  <?php endif; ?>

  <hr style="border: 1px solid rgba(255,255,255,0.1); margin: 2rem 0;">

  <h2 class="card-subtitle"><i class="fas fa-star"></i> Agregar Evento Especial</h2>

  <?php if (session()->getFlashdata('success_evento')): ?>
    <div class="alert alert-success" role="alert">
      <?= session()->getFlashdata('success_evento') ?>
      <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label="Cerrar">&times;</button>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error_evento')): ?>
    <div class="alert alert-danger" role="alert">
      <?= session()->getFlashdata('error_evento') ?>
      <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label="Cerrar">&times;</button>
    </div>
  <?php endif; ?>

  <div class="card" style="background: transparent; box-shadow: none; padding: 0; margin-top: 1rem;">
    <?php if ($dispositivo): ?>
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
        <button type="submit" class="btn-main">
          <i class="fas fa-plus-circle"></i> Agregar Evento Especial
        </button>
      </form>
    <?php else: ?>
      <button class="btn-main" disabled>
        <i class="fas fa-plus-circle"></i> Agregar Evento Especial
      </button>
      <p class="disabled-message">No tienes un dispositivo asociado, no puedes agregar eventos especiales.</p>
    <?php endif; ?>
  </div>

  <?php if (!empty($eventosEspeciales)) : ?>
    <h2 class="card-subtitle" style="margin-top: 2rem;"><i class="fas fa-list-check"></i> Eventos Especiales Activos</h2>
    <div class="horarios-list">
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
              <i class="fas fa-trash-alt"></i> Eliminar
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else : ?>
    <p class="empty-state-message">No hay eventos especiales activos.</p>
  <?php endif; ?>

  <hr style="border: 1px solid rgba(255,255,255,0.1); margin: 2rem 0;">

  <h2 class="card-subtitle"><i class="fas fa-clock"></i> Horarios Regulares</h2>

  <?php if (session()->getFlashdata('success_horario')): ?>
    <div class="alert alert-success" role="alert">
      <?= session()->getFlashdata('success_horario') ?>
      <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label="Cerrar">&times;</button>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error_horario')): ?>
    <div class="alert alert-danger" role="alert">
      <?= session()->getFlashdata('error_horario') ?>
      <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label="Cerrar">&times;</button>
    </div>
  <?php endif; ?>
  
  <div class="horarios-list">
    <?php 
      $dias = [1=>'Lunes', 2=>'Martes', 3=>'Miércoles', 4=>'Jueves', 5=>'Viernes', 6=>'Sábado', 7=>'Domingo'];
      if (!empty($data)) { 
        foreach ($data as $row) { ?>
          <div class="horario-card">
            <div class="horario-info">
              <p><strong>Evento:</strong> <?= htmlspecialchars($row['evento']) ?></p>
              <p><strong>Hora:</strong> <?= htmlspecialchars($row['hora']) ?></p>
              <p><strong>Día:</strong> <?= $dias[$row['iddia']] ?? 'Desconocido' ?></p>
            </div>
            <div class="horario-actions">
              <a href="<?= base_url('horarios/editar/' . $row['idhorario']) ?>" class="btn-edit">
                <i class="fas fa-edit"></i> Modificar
              </a>
              <a href="<?= base_url('horarios/delete/' . $row['idhorario']) ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este horario?')">
                <i class="fas fa-trash-alt"></i> Eliminar
              </a>
            </div>
          </div>
        <?php } 
      } else { ?>
        <p class="empty-state-message">No hay horarios regulares activos.</p>
      <?php } ?>
  </div>

  <button class="btn-main" onclick="window.location.href='<?= base_url('horarios/agregar') ?>'" <?= $dispositivo ? '' : 'disabled' ?>>
    <i class="fas fa-plus"></i> Agregar Horario
  </button>
  <?php if (!$dispositivo): ?>
    <p class="disabled-message">No tienes un dispositivo asociado, no puedes agregar horarios.</p>
  <?php endif; ?>
  
</div>

<footer class="footer">
  <p>Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara</p>
</footer>

</body>
</html>