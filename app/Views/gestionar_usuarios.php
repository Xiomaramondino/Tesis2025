<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #091342;
            padding-top: 100px;
        }

        .navbar {
            width: 100%;
            display: flex;
            align-items: center;
            background-color: #081136;
            padding: 1rem 2rem;
            position: fixed;
            z-index: 1000;
        }

        .navbar .logo {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            margin-left: 89px;
        }

        .navbar-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .gestion-btn, .cerrar-btn {
            background-color: transparent;
            color: white;
            border: none;
            padding: 0.3rem 0.8rem;
            font-size: 1rem;
            text-align: left;
            cursor: pointer;
            text-decoration: none;
        }

        .gestion-btn:hover,
        .cerrar-btn:hover,
        .gestion-btn:active,
        .cerrar-btn:active,
        .gestion-btn:focus,
        .cerrar-btn:focus {
            background-color: transparent;
            color: white;
            outline: none;
        }

        .footer {
            text-align: center;
            background-color: #081136;
            font-weight: bold;
            color: white;
            margin-top: 4.6rem;
            padding: 0.3rem;
        }

        .form-card {
            background: #081136;
            border-radius: 1.5rem;
            box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
            padding: 30px;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .form-control {
            padding: 0.6rem 1rem;
            background-color: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 0.8rem;
            color: white;
        }

        .form-control::placeholder {
            color: #bbb;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.08);
            color: #bbb;
            border: 1px solid #6f42c1;
            box-shadow: 0 0 10px #6f42c1;
        }

        .btn-form {
            background-color: #070f2e;
            color: white;
            border: none;
            width: 100%;
            border-radius: 10px;
            padding: 10px;
        }

        .btn-form:hover {
            background-color: #666565;
        }

        .btn-ancho-custom {
            width: 250px;
            max-width: 100%;
            background-color: #070f2e;
            border-radius: 13px;
        }

        .alert {
            margin-top: 20px;
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);
            font-size: 1rem;
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

        .alert .close-btn {
            background: none;
            border: none;
            color: inherit;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0;
            margin-left: 1rem;
            line-height: 1;
        }

        .directivo-card {
            background: #091342;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            padding: 20px;
            color: white;
            transition: background-color 0.3s ease;
        }

        .directivo-card:hover {
            background: #122466;
            box-shadow: 0 6px 20px rgba(111, 66, 193, 0.7);
        }

        .directivo-card h5 {
            margin-bottom: 0.3rem;
        }

        .directivo-card p {
            font-size: 0.9rem;
            margin-bottom: 1rem;
            color: #ccc;
            word-break: break-word;
        }

        .directivo-card .btn {
            padding: 0.3rem 0.8rem;
            font-size: 0.9rem;
            border-radius: 8px;
        }
        input:-webkit-autofill,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: #fff;
            transition: background-color 9999s ease-in-out 0s;
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset;
            caret-color: #fff;
        }

        input:-moz-autofill {
            box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset;
            -moz-text-fill-color: #fff;
            caret-color: #fff;
        }
    </style>
</head>

<body>
<!-- Navbar -->
<nav class="navbar sticky-top">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
    <div class="logo">RingMind</div>
    <div class="navbar-buttons">
        <a href="<?= base_url('/horarios'); ?>" class="btn btn-sm gestion-btn">Gestión de timbres</a>
        <form action="<?= base_url('/logout'); ?>" method="post">
            <button type="submit" class="btn btn-sm cerrar-btn">Cerrar sesión</button>
        </form>
    </div>
</nav>

<br>
<!-- Botones principales -->
<div class="text-center mb-3">
    <div class="d-flex justify-content-center align-items-center" style="gap: 15px;">
        <form action="<?= base_url('/cambiar-colegio') ?>" method="get" style="margin: 0;">
            <button type="submit" class="btn btn-form btn-ancho-custom">Cambiar de colegio</button>
        </form>
        <form action="<?= base_url('/sonar-timbre') ?>" method="post" style="margin: 0;">
            <button type="submit" class="btn btn-form btn-ancho-custom">Sonar timbre</button>
        </form>
    </div>
</div>

<!-- Formulario de alta de alumnos -->
<div class="container mt-4">
    <div class="col-md-6 mx-auto">
        <div class="form-card">
            <h2 class="text-center">Agregar alumnos</h2>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label="Cerrar">&times;</button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label="Cerrar">&times;</button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('directivo/agregarUsuario') ?>" method="post">
                <div class="mb-3">
                    <input type="text" name="usuario" class="form-control" placeholder="Nombre de usuario" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required>
                </div>
                <div style="margin-top:10px; background: transparent; padding:10px;">
                    ⚠️ <strong>Nota:</strong> Si el alumno no posee una cuenta en el sistema, se le generará una automáticamente junto a una contraseña aleatoria. También recibirá un correo para que pueda cambiarla.
                </div>
                <br>
                <button type="submit" class="btn btn-form">Agregar Usuario</button>
            </form>
        </div>
    </div>
</div>

<!-- Tarjetas de alumnos -->
<div class="container mt-4">
    <div class="card" style="border-radius: 1.5rem; background: #081136; border: 1px solid rgba(255, 255, 255, 0.05); color: white;">
        <div class="card-header">
            <h2 class="text-center">Alumnos vinculados</h2>
        </div>
        <div class="card-body">
            <?php if (empty($lectores)) : ?>
                <p class="text-center">No hay alumnos vinculados al colegio.</p>
            <?php else : ?>
                <div class="row g-3">
                    <?php foreach ($lectores as $lector) : ?>
                        <div class="col-md-6">
                            <div class="directivo-card">
                                <h5><?= esc($lector['usuario']) ?></h5>
                                <p><?= esc($lector['email']) ?></p>
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('/directivo/eliminarUsuario/' . $lector['idusuario']) ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('¿Estás seguro de que querés eliminar este alumno de este colegio?');">
                                       Desvincular
                                    </a>
                                    <a href="<?= base_url('/directivo/editarUsuario/' . $lector['idusuario']) ?>"
                                       class="btn btn-sm btn-secondary">
                                       Editar
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
        <p>
            Tesis timbre automático 2025 <br />
            Marquez Juan - Mondino Xiomara
        </p>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
