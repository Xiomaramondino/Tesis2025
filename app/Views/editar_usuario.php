<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color:  #091342; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-card {
            background: #081136; 
            border-radius: 1.5rem;
            padding: 30px;
            box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5); 
            transition: transform 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
            color:white;
        }

        .form-card h1 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .form-control,
        .form-select {
            padding: 0.6rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: transparent;
            color: white;
            margin-bottom: 0.8rem;   
        }

        .btn-form {
            background-color: #5c0066;
            color: white;
            border-radius: 8px;
            width: 100%;
        }
        .form-control::placeholder {
            color: #bbb;
        }
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.08);
            color: #bbb;
            border: 1px solid #6f42c1;
            box-shadow: 0 0 10px #6f42c1;
            caret-color: #bbb;
        }

        .btn-form {
            background-color: #070f2e;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 10px;
        }

        .btn-form:hover {
            background-color: #666565;
        }
        .navbar {
            width: 100%; /* La barra de navegación ocupa el 100% del ancho */
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #081136;
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
            background-color: #081136;
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
    input:-webkit-autofill,
input:-webkit-autofill:focus,
input:-webkit-autofill:hover,
input:-webkit-autofill:active {
    -webkit-text-fill-color: #fff ;
    transition: background-color 9999s ease-in-out 0s ;
    -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset;
    caret-color: #fff;
}
input:-moz-autofill {
    box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset ;
    -moz-text-fill-color: #fff;
    caret-color: #fff;
}
    </style>

    <nav class="navbar">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
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
            <div class="form-card"  style=" border-radius: 1.5rem;">
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
