<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h2>Gestión de Cursos y Divisiones</h2>

    <form action="<?= base_url('cursos/guardar') ?>" method="post" class="mb-3">
        <div class="row">
            <div class="col-md-5">
                <input type="text" name="nombre" class="form-control" placeholder="Ej: 1º Año, 2º Grado" required>
            </div>
            <div class="col-md-5">
                <input type="text" name="division" class="form-control" placeholder="Ej: A, B, C (opcional)">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Agregar</button>
            </div>
        </div>
    </form>

    <!-- Botón “Listo / Cursos cargados” -->
    <?php if(count($cursos) > 0): ?>
        <div class="mb-3">
            <a href="<?= base_url('vista_admin') ?>" class="btn btn-success w-100">
                ✅ Listo, cursos cargados
            </a>
        </div>
    <?php endif; ?>

    <table class="table table-bordered">
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
                    <td><?= $curso['nombre'] ?></td>
                    <td><?= $curso['division'] ?></td>
                    <td>
                        <a href="<?= base_url('cursos/eliminar/'.$curso['idcurso']) ?>" class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
