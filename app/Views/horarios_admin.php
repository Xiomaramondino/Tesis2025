<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #091342;
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
        }

        /* Navbar fija arriba */
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
            font-size: 1.9rem;
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
            text-align: left;
            cursor: pointer;
            text-decoration: none;
        }
        .volver-btn:hover,
        .volver-btn:active,
        .volver-btn:focus {
            background-color: transparent;
            color: white; 
            outline: none;
        }

        /* Contenedor principal: deja espacio para navbar y footer */
        .main-content {
            flex: 1; /* ocupa todo el espacio restante */
            display: flex;
            justify-content: center;
            align-items: flex-start; /* inicia desde arriba */
            padding: 120px 20px 20px 20px; /* top navbar, bottom footer */
            box-sizing: border-box;
        }

        /* Card de horarios */
        .card {
            background: #081136;
            border-radius: 1.5rem;
            padding: 2rem 2.5rem;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
            margin-bottom: 2rem; /* espacio antes del footer */
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

        /* Footer */
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

<!-- Navbar -->
<nav class="navbar sticky-top">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
    <div class="logo">RingMind</div>
    <div class="navbar-buttons">
        <a href="<?= base_url('/vista_admin'); ?>" class="btn btn-sm volver-btn">Volver</a>
    </div>
</nav>

<!-- Contenido principal -->
<div class="main-content">
    <div class="card" role="main" aria-label="Lista de horarios de timbre">

        <!-- Eventos especiales -->
        <?php if(!empty($eventosEspeciales)) : ?>
            <h2 class="card-title" style="margin-top:2rem; margin-bottom:1rem; text-align:center; color:#d4b8e0;">Eventos Especiales</h2>
            <div class="horarios-list mb-4">
                <?php foreach($eventosEspeciales as $evento) : ?>
                    <div class="horario-card">
                        <div class="horario-info">
                            <p><strong>Descripción: </strong><?= htmlspecialchars($evento->descripcion) ?></p>
                            <p><strong>Fecha: </strong><?= htmlspecialchars($evento->fecha) ?></p>
                            <p><strong>Hora: </strong><?= htmlspecialchars($evento->hora) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Horarios normales -->
        <h2 class="card-title" style="margin-top:2rem; margin-bottom:1rem; text-align:center; color:#d4b8e0;">Horarios</h2>
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
                        <p><strong>Evento: </strong><?= htmlspecialchars($row->evento) ?></p>
                        <p><strong>Hora: </strong><?= htmlspecialchars($row->hora) ?></p>
                        <p><strong>Día: </strong><?= $dias[$row->iddia] ?? 'Desconocido' ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <p>Tesis timbre automático 2025 <br>
    Marquez Juan - Mondino Xiomara</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
