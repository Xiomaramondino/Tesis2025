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
            margin-bottom: 2rem;
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

        .btn-form {
            background: #081136;
            color: white;
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            display: inline-block;
        }

        .btn-form:hover {
            background-color: #666565;
            color: white;
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

    <!-- Botón cambiar colegio -->
    <div style="width: 100%; display: flex; justify-content: center; margin-top: 20px; margin-bottom: 10px;">
        <form action="<?= base_url('/cambiar-colegio') ?>" method="get">
            <button type="submit" class="btn-form">Cambiar de colegio</button>
        </form>
    </div>

    <!-- Contenedor principal -->
    <div class="card" role="main" aria-label="Lista de horarios de timbre">

        <!-- Eventos Especiales -->
        <?php if (!empty($eventos)) : ?>
            <h2 class="card-title" style="color:#d4b8e0;">Eventos Especiales</h2>
            <div class="horarios-list">
                <?php foreach ($eventos as $evento) : ?>
                    <div class="horario-card">
                        <div class="horario-info">
                            <p><strong>Descripción:</strong> <?= htmlspecialchars($evento['descripcion']) ?></p>
                            <p><strong>Fecha:</strong> <?= htmlspecialchars($evento['fecha']) ?></p>
                            <p><strong>Hora:</strong> <?= htmlspecialchars($evento['hora']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <h2 class="card-title" style="color:#d4b8e0;">Eventos Especiales</h2>
            <p style="color:white; text-align:center;">No hay eventos especiales activos.</p>
        <?php endif; ?>

        <!-- Horarios normales -->
        <h2 class="card-title" style="color:#d4b8e0;">Eventos Activos</h2>
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
                    <p style="color:white; text-align:center;">No hay horarios cargados.</p>
                <?php endif; ?>
        </div>

    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"
    ></script>

    <!-- Footer -->
    <footer class="footer">
        <p>
            Tesis timbre automático 2025 <br />
            Marquez Juan - Mondino Xiomara
        </p>
    </footer>
</body>
</html>
