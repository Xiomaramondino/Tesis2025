<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <style>
             *{ 
             margin: 0;
            padding: 0;
        }
      body{
            height: 100vh;
            width: 100%;
            flex-direction: column;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #b6a0d7; 
        }
          .password-container img{
            margin-right: -300px;
            padding-left: 15px;
            width: 35px;
            cursor: pointer;
            transform: translateY(-160%);
        }
        .card{
            background-color: #ebdef0 ;
            border-radius: 1.5rem;
        }
        .navbar {
            width: 100%; /* Hace que la barra de navegación ocupe todo el ancho */
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #4a045a;
            padding: 1rem 2rem;
            position: fixed; /* Fija la barra en la parte superior */
            top: 0; /* Coloca la barra en la parte superior */
            left: 0; /* Asegura que se extienda a lo largo de toda la pantalla */
            z-index: 1000; /* Asegura que la barra esté por encima de otros elementos */
        }

        .navbar .logo {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
        }
        .footer {
            text-align: center;
            padding: 0.7rem;
            background-color: #4a045a;
            font-weight: bold;
            color: white;
            margin-top: 2.5rem;
            position: fixed; /* Fija el footer en la parte inferior */
            bottom: 0; /* Colócalo en la parte inferior de la pantalla */
            left: 0; /* Asegúrate de que se extienda a lo largo de la pantalla */
            width: 100%;
            z-index: 1000; /* Opcional, asegura que esté encima de otros elementos */
        }
    </style>
     <nav class="navbar">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" width="60px" alt="Logo">
       <center> <div class="logo" style="padding-right: 590px;">RingMind</div></center>
    </nav>
     <div class="card" style="width: 30rem;">
  <div class="card-body">
    <div class="container text-center">
        <div class="row justify-content-md-center">
            <div class="col-md-10">
                <h4>Restablecer password</h4>
                <?php if (session()->get('password_error')) : ?>
                        <div class="alert alert-danger"><?= session()->get('password_error'); ?></div>
                        <?php session()-> remove('password_error'); ?>
                    <?php endif; ?>
                <form action="<?= base_url('procesar_resetear_contrasena') ?>" method="post">
                    <input type="hidden" name="token" value="<?= $token ?>">
                    

                    <div class="mb-3">
                    <div class="mb-3">
    <label for="usuario" class="form-label">Tu usuario</label>
    <input type="text" class="form-control" id="usuario" value="<?= esc($usuario) ?>" readonly>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Tu email</label>
    <input type="text" class="form-control" id="email" value="<?= esc($email) ?>" readonly>
</div>


                    <label for="nueva_contrasenia"></label>
                    <div class="password-container">
                    <input type="password" name="nueva_contrasenia" id="password" class="form-control" required placeholder="Introduce tu nueva contraseña">
                    <img src="https://static.thenounproject.com/png/1035969-200.png" id="eyeicon">
                   <div> <input class="btn btn-sm" style="background-color: #540466; color: white;" type="submit" value="Restablecer contraseña"></div>
                </form>
                <a href="<?= base_url('login') ?>" style="color: #4a045a;">Regresar al inicio de sesión</a>
            </div>
        </div></div>
        </div></div></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
     <script>
    let eyeicon = document.getElementById("eyeicon"); 
    let password= document.getElementById("password"); 
     eyeicon.onclick = function(){
        if(password.type == "password"){
            password.type = "text";
            eyeicon.src= "https://icons.veryicon.com/png/o/miscellaneous/myfont/eye-open-4.png";
        }
        else{
            password.type = "password";
            eyeicon.src= "https://static.thenounproject.com/png/1035969-200.png";
        }
     }
     </script>
        <footer class="footer">
        <p>Tesis timbre automático 2025 <br>
            Marquez Juan - Mondino Xiomara
        </p>
    </footer>
</body>
</html>
