<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RingMind - Gestión de Usuarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            background-color: var(--color-primary);
            color: var(--color-text-white);
            padding-top: 100px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* --- Navbar mejorada --- */
        .navbar {
            width: 100%;
            background-color: #081136;
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .navbar-container {
            width: 100%;
            max-width: 1200px; /* Limita el ancho para pantallas grandes */
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }
        
        .logo-link {
            display: flex;
            align-items: center;
        }

        .navbar .logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            white-space: nowrap;
        }

        .navbar-buttons {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            margin-left: auto;
        }
        
        .nav-btn {
            background-color: transparent;
            color: white;
            border: none;
            padding: 0.3rem 0.8rem;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* Contenido principal */
        main {
            flex-grow: 1;
            padding: 1rem;
        }

        .card-custom {
            background: var(--color-secondary);
            border-radius: 1.5rem;
            box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
            padding: 30px;
            color: var(--color-text-white);
            border: 1px solid rgba(255, 255, 255, 0.05);
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

        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            background-color: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: var(--color-text-white);
            font-size: 1rem;
            transition: all 0.3s ease;
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
        
        input:-webkit-autofill,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: var(--color-text-white) !important;
            transition: background-color 9999s ease-in-out 0s !important;
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset !important;
            caret-color: var(--color-text-white) !important;
        }

        /* Alumnos List */
        .directivo-card {
            background: var(--color-primary);
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            padding: 20px;
            color: var(--color-text-white);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
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

        .alert-custom {
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

        .note {
            font-size: 0.9rem;
            color: #ccc;
            line-height: 1.4;
            padding: 1rem;
            background-color: rgba(255, 255, 255, 0.05);
            border-left: 4px solid var(--color-accent);
            border-radius: 0.5rem;
        }
        
        /* Footer */
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
    <nav class="navbar sticky-top">
        <div class="navbar-container">
            <a href="#" class="logo-link">
                <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
            </a>
            
            <div class="logo">RingMind</div>

            <div class="navbar-buttons">
                <a href="<?= base_url('/horarios'); ?>" class="nav-btn"><i class="fas fa-clock"></i> Gestión de timbres</a>
                <form action="<?= base_url('/logout'); ?>" method="post">
                    <button type="submit" class="nav-btn"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <main>
        <div class="container mx-auto my-4 max-w-4xl">
            <div class="flex flex-col md:flex-row justify-center gap-4 mb-8">
                <a href="<?= base_url('/cambiar-colegio') ?>" class="btn-custom">
                    <i class="fas fa-school"></i>
                    Cambiar de colegio
                </a>
                <form action="<?= base_url('/sonar-timbre') ?>" method="post">
                    <button type="submit" class="btn-custom">
                        <i class="fas fa-bell"></i>
                        Sonar timbre
                    </button>
                </form>
            </div>

            <div class="flex justify-center">
                <div class="w-full md:w-3/4 lg:w-2/3">
                    <div class="card-custom">
                        <h2 class="text-center text-2xl md:text-3xl font-bold mb-4">Agregar alumnos</h2>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert-custom alert-success">
                                <i class="fas fa-check-circle"></i>
                                <span><?= session()->getFlashdata('success') ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert-custom alert-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span><?= session()->getFlashdata('error') ?></span>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('directivo/agregarUsuario') ?>" method="post">
                            <div class="mb-3">
                                <input type="text" name="usuario" class="form-control" placeholder="Nombre de usuario" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required>
                            </div>
                            <div class="note my-4">
                                <strong>Importante:</strong> Si el alumno no tiene una cuenta, se creará una automáticamente. Se le enviará un correo con una contraseña temporal y un enlace para que pueda establecer una nueva.
                            </div>
                            <button type="submit" class="btn-custom w-full">
                                <i class="fas fa-user-plus"></i>
                                Agregar Usuario
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <hr class="my-8" style="border-color: rgba(255, 255, 255, 0.1);" />

            <div class="card-custom">
                <h2 class="text-center text-2xl md:text-3xl font-bold mb-4">Alumnos vinculados</h2>

                <?php if (empty($lectores)) : ?>
                    <p class="text-center text-gray-400">No hay alumnos vinculados al colegio.</p>
                <?php else : ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($lectores as $lector) : ?>
                            <div class="directivo-card">
                                <h5 class="text-lg font-semibold"><?= esc($lector['usuario']) ?></h5>
                                <p class="text-gray-400 mb-3"><?= esc($lector['email']) ?></p>
                                <div class="flex flex-col sm:flex-row justify-between gap-2">
                                    <a href="<?= base_url('/directivo/eliminarUsuario/' . $lector['idusuario']) ?>"
                                        class="btn-custom bg-red-600 hover:bg-red-700"
                                        onclick="return confirm('¿Estás seguro de que querés eliminar este alumno de este colegio?');">
                                        <i class="fas fa-user-slash"></i>
                                        Desvincular
                                    </a>
                                    <a href="<?= base_url('/directivo/editarUsuario/' . $lector['idusuario']) ?>"
                                        class="btn-custom bg-gray-500 hover:bg-gray-600">
                                        <i class="fas fa-edit"></i>
                                        Editar
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>
            Tesis timbre automático 2025 <br />
            Marquez Juan - Mondino Xiomara
        </p>
    </footer>

</body>
</html>