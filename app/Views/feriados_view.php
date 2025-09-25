<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gestión de Timbres - Feriados</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVwL4S/T6jL4xP5U5O5+V5aX5tG3p6+rFp5S5b3c4z5p0+V5k5p5D3+w5u5z5O5" crossorigin="anonymous" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
    --color-success-hover: #38a169;
    --color-text-light: #e0e0e0;
    --color-text-white: white;
  }

  html, body {
    height: 100%;
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: var(--color-primary);
    color: var(--color-text-light);
  }

  body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
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
    justify-content: space-between;
    align-items: center;
    box-sizing: border-box;
    z-index: 1000;
  }

  .navbar-left img {
    height: 40px;
  }

  .navbar-center .logo {
    color: var(--color-text-white);
    font-size: 1.9rem;
    font-weight: bold;
    text-align: center;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .navbar-right .volver-btn {
    background: transparent;
    color: var(--color-text-white);
    font-size: 1rem;
    cursor: pointer;
    padding: 0.3rem 0.8rem;
    text-decoration: none;
    border: none;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .navbar-right .volver-btn:hover {
    color: #d4b8e0;
  }

  main {
    flex: 1;
    padding: 100px 2rem 2rem 2rem;
    max-width: 950px;
    width: 100%;
    margin: 0 auto;
    box-sizing: border-box;
  }

  h1 {
    text-align: center;
    color: var(--color-text-white);
    font-size: 2.5rem;
    margin-bottom: 2rem;
  }

  .card-section {
    background: var(--color-secondary);
    border-radius: 1.5rem;
    padding: 2rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
    margin-bottom: 2rem;
  }

  .card-section h2 {
    color: #d4b8e0;
    font-weight: 600;
    margin-top: 0;
    margin-bottom: 1.5rem;
    text-align: center;
    font-size: 1.5rem;
  }

  /* Formulario de excepciones */
  form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-width: 450px;
    margin: 0 auto;
  }

  .form-group {
    display: flex;
    flex-direction: column;
  }

  .form-control {
    width: 100%;
    padding: 0.6rem 1rem;
    background-color: transparent;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    color: var(--color-text-white);
    font-size: 1rem;
    transition: all 0.3s ease;
    box-sizing: border-box;
  }

  .form-control::placeholder {
    color: #bbb;
  }

  .form-control:focus {
    background-color: rgba(255, 255, 255, 0.08);
    color: var(--color-text-white);
    border: 1px solid var(--color-accent);
    box-shadow: 0 0 10px var(--color-accent);
    caret-color: var(--color-text-white);
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

  input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1);
    cursor: pointer;
  }
  input[type="date"]::-moz-calendar-picker-indicator {
    filter: invert(1);
    cursor: pointer;
  }

  .btn-submit {
    background-color: var(--color-tertiary);
    color: var(--color-text-white);
    border: none;
    border-radius: 1rem;
    padding: 0.9rem 1.8rem;
    font-size: 1.2rem;
    font-weight: 500;
    width: 100%;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
  }

  .btn-submit:hover {
    background-color: #666565;
    transform: translateY(-2px);
  }

  /* Tabla escolar */
  .tabla-feriados {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
  }

  .tabla-feriados thead {
    background: var(--color-tertiary);
  }

  .tabla-feriados th {
    padding: 1rem;
    color: var(--color-text-white);
    text-align: center;
    font-size: 1rem;
    border-radius: 8px 8px 0 0;
  }

  .tabla-feriados tbody tr {
    background: rgba(255, 255, 255, 0.05);
    transition: transform 0.2s ease, background 0.2s ease;
  }

  .tabla-feriados tbody tr:hover {
    transform: scale(1.01);
    background: rgba(255, 255, 255, 0.1);
  }

  .tabla-feriados td {
    padding: 1rem;
    text-align: center;
    font-size: 1rem;
  }

  /* Colores segun tipo */
  .tabla-feriados tr.feriado td {
    color: #80ed99;
  }

  .tabla-feriados tr.excepcion td {
    color: #f87171;
  }

  /* Fecha toma color segun tipo */
  .tabla-feriados tr.feriado .fecha {
    font-weight: bold;
    color: #80ed99;
  }

  .tabla-feriados tr.excepcion .fecha {
    font-weight: bold;
    color: #f87171;
  }

  .acciones {
    white-space: nowrap;
  }

  .acciones a {
    padding: 0.5rem 1rem;
    border-radius: 0.6rem;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-right: 0.5rem;
  }

  .btn-modify {
    background-color: var(--color-accent);
    color: var(--color-text-white);
  }
  .btn-modify:hover {
    background-color: var(--color-accent-hover);
  }

  .btn-delete {
    background-color: var(--color-danger);
    color: var(--color-text-white);
  }
  .btn-delete:hover {
    background-color: var(--color-danger-hover);
  }

  .no-acciones {
    font-style: italic;
    color: #bbb;
  }

  /* Mensajes de alerta */
  .alert {
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border-radius: 1rem;
    text-align: center;
    font-size: 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
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

  .footer {
    text-align: center;
    background-color: var(--color-secondary);
    font-weight: bold;
    color: var(--color-text-white);
    padding: 0.8rem;
    font-size: 0.95rem;
    margin-top: auto;
  }
  
</style>
</head>
<body>

<nav class="navbar">
  <div class="navbar-left">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" alt="Logo">
  </div>
  <div class="navbar-center">
    <div class="logo">
      <i class="fas fa-bell"></i> RingMind
    </div>
  </div>
  <div class="navbar-right">
    <a href="<?= base_url('horarios') ?>" class="volver-btn">
      <i class="fas fa-arrow-left"></i> Volver
    </a>
  </div>
</nav>

<main>
  <h1>Feriados de Argentina <?= date('Y') ?></h1>

  <section class="card-section">
    <h2><i class="fas fa-exclamation-triangle"></i> Desactivar Timbres en un Día Específico</h2>
    
    <?php if(session()->getFlashdata('success')): ?>
      <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <i class="fas fa-times-circle"></i> <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('excepciones/registrar') ?>" method="post">
      <div class="form-group">
        <label for="fecha">Fecha:</label>
        <input class="form-control" type="date" id="fecha" name="fecha" required>
      </div>
      <div class="form-group">
        <label for="motivo">Motivo (opcional):</label>
        <input class="form-control" type="text" id="motivo" name="motivo" placeholder="Ej: Día del estudiante, Acto">
      </div>
      <button type="submit" class="btn-submit">
        <i class="fas fa-ban"></i> Desactivar Timbres
      </button>
    </form>
  </section>

  <section class="card-section">
    <h2><i class="fas fa-calendar-check"></i> Calendario Escolar de Feriados y Excepciones</h2>
    <div class="table-container">
      <table class="tabla-feriados">
        <thead>
          <tr>
            <th><i class="fas fa-calendar-day"></i> Fecha</th>
            <th><i class="fas fa-clock"></i> Día</th>
            <th><i class="fas fa-book-open"></i> Motivo</th>
            <th><i class="fas fa-cogs"></i> Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($feriados as $f): ?>
            <?php 
              $fechaObj = new DateTime($f['date']); 
              $diaSemana = $fechaObj->format('l'); 
              $dias = [
                'Monday' => 'Lunes',
                'Tuesday' => 'Martes',
                'Wednesday' => 'Miércoles',
                'Thursday' => 'Jueves',
                'Friday' => 'Viernes',
                'Saturday' => 'Sábado',
                'Sunday' => 'Domingo'
              ];
              $esExcepcion = str_contains($f['localName'], 'Excepción');
              $claseFila = $esExcepcion ? 'excepcion' : 'feriado';
            ?>
            <tr class="<?= $claseFila ?>">
              <td><span class="fecha"><?= $fechaObj->format('d/m/Y') ?></span></td>
              <td><?= $dias[$diaSemana] ?></td>
              <td>
                <?php if($esExcepcion): ?>
                  <i class="fas fa-school"></i> <?= htmlspecialchars($f['localName']) ?>
                <?php else: ?>
                  <i class="fas fa-flag"></i> <?= htmlspecialchars($f['localName']) ?>
                <?php endif; ?>
              </td>
              <td class="acciones">
                <?php if($esExcepcion): ?>
                  <a href="<?= base_url('excepciones/modificar/'.$f['id']) ?>" class="btn-modify">
                     <i class="fas fa-edit"></i> Editar
                  </a>
                  <a href="<?= base_url('excepciones/eliminar/'.$f['id']) ?>" 
                     class="btn-delete"
                     onclick="return confirm('¿Seguro que desea eliminar esta excepción?');">
                     <i class="fas fa-trash-alt"></i> Borrar
                  </a>
                <?php else: ?>
                  <span class="no-acciones">No aplica</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

</main>

<footer class="footer">
  <p>Tesis timbre automático 2025 <br>
  Marquez Juan - Mondino Xiomara</p>
</footer>

</body>
</html>
