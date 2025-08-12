<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestionar Directivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #091342;
            padding-top: 100px;
        }

        .form-card {
            background: #081136;
            border-radius: 1.5rem;
            box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
            padding: 30px;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .form-control {
            padding: 0.6rem 1rem;
            background-color: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 0.8rem;
            transition: all 0.3s ease;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            color: white;
        }

        .form-control::placeholder {
            color: #bbb;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.08);
            color: #bbb;
            border: 1px solid #6f42c1;
            box-shadow: 0 0 10px #6f42c1;
            caret-color: #bbb;
        }

        .btn-form {
            background-color: #070f2e;
            color: white;
            border: none;
            width: 100%;
            border-radius: 10px;
            padding: 10px;
        }

        .btn-form:hover {
            background-color: #666565;
        }

        .navbar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            background-color: #081136;
            padding: 1rem 2rem;
            position: fixed;
            z-index: 1000;
            align-items: center;
        }

        .navbar .logo {
            color: white;
            font-size: 1.9rem;
            font-weight: bold;
            padding-left: 80px;
        }

        .navbar-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .cerrar-btn {
            background-color: transparent;
            color: white;
            border: none;
            padding: 0.3rem 0.8rem;
            font-size: 1rem;
            text-align: left;
            cursor: pointer;
            text-decoration: none;
        }

        .cerrar-btn:hover,
        .cerrar-btn:active,
        .cerrar-btn:focus {
            background-color: transparent;
            color: white;
            outline: none;
        }

        .footer {
            text-align: center;
            padding: 1.5rem;
            background-color: #081136;
            font-weight: bold;
            color: white;
            margin-top: 3rem;
        }

        .btn-ancho-custom {
            width: 250px;
            max-width: 100%;
            background-color: #070f2e;
            border-radius: 13px;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: #fff;
            transition: background-color 9999s ease-in-out 0s;
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset;
            caret-color: #fff;
        }

        input:-moz-autofill {
            box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset;
            -moz-text-fill-color: #fff;
            caret-color: #fff;
        }

        .directivo-card {
            background: #091342;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            padding: 20px;
            color: white;
            transition: background-color 0.3s ease;
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
    margin-top: 20px;
    padding: 0.75rem 1rem;
    border-radius: 1rem;
    text-align: center;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);
    font-weight: 100;
    font-size: 1rem;
}

.alert-success {
    background-color: rgba(72, 187, 120, 0.15);
    border: 1.5px solid rgba(72, 187, 120, 0.6);
    color: #48bb78;
}

.alert-danger {
    background-color: rgba(220, 38, 38, 0.15);
    border: 1.5px solid rgba(220, 38, 38, 0.6);
    color: #dc2626;
}

.alert-info {
    background-color: rgba(59, 130, 246, 0.15);
    border: 1.5px solid rgba(59, 130, 246, 0.6);
    color: #3b82f6;
}
.alert .close-btn {
    background: none;
    border: none;
    color: inherit;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 0;
    margin-left: 1rem;
    line-height: 1;
}

    </style>

    <nav class="navbar sticky-top">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo" />
        <div class="logo">RingMind</div>
        <div class="navbar-buttons">
            <a href="<?= base_url('/admin/horarios'); ?>" class="btn btn-sm cerrar-btn">Visualizar horarios</a>

            <form action="<?= base_url('/logout'); ?>" method="post">
                <?= csrf_field(); ?>
                <button type="submit" class="btn btn-sm cerrar-btn">Cerrar sesión</button>
                <br />
            </form>
        </div>
    </nav>
</head>

<body>
    <br />
    <div class="text-center mb-3">
        <form action="<?= base_url('registrar_dispositivo') ?>" method="get">
            <button type="submit" class="btn btn-form btn-ancho-custom">Registrar y ver mis Dispositivos</button>
        </form>
    </div>
    <div class="text-center mb-3">
        <form action="<?= base_url('/cambiar-colegio') ?>" method="get">
            <button type="submit" class="btn btn-form btn-ancho-custom">Cambiar de colegio</button>
        </form>
    </div>

    <div class="container mt-4">
        <div class="col-md-6 mx-auto">
            <div class="form-card">
                <center>
                    <h2>Agregar usuario directivo</h2>
                </center>
                <?php if (session()->get('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <?= session()->get('error'); ?>
                        <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label="Cerrar">×</button>

                    </div>
                <?php endif; ?>

                <?php if (session()->get('success') || session()->get('exito')) : ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <?= session()->get('success') ?: session()->get('exito'); ?>
                        <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label="Cerrar">×</button>

                    </div>
                <?php endif; ?>

                <?php if (session()->get('info')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <?= session()->get('info'); ?>
                        <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label="Cerrar">×</button>

                    </div>
                <?php endif; ?>
                <form action="<?= base_url('admin/guardarUsuario') ?>" method="post">
                    <div class="mb-3">
                        <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Nombre de usuario" required />
                    </div>

                    <div class="mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Correo electrónico" required />
                    </div>

                    <div>
                        ⚠️ <strong>Nota:</strong> Si el directivo no posee una cuenta en el sistema, el mismo le generará una, junto a una contraseña aleatoria y le enviará un correo con un enlace para que pueda cambiarla.
                    </div>
                    <br />

                    <div><button type="submit" class="btn btn-form">Agregar directivo</button></div>
                </form>
            </div>
        </div>
    </div>

    <hr class="my-5" />

    <div class="container">
        <div class="card" style="border-radius: 1.5rem; background: #081136; border: 1px solid rgba(255, 255, 255, 0.05); color: white;">
            <div class="card-header">
                <h2>Usuarios directivos</h2>
            </div>
            <div class="card-body">
                <?php if (empty($usuarios_directivos)) : ?>
                    <p>No hay usuarios directivos vinculados.</p>
                <?php else : ?>
                    <div class="row g-3">
                        <?php foreach ($usuarios_directivos as $usuario) : ?>
                            <div class="col-md-6">
                                <div class="directivo-card">
                                    <h5><?= esc($usuario['usuario']) ?></h5>
                                    <p><?= esc($usuario['email']) ?></p>
                                    <div class="d-flex justify-content-between">
                                        <a href="<?= base_url('admin/eliminar_directivo/' . $usuario['idusuario']) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Estás seguro de eliminar de este colegio a este directivo?');">Desvincular</a>

                                        <a href="<?= base_url('admin/editarDirectivo/' . $usuario['idusuario']) ?>"
                                            class="btn btn-sm btn-secondary">Editar</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <footer class="footer mt-4">
        <div class="container text-center">
            <p>Tesis timbre automático 2025 <br />Marquez Juan - Mondino Xiomara</p>
        </div>
    </footer>
</body>

</html>
