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
    padding-top: 80px;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
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
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: background-color 0.3s ease, transform 0.3s ease;
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
.footer {
    text-align: center;
    background-color: var(--color-secondary);
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

  input:-webkit-autofill,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: var(--color-text-white) !important;
            transition: background-color 9999s ease-in-out 0s !important;
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset !important;
            caret-color: var(--color-text-white) !important;
        }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar fixed top-0 w-full flex justify-between items-center bg-[var(--color-secondary)] p-4 md:p-6 z-50">
    <div class="navbar-left flex items-center">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" alt="Logo" class="h-10 md:h-12">
    </div>
    <div class="logo text-xl md:text-2xl font-bold absolute left-1/2 transform -translate-x-1/2">
        RingMind
    </div>
    <div class="navbar-right flex items-center gap-2 md:gap-4">
        <a href="<?= base_url('vista_admin'); ?>" class="nav-btn flex items-center gap-1 text-sm md:text-base">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</nav>

<main class="flex-1 p-4 md:p-8">
    <div class="container mx-auto max-w-4xl">
        <div class="card-custom">
            <h2 class="text-center text-xl md:text-3xl font-bold mb-4">Gestión de Cursos y Divisiones</h2>

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
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <input type="text" name="nombre" class="form-control" placeholder="Ej: 1º Año, 2º Grado" required>
                    <input type="text" name="division" class="form-control" placeholder="Ej: A, B, C (opcional)">
                    <button type="submit" class="btn-custom w-full md:w-auto justify-center">
                        <i class="fas fa-plus"></i> Agregar
                    </button>
                </div>
            </form>

            <!-- Botón “Listo / Cursos cargados” -->
            <?php if(count($cursos) > 0): ?>
                <div class="mb-4">
                    <a href="<?= base_url('vista_admin') ?>" class="btn-custom w-full md:w-auto bg-green-600 hover:bg-green-700 text-center">
                        Cursos cargados, accionar para continuar.
                    </a>
                </div>
            <?php endif; ?>

            <!-- Tabla de cursos -->
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="text-left px-3 py-2">Curso</th>
                            <th class="text-left px-3 py-2">División</th>
                            <th class="text-left px-3 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($cursos as $curso): ?>
                            <tr>
                                <td class="px-3 py-2"><?= esc($curso['nombre']) ?></td>
                                <td class="px-3 py-2"><?= esc($curso['division']) ?></td>
                                <td class="px-3 py-2">
                                    <a href="<?= base_url('cursos/eliminar/'.$curso['idcurso']) ?>" class="btn-custom bg-red-600 hover:bg-red-700 w-full md:w-auto justify-center">
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
