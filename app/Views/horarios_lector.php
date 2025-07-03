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
            padding-top: 70px; /* Reducido para menos espacio arriba */
            min-height: 100vh;
            height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-size: cover;
            background-position: center;
            background-color: #b6a0d7;
        }

        /* Barra de navegación sticky */
        .navbar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #4a045a;
            padding: 1rem 2rem;
            margin-bottom: 0;
            position: fixed;
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

        .card-container {
            width: 80%;
            max-width: 900px;
            flex-grow: 1;
            margin-top: 35px;
            flex-direction: column;
            justify-content: flex-start;
            padding-bottom: 60px;
        }

        .footer {
            text-align: center;
            padding: 1.2rem;
            background-color: #4a045a;
            font-weight: bold;
            color: white;
            width: 100%;
            position: relative;
            bottom: 0;
        }

        /* Estilo para el botón Cambiar de colegio */
        .btn-form {
            background-color:#4a045a; 
            color: white;
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
            border: none;
            border-radius: 0.5rem;
            margin: 0;
            cursor: pointer;
            display: inline-block;
        }

        .btn-form:hover {
            background-color: #4a045a; /* tono más oscuro */
            color: white;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación sticky -->
    <nav class="navbar sticky-top">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" width="60px" alt="Logo" />
        <div class="logo" style="padding-right: -600px;">RingMind</div>

        <div class="navbar-buttons">
            <form action="<?= base_url('/logout'); ?>" method="post">
                <button type="submit" class="btn btn-sm volver-btn">Cerrar sesión</button>
            </form>
        </div>
    </nav>

    <!-- Contenedor para centrar y separar el botón con menos margen -->
    <div style="width: 100%; display: flex; justify-content: center; margin-top: 30px; margin-bottom: 10px;">
        <form action="<?= base_url('/cambiar-colegio') ?>" method="get">
            <button type="submit" class="btn-form">Cambiar de colegio</button>
        </form>
    </div>

    <!-- Contenido principal con card -->
    <div class="container card-container">
        <div class="card" style="border-radius: 1.5rem;">
            <div class="card-body">
                <h1 class="card-title text-center">Horarios</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Evento</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row->evento) ?></td>
                            <td><?= htmlspecialchars($row->hora) ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"
    ></script>

    <!-- Pie de página -->
    <footer class="footer">
        <p>
            Tesis timbre automático 2025 <br />
            Marquez Juan - Mondino Xiomara
        </p>
    </footer>
</body>
</html>
