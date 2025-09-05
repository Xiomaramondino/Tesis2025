<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Aviso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
<div class="container mt-5">
    <h2 class="mb-4">Crear Aviso</h2>

    <?php if(session()->get('success')): ?>
        <div class="alert alert-success"><?= session()->get('success') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('avisos/guardarAviso') ?>" method="post">
        <?= csrf_field(); ?>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha y hora</label>
            <input type="datetime-local" name="fecha" id="fecha" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="idcurso" class="form-label">Curso (opcional)</label>
            <select name="idcurso" id="idcurso" class="form-control">
                <option value="">Todos los cursos</option>
                <?php foreach($cursos as $curso): ?>
                    <option value="<?= $curso->idcurso ?>"><?= $curso->nombre ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="visibilidad" class="form-label">Visibilidad</label>
            <select name="visibilidad" id="visibilidad" class="form-control" required>
                <option value="alumnos">Alumnos</option>
                <option value="profesores">Profesores</option>
                <option value="solo_creador">Solo yo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar aviso</button>
        <a href="<?= base_url('avisos/listar') ?>" class="btn btn-secondary">Volver</a>
    </form>
</div>
</body>
</html>
