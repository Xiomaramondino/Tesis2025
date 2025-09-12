<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Aviso</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<style>
body {
    padding-top: 80px;
    background-color: #091342;
    color: white;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.container {
    max-width: 700px;
    margin: 0 auto;
    background-color: #081136;
    padding: 2rem;
    border-radius: 10px;
}
.btn-custom {
    background-color: #070f2e;
    color: white;
    border-radius: 10px;
    padding: 10px 20px;
    border: none;
}
.btn-custom:hover {
    background-color: #333;
}
</style>
</head>
<body>

<div class="container">
<h2 class="mb-4 text-center">Editar Aviso</h2>

<form action="<?= base_url('avisos/actualizar/' . $aviso['idaviso']); ?>" method="post">
    <?= csrf_field(); ?>

    <!-- Título -->
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" class="form-control" id="titulo" name="titulo" value="<?= esc($aviso['titulo']); ?>" required>
    </div>

    <!-- Fecha y Hora -->
    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha y Hora</label>
        <input type="datetime-local" class="form-control" id="fecha" name="fecha"
               value="<?= date('Y-m-d\TH:i', strtotime($aviso['fecha'])); ?>" required>
    </div>

    <!-- Descripción -->
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="4"><?= esc($aviso['descripcion']); ?></textarea>
    </div>

    <!-- Tipo -->
    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo</label>
        <select class="form-select" id="tipo" name="tipo" required>
            <option value="alumnos" <?= $aviso['visibilidad'] === 'alumnos' ? 'selected' : ''; ?>>Alumnos</option>
            <option value="profesores" <?= $aviso['visibilidad'] === 'profesores' ? 'selected' : ''; ?>>Profesores</option>
            <option value="solo_creador" <?= $aviso['visibilidad'] === 'solo_creador' ? 'selected' : ''; ?>>Solo creador</option>
        </select>
    </div>

    <!-- Botones -->
    <div class="d-flex justify-content-between mt-4">
        <a href="<?= base_url('profesor/avisos'); ?>" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-custom">Guardar Cambios</button>
    </div>
</form>
</div>

</body>
</html>
