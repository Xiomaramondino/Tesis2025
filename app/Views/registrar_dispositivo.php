<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrar Dispositivo</title>
    <link rel="icon" href="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" type="image/png" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            background-color: #091342;
            padding-top: 80px;
            color: #ffffff;
        }

      /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            background-color: #081136;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }

        .navbar-left img {
            width: 50px;
            height: 50px;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--color-text-white);
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .navbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-btn {
            background-color: var(--color-tertiary);
            color: var(--color-text-white);
            padding: 0.5rem 1rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .nav-btn:hover {
            background-color: #666565;
            transform: translateY(-2px);
        }

        .hamburger {
            display: none;
            font-size: 1.5rem;
            background: none;
            border: none;
            color: var(--color-text-white);
            cursor: pointer;
        }
        /* Container */
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Card */
        .card {
            background: #081136;
            padding: 2rem;
            border-radius: 1.5rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
            margin-bottom: 2rem;
        }

        .card h2 {
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: white;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: white;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            background-color: transparent;
            color: white;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        button {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 1.5rem auto 0;
            padding: 0.75rem;
            font-size: 1.1rem;
            font-weight: 500;
            background-color: #070f2e;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #1e3a8a;
            transform: translateY(-2px);
        }

        /* Alerts */
        .alert {
            margin: 1.5rem auto;
            padding: 1rem;
            border-radius: 1rem;
            width: 100%;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .alert-success {
            background-color: rgba(72, 187, 120, 0.15);
            border: 1px solid rgba(72, 187, 120, 0.6);
            color: #48bb78;
        }

        .alert-danger {
            background-color: rgba(220, 38, 38, 0.15);
            border: 1px solid rgba(220, 38, 38, 0.6);
            color: #dc2626;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            padding: 0.75rem;
            text-align: left;
        }

        th {
            background-color: #070f2e;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: 1px solid #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 1.5rem;
            background-color: #081136;
            color: white;
            font-weight: 500;
            margin-top: 3rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 60px;
                left: 0;
                width: 100%;
                background-color: #081136;
                padding: 1rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            }

            .navbar-menu.active {
                display: flex;
            }

            .hamburger {
                display: block;
            }

            .card {
                padding: 1.5rem;
            }

            button {
                max-width: 100%;
            }

            .alert {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-left">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" alt="Logo">
    </div>
    <div class="logo">RingMind</div>
    <button class="hamburger"><i class="fas fa-bars"></i></button>
    <div class="navbar-right">
        <a href="<?= base_url('vista_admin'); ?>" class="nav-btn">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</nav>

<div class="container">

    <!-- Estado general de dispositivos -->
    <div class="card">
        <h2>Estado de tus dispositivos</h2>
        <?php 
            $registrados = count($mis_dispositivos);
            $pendientes = max(0, $totalComprados - $registrados);         
        ?>
        <p style="text-align: center; font-size: 1.1rem;">
            Compraste <strong><?= $totalComprados ?></strong> dispositivo(s).<br>
            Ya registraste <strong><?= $registrados ?></strong>.<br>
            <?php if ($totalComprados == 0): ?>
                <span style="color: #f87171;">Aún no compraste dispositivos.</span>
            <?php elseif ($pendientes > 0): ?>
                <span style="color: #f87171;">Te falta registrar <?= $pendientes ?> dispositivo(s).</span>
            <?php else: ?>
                <span style="color: #48bb78;">¡Todos tus dispositivos están registrados!</span>
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
            <p style="text-align: center;">No puedes registrar dispositivos porque aún no compraste ninguno.</p>
        <?php else: ?>
            <p style="text-align: center;">Ya registraste todos tus dispositivos.</p>
        <?php endif; ?>
    </div>

    <div class="card">
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
                    <tr><td colspan="3" style="text-align: center;">No tienes dispositivos registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<footer class="footer">
    <p>Tesis Timbre Automático 2025<br>Marquez Juan - Mondino Xiomara</p>
</footer>

<script>
    // Hamburger menu toggle
    const hamburger = document.querySelector('.hamburger');
    const navbarMenu = document.querySelector('.navbar-menu');

    hamburger.addEventListener('click', () => {
        navbarMenu.classList.toggle('active');
    });
</script>
</body>
</html>