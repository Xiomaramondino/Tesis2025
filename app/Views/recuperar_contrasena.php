<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            height: 100vh;
            width: 100%;
            align-items: center;
            flex-direction: column;
            justify-content: center;
            background-color: #b6a0d7;
        }

        .card {
            background-color: #ebdef0;
            display: flex;
            margin-left: 443px;
            margin-top: 90px;
        }

        /* Barra de navegación */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #4a045a;
            padding: 1rem 2rem;
        }

        .navbar .logo {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
        }

        /* Estilos para las alertas */
        .alert {
            position: relative;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .alert .close-btn {
            position: absolute;
            top: 50%;
            right: 10px; /* Ajusta esto para mover la "X" más a la derecha */
            transform: translateY(-50%); /* Centra la "X" verticalmente */
            background: none;
            border: none;
            color: #721c24; /* Asegura que la X sea visible sobre el fondo */
            font-size: 1.5rem;
            cursor: pointer;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert .close-btn:hover {
            color: #1c1c1c; /* Cambia el color de la X cuando se pase el mouse */
        }

        /* Pie de página */
        .footer {
            text-align: center;
            padding: 1.5rem;
            background-color: #4a045a;
            font-weight: bold;
            color: white;
            margin-top: 9rem;
        }

    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" width="60px" alt="Logo">
        <center> <div class="logo" style="padding-right: 579px;">RingMind</div></center>
    </nav>

    <!-- Card para recuperar contraseña -->
    <div class="card" style="width: 30rem;">
        <div class="card-body">
            <div class="container text-center">
                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <h3>Recuperar Password</h3>

                        <form action="<?= base_url('enviar_recuperacion') ?>" method="post">
                            <!-- Mensajes de error -->
                            <?php if(session()->get('error')): ?>
                                <div class="alert alert-danger">
                                    <?= session()->get('error'); ?>
                                    <button type="button" class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                                </div>
                                <?php session()->remove('error'); ?>
                            <?php endif; ?>
                            
                            <!-- Mensajes de éxito -->
                            <?php if(session()->get('success')): ?>
                                <div class="alert alert-success">
                                    <?= session()->get('success'); ?>
                                    <button type="button" class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                                </div>
                                <?php session()->remove('success'); ?>
                            <?php endif; ?>
    
<div class="mb-0.5">
                            <label for="email"></label> 
                           <input type="email" name="email" class="form-control" required placeholder="Introduce tu correo">
                           </div> <br>
                            <input class="btn btn-sm btn-primary" type="submit" value="Enviar enlace de recuperación" style="background-color: #4a045a; border-color: #4a045a;">
                        </form>
                        <a href="<?= base_url('login') ?>" style="color: #4a045a;">Regresar al inicio de sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="footer">
        <p>Tesis timbre automático 2025 <br>
            Marquez Juan - Mondino Xiomara
        </p>
    </footer>
</body>
</html>
