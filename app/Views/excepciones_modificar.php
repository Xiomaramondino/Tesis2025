<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Excepción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color:  #091342; 
        }
        .card {
            background: #081136; 
            border-radius: 1.5rem;
            margin-top: 30px;  
            box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
        }
        .navbar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #081136;
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
        }
        .navbar .logo {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
        }
        .navbar-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        button {
            padding: 0.4rem 1.7rem;
            font-size: 1.1rem;
            background-color: #070F2E;
            border: none;
            color: white;
            border-radius: 5px;
        }
        button:hover {
            background-color:#666565;
        }
        .volver-btn {
            background-color: transparent;
            color: white;
            border: none;
            padding: 0.3rem 0.8rem;
            font-size: 1rem;
            text-align: left;
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
            padding-top: 45px;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 0.3rem;
            background-color: #081136;
            font-weight: bold;
            color: white;
        }
        .card-body {
            margin-top: -45px;
        }
        .form-control {
            width: 100%; 
            padding: 0.6rem 1rem;
            background-color: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
            font-size: 1rem;
            margin-bottom: 0.4rem;
            transition: all 0.3s ease;
            margin: 0 auto;
        }
        .form-control::placeholder {
            color: #bbb;
        }
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.08);
            color: #bbb ;
            border: 1px solid #6f42c1 ;
            box-shadow: 0 0 10px #6f42c1 ;
            caret-color: #bbb;
        }
        .alert {
            margin-top: 20px;
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);
            font-weight: 100;
            font-size: 1rem;
        }
        .alert > span {
            flex-grow: 1;
            text-align: left;
        }
        .alert .close-btn {
            background: none;
            border: none;
            color: inherit;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0;
            margin-left: 20px;
            line-height: 1;
        }
        .alert-danger {
            background-color: rgba(220, 38, 38, 0.15);
            border: 1.5px solid rgba(220, 38, 38, 0.6);
            color: #dc2626;
        }
        label {
            text-align: left;
            display: block;
            margin-bottom: 0.4rem;
            margin-left: 0;
            font-weight: 500;
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

<!-- Barra de navegación -->
<nav class="navbar sticky-top">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
    <div class="logo" style="padding-right: -600px;">RingMind</div>
    <div class="navbar-buttons">
        <a href="<?= base_url('feriados/ver') ?>" class="btn btn-sm volver-btn">Volver</a>
    </div>
</nav>

<div class="card" style="width: 30rem;">

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <span><?= session()->getFlashdata('error'); ?></span>
            <button type="button" class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
    <?php endif; ?>

    <div class="card-body">
        <div class="container text-center">
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <h3>Modificar Excepción</h3>
                    <form action="<?= base_url('excepciones/actualizar/'.$excepcion['id']) ?>" method="post">
                        <label for="fecha">Fecha:</label>
                        <input type="date" name="fecha" class="form-control" value="<?= esc($excepcion['fecha']) ?>" required>

                        <label for="motivo">Motivo:</label>
                        <input type="text" name="motivo" class="form-control" value="<?= esc($excepcion['motivo']) ?>" required>

                        <br>
                        <button type="submit">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pie de página -->
<footer class="footer">
    <p>Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara</p>
</footer>

</body>
</html>
