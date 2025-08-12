<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Horario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
    /* text-align: center;  <-- quitar */
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);
    font-weight: 100;
    /* position: absolute;  <-- eliminar o verificar contexto */
    font-size: 1rem;
}

.alert > span {
    flex-grow: 1; /* hace que el texto tome todo el espacio disponible */
    text-align: left; /* asegura que el texto esté alineado a la izquierda */
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
    margin-left: 0; /* Elimina el margen negativo */
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

<!-- Barra de navegación -->
<nav class="navbar sticky-top">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
    <div class="logo" style="padding-right: -600px;">RingMind</div>

    <div class="navbar-buttons">
        <form action="<?= base_url('/horarios'); ?>" method="get">
            <button type="submit" class="btn btn-sm volver-btn">Volver</button>
        </form>
    </div>
</nav>
<div class="card" style="width: 30rem;">

<?php if (session()->get('error')): ?>
    <div class="alert alert-danger" role="alert">
        <span><?= session()->get('error'); ?></span>
        <button type="button" class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
<?php endif; ?>

<div class="card-body">
        <div class="container text-center">
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <h3>Modificar horarios</h3>
                    <form action="<?= site_url('horarios/actualizar') ?>" method="post">
                        <input type="hidden" name="idhorario" class="form-control" value="<?= esc($horario['idhorario']) ?>">
                        <label for="evento">Evento:</label>
<input type="text" name="evento" class="form-control" value="<?= esc($horario['evento']) ?>" required>

<label for="hora">Hora:</label>
<input type="time" name="hora" class="form-control" value="<?= esc($horario['hora']) ?>" required>

<label for="iddia">Día de la semana:</label>
<select name="iddia" class="form-control" required>
    <option value="1" <?= $horario['iddia'] == 1 ? 'selected' : '' ?>>Lunes</option>
    <option value="2" <?= $horario['iddia'] == 2 ? 'selected' : '' ?>>Martes</option>
    <option value="3" <?= $horario['iddia'] == 3 ? 'selected' : '' ?>>Miércoles</option>
    <option value="4" <?= $horario['iddia'] == 4 ? 'selected' : '' ?>>Jueves</option>
    <option value="5" <?= $horario['iddia'] == 5 ? 'selected' : '' ?>>Viernes</option>
    <option value="6" <?= $horario['iddia'] == 6 ? 'selected' : '' ?>>Sábado</option>
    <option value="7" <?= $horario['iddia'] == 7 ? 'selected' : '' ?>>Domingo</option>
</select>
<br>

                        <button type="submit">Actualizar</button>
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
