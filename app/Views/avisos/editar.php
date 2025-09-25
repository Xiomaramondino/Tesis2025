<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Aviso</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

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
    padding-top: 70px; /* espacio navbar */
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

.form-control, .form-select {
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
.form-control:focus, .form-select:focus {
    background-color: rgba(255,255,255,0.08);
    color: #fff;
    border: 1px solid var(--color-accent);
    box-shadow: 0 0 10px var(--color-accent);
    caret-color: #fff;
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
    width: 48%;
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
.btn-custom {
    background-color: var(--color-tertiary);
    color: var(--color-text-white);
    border: none;
    border-radius: 12px;
    padding: 0.9rem 1.8rem;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: background-color 0.3s ease, transform 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    text-decoration: none;
}

.btn-custom:hover {
    background-color: #666565;
    transform: translateY(-2px);
    color: var(--color-text-white);
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
input[type="datetime-local"]::-webkit-calendar-picker-indicator {
    filter: invert(1); /* icono blanco */
    cursor: pointer;
}
.form-control option,
.form-select option {
    background-color: var(--color-secondary); /* Fondo de las opciones */
    color: var(--color-text-white); /* Texto blanco */
}
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

    if ($idrol == 4) {
        $volverUrl = base_url('profesor/avisos');
    } elseif ($idrol == 1) {
        $volverUrl = base_url('admin/calendario');
    } elseif ($idrol == 2) {
        $volverUrl = base_url('/calendario_directivo');
    } else {
        $volverUrl = base_url('/');
    }
    ?>
    <a href="<?= $volverUrl ?>" class="volver-btn"><i class="fas fa-arrow-left"></i> Volver</a>
</nav>

<!-- Card -->
<div class="card-container">
    <h1 class="card-title">Editar Aviso</h1>

    <form action="<?= base_url('avisos/actualizar/' . $aviso['idaviso']); ?>" method="post">
        <?= csrf_field(); ?>

        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" class="form-control" 
               value="<?= esc($aviso['titulo']); ?>" placeholder="Ingrese el título" required>

        <label for="fecha">Fecha y hora</label>
        <input type="datetime-local" id="fecha" name="fecha" class="form-control"
               value="<?= date('Y-m-d\TH:i', strtotime($aviso['fecha'])); ?>" required>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" class="form-control" rows="3"
                  placeholder="Ingrese la descripción"><?= esc($aviso['descripcion']); ?></textarea>

        <label for="visibilidad">Visibilidad</label>
        <select id="visibilidad" name="visibilidad" class="form-select" required>
            <option value="alumnos" <?= $aviso['visibilidad'] === 'alumnos' ? 'selected' : ''; ?>>Alumnos</option>
            <option value="profesores" <?= $aviso['visibilidad'] === 'profesores' ? 'selected' : ''; ?>>Profesores</option>
            <option value="solo_creador" <?= $aviso['visibilidad'] === 'solo_creador' ? 'selected' : ''; ?>>Solo yo</option>
        </select>

        <!-- Select de cursos solo para alumnos -->
        <div id="div-curso" style="display: <?= $aviso['visibilidad'] === 'alumnos' ? 'block' : 'none'; ?>;">
            <label for="idcurso">Curso</label>
            <select id="idcurso" name="idcurso" class="form-select">
    <option value="0" <?= ($aviso['idcurso'] ?? 0) == 0 ? 'selected' : ''; ?>>Todos los cursos</option>
    <?php foreach ($cursos as $curso): ?>
        <option value="<?= $curso['idcurso']; ?>" <?= ($aviso['idcurso'] ?? 0) == $curso['idcurso'] ? 'selected' : ''; ?>>
            <?= esc($curso['nombre']); ?> - <?= esc($curso['division']); ?>
        </option>
    <?php endforeach; ?>
</select>

        </div>

        <!-- Botones -->
        <div class="d-flex flex-column flex-md-row justify-content-between mt-4 gap-3">
            <a href="<?= $volverUrl ?>" class="btn-custom w-100 w-md-50 text-center">
                <i class="fas fa-times"></i>
                Cancelar
            </a>
            <button type="submit" class="btn-custom w-100 w-md-50">
                <i class="fas fa-save"></i>
                Guardar cambios
            </button>
        </div>

    </form>
</div>

<footer class="footer">
    Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para mostrar/ocultar curso -->
<script>
const visibilidadSelect = document.getElementById('visibilidad');
const divCurso = document.getElementById('div-curso');

visibilidadSelect.addEventListener('change', () => {
    if(visibilidadSelect.value === 'alumnos'){
        divCurso.style.display = 'block';
    } else {
        divCurso.style.display = 'none';
    }
});
</script>

</body>
</html>
