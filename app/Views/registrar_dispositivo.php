<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrar Dispositivo</title>
    <link rel="icon" href="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" type="image/png" />

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            line-height: 1.6;
            background-color: #091342;
            padding-top: 100px;
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            width: 100%;
            height: 70px;
            background-color: #081136;
            padding: 0 2rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        .logo-left { display: flex; align-items: center; }
        .logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
        }
        .navbar-buttons button, .volver-btn {
            background-color: transparent;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
        }
        .container { max-width: 900px; margin: 40px auto; padding: 20px; }
        .card {
            background: #081136;
            padding: 30px;
            border-radius: 1.5rem;
            box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
            margin-bottom: 50px;
        }
        .card h2 { text-align: center; color: white; margin-bottom: 1rem; }
        .form-group label { color: white; font-weight: 600; }
        .form-control {
            width: calc(100% - 20px);
            padding: 0.6rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            background-color: transparent;
            color: white;
            margin-bottom: 0.8rem;
        }
        .form-control::placeholder { color: #bbb; }
        button {
            padding: 12px 30px;
            font-size: 1.1rem;
            background-color:#070f2e;
            border: none;
            color:white;
            cursor: pointer;
            border-radius: 5px;
            width: 40%;
            margin: 13px auto 0 auto;
            display: block;
        }
        button:hover { background-color:#666565; }
        .alert {
            margin: 20px auto;
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            width: 60%;
            text-align: center;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);
        }
        .alert-success {
            background-color: rgba(72, 187, 120, 0.15);
            border: 1.5px solid rgba(72, 187, 120, 0.6);
            color: #48bb78;
        }
        .alert-danger {
            background-color: rgba(220, 38, 38, 0.15);
            border: 1.5px solid rgba(220, 38, 38, 0.6);
            color: #dc2626;
        }
        table { width: 100%; border-collapse: collapse; color: white; margin-top: 10px; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #070F2E; font-weight: bold; }
        tr:hover { background-color: rgba(255, 255, 255, 0.05); }
        .btn-sm { padding: 6px 12px; border-radius: 4px; text-decoration: none; }
        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: 1px solid #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .footer {
            text-align: center;
            padding: 0.1rem;
            background-color: #081136;
            font-weight: bold;
            color: white;
            margin-top: 3rem;
        }
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="50px" alt="Logo" class="logo-left">
    <div class="logo">RingMind</div>
    <form action="<?= base_url('/vista_admin'); ?>" method="get" class="navbar-buttons">
        <button type="submit" class="volver-btn">Volver</button>
    </form>
</nav>

<div class="container">

    <!-- Estado general de dispositivos -->
    <div class="card">
        <h2>Estado de tus dispositivos</h2>
        <?php 
            $registrados = count($mis_dispositivos);
            $pendientes = max(0, $totalComprados - $registrados);         
        ?>
        <p style="color:white; text-align:center; font-size:1.1rem;">
            Compraste <strong><?= $totalComprados ?></strong> dispositivo(s).<br>
            Ya registraste <strong><?= $registrados ?></strong>.<br>
            <?php if ($totalComprados == 0): ?>
                <span style="color:#f87171;">Aún no compraste dispositivos.</span>
            <?php elseif ($pendientes > 0): ?>
                <span style="color:#f87171;">Te falta registrar <?= $pendientes ?> dispositivo(s).</span>
            <?php else: ?>
                <span style="color:#48bb78;">¡Todos tus dispositivos están registrados!</span>
            <?php endif; ?>
        </p>
    </div>

    <div class="card">
        <h2>Registrar Dispositivo</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>

        <?php if ($totalComprados > 0 && $pendientes > 0): ?>
        <form action="<?= base_url('guardar_dispositivo') ?>" method="post">
            <?= csrf_field(); ?>
            <div class="form-group">
                <label for="mac">Dirección MAC:</label>
                <input type="text" name="mac" class="form-control" placeholder="AA:BB:CC:DD:EE:FF" required>
            </div>
            <button type="submit">Registrar</button>
        </form>
        <?php elseif ($totalComprados == 0): ?>
            <p style="color:white; text-align:center;">No puedes registrar dispositivos porque aún no compraste ninguno.</p>
        <?php else: ?>
            <p style="color:white; text-align:center;">Ya registraste todos tus dispositivos.</p>
        <?php endif; ?>
    </div>

    <div class="card mt-4">
        <h2>Mis Dispositivos</h2>
        <table>
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
                                <a href="<?= base_url('/dispositivos/eliminar/' . esc($dispositivo['iddispositivo'])) ?>" class="btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este dispositivo?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" style="text-align:center;">No tienes dispositivos registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<footer class="footer">
    <p>Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara</p>
</footer>
</body>
</html>
