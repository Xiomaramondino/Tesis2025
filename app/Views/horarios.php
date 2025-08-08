<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Gestión de timbres - Horarios</title>
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

  /* Navbar */
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
    font-size: 2.4rem;
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
    margin-top: 2.5rem;
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

<div class="card" role="main" aria-label="Lista de horarios de timbre">
  <h1 class="card-title">Horarios</h1>

  <div class="horarios-list">
    <?php 
      $dias = [
          1 => 'Lunes',
          2 => 'Martes',
          3 => 'Miércoles',
          4 => 'Jueves',
          5 => 'Viernes',
          6 => 'Sábado',
          7 => 'Domingo'
      ];
      foreach ($data as $row) { ?>
        <div class="horario-card">
          <div class="horario-info">
            <p><strong>Evento:</strong> <?= htmlspecialchars($row['evento']) ?></p>
            <p><strong>Hora:</strong> <?= htmlspecialchars($row['hora']) ?></p>
            <p><strong>Día:</strong> <?= $dias[$row['iddia']] ?? 'Desconocido' ?></p>
          </div>
          <div class="horario-actions">
            <a href="<?= base_url('horarios/editar/' . $row['idhorario']) ?>" class="btn-edit" aria-label="Modificar horario <?= htmlspecialchars($row['evento']) ?>">Modificar</a>
            <a href="<?= base_url('horarios/delete/' . $row['idhorario']) ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este horario?')" aria-label="Eliminar horario <?= htmlspecialchars($row['evento']) ?>">Eliminar</a>
          </div>
        </div>
    <?php } ?>
  </div>

  <button class="btn-add" onclick="window.location.href='<?= base_url('horarios/agregar') ?>'">Agregar horario</button>
</div>

<footer class="footer">
  <p>Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara</p>
</footer>

</body>
</html>
