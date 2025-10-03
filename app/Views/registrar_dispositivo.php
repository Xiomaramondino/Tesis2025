<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrar Dispositivo</title>
    <link rel="icon" href="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" type="image/png" />

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            line-height: 1.6;
            background-color: #091342;
            padding-top: 100px;
        }
.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between; /* logo a la izquierda y boton a la derecha */
    position: fixed;
    top: 0;
    width: 100%;
    height: 70px;
    background-color: #081136;
    padding: 0 2rem;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    z-index: 1000;
    box-sizing: border-box;
}

.logo-left {
    display: flex;
    align-items: center;
}

.logo {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    font-size: 1.8rem;
    font-weight: bold;
}

.navbar-buttons {
    display: flex;
    align-items: center;
    height: 100%;
}

.navbar-buttons button {
    background-color: transparent;
    color: white;
    border: none;
    padding: 0.5rem 1.5rem; /* suficiente espacio para que no se corte */
    font-size: 1rem;
    cursor: pointer;
}



.volver-btn {
    background-color: transparent;
    color: white;
    border: none;
    padding: 0.5rem 1.5rem; /* un poco más de espacio horizontal y vertical */
    font-size: 1rem;
    cursor: pointer;
    text-decoration: none;
}
        .volver-btn:hover,
        .volver-btn:active,
        .volver-btn:focus {
            background-color: transparent;
            color: white; 
            outline: none;
        }

        .container {
            max-width: 900px; 
            margin: 40px auto 40px auto; 
            padding: 20px;
        }

        .card {
            background: #081136;
            padding: 30px;
            border-radius: 1.5rem;
            box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
            margin-bottom: 50px;
        }
        .card h2 {
            text-align: center;
            margin-bottom: 1rem;
            color: white; 
            font-size: 1.8rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: white;
            font-weight: 600; 
        }

        .form-control {
            width: calc(100% - 20px);
            padding: 0.6rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: transparent;
            color: white;
            margin-bottom: 0.8rem;    
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

        button {
            padding: 12px 30px;
            font-size: 1.1rem;
            background-color:#070f2e;
            border: none;
            color:white;
            cursor: pointer;
            border-radius: 5px;
            width: 40%;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 15px;
            margin: 13px auto 0 auto; 
            display: block;
        }

        button:hover {
            background-color:#666565; 
        }

        .alert {
    margin: 20px auto 0 auto; 
    padding: 0.75rem 1rem;
    border-radius: 1rem;
    justify-content: space-between;
    align-items: center;
    width: 60%;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            color: white;
        }

        th, td {
            padding: 8px 8px;
            text-align: left;
        }

        th {
            background-color: #070F2E;
            color: #ffffff;
            font-weight: bold;
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: 1px solid #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
            transform: translateY(-1px);
        }

        .footer {
            text-align: center;
            padding: 0.1rem;
            background-color: #081136;
            font-weight: bold;
            color: white;
            margin-top: 3rem;
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
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="50px" alt="Logo" class="logo-left">
    <div class="logo">RingMind</div>
    <form action="<?= base_url('/vista_admin'); ?>" method="get" class="navbar-buttons">
        <button type="submit" class="volver-btn">Volver</button>
    </form>
</nav>



<div class="container">
    <div class="card">
        <h2>Registrar Dispositivo</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>

        <form action="<?= base_url('guardar_dispositivo') ?>" method="post">
            <?= csrf_field(); ?>
            <div class="form-group">
                <label for="mac">Dirección MAC:</label>
                <input type="text" name="mac" class="form-control" placeholder="AA:BB:CC:DD:EE:FF" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Registrar</button>
        </form>
    </div>

    <div class="card mt-4" >
        <div class="card-header" >
            <h2>Mis Dispositivos</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Dirección MAC</th>
                        <th>Colegio</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mis_dispositivos)): ?>
                        <?php foreach ($mis_dispositivos as $dispositivo): ?>
                            <tr>
                                <td><?= esc($dispositivo['mac']) ?></td>
                                <td><?= esc($dispositivo['nombre_colegio']) ?></td>
                                <td>
                                    <a href="<?= base_url('/dispositivos/eliminar/' . esc($dispositivo['iddispositivo'])) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este dispositivo?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No tienes dispositivos registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="footer">
    <p>Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara</p>
</footer>

</body>
</html>
