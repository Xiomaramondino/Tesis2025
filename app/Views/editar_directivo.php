<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RingMind - Editar Directivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --color-primary: #091342;
            --color-secondary: #081136;
            --color-tertiary: #070f2e;
            --color-accent: #7158e2;
            --color-text-white: white;
            --color-danger: #dc2626;
            --color-success: #48bb78;
            --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            font-family: var(--font-family);
            line-height: 1.6;
            background-color: var(--color-primary);
            min-height: 100vh;
            color: var(--color-text-white);
            display: flex;
            flex-direction: column;
            padding-top: 100px;
        }

        /* --- Estilos originales de la barra de navegación --- */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #081136;
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            width: 100%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
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
        
        .form-card {
            background: var(--color-secondary); 
            border-radius: 1.5rem;
            padding: 30px;
            box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5); 
            transition: transform 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--color-text-white);
        }

        .form-card h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .form-control {
            padding: 0.8rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: transparent;
            color: var(--color-text-white);
        }

        .form-control::placeholder {
            color: #bbb;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--color-accent);
            box-shadow: 0 0 10px var(--color-accent);
            caret-color: var(--color-text-white);
        }

        /* Autofill Styles */
        input:-webkit-autofill,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: var(--color-text-white) !important;
            transition: background-color 9999s ease-in-out 0s !important;
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset !important;
            caret-color: var(--color-text-white) !important;
        }
        
        .btn-custom {
            background-color: var(--color-tertiary);
            color: var(--color-text-white);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-custom:hover {
            background-color: #666565;
            transform: translateY(-2px);
            color: var(--color-text-white);
        }

        .alert {
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border-radius: 1rem;
            text-align: center;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-success {
            background-color: rgba(72, 187, 120, 0.15);
            border: 1.5px solid rgba(72, 187, 120, 0.6);
            color: var(--color-success);
        }

        .alert-danger {
            background-color: rgba(220, 38, 38, 0.15);
            border: 1.5px solid rgba(220, 38, 38, 0.6);
            color: var(--color-danger);
        }
        
        .footer {
            text-align: center;
            background-color: #081136;
            font-weight: bold;
            color: white;
            padding: 0.8rem;
            width: 100%;
            margin-top: auto;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
        <div class="logo">RingMind</div>
        <div class="navbar-buttons">
            <form action="<?= base_url('/vista_admin'); ?>" method="get">
                <button type="submit" class="btn btn-sm volver-btn">Volver</button>
            </form>
        </div>
    </nav>

    <main class="d-flex justify-content-center align-items-center flex-grow-1">
        <div class="container my-4">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-card">
                        <h2 class="text-center mb-4">Editar directivo</h2>

                        <!-- Mensajes -->
                        <?php if (session()->get('error')): ?>
                            <div class="alert alert-danger" role="alert"><?= session()->get('error'); ?></div>
                        <?php endif; ?>
                        <?php if (session()->get('exito')): ?>
                            <div class="alert alert-success" role="alert"><?= session()->get('exito'); ?></div>
                        <?php endif; ?>

                        <!-- Formulario -->
                        <form action="<?= base_url('admin/guardarEdicionDirectivo') ?>" method="post">
                            <input type="hidden" name="idusuario" value="<?= esc($usuario['idusuario']) ?>">

                            <div class="mb-3">
                                <input type="email" id="email" name="email" class="form-control" value="<?= esc($usuario['email']) ?>" placeholder="Correo electrónico" required>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-custom">
                                    <i class="fas fa-save"></i> Actualizar Usuario
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <footer class="footer">
        <center><p>Tesis timbre automático 2025 <br>
            Marquez Juan - Mondino Xiomara
        </p></center>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
