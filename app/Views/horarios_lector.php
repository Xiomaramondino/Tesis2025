<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Visualizar Horarios</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            padding-top: 90px; /* espacio para navbar */
            padding-bottom: 70px; /* espacio para footer */
            min-height: 100vh;
            width: 100%;
            background-size: cover;
            background-position: center;
            background-color: #091342;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #081136;
            padding: 1rem 2rem;
            margin-bottom: 0;
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .navbar .logo {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
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

        .card {
            background: #081136;
            border-radius: 1.5rem;
            padding: 2rem 2.5rem;
            max-width: 700px;
            margin: 2rem auto;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
            width: 90%;
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
            box-shadow: 0 4px 12px rgba(163, 143, 193, 0.25);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: white;
        }

        .horario-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(163, 143, 193, 0.5);
        }

        .horario-info p {
            margin: 0.15rem 0;
            font-size: 1.05rem;
            line-height: 1.3;
        }

        .footer {
            text-align: center;
            background-color: #081136;
            font-weight: bold;
            color: white;
            padding: 0.8rem;
            width: 100%;
            font-size: 0.95rem;
            position: fixed;
            bottom: 0;
            left: 0;
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
            cursor: not-allowed;
            color: #999;
        }

        .disabled-message {
            color: #e24363;
            text-align: center;
            margin-bottom: 1rem;
            font-weight: bold;
            font-size: 0.95rem;
        }
        .btn-custom {
    background-color: var(--color-tertiary, #070f2e);
    color: var(--color-text-white, #fff);
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 500;
    text-decoration: none;
}

.btn-custom:hover {
    background-color: #666565;
    transform: translateY(-2px);
    color: var(--color-text-white, #fff);
}

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo" />
        <div class="logo">RingMind</div>
        <div class="navbar-buttons">
            <form action="<?= base_url('/logout'); ?>" method="post">
                <button type="submit" class="btn btn-sm volver-btn">Cerrar sesión</button>
            </form>
        </div>
    </nav>

 <!-- Botón cambiar colegio con estilo personalizado -->
<div class="container-calendar mt-4 text-center">
    <div class="flex flex-col md:flex-row justify-center gap-4 mb-8">
        <a href="<?= base_url('/cambiar-colegio') ?>" class="btn-custom">
            <i class="fas fa-school"></i>
            Cambiar de colegio
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

    <!-- Contenedor principal -->
    <div class="card" role="main" aria-label="Lista de horarios de timbre">

        <!-- Botón Ver Feriados -->
        <button class="btn-main" onclick="window.location.href='<?= base_url('feriados/lectura') ?>'" <?= $dispositivo ? '' : 'disabled' ?>>
            <i class="fas fa-calendar-alt"></i> Ver Feriados del Año
        </button>
        <?php if (!$dispositivo): ?>
            <p class="disabled-message">No tienes un dispositivo asociado, no puedes ver los feriados.</p>
        <?php endif; ?>

        <!-- Eventos Especiales -->
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
        <?php else : ?>
            <h2 class="card-title">Eventos Especiales</h2>
            <p style="color:white; text-align:center;">No hay eventos especiales activos.</p>
        <?php endif; ?>

        <!-- Horarios normales -->
        <h2 class="card-title">Eventos Activos</h2>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Footer -->
    <footer class="footer">
        <p>
            Tesis timbre automático 2025 <br />
            Marquez Juan - Mondino Xiomara
        </p>
    </footer>
</body>
</html>
