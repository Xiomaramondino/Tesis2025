<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de timbres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<style>
    body {
        padding-top: 80px; /* Ajuste el padding superior para dar espacio a la navbar sticky */
        min-height: 100vh; /* Asegura que el cuerpo ocupe al menos toda la pantalla */
        height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-size: cover;
        background-position: center;
        background-color: #b6a0d7;
    }

    /* Barra de navegación sticky */
    .navbar {
        width: 100%; /* Hace que la barra de navegación ocupe todo el ancho */
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color:#4a045a;
        padding: 1rem 2rem;
        margin-bottom: 0; /* Elimina el margen para que se quede pegada arriba */
        position: fixed;
        z-index: 1000; /* Asegura que esté por encima del contenido */
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

/* Estilo común para el botón "Volver" plano */
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

/* Sin efectos visuales */
.volver-btn:hover,
.volver-btn:active,
.volver-btn:focus {
    background-color: transparent;
    color: white; 
    outline: none;
}
    
    /* Estilos para la card */
    .card-container {
        width: 80%; /* Ajusta el tamaño de la tarjeta */
        max-width: 900px; /* Limita el ancho máximo */
        flex-grow: 1; /* Permite que el contenido crezca y empuje al footer */
        margin-top: 100px; /* Espacio entre la navbar y la tarjeta */
        flex-direction: column;
        justify-content: flex-start; /* Asegura que el contenido se expanda desde arriba */
        padding-bottom: 60px; /* Espacio entre la tabla y el footer */
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
</style>

<!-- Barra de navegación sticky -->
<nav class="navbar sticky-top">
<img src="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" width="60px" alt="Logo">
    <div class="logo" style="padding-right: -600px;">RingMind</div>

    <div class="navbar-buttons">
        <form action="<?= base_url('/gestionar_usuarios'); ?>" method="get">
            <button type="submit" class="btn btn-sm volver-btn">Volver</button>
        </form>
    </div>
</nav>

<!-- Contenido principal con card -->
<div class="container card-container">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title text-center">Horarios</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Evento</th>
                        <th>Hora</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row) { ?>
                    <tr>
                    <td><?= htmlspecialchars($row['evento']) ?></td>
                    <td><?= htmlspecialchars($row['hora']) ?></td>

                        <td>
                        <a href="<?= base_url('horarios/delete/' . $row['idhorario']) ?>" onclick="return confirm('¿Estás seguro de eliminar este horario?')">Eliminar</a>

                        <a href="<?= base_url('horarios/editar/' . $row['idhorario']) ?>">Modificar</a>


                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- Botón de agregar -->
            <button class="btn btn-sm" style="background-color: #540466; color: white;" onclick="window.location.href='<?= base_url('horarios/agregar') ?>'">Agregar horario</button>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Pie de página -->
<footer class="footer">
    <p>Tesis timbre automático 2025 <br>
        Marquez Juan - Mondino Xiomara
    </p>
</footer>

</body>
</html>
