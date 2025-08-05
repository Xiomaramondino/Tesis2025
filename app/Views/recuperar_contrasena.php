<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    
    body {
            height: 100vh;
            width: 100%;
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            background-color:  #091342; 
        }
        
        .card {
         display: flex;
        margin-left: 443px;
        margin-top: 90px;
        border-radius: 1.5rem;
    max-width: 550px;
    background: #081136;
    box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.05);
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #081136;
            padding: 1rem 2rem;
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
            right: -3px; 
            transform: translateY(-20px); 
            background: none;
            border: none;
            color: red; 
            font-size: 1.5rem;
            cursor: pointer;
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
            text-align: center;
            color: white;
            margin-top: 10rem;
            background-color: #081136;
            font-weight: bold;;
            padding: 0.3rem;
        }

    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
        <center> <div class="logo" style="padding-right: 579px;">RingMind</div></center>
    </nav>

    <!-- Card para recuperar contraseña -->
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
                            <input class="btn btn-sm btn-primary" type="submit" value="Enviar enlace de recuperación" style="background-color: #4a045a; border-color: #4a045a;">
                        </form>
                        <a href="<?= base_url('login') ?>" style="color: #4a045a;">Regresar al inicio de sesión</a>
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
