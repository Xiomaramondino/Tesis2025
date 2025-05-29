<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Directivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #c6a9dc;
            padding-top: 100px;
        }

        .form-card {
            background-color: #eddcf5;
            border-radius: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            padding: 30px;
        }

        .form-card h2 {
            
            text-align: center;
            margin-bottom: 20px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }

        .btn-form {
            background-color:  #4a045a;
            color: white;
            border: none;
            width: 100%;
            border-radius: 10px;
            padding: 10px;
        }

        .btn-form:hover {
            background-color: #3d003d;
        }

        .form-note {
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        .navbar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #540466;
            padding: 1rem 2rem;
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

        .cerrar-btn {
            background-color: transparent;
            color: white;
            border: none;
            padding: 0.3rem 0.8rem;
            font-size: 1rem;
            text-align: left;
            cursor: pointer;
            text-decoration: none;
        }

        .cerrar-btn:hover,
        .cerrar-btn:active,
        .cerrar-btn:focus {
            background-color: transparent;
            color: white;
            outline: none;
        }

        .footer {
            text-align: center;
            padding: 0.5rem;
            background-color: #4a045a;
            font-weight: bold;
            color: white;
            width: 100%;
            position: relative;
            bottom: 0;
        }
        .btn-ancho-custom {
        width: 250px; 
        max-width: 100%;
        background-color: #4a045a;
        border-radius: 13px;
}

    </style>

    <nav class="navbar sticky-top">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/DINGDONG.jpg" width="60px" alt="Logo">
        <div class="logo" style="padding-left: 80px;">RingMind</div>
        <div class="navbar-buttons">
            <a href="<?= base_url('/admin/horarios'); ?>" class="btn btn-sm cerrar-btn">Visualizar horarios</a>
            <form action="<?= base_url('/logout'); ?>" method="post">
                <?= csrf_field(); ?>
                <button type="submit" class="btn btn-sm cerrar-btn">Cerrar sesión</button> <br>
            </form>
        </div>
    </nav>
</head>
<body> <br>
<div class="text-center mb-3">
    <form action="<?= base_url('registrar_dispositivo') ?>" method="get">
        <button type="submit" class="btn btn-form btn-ancho-custom">Registrar Dispositivo</button>
    </form>
</div>

    <div class="container mt-4">
        <div class="col-md-6 mx-auto">
            <div class="form-card">
                <h2>Agregar usuario directivo</h2>
                <?php if (session()->get('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <?= session()->get('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->get('success') || session()->get('exito')): ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <?= session()->get('success') ?: session()->get('exito'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('admin/guardarUsuario') ?>" method="post">
                    <div class="mb-3">
                        <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Nombre de usuario" required>
                    </div>

                    <div class="mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                    </div>

                    <div class="mb-3">
                        <select id="idturno" name="idturno" class="form-select" required>
                            <option value="" disabled selected>Selecciona turno</option>
                            <option value="1">Mañana</option>
                            <option value="2">Tarde</option>
                            <option value="3">Mixto</option>
                        </select>
                    </div>

                    <div style="margin-top:10px; background: #f1f1f1; padding:10px; border-left: 5px solid #2196F3;">
                        ⚠️ <strong>Nota:</strong> El sistema generará una contraseña automática y enviará un correo al usuario con un enlace para que cree su propia contraseña.
                    </div>
                    <br>

                    <div><button type="submit" class="btn btn-form">Agregar directivo</button></div>
                </form>
            </div>
        </div>
    </div> 
    
    <hr class="my-5">
    <!-- Card para la tabla de usuarios directivos -->
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Usuarios directivos</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo Electrónico</th>
                            <th>IdRol</th>
                            <th>IdTurno</th>
                            <th>Acción</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios_directivos as $usuario): ?>
                            <tr>
                                <td><?= esc($usuario['usuario']) ?></td>
                                <td><?= esc($usuario['email']) ?></td>
                                <td><?= esc($usuario['idrol']) ?></td>
                                <td><?= esc($usuario['idturno']) ?></td>
                                <td>
                                <a href="<?= base_url('admin/eliminar_directivo/' . $usuario['idusuario']) ?>" 
   class="text-decoration-none" 
   style="color: black;" 
   onclick="return confirm('¿Estás seguro de eliminar al directivo?');">Eliminar</a>

                                </td>
                                <td>
                                    <a href="<?= base_url('admin/editarDirectivo/' . $usuario['idusuario']) ?>" class="text-decoration-none" style="color: black;">Editar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <footer class="footer mt-4">
        <div class="container text-center">
            <p>Tesis timbre automático 2025 <br>
                Marquez Juan - Mondino Xiomara
            </p>
        </div>
    </footer>
</body>
</html>
