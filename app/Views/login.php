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
        * { 
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            height: 100vh;
            width: 100%;
            flex-direction: column; /* Asegura que los elementos se apilen en columna */
            justify-content: center; /* Centra verticalmente el contenido */
            align-items: center; /* Centra horizontalmente */
            background-color: #b6a0d7; 
        }
        
        .navbar {
            width: 100%; /* Hace que la barra de navegación ocupe todo el ancho */
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #540466;
            padding: 1rem 2rem;
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

/* Estilo común para el botón "Volver" plano */
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

/* Sin efectos visuales */
.volver-btn:hover,
.volver-btn:active,
.volver-btn:focus {
    background-color: transparent;
    color: white; 
    outline: none;
}
        .card {
            background-color: #ebdef0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 55px; 
        }

        .password-container img {
            margin-right: -380px;
            padding-left: 15px;
            width: 35px;
            cursor: pointer;
            transform: translateY(-180%);
        }
        button {
            padding: 0.4rem 1.7rem;
            font-size: 1.1rem;
            background-color: #540466;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: black;
        }
        .form-group {
            margin-bottom: 0.3rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.3rem;
            color: #333;
            font-weight: 500;
        }
        .form-control {
            width: 140%;
            padding: 0.4rem;
            border: 1px solid #ddd;
            border-radius: 7px;
            margin-bottom: 0.3rem;
            display: block;        /* Cambia el tipo de display a block */
            margin-left:-60px;     /* Centra el campo horizontalmente */
        }
        
        /* Estilos para las alertas */
        .alert {
    margin-top: 10px;
    text-align: center;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.alert .close-btn {
    background: none;
    border: none;
    color: inherit;
    font-size: 1.5rem;
    font-weight: bold;
    line-height: 1;
    cursor: pointer;
    float: right;
    margin-right: -30px; 
    margin-top: -5px;
}

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert .close-btn:hover {
            color: #1c1c1c; /* Cambia el color de la X cuando se pase el mouse */
        }

        /* Pie de página */
        .footer {
        
            padding: 1.5rem;
            background-color: #4a045a;
            font-weight: bold;
            color: white;
            margin-top: 3rem;
        }
        
    </style>
</head>
<body>

    <!-- Barra de navegación -->
    <nav class="navbar">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/DINGDONG.jpg" width="60px" alt="Logo">
        <center><div class="logo" style="padding-right: -540px;">DING DONG PRO</div></center>
        <div class="navbar-buttons">
        <form action="<?= base_url('/'); ?>" method="get">
            <button type="submit" class="btn btn-sm volver-btn">Volver</button>
        </form>
    </div>
    </nav>

    <!-- Formulario de inicio de sesión -->
    <center>
    <div class="card" style="width: 30rem;">
        <div class="card-body">
            <div class="container text-center">
                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <h3><em>𝓐𝓬𝓬𝓮𝓭𝓮𝓻 𝓪 𝓶𝓲 𝓬𝓾𝓮𝓷𝓽𝓪</em></h3>
                        <form action="<?= base_url('autenticar') ?>" method="post">
                            
                            <!-- Mensajes de éxito o error -->
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
    <select name="idcolegio" class="form-control" id="idcolegio" required>
    <option value="" disabled selected>Seleccione una institución</option>

    <optgroup label="Escuelas Primarias">
    <option value="1">Presidente Mitre</option>
    <option value="2">Modesto Acuña</option>
    <option value="3">Remedios de Escalada de San Martín</option>
    <option value="4">Berta Biondo de Zerega</option>
    <option value="5">Manuel Nicolás Savio</option>
    <option value="6">Martín Miguel de Güemes</option>
    <option value="7">José Matías Zapiola</option>
    <option value="8">General Manuel Belgrano</option>
    <option value="9">Angélica Prado</option>
    <option value="10">Domingo Faustino Sarmiento</option>
    <option value="11">Gregoria Ignacia Perez</option>
    <option value="12">Armando Rótulo</option>
    <option value="13">Instituto Privado Doctor Alexis Carrel</option>
    <option value="14">Instituto Privado Carlos Saavedra Lamas</option>
    <option value="15">Instituto Privado Jesús, María y José</option>
    <option value="16">Instituto Privado Arte Nuevo</option>
</optgroup>

<optgroup label="Escuelas Secundarias">
    <option value="17">I.P.E.M. Nº 98 "Luis de Tejeda"</option>
    <option value="18">Escuela Superior de Comercio</option>
    <option value="19">I.P.E.M. Nº 288 "José Hernández"</option>
    <option value="20">C.E.N.M.A. "Centro de Enseñanza de Nivel Medio para Adultos"</option>
    <option value="21">I.P.E.M. Nº 266 ex ENET Nº1 "General Manuel Nicolás Savio"</option>
    <option value="22">C.E.D.E.R. Río Tercero</option>
    <option value="23">Instituto Privado Carlos Saavedra Lamas</option>
    <option value="24">Instituto Privado Doctor Alexis Carrel</option>
    <option value="25">Instituto Privado Arte Nuevo</option>
    <option value="26">Instituto Privado Jesús, María y José</option>
    <option value="27">Instituto Privado Nivel Medio Río Tercero (ex I.T.T.)</option>
</optgroup>

<optgroup label="Escuelas Terciarias">
    <option value="28">Escuela Superior de Comercio</option>
    <option value="29">Instituto Privado Carlos Saavedra Lamas</option>
    <option value="30">Instituto Privado Doctor Alexis Carrel</option>
    <option value="31">I.E.S. Instituto de Enseñanza Superior Río Tercero</option>
    <option value="32">Instituto Privado Jesús, María y José</option>
    <option value="33">I.S.D.E. Instituto Superior para el Desarrollo Educativo</option>
</optgroup>
</select>
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

                            <a href="<?= base_url('/horarios'); ?>"><button>Iniciar sesión</button></a>
                            <br>
                            <a href="<?= base_url('recuperar_contrasena') ?>" style="color: #540466;">Olvidaste tu contraseña?</a>
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
        <p>Tesis timbre automático 2025 <br>
            Marquez Juan - Mondino Xiomara
        </p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        
        $('#idcolegio').select2({
            placeholder: "Seleccione una institución",
            allowClear: true,
            width: '400px'
        
        });
    });
</script>
</body>
</html>
