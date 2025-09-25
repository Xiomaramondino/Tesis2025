<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Visualizar Horarios</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background-color: #091342;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        z-index: 1000;
    }
    .navbar .logo {
        color: white;
        font-size: 1.8rem;
        font-weight: bold;
    }
    .navbar-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .volver-btn {
        background-color: transparent;
        color: white;
        border: none;
        padding: 0.3rem 0.8rem;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
    }
    .volver-btn:hover {
        color: white;
        outline: none;
    }

    /* Contenido principal */
    .main-content {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 85px 20px 20px 20px; /* espacio para navbar */
        box-sizing: border-box;
    }

    .card {
        background: #081136;
        border-radius: 1.5rem;
        padding: 2rem 2.5rem;
        max-width: 700px;
        width: 100%;
        box-shadow: 0 8px 30px rgba(0,0,0,0.6);
        margin-bottom: 2rem;
        margin-top: -90px;
    }
    .card-title {
        text-align: center;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #d4b8e0;
    }

    .horarios-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .horario-card {
        background: #070f2e;
        border-radius: 1rem;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .horario-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(163,143,193,0.5);
    }
    .horario-info p {
        margin: 0.15rem 0;
        font-size: 1.05rem;
    }

    .btn-main {
        margin-bottom: 1.5rem;
        background-color: #070f2e;
        color: white;
        border: none;
        border-radius: 1rem;
        padding: 0.9rem 1.8rem;
        font-size: 1.1rem;
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
        background-color: #333;
        transform: translateY(-2px);
    }
    .btn-main:disabled {
        background-color: #333;
        color: #999;
        cursor: not-allowed;
    }
    .disabled-message {
        color: #e24363;
        text-align: center;
        margin-bottom: 1rem;
        font-weight: bold;
    }
    .btn-custom {
        background-color: #070f2e;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 1rem;
        font-weight: 500;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .btn-custom:hover {
        background-color: #666565;
        transform: translateY(-2px);
        color: #fff;
    }

    /* Footer estilo bonito */
    .footer {
        text-align: center;
        background-color: #081136;
        font-weight: bold;
        color: white;
        padding: 0.8rem;
        font-size: 0.95rem;
    }

</style>
</head>
<body>

<nav class="navbar">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo" />
    <div class="logo">RingMind</div>
    <div class="navbar-buttons">
        <form action="<?= base_url('/logout'); ?>" method="post">
            <button type="submit" class="btn btn-sm volver-btn">Cerrar sesión</button>
        </form>
    </div>
</nav>

<div class="container-calendar text-center" style="margin-top: 100px;">
    <div class="flex flex-col md:flex-row justify-center gap-4 mb-4">
        <a href="<?= base_url('/cambiar-colegio') ?>" class="btn-custom">
            <i class="fas fa-school"></i> Cambiar de colegio
        </a>
        <a href="<?= base_url('/calendario_alumno') ?>" class="btn-custom">
            <i class="fas fa-calendar-alt"></i> Calendario
        </a>
    </div>
</div>

<?php
  // Verificar dispositivo asociado
  $session = session();
  $idcolegio = $session->get('idcolegio');
  $db = \Config\Database::connect();
  $dispositivo = $db->table('dispositivo')->where('idcolegio', $idcolegio)->get()->getRow();
  ?>

<div class="main-content">
    <div class="card" role="main" aria-label="Lista de horarios de timbre">

        <button class="btn-main" onclick="window.location.href='<?= base_url('feriados/lectura') ?>'" <?= $dispositivo ? '' : 'disabled' ?>>
            <i class="fas fa-calendar-alt"></i> Ver Feriados del Año
        </button>
        <?php if (!$dispositivo): ?>
            <p class="disabled-message">No tienes un dispositivo asociado, no puedes ver los feriados.</p>
        <?php endif; ?>

        <?php if (!empty($eventos)) : ?>
            <h2 class="card-title">Eventos Especiales</h2>
            <div class="horarios-list">
                <?php foreach ($eventos as $evento) : ?>
                    <div class="horario-card">
                        <div class="horario-info">
                            <p><strong>Descripción:</strong> <?= htmlspecialchars($evento->descripcion) ?></p>
                            <p><strong>Fecha:</strong> <?= htmlspecialchars($evento->fecha) ?></p>
                            <p><strong>Hora:</strong> <?= htmlspecialchars($evento->hora) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <h2 class="card-title">Eventos Especiales</h2>
            <p style="color:white; text-align:center;">No hay eventos especiales activos.</p>
        <?php endif; ?>

        <h2 class="card-title">Eventos Activos</h2>
        <div class="horarios-list">
            <?php 
            $dias = [1=>'Lunes',2=>'Martes',3=>'Miércoles',4=>'Jueves',5=>'Viernes',6=>'Sábado',7=>'Domingo'];
            if (!empty($data)) :
                foreach ($data as $row) : ?>
                    <div class="horario-card">
                        <div class="horario-info">
                            <p><strong>Evento:</strong> <?= htmlspecialchars($row['evento']) ?></p>
                            <p><strong>Hora:</strong> <?= htmlspecialchars($row['hora']) ?></p>
                            <p><strong>Día:</strong> <?= $dias[$row['iddia']] ?? 'Desconocido' ?></p>
                        </div>
                    </div>
                <?php endforeach; 
            else: ?>
                <p style="color:white; text-align:center;">No hay horarios activos.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<footer class="footer">
    <p>
        Tesis timbre automático 2025 <br>
        Marquez Juan - Mondino Xiomara
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
