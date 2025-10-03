<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    
    body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center; /* centra verticalmente */
    align-items: center; /* Esto ayuda a separar contenido y footer */
    background-color: #091342;
    margin: 0;
    
}

.main-content {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-grow: 1; /* Ocupa el espacio disponible */
}
        
.card {
    border-radius: 1.5rem;
    max-width: 550px;
    width: 90%; /* ocupa hasta 90% del ancho en pantallas pequeñas */
    background: #081136;
    box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.05);
    padding: 2rem;
}
.form-control {
    width: 120%; 
    padding: 0.6rem 1rem;
    background-color: transparent;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    color: white;
    font-size: 1rem;
    margin-bottom: 0.4rem;
    transition: all 0.3s ease;
    position: relative;
    left: 50%;
    transform: translateX(-50%);
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
   .navbar {
    width: 100%;
    position: relative; /* para usar posición absoluta si hace falta */
    background-color: #081136;
    padding: 1rem 2rem;
    display: flex;
    justify-content: center; /* centra el logo centralizable */
    align-items: center;
}

.navbar .logo-left {
    position: absolute; /* lo sacamos del flujo para que quede a la izquierda */
    left: 2rem; /* margen desde el borde izquierdo */
}

    .navbar .logo {
    color: white;
    font-size: 1.9rem;
    font-weight: bold;
        }

    .alert {
    position: relative;
    padding: 10px 15px;
    border-radius: 5px;
    margin-bottom: 10px;
    }

    .alert .close-btn {
    position: absolute;
    top: 50%;
    right: -20px; 
    transform: translateY(-26px); 
    background: none;
    border: none;
    color: #bbb; 
    font-size: 1.5rem;
    }

        .alert-success {
            background-color: transparent;
            color: green;
        }

        .alert-danger {
            background-color: transparent;
            color: red;
        }

        .footer {
    width: 100%; /* ocupa todo el ancho */
    text-align: center;
    color: white;
    background-color: #081136;
    font-weight: bold;
    padding: 0.5rem;
    box-sizing: border-box; /* evita que padding lo corte */
}

        button {
            padding: 0.4rem 1.7rem;
            font-size: 1.1rem;
            background-color: #070F2E;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        
        button:hover {
            background-color:#666565;
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
    <nav class="navbar">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo" class="logo-left">
    <div class="logo">RingMind</div>
</nav>

    <!-- Card para recuperar contraseña -->
    <div class="main-content">
    <div class="card" style="width: 30rem;">
        <div class="card-body">
            <div class="container text-center">
                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <h3>Recuperar Password</h3>

                        <form action="<?= base_url('enviar_recuperacion') ?>" method="post">
                            <!-- Mensajes de error -->
                            <?php if(session()->get('error')): ?>
                                <div class="alert alert-danger">
                                    <?= session()->get('error'); ?>
                                    <button type="button" class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                                </div>
                                <?php session()->remove('error'); ?>
                            <?php endif; ?>
                            
                            <!-- Mensajes de éxito -->
                            <?php if(session()->get('success')): ?>
                                <div class="alert alert-success">
                                    <?= session()->get('success'); ?>
                                    <button type="button" class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                                </div>
                                <?php session()->remove('success'); ?>
                            <?php endif; ?>
    
<div class="mb-0.5">
                            <label for="email"></label> 
                           <input type="email" name="email" class="form-control" required placeholder="Introduce tu correo">
                           </div> <br>
                           <button type="submit"> Enviar enlace de recuperación</button>
                        </form>
                        <a href="<?= base_url('login') ?>" style="color: white;">Regresar al inicio de sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Pie de página -->
    <footer class="footer">
        <p>Tesis timbre automático 2025 <br>
            Marquez Juan - Mondino Xiomara
        </p>
    </footer>
</body>
</html>
