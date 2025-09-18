<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RingMind - Gestión de Cursos</title>
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
        .logo-link img { width: 60px; }
        .logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            white-space: nowrap;
        }
        .navbar-buttons { display: flex; gap: 0.5rem; align-items: center; margin-left: auto; }
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
        main { flex-grow: 1; padding: 1rem; }
        .card-custom {
            background: var(--color-secondary);
            border-radius: 1.5rem;
            box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
            padding: 30px;
            color: var(--color-text-white);
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 2rem;
        }
        .btn-custom {
            background-color: var(--color-tertiary);
            color: var(--color-text-white);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-custom:hover { background-color: #666565; transform: translateY(-2px); color: var(--color-text-white); }
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
        .form-control::placeholder { color: #bbb; }
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--color-accent);
            box-shadow: 0 0 10px var(--color-accent);
            caret-color: var(--color-text-white);
        }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.75rem; border: 1px solid rgba(255,255,255,0.1); text-align: left; }
        th { background-color: rgba(255,255,255,0.05); }
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
        .alert-success { background-color: rgba(72, 187, 120, 0.15); border: 1.5px solid rgba(72, 187, 120, 0.6); color: var(--color-success); }
        .alert-danger { background-color: rgba(220, 38, 38, 0.15); border: 1.5px solid rgba(220, 38, 38, 0.6); color: var(--color-danger); }
        .alert button.close-alert { position: absolute; top: 0.5rem; right: 0.75rem; background: transparent; border: none; font-size: 1.2rem; font-weight: bold; cursor: pointer; color: inherit; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar sticky-top">
        <div class="navbar-container">
            <a href="#" class="logo-link"><img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" alt="Logo"></a>
            <div class="logo">RingMind</div>
            <div class="navbar-buttons">
                <a href="<?= base_url('vista_admin'); ?>" class="nav-btn"><i></i>Volver</a>
            </div>
        </div>
    </nav>

    <main>
        <div class="container mx-auto my-4 max-w-4xl">
            <div class="card-custom">
                <h2 class="text-center text-2xl md:text-3xl font-bold mb-4">Gestión de Cursos y Divisiones</h2>

                <?php if(session()->get('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->get('success'); ?>
                        <button type="button" class="close-alert" onclick="this.parentElement.style.display='none';">&times;</button>
                    </div>
                <?php endif; ?>

                <?php if(session()->get('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->get('error'); ?>
                        <button type="button" class="close-alert" onclick="this.parentElement.style.display='none';">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- Formulario de agregar curso -->
                <form action="<?= base_url('cursos/guardar') ?>" method="post" class="mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: 1º Año, 2º Grado" required>
                        <input type="text" name="division" class="form-control" placeholder="Ej: A, B, C (opcional)">
                        <button type="submit" class="btn-custom w-full"><i class="fas fa-plus"></i> Agregar</button>
                    </div>
                </form>

                <!-- Botón “Listo / Cursos cargados” -->
                <?php if(count($cursos) > 0): ?>
                    <div class="mb-4">
                        <a href="<?= base_url('vista_admin') ?>" class="btn-custom w-full bg-green-600 hover:bg-green-700">
                        Cursos cargados, accionar para continuar.
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Tabla de cursos -->
                <div class="overflow-x-auto mt-4">
                    <table>
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th>División</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($cursos as $curso): ?>
                                <tr>
                                    <td><?= esc($curso['nombre']) ?></td>
                                    <td><?= esc($curso['division']) ?></td>
                                    <td>
                                        <a href="<?= base_url('cursos/eliminar/'.$curso['idcurso']) ?>" class="btn-custom bg-red-600 hover:bg-red-700">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara</p>
    </footer>
</body>
</html>
