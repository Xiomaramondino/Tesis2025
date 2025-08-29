<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Agregar SDK de PayPal -->
    <script src="https://www.paypal.com/sdk/js?client-id=Ad90Y0ZPLcNppVf9gaeaq4Y5T2HlxrTzpAPOCMfegyQnARqoEtg83isUJjcw_npCVpdL6yRx4Y2WZVAi&currency=USD"></script>
    <!-- Agregar SweetAlert2 para mejores alertas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<style>

    body {
            height: 100vh;
            width: 100%;
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            background-color:  #091342; 
        }
    .card{
    margin-left: 30%;
    max-width: 550px;
    background: #081136;
    padding: 30px;
    border-radius: 1.5rem;
    box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
    margin-top: 55px;
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .section-title {
        color: white;
        margin: 25px 0 15px 0;
        font-weight: bold;
        text-align: center;
    }

    .form-group label {
        color: white;
        font-weight: 500;
    }

    .form-control {
    border-radius: 8px;
    width: 100%; 
    padding: 0.6rem 1rem;
    background-color: transparent;
    border: 1px solid rgba(255, 255, 255, 0.2);
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
    
    .password-container {
    position: relative;
    margin-bottom: 1.2rem;
}

.password-container img {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    width: 20px;
    height: auto;
    cursor: pointer;
    filter: invert(1) brightness(2);
    transition: filter 0.3s ease;
}

    .btn-primary {
        width: 100%;
        padding: 0.8rem;
        margin-top: 1.5rem;
        background-color: #070F2E;
        border: none;
    }
    .btn-primary:hover {
        background-color: #666565;
    }
    .login-link {
        text-align: center;
        margin-top: 1rem;
        color: #540466;
        text-decoration: none;
    }
    .login-link:hover {
        color: #4a045a;
        text-decoration: underline;
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
    #submit-btn {
        display: none; 
    }
    .footer {
            text-align: center;
            background-color: #081136;
            font-weight: bold;
            color: white;
            margin-top: 4.6rem;
            padding: 0.3rem;
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
<nav class="navbar">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
    <center><div class="logo" style="padding-right: -540px;">RingMind</div></center>
    <div class="navbar-buttons">
        <form action="<?= base_url('/'); ?>" method="get">
            <button type="submit" class="btn btn-sm volver-btn">Volver</button>
        </form>
    </div>
    </nav>
</nav>

<div class="card" style="width: 35rem; margin-bottom: 30px;">
    <div class="card-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h3 class="text-center mb-4">Comprar producto</h3>
                    <form id="registerForm" action="<?= base_url('registro') ?>" method="post"> 
                        <?php if (session()->get('error')) : ?>
                            <div class="alert alert-danger"><?= session()->get('error'); ?> </div>
                            <?php session()->remove('error'); ?>
                        <?php endif ?>
                        <?php if (session()->get('password_error')) : ?>
                            <div class="alert alert-danger"><?= session()->get('password_error'); ?></div>
                            <?php session()-> remove('password_error'); ?>
                        <?php endif ?>

    
                        <h4 class="section-title">Institución</h4>
                        <div class="form-group">
    <label for="idcolegio">Seleccione institución:</label>
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
                        </div>
                        <h4 class="section-title">Detalles del Producto</h4>
                        <div class="form-group">
                            <label for="producto">Seleccione el Producto:</label>
                            <select name="producto" class="form-control" id="producto">
                                <option value="timbre_automatizado">Timbre Automatizado - $100.000</option>
                            </select>
                        </div>

                        <!-- Sección de Facturación -->
                        <h4 class="section-title">Información de registro</h4>
                        <div class="form-group">
                            <label for="usuario">Nombre de Usuario:</label>
                            <input type="text" name="usuario" class="form-control" value="<?= old('usuario') ?>" placeholder="Introduce nombre de usuario" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" placeholder="Introduce tu correo" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <div class="password-container">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Introduce tu contraseña" required>
                                <img src="https://static.thenounproject.com/png/1035969-200.png" id="eyeicon">
                            </div>
                        </div>

                        <!-- Sección de Pago -->
                        <h4 class="section-title">Pago con PayPal</h4>
                        <div class="form-group">
                            <div id="paypal-button-container"></div>
                        </div>
                        
                        <!-- Input hidden para el estado del pago -->
                        <input type="hidden" name="payment_status" id="payment_status" value="">
                        <input type="hidden" name="paypal_order_id" id="paypal_order_id" value="">
                        
                        <input class="btn btn-primary" type="submit" id="submit-btn" value="Iniciar sesión">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    // Función para validar todo el formulario antes del pago
    function validarFormulario() {
        const usuario = document.querySelector('input[name="usuario"]').value.trim();
        const email = document.querySelector('input[name="email"]').value.trim();
        const password = document.querySelector('input[name="password"]').value;

        // Validar usuario (solo letras y espacios)
        if (!/^[a-zA-Z\s]+$/.test(usuario)) {
            Swal.fire('Error', 'El nombre de usuario solo puede contener letras.', 'error');
            return false;
        }

        // Validar email (simple)
        if (email === '') {
            Swal.fire('Error', 'El correo es obligatorio.', 'error');
            return false;
        }

        // Validar contraseña (6 caracteres, mayúscula, símbolo)
        if (password.length < 6 || !/[A-Z]/.test(password) || !/[!@#$%*]/.test(password)) {
            Swal.fire('Error', 'La contraseña debe tener al menos 6 caracteres, una letra mayúscula y un símbolo (!@#$%).', 'error');
            return false;
        }

        return true;
    }

    // Funciones para validar individualmente cada campo con mensajes específicos
    function validarUsuario() {
        const usuario = document.querySelector('input[name="usuario"]').value.trim();
        if (!/^[a-zA-Z\s]+$/.test(usuario)) {
            Swal.fire('Error', 'El nombre de usuario solo puede contener letras.', 'error');
            return false;
        }
        return true;
    }
    function validarEmail() {
        const email = document.querySelector('input[name="email"]').value.trim();
        if (email === '') {
            Swal.fire('Error', 'El correo es obligatorio.', 'error');
            return false;
        }
        return true;
    }
    function validarPassword() {
        const password = document.querySelector('input[name="password"]').value;
        if (password.length < 6 || !/[A-Z]/.test(password) || !/[!@#$%*]/.test(password)) {
            Swal.fire('Error', 'La contraseña debe tener al menos 6 caracteres, una letra mayúscula y un símbolo (!@#$%).', 'error');
            return false;
        }
        return true;
    }

    // Variables para evitar alertas repetidas al enfocar y desenfocar
    let alertaUsuarioMostrada = false;
    let alertaEmailMostrada = false;
    let alertaPasswordMostrada = false;

    // Validar en blur (cuando se pierde foco) para cada input
    document.addEventListener('DOMContentLoaded', () => {
        const usuarioInput = document.querySelector('input[name="usuario"]');
        const emailInput = document.querySelector('input[name="email"]');
        const passwordInput = document.querySelector('input[name="password"]');

        usuarioInput.addEventListener('blur', () => {
            if (!validarUsuario()) {
                if (!alertaUsuarioMostrada) {
                    alertaUsuarioMostrada = true;
                    setTimeout(() => { alertaUsuarioMostrada = false; }, 2000);
                }
            }
        });

        emailInput.addEventListener('blur', () => {
            if (!validarEmail()) {
                if (!alertaEmailMostrada) {
                    alertaEmailMostrada = true;
                    setTimeout(() => { alertaEmailMostrada = false; }, 2000);
                }
            }
        });

        passwordInput.addEventListener('blur', () => {
            if (!validarPassword()) {
                if (!alertaPasswordMostrada) {
                    alertaPasswordMostrada = true;
                    setTimeout(() => { alertaPasswordMostrada = false; }, 2000);
                }
            }
        });
    });

    // Toggle para mostrar/ocultar contraseña
    let eyeicon = document.getElementById("eyeicon"); 
    let passwordInputField = document.getElementById("password"); 
    eyeicon.onclick = function(){
        if(passwordInputField.type == "password"){
            passwordInputField.type = "text";
            eyeicon.src = "https://icons.veryicon.com/png/o/miscellaneous/myfont/eye-open-4.png";
        } else {
            passwordInputField.type = "password";
            eyeicon.src = "https://static.thenounproject.com/png/1035969-200.png";
        }
    }

    // Configuración del botón de PayPal
    // Configuración de PayPal
    paypal.Buttons({
            style: {
                layout: 'vertical',
                color: 'blue',
                shape: 'pill',
                label: 'paypal'
            },
            createOrder: function(data, actions) {
                if (!validarFormularioCompleto()) {
                    return actions.reject();
                }

                const producto = document.getElementById('producto').value;
                let precio = 0;
                let descripcion = '';

                switch(producto) {
                    case 'timbre_automatizado':
                        precio = 100000;
                        descripcion = 'Timbre Automatizado';
                        break;
                }

                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: (precio).toFixed(2),
                            currency_code: "USD"
                        },
                        description: descripcion,
                        custom_id: producto
                    }],
                    application_context: {
                        shipping_preference: "NO_SHIPPING"
                    }
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    Swal.fire({
                        title: '¡Pago Completado!',
                        text: 'Gracias ' + details.payer.name.given_name + ' por tu compra.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        document.getElementById('payment_status').value = 'completed';
                        document.getElementById('paypal_order_id').value = data.orderID;
                        submitBtn.style.display = 'block';
                        submitBtn.scrollIntoView({ behavior: 'smooth' });
                    });
                });
            },

            onError: function(err) {
                console.error("PayPal onError:", err);
                Swal.fire({
                    title: 'Error en el pago',
                    text: 'Ocurrió un error al procesar el pago. Por favor intenta nuevamente.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            },

            onCancel: function(data) {
                Swal.fire({
                    title: 'Cancelado',
                    text: 'Has cancelado el proceso de pago.',
                    icon: 'info',
                    confirmButtonText: 'Aceptar'
                });
            }

        }).render('#paypal-button-container');

        // Manejar el envío final del formulario
        registerForm.addEventListener('submit', function(e) {
            if (document.getElementById('payment_status').value !== 'completed') {
                e.preventDefault();
                Swal.fire({
                    title: 'Pago requerido',
                    text: 'Debes completar el proceso de pago con PayPal antes de registrarte.',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
</script>

<footer class="footer">
    <p>Tesis timbre automático 2025 <br>
        Marquez Juan - Mondino Xiomara
    </p>
</footer>
</body>
</html>
