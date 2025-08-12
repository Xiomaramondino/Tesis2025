<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Directivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        background-color: #091342;
        min-height: 100vh;
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

        .form-card h3 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .form-control {
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

        .btn-ancho-custom {
            width: 100%;
            max-width: 40%;
            border-radius: 13px;
            display: block;     
            margin: 0 auto;  
        }
        .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #081136;
        padding: 1rem 2rem;
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
            gap: 0.10rem;
     }

    .volver-btn {
        background-color: transparent;
        color: white;
        border: none;
        padding: 0.3rem 0.8rem;
        font-size: 1rem;
        text-align: left;
     }

        .volver-btn:hover,
        .volver-btn:active,
        .volver-btn:focus {
            background-color: transparent;
            color: white;
            outline: none;
        }

        .footer {
            text-align: center;
            padding: 0.1rem;
            background-color: #081136;
            font-weight: bold;
            color: white;
            margin-top: 3rem;
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
        <div class="logo">RingMind</div>
        <div class="navbar-buttons">
            <form action="<?= base_url('/vista_admin'); ?>" method="get">
                <button type="submit" class="btn btn-sm volver-btn">Volver</button>
            </form>
        </div>
    </nav>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="form-card">
                <h3>Editar directivo</h3>

                <!-- Mensajes -->
                <?php if (session()->get('error')): ?>
                    <div class="alert alert-danger"><?= session()->get('error'); ?></div>
                <?php endif; ?>
                <?php if (session()->get('exito')): ?>
                    <div class="alert alert-success"><?= session()->get('exito'); ?></div>
                <?php endif; ?>

                <!-- Formulario -->
                <form action="<?= base_url('admin/guardarEdicionDirectivo') ?>" method="post">
                    <input type="hidden" name="idusuario" value="<?= esc($usuario['idusuario']) ?>">

                    <div class="mb-3">
                        <input type="email" id="email" name="email" class="form-control" value="<?= esc($usuario['email']) ?>" placeholder="Correo electrónico" required>
                    </div>

                    <!-- Botón igual al de agregar directivo -->
                    <button type="submit" class="btn btn-form btn-ancho-custom">Actualizar Usuario</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <footer class="footer">
        <p>Tesis timbre automático 2025 <br>
            Marquez Juan - Mondino Xiomara
        </p>
    </footer>
</body>
</html>
