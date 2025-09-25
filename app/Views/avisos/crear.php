<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Crear Aviso</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<style>
:root {
    --color-primary: #091342;
    --color-secondary: #081136;
    --color-tertiary: #070f2e;
    --color-accent: #7158e2;
    --color-accent-hover: #5534b8;
    --color-danger: #e24363;
    --color-danger-hover: #a7283f;
    --color-text-white: #ffffff;
    --color-text-light: #e0e0e0;
}

body {
    margin: 0;
    padding-top: 70px; /* espacio para navbar */
    background-color: var(--color-primary);
    color: var(--color-text-white);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
    display: flex;
    align-items: center;
    justify-content: space-between;
    z-index: 1000;
}
.navbar .logo { color: var(--color-text-white); font-size: 1.8rem; font-weight: bold; }
.navbar img { height: 40px; }
.volver-btn { background: transparent; border: none; color: var(--color-text-white); font-size: 1rem; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; }
.volver-btn:hover { color: #d4b8e0; }

.card-container {
    background: var(--color-secondary);
    border-radius: 1.5rem;
    padding: 2rem 2.5rem;
    max-width: 600px;
    margin: 2rem auto;
    box-shadow: 0 8px 30px rgba(0,0,0,0.6);
    width: 90%;
    color: var(--color-text-white);
}

.card-title { 
    text-align: center; 
    font-weight: 700; 
    margin-bottom: 2rem; 
    font-size: 2rem; 
    color: var(--color-text-white);
}

.form-control {
    width: 100%;
    padding: 0.6rem 1rem;
    background-color: transparent;
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 8px;
    color: var(--color-text-white);
    font-size: 1rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}
.form-control::placeholder { color: #bbb; }
.form-control:focus {
    background-color: rgba(255,255,255,0.08);
    color: #fff;
    border: 1px solid var(--color-accent);
    box-shadow: 0 0 10px var(--color-accent);
    caret-color: #fff;
}
.form-control option {
    background-color: var(--color-secondary);  /* Fondo de las opciones */
    color: var(--color-text-white);  /* Color de texto de las opciones */
}
.btn-main {
    margin-top: 1rem;
    background-color: var(--color-tertiary);
    color: var(--color-text-white);
    border: none;
    border-radius: 1rem;
    padding: 0.9rem 1.8rem;
    font-size: 1.2rem;
    font-weight: 500;
    width: 100%;
    max-width: 350px;
    display: block;
    margin-left: auto;
    margin-right: auto;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
}
.btn-main:hover { background-color: #666565; transform: translateY(-2px); }

.footer {
    text-align: center;
    background-color: var(--color-secondary);
    font-weight: bold;
    color: var(--color-text-white);
    padding: 0.8rem;
    width: 100%;
    margin-top: auto;
    font-size: 0.95rem;
}

input[type="datetime-local"]::-webkit-calendar-picker-indicator {
    filter: invert(1); /* icono blanco */
    cursor: pointer;
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

#div-curso { margin-bottom: 1rem; } /* espacio extra */
</style>
</head>

<body>
<!-- Navbar -->
<nav class="navbar">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" alt="Logo">
    <div class="logo">RingMind</div>
    <?php 
    $session = session();
    $idrol = $session->get('idrol');

    if ($idrol == 1) {
        $urlVolver = base_url('admin/calendario');
    } elseif ($idrol == 2) {
        $urlVolver = base_url('/calendario_directivo');
    } elseif ($idrol == 4) {
        $urlVolver = base_url('profesor/avisos');
    } else {
        $urlVolver = base_url('/');
    }
    ?>
    <a href="<?= $urlVolver ?>" class="volver-btn">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</nav>

<div class="card-container">
    <h1 class="card-title">Crear Aviso</h1>

    <?php if(session()->get('success')): ?>
        <div class="alert alert-success"><?= session()->get('success') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('avisos/guardarAviso') ?>" method="post">
        <?= csrf_field(); ?>

        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ingrese el título" required>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" class="form-control" rows="3" placeholder="Ingrese la descripción"></textarea>

        <label for="fecha">Fecha y hora</label>
        <input type="datetime-local" id="fecha" name="fecha" class="form-control" required>

        <label for="visibilidad">Visibilidad</label>
        <select id="visibilidad" name="visibilidad" class="form-control" required>
            <option value="alumnos">Alumnos</option>
            <option value="profesores">Profesores</option>
            <option value="solo_creador">Solo yo</option>
        </select>

        <!-- Contenedor select de cursos, solo visible si visibilidad = alumnos -->
        <div id="div-curso">
            <label for="idcurso">Curso (opcional)</label>
            <select id="idcurso" name="idcurso" class="form-control">
                <option value="">Todos los cursos</option>
                <?php foreach($cursos as $curso): ?>
                    <option value="<?= $curso->idcurso ?>"><?= $curso->nombre ?> - <?= $curso->division ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn-main"><i class="fas fa-save"></i> Guardar aviso</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const visibilidad = document.getElementById('visibilidad');
    const divCurso = document.getElementById('div-curso');

    function toggleCurso() {
        if(visibilidad.value === 'alumnos') {
            divCurso.style.display = 'block';
        } else {
            divCurso.style.display = 'none';
            document.getElementById('idcurso').value = '';
        }
    }

    // Ejecutar al cargar la página
    toggleCurso();

    // Ejecutar cada vez que cambie la visibilidad
    visibilidad.addEventListener('change', toggleCurso);
});
</script>

<footer class="footer">
    Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara
</footer>

</body>
</html>
