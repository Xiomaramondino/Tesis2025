<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
body {
    background-color: #c6a9dc;
    padding-top: 100px;
}

.navbar {
    width: 100%;
    display: flex;
    align-items: center;
    background-color: #4a045a;
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
    padding: 0.5rem;
    background-color: #4a045a;
    font-weight: bold;
    color: white;
    width: 100%;
    position: relative;
    bottom: 0;
}

.form-card {
    background-color: #eddcf5;
    border-radius: 20px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    padding: 30px;
    margin-top: 20px;
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
    background-color: #550055;
    color: white;
    border: none;
    width: 100%;
    border-radius: 10px;
    padding: 10px;
}

.btn-form:hover {
    background-color: #3d003d;
}

.table {
    width: 100%;
    margin-top: 30px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.table th,
.table td {
    text-align: center;
    vertical-align: middle;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #ddd;
}

.alert {
    margin-top: 10px;
    text-align: center;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.alert .close-btn {
    background: none;
    border: none;
    color: inherit;
    font-size: 1.5rem;
    font-weight: bold;
    line-height: 1;
    cursor: pointer;
    float: right;
    margin-right: -30px; 
    margin-top: -5px;
}
</style>

<body>
<!-- Barra de navegación -->
<nav class="navbar sticky-top">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" width="60px" alt="Logo">
    <div class="logo" style="margin-left: 89px;">RingMind</div>


    <div class="navbar-buttons">
        <a href="<?= base_url('/horarios'); ?>" class="btn btn-sm gestion-btn">Gestión de timbres</a>
        <form action="<?= base_url('/logout'); ?>" method="post">
            <button type="submit" class="btn btn-sm cerrar-btn">Cerrar sesión</button>
        </form>
    </div>
</nav>

<!-- Formulario para agregar nuevo usuario -->
<div class="container mt-4">
    <div class="col-md-6 mx-auto">
        <div class="form-card">
            <h2>Agregar alumnos</h2>

            <!-- Mensajes dentro del formulario -->
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
                <div class="mb-3">
    <input type="text" name="curso" class="form-control" placeholder="Curso" required>
</div>
                <div style="margin-top:10px; background: #f1f1f1; padding:10px; border-left: 5px solid #2196F3;">
                        ⚠️ <strong>Nota:</strong> El sistema generará una contraseña automática y enviará un correo al usuario con un enlace para que cree su propia contraseña.
                    </div>
                    <br>
                <button type="submit" class="btn btn-form">Agregar Usuario</button>
            </form>
        </div>
    </div>
</div>

<!-- Tabla de usuarios existentes -->
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <center><h2>Usuarios existentes</h2></center>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre de Usuario</th>
                        <th>Correo Electrónico</th>
                        <th>Curso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lectores as $lector): ?>
                        <tr>
                            <td><?= esc($lector['usuario']) ?></td>
                            <td><?= esc($lector['email']) ?></td>
                            <td><?= esc($lector['curso']) ?></td>
                            <td>
                                
                            <a href="<?= base_url('/directivo/editarUsuario/' . $lector['idusuario']) ?>" class="text-decoration-none" style="color: black; margin-right: 10px;">Editar</a>

    <a href="<?= base_url('/directivo/eliminarUsuario/' . $lector['idusuario']) ?>" 
       class="text-decoration-none" 
       style="color: black;" 
       onclick="return confirm('¿Estás seguro de que querés eliminar este usuario?');">
        Eliminar
    </a>


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
        Marquez Juan - Mondino Xiomara</p>
    </div>
</footer>
</body>
</html>
