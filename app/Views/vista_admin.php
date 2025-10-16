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

        .navbar {
            width: 100%;
            background-color: var(--color-secondary);
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .navbar-container {
            width: 100%;
            max-width: 1200px;
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
        .form-control option {
    background-color: var(--color-secondary);  /* Fondo de las opciones */
    color: var(--color-text-white);  /* Color de texto de las opciones */
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
            position: relative;
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

        .alert-info {
            background-color: rgba(59, 130, 246, 0.15);
            border: 1.5px solid rgba(59, 130, 246, 0.6);
            color: #3b82f6;
        }

        .alert button.close-alert {
            position: absolute;
            top: 0.5rem;
            right: 0.75rem;
            background: transparent;
            border: none;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            color: inherit;
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

        .note {
            font-size: 0.9rem;
            color: #ccc;
            line-height: 1.4;
            padding: 1rem;
            background-color: rgba(255, 255, 255, 0.05);
            border-left: 4px solid var(--color-accent);
            border-radius: 0.5rem;
        }

      /* Botón de notificación con estilo btn-custom */
.btn-custom.notification {
    position: relative;
    padding-right: 2.2rem; /* espacio para el puntito */
}

/* Puntito verde */
.btn-custom.notification::after {
    content: '';
    position: absolute;
    top: 10px;
    right: 12px;
    width: 10px;
    height: 10px;
    background-color: #48bb78; /* verde tipo WhatsApp */
    border-radius: 50%;
    border: 2px solid var(--color-tertiary);
    display: none; /* oculto por defecto */
}

/* Mostrar el puntito cuando hay notificación */
.btn-custom.notification.has-notif::after {
    display: block;
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
                <a href="<?= base_url('/admin/horarios'); ?>" class="nav-btn">
                    <i class="fas fa-clock"></i> Visualizar horarios
                </a>
                <form action="<?= base_url('/logout'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <button type="submit" class="nav-btn">
                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main>
        <div class="container mx-auto my-4 max-w-4xl">
            <div class="flex flex-col md:flex-row justify-center gap-4 mb-8">
                <a href="<?= base_url('registrar_dispositivo') ?>" class="btn-custom">
                    <i class="fas fa-microchip"></i>
                    Registrar y ver mis Dispositivos
                </a>
             <?php if(session()->get('es_admin_principal') == 1): ?>
        <a href="<?= base_url('admin/solicitudesPendientes') ?>" 
           class="btn-custom notification <?= isset($solicitudesPendientes) && $solicitudesPendientes > 0 ? 'has-notif' : '' ?>">
            <i class="fas fa-envelope-open-text"></i> Solicitudes Pendientes
        </a>
    <?php endif; ?>

                <a href="<?= base_url('/cambiar-colegio') ?>" class="btn-custom">
                <i class="fas fa-school"></i>
                    Cambiar de colegio
                </a>
                <a href="<?= base_url('/cursos') ?>" class="btn-custom">
                <i class="fas fa-book"></i>
                Cursos
            </a>
            <a href="<?= base_url('admin/calendario') ?>" class="btn-custom">
    <i class="fas fa-calendar-alt"></i>
    Calendario
</a>
            </div>

            <!-- Card de agregar usuarios -->
            <div class="flex justify-center">
                <div class="w-full md:w-3/4 lg:w-2/3">
                    <div class="card-custom">
                        <h2 class="text-center text-2xl md:text-3xl font-bold mb-4">Agregar usuario</h2>

                        <?php if (session()->get('error')) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?= session()->get('error'); ?>
                                <button type="button" class="close-alert" onclick="this.parentElement.style.display='none';">&times;</button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->get('success') || session()->get('exito')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->get('success') ?: session()->get('exito'); ?>
                                <button type="button" class="close-alert" onclick="this.parentElement.style.display='none';">&times;</button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->get('info')) : ?>
                            <div class="alert alert-info" role="alert">
                                <?= session()->get('info'); ?>
                                <button type="button" class="close-alert" onclick="this.parentElement.style.display='none';">&times;</button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('admin/guardarUsuario') ?>" method="post">
                            <div class="mb-3">
                                <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Nombre de usuario" required />
                            </div>

                            <div class="mb-3">
                                <input type="email" id="email" name="email" class="form-control" placeholder="Correo electrónico" required />
                            </div>

                            <div class="mb-3">
    <select name="tipo_usuario" id="tipo_usuario" class="form-control" required>
        <option value="" disabled selected>Seleccione tipo de usuario</option>
        <option value="2">Directivo / Preceptor</option>
        <option value="4">Profesor</option>
    </select>
</div>


                            <div class="note my-3">
                                <strong>Importante:</strong> Si el usuario no tiene una cuenta, nuestro sistema creará una automáticamente. Se le enviará un correo con una contraseña temporal y un enlace para que pueda establecer una nueva.
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn-custom w-full">
                                    <i class="fas fa-user-plus"></i> Agregar usuario
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <hr class="my-8" style="border-color: rgba(255, 255, 255, 0.1);" />

            <!-- Listado de directivos -->
            <div class="card-custom mb-8">
                <h2 class="text-center text-2xl md:text-3xl font-bold mb-4">Usuarios directivos</h2>
                <?php if (empty($usuarios_directivos)) : ?>
                    <p class="text-center text-gray-400">No hay usuarios directivos vinculados.</p>
                <?php else : ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($usuarios_directivos as $usuario) : ?>
                            <div class="directivo-card">
                                <h5 class="text-lg font-semibold"><?= esc($usuario['usuario']) ?></h5>
                                <p class="text-gray-400 mb-3"><?= esc($usuario['email']) ?></p>
                                <div class="flex flex-col sm:flex-row justify-between gap-2">
                                    <a href="<?= base_url('admin/eliminar_directivo/' . $usuario['idusuario']) ?>"
                                        class="btn-custom bg-red-600 hover:bg-red-700"
                                        onclick="return confirm('¿Estás seguro de eliminar de este colegio a este directivo?');">
                                        <i class="fas fa-user-slash"></i> Desvincular
                                    </a>
                                    <a href="<?= base_url('admin/editarDirectivo/' . $usuario['idusuario']) ?>"
                                        class="btn-custom bg-gray-500 hover:bg-gray-600">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Listado de profesores -->
            <div class="card-custom mb-8">
                <h2 class="text-center text-2xl md:text-3xl font-bold mb-4">Usuarios profesores</h2>
                <?php if (empty($usuarios_profesores)) : ?>
                    <p class="text-center text-gray-400">No hay profesores vinculados.</p>
                <?php else : ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($usuarios_profesores as $profesor) : ?>
                            <div class="directivo-card">
                                <h5 class="text-lg font-semibold"><?= esc($profesor['usuario']) ?></h5>
                                <p class="text-gray-400 mb-3"><?= esc($profesor['email']) ?></p>
                                <div class="flex flex-col sm:flex-row justify-between gap-2">
                                    <a href="<?= base_url('admin/eliminar_profesor/' . $profesor['idusuario']) ?>"
                                        class="btn-custom bg-red-600 hover:bg-red-700"
                                        onclick="return confirm('¿Estás seguro de eliminar a este profesor?');">
                                        <i class="fas fa-user-slash"></i> Desvincular
                                    </a>
                                    <a href="<?= base_url('admin/editarProfesor/' . $profesor['idusuario']) ?>"
                                        class="btn-custom bg-gray-500 hover:bg-gray-600">
                                        <i class="fas fa-edit"></i> Editar
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
        <center>
            <p>Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara</p>
        </center>
    </footer>
</body>
</html>
