<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            height: 100vh;
            width: 100%;
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            background-color:  #091342; 
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

.volver-btn {
    color: white;
    padding: 0.3rem 0.8rem;
    font-size: 1rem;
}
img:hover {
        transform: scale(1.05);
    }
.card {
    max-width: 550px;
    background: #081136; 
    padding: 30px;
    border-radius: 1.5rem;
    box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
    margin-top: 55px;
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.05);
}
        .password-container img {
            margin-right: -380px;
            padding-left: 15px;
            width: 35px;
            transform: translateY(-242%);
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
        .form-group {
            margin-bottom: 0.3rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.9rem;
        }
        .form-control {
    width: 120%; 
    padding: 0.6rem 1rem;
    background-color: transparent;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    color: white;
    font-size: 1rem;
    margin-bottom: 0.8rem;
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
    .footer {
            text-align: center;
            background-color: #081136;
            font-weight: bold;
            color: white;
            margin-top: 4.6rem;
            padding: 0.3rem;
        }
        #eyeicon {
    filter: invert(1) brightness(2);
    transition: filter 0.3s ease;
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

    
    <nav class="navbar">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
        <center><div class="logo" style="padding-right: -540px;">RingMind</div></center>
        <div class="navbar-buttons">
        <form action="<?= base_url('/'); ?>" method="get">
            <button type="submit" class="btn btn-sm volver-btn">Volver</button>
        </form>
    </div>
    </nav>
   
    <center>
    <div class="card">
        <div class="card-body">
            <div class="container text-center">
                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <h3>Acceder a mi cuenta</h3>
                        <form action="<?= base_url('autenticar') ?>" method="post">
                            
                       
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success">
                                    <?= session()->getFlashdata('success'); ?>
                                    <button type="button" class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                                </div>
                            <?php endif; ?>

                            <?php if(session()->get('error')) : ?>
                                <div class="alert alert-danger">
                                    <?= session()->get('error'); ?>
                                    <button type="button" class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                                </div>
                                <?php session()->remove('error'); ?>
                            <?php endif ?> 

                            <?php if (session()->get('exito')): ?>
                                <div class="alert alert-success">
                                    <?= session()->get('exito') ?>
                                    <button type="button" class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                                </div>
                                <?php session()->remove('exito'); ?>
                            <?php endif ?>
    <div class="form-group">
                            <div class="form-group">
                                <label for="usuario"></label>
                                <input type="text" class="form-control" name="usuario" required placeholder="Introduce tu usuario">
                            </div>

                            <label for="email"></label>
                            <input type="email" name="email" class="form-control" required placeholder="Introduce tu email">

                            <label for="password"></label>
                            <div class="password-container">
    <input type="password" name="password" id="password" class="form-control" required placeholder="Introduce tu contraseña"> 
    <img src="https://static.thenounproject.com/png/1035969-200.png" id="eyeicon">
</div>

<button type="submit">Iniciar sesión</button>
<br>
<a href="<?= base_url('recuperar_contrasena') ?>" style="color: #FFFFFF;">¿Olvidaste tu contraseña?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </center>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        let eyeicon = document.getElementById("eyeicon"); 
        let password = document.getElementById("password"); 

        eyeicon.onclick = function() {
            if(password.type == "password") {
                password.type = "text";
                eyeicon.src= "https://icons.veryicon.com/png/o/miscellaneous/myfont/eye-open-4.png";
            } else {
                password.type = "password";
                eyeicon.src= "https://static.thenounproject.com/png/1035969-200.png";
            }
        }
    </script>
    
    <!-- Pie de página -->
    <footer class="footer">
        <center><p>Tesis timbre automático 2025 <br>
            Marquez Juan - Mondino Xiomara
        </p></center>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
