<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Dispositivo</title>

    <style>
        body {
            background-color: #c6a9dc;
            margin: 0;
            font-family: sans-serif;
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

        /* Contenedor principal */
        .container {
            max-width: 500px;
            margin: 120px auto 0 auto; /* Espacio para la navbar */
            padding: 20px;
        }

        .card {
            background-color: #ebdef0;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 55px;
    
        }

        .card h2 {
            text-align: center;
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.3rem;
            color: #333;
            font-weight: 500;
        }

        .form-control {
            width: 95%;
            padding: 0.6rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 0.7rem;
            display: block;        /* Cambia el tipo de display a block */
            margin-left:0.5px;     /* Centra el campo horizontalmente */
        }
        button {
            padding: 0.4rem 1.7rem;
            font-size: 1.1rem;
            background-color: #540466;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }

        button:hover {
            background-color: black;
        }

        .alert {
            margin-top: 10px;
            text-align: center;
            padding: 0.5rem;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Footer */
        .footer {
            margin-top: 95px;
      text-align: center;
      padding: 1.3rem;
       background-color: #4a045a;
      font-weight: bold;
        color: white;
        }
        
    </style>
</head>
<body>


<!-- Barra de navegación sticky -->
<nav class="navbar sticky-top">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" width="60px" alt="Logo">
    <div class="logo" style="padding-right: 50px;">RingMind</div>

    <div class="navbar-buttons">
        <form action="<?= base_url('/vista_admin'); ?>" method="get">
            <button type="submit" class="btn btn-sm volver-btn">Volver</button>
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

    <!-- Tabla de dispositivos registrados -->
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

<!-- FOOTER -->
<footer class="footer">
    <p>Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara</p>
</footer>

</body>
</html>
