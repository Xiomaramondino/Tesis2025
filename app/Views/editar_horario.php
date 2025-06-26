<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Horario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<style>
    * { 
        margin: 0;
        padding: 0;
    }
    body {
        height: 100vh;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #b6a0d7;
    }
    .card {
        background-color: #ebdef0;
        border-radius: 1.5rem;
        margin-top: 30px;  /* Añadido margen superior */
    }
    .navbar {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #4a045a;
        padding: 1rem 2rem;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 9999;
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

    .container {
        padding-top: 80px;
    }

    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
        padding: 0.8rem;
        background-color: #4a045a;
        font-weight: bold;
        color: white;
    }

    .card-body {
        margin-top: -50px;
        
    }

    /* Estilo para el mensaje de error */
    .alert {
    position: fixed;
    top: 100px;  /* Ajustado para dar espacio entre navbar y mensaje */
    left: 50%;
    transform: translateX(-50%);
    max-width: 56%;
    width: 500px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;  /* Espacio adicional debajo del mensaje */
}

</style>

<!-- Barra de navegación -->
<nav class="navbar sticky-top">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" width="60px" alt="Logo">
    <div class="logo" style="padding-right: -600px;">RingMind</div>

    <div class="navbar-buttons">
        <form action="<?= base_url('/horarios'); ?>" method="get">
            <button type="submit" class="btn btn-sm volver-btn">Volver</button>
        </form>
    </div>
</nav>

<!-- Flash data de errores -->
<!-- Flash data de error -->
<?php if (session()->get('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->get('error'); ?>
        
    </div>
<?php endif; ?>

<!-- Contenido principal -->
<div class="card" style="width: 30rem;">
    <div class="card-body">
        <div class="container text-center">
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <h3>Modificar horarios</h3>
                    <form action="<?= site_url('horarios/actualizar') ?>" method="post">
                        <input type="hidden" name="idhorario" class="form-control" value="<?= esc($horario['idhorario']) ?>">
                        <label for="evento">Evento:</label>
                        <input type="text" name="evento" class="form-control" value="<?= esc($horario['evento']) ?>" required>
                        <label for="hora">Hora:</label>
                        <input type="text" name="hora" class="form-control" value="<?= esc($horario['hora']) ?>" required><br>
                        <button class="btn btn-sm" style="background-color: #540466; color:white;" type="submit">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pie de página -->
<footer class="footer">
    <p>Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara</p>
</footer>

</body>
</html>
