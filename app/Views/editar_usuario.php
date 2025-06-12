<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #c7a7da; /* mismo tono violeta de fondo */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-card {
            background-color: #f2dff6;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .form-card h1 {
            text-align: center;
            font-family: 'Brush Script MT', cursive;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
        }

        .btn-form {
            background-color: #5c0066;
            color: white;
            border-radius: 8px;
            width: 100%;
        }

        .btn-form:hover {
            background-color: #45004d;
        }
        
        .navbar {
            width: 100%; /* La barra de navegación ocupa el 100% del ancho */
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color:#4a045a;
            padding: 1rem 2rem;
            position: fixed; /* Mantiene la navbar fija en la parte superior */
            top: 0;
            left: 0;
            z-index: 9999; /* Asegura que la navbar esté por encima de otros elementos */
        }

        .navbar .logo {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
        }

        .footer {
            position: absolute; /* Esto asegura que el footer se quede al final */
            bottom: 0;
            width: 100%; /* Hace que el footer ocupe todo el ancho */
            text-align: center;
            padding: 0.4rem;
            background-color: #4a045a;
            font-weight: bold;
            color: white;
        }
        
        .password-container img {
            margin-left: 450px;
            padding-left: 15px;
            width: 35px;
            cursor: pointer;
            transform: translateY(-160%);
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
    </style>

    <nav class="navbar">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" width="60px" alt="Logo">
        <div class="logo" style="padding-right: -540px;">RingMind</div>
        <div class="navbar-buttons">
        <form action="<?= base_url('/gestionar_usuarios'); ?>" method="get">
            <button type="submit" class="btn btn-sm volver-btn">Volver</button>
        </form>
    </div>
    </nav>

</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="form-card">
                <center><h3>Editar usuario</h3></center>

                <!-- Mensajes -->
                <?php if (session()->get('error')): ?>
                    <div class="alert alert-danger"><?= session()->get('error'); ?></div>
                <?php endif; ?>
                <?php if (session()->get('exito')): ?>
                    <div class="alert alert-success"><?= session()->get('exito'); ?></div>
                <?php endif; ?>

                <!-- Formulario -->
                <form action="<?= base_url('directivo/actualizarUsuario') ?>" method="post">
                    <input type="hidden" name="idusuario" value="<?= esc($usuario['idusuario']) ?>">

                    <div class="mb-3">
                        <input type="text" id="usuario" name="usuario" class="form-control" value="<?= esc($usuario['usuario']) ?>" placeholder="Nombre de usuario" required>
                    </div>

                    <div class="mb-3">
                        <input type="email" id="email" name="email" class="form-control" value="<?= esc($usuario['email']) ?>" placeholder="Correo electrónico" required>
                    </div>
                    

                    <button type="submit" class="btn btn-form">Actualizar Usuario</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <footer class="footer">
        <p>Tesis timbre automático 2025 <br>
        Marquez Juan - Mondino Xiomara</p>
    </footer>
</body>
</html>
