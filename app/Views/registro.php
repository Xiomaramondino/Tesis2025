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
    *{ 
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        height: 100vh;
        width: 100%;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #b6a0d7; 
    }
    .card{
        background-color: #ebdef0;
        max-height: 90vh;
        overflow-y: auto;
        padding: 2rem;
        margin-left: 30%;
        margin-top: 55px;
        border-radius: 1.5rem;
    }
    .section-title {
        color: #540466;
        margin: 25px 0 15px 0;
        font-weight: bold;
        text-align: center;
    }
    .form-group {
        margin-bottom: 1.2rem;
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #333;
        font-weight: 500;
    }
    .form-control {
        width: 100%;
        padding: 0.6rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 0.5rem;
    }
    .password-container {
        position: relative;
        margin-bottom: 1.2rem;
    }
    .password-container img {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 25px;
        cursor: pointer;
    }
    .btn-primary {
        width: 100%;
        padding: 0.8rem;
        margin-top: 1.5rem;
        background-color: #540466;
        border: none;
    }
    .btn-primary:hover {
        background-color: #4a045a;
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
        background-color: #4a045a;
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
    #submit-btn {
        display: none; /* Ocultamos el botón de submit inicialmente */
    }
</style>

<!-- Barra de navegación -->
<nav class="navbar">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" width="60px" alt="Logo">
    <center><div class="logo" style="padding-right: -540px;">RingMind</div></center>
    <div class="navbar-buttons">
        <form action="<?= base_url('/'); ?>" method="get">
            <button type="submit" class="btn btn-sm volver-btn">Volver</button>
        </form>
    </div>
    </nav>
</nav>

<div class="card" style="width: 35rem;">
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
    // Toggle para mostrar/ocultar contraseña
    let eyeicon = document.getElementById("eyeicon"); 
    let password = document.getElementById("password"); 
    eyeicon.onclick = function(){
        if(password.type == "password"){
            password.type = "text";
            eyeicon.src = "https://icons.veryicon.com/png/o/miscellaneous/myfont/eye-open-4.png";
        } else {
            password.type = "password";
            eyeicon.src = "https://static.thenounproject.com/png/1035969-200.png";
        }
    }

    // Configuración del botón de PayPal
    paypal.Buttons({
        
        createOrder: function(data, actions) {
            // Validar campos del formulario antes de proceder al pago
            const form = document.getElementById('registerForm');
            const inputs = form.querySelectorAll('input[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if(!input.value.trim()) {
                    input.style.borderColor = 'red';
                    isValid = false;
                } else {
                    input.style.borderColor = '#ddd';
                }
            });
            
            if(!isValid) {
                Swal.fire({
                    title: 'Campos requeridos',
                    text: 'Por favor complete todos los campos obligatorios',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                });
                return;
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
                        value: (precio).toFixed(2), // Convertir a USD (aproximadamente)
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
                // Mostrar mensaje de éxito
                Swal.fire({
                    title: '¡Pago Completado!',
                    text: 'Gracias ' + details.payer.name.given_name + ' por tu compra',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Guardar datos del pago en el formulario
                        document.getElementById('payment_status').value = 'completed';
                        document.getElementById('paypal_order_id').value = data.orderID;
                        
                        // Mostrar el botón de submit para completar el registro
                        document.getElementById('submit-btn').style.display = 'block';
                        
                        // Desplazarse al botón de submit
                        document.getElementById('submit-btn').scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
        },
        onError: function(err) {
            Swal.fire({
                title: '',
                text: 'Por favor, completa tu Información de registro para poder continuar con el pago',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        },
        onCancel: function(data) {
            Swal.fire({
                title: 'Cancelado',
                text: 'Has cancelado el proceso de pago',
                icon: 'info',
                confirmButtonText: 'Aceptar'
            });
        }
    }).render('#paypal-button-container');

    // Manejar el envío del formulario
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        // Verificar que el pago se haya completado
        if(document.getElementById('payment_status').value !== 'completed') {
            e.preventDefault();
            Swal.fire({
                title: 'Pago requerido',
                text: 'Debes completar el proceso de pago antes de registrar',
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            });
        }
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('#idcolegio').select2({
      placeholder: "Seleccione una institución",
      allowClear: true,
      width: '100%' // asegura que respete el ancho del Bootstrap
    });
  });
</script>

</body>
</html>
