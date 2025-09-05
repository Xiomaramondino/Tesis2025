<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Profesor - RingMind</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#091342] text-white font-sans p-6">
    <div class="max-w-lg mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-6 text-center">Editar Profesor</h2>

        <?php if (session()->get('error')) : ?>
            <div class="bg-red-600 text-white p-3 rounded mb-4">
                <?= session()->get('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/actualizarProfesor/' . $usuario['idusuario']) ?>" method="post" class="bg-[#081136] p-6 rounded shadow-md">
            <?= csrf_field(); ?>

            <div class="mb-4">
                <label for="usuario" class="block mb-1">Nombre del Profesor</label>
                <input type="text" id="usuario" name="usuario" class="form-control w-full p-2 rounded border border-gray-400 text-black" value="<?= esc($usuario['usuario']) ?>" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block mb-1">Correo electrónico</label>
                <input type="email" id="email" name="email" class="form-control w-full p-2 rounded border border-gray-400 text-black" value="<?= esc($usuario['email']) ?>" required>
            </div>

            <div class="mb-4 text-center">
                <button type="submit" class="bg-[#7158e2] hover:bg-[#5936c1] text-white font-bold py-2 px-4 rounded">
                    Guardar cambios
                </button>
                <a href="<?= base_url('vista_admin') ?>" class="ml-4 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>
