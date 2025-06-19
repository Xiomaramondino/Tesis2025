<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Dispositivo</title>
    <link rel="icon" href="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" type="image/png">

    <style>
        body {
            background-color: #c6a9dc;
            margin: 0;
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Navbar */
        .navbar {
            width: 97%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #4a045a;
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .navbar .logo {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
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
            padding: 0.5rem 1rem;
            font-size: 1rem;
            text-align: left;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
            border-radius: 5px;
        }

        .volver-btn:hover,
        .volver-btn:active,
        .volver-btn:focus {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            outline: none;
        }

        /* Contenedor principal */
        .container {
            max-width: 900px; /* Aumentado para mejor visualización de la tabla */
            margin: 120px auto 40px auto; /* Espacio para la navbar y el footer */
            padding: 20px;
        }

        .card {
            background-color: #ebdef0;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15); /* Sombra más pronunciada */
            margin-bottom: 30px; /* Espacio entre tarjetas */
        }

        .card h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #4a045a; /* Color del texto de los títulos */
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 600; /* Un poco más de peso a las etiquetas */
        }

        .form-control {
            width: calc(100% - 20px); /* Ajuste para el padding */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box; /* Incluye padding y border en el ancho */
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #540466;
            box-shadow: 0 0 0 3px rgba(84, 4, 102, 0.2);
            outline: none;
        }

        button {
            padding: 12px 25px;
            font-size: 1.1rem;
            background-color: #540466;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 15px; /* Espacio superior para el botón */
        }

        button:hover {
            background-color: #33023e; /* Tono más oscuro al pasar el mouse */
            transform: translateY(-2px); /* Ligero efecto de elevación */
        }

        .alert {
            margin-top: 20px;
            text-align: center;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: 500;
            animation: fadeIn 0.5s ease-out; /* Animación para alertas */
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Tabla */
        .table {
            width: 100%;
            border-collapse: collapse; /* Elimina el espacio entre celdas */
            margin-top: 20px;
            background-color: #fff; /* Fondo blanco para las tablas */
            border-radius: 8px;
            overflow: hidden; /* Asegura que las esquinas redondeadas se apliquen a todo */
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .table thead {
            background-color: #4a045a; /* Color de cabecera de la tabla */
            color: white;
        }

        .table th,
        .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0; /* Límite sutil entre filas */
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9; /* Rayas para facilitar la lectura */
        }

        .table tbody tr:hover {
            background-color: #f0e6f3; /* Efecto hover en las filas */
            transition: background-color 0.3s ease;
        }

        .table td:last-child {
            text-align: center; /* Centra el botón de acción */
        }

        /* Botones de acción en la tabla */
        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block; /* Para que el margin funcione correctamente */
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: 1px solid #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
            transform: translateY(-1px);
        }

        .text-center {
            text-align: center;
            font-style: italic;
            color: #666;
        }

        /* Separador */
        .my-5 {
            margin-top: 50px;
            margin-bottom: 50px;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            text-align: center;
            padding: 1.5rem;
            background-color: #4a045a;
            font-weight: bold;
            color: white;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.2);
        }

        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

    </style>
</head>
<body>


<nav class="navbar sticky-top">
    <div class="logo">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" width="50px" alt="Logo" style="padding-right: 510px;"> RingMind
    </div>
    <div class="navbar-buttons">
        <form action="<?= base_url('/vista_admin'); ?>" method="get">
            <button type="submit" class="volver-btn">Volver</button>
        </form>
    </div>
</nav>

<div class="container">
    <div class="card">
        <h2>Registrar Dispositivo</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>

        <form action="<?= base_url('guardar_dispositivo') ?>" method="post">
            <?= csrf_field(); ?>
            <div class="form-group">
                <label for="mac">Dirección MAC:</label>
                <input type="text" name="mac" class="form-control" placeholder="AA:BB:CC:DD:EE:FF" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Registrar</button>
        </form>
    </div>

    <hr class="my-5">

    <div class="card mt-4">
        <div class="card-header">
            <h2>Mis Dispositivos</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Dirección MAC</th>
                        <th>Colegio</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mis_dispositivos)): ?>
                        <?php foreach ($mis_dispositivos as $dispositivo): ?>
                            <tr>
                                <td><?= esc($dispositivo['mac']) ?></td>
                                <td><?= esc($dispositivo['nombre_colegio']) ?></td>
                                <td>
                                    <a href="<?= base_url('/dispositivos/eliminar/' . esc($dispositivo['iddispositivo'])) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este dispositivo?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No tienes dispositivos registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="footer">
    <p>Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara</p>
</footer>

</body>
</html>