<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Principal</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body onclick="closeDropdown(event)">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        color: #333;
        background-size: cover;
        background-position: right;
        background-attachment: fixed;
        background-color: #b6a0d7;
    }

    .navbar {
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

    .icon-links {
        display: flex;
        list-style: none;
        gap: 15px;
        margin: 0;
        padding: 0;
    }

    .icon-links li a {
        font-size: 20px;
        color: white;
        transition: color 0.3s;
    }

    .icon-links li a:hover {
        color: #ccc;
    }

    .hero-section {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: black;
        text-align: center;
        padding: 0 2rem;
    }

    .hero-section h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .hero-section p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
    }

    .hero-section button {
        padding: 0.8rem 2rem;
        font-size: 1.1rem;
        background-color: #540466;
        border: none;
        color: white;
        cursor: pointer;
        border-radius: 5px;
    }

    .hero-section button:hover {
        background-color: black;
    }

    .content {
        display: flex;
        justify-content: space-around;
        padding: 3rem 2rem;
    }

    .card {
        padding: 2rem;
        border-radius: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 30%;
        background-color: white;
        border-radius: 1.5rem;
        transition: transform 0.3s ease;
    }

    .card h3 {
        font-size: 1.6rem;
        margin-bottom: 1rem;
    }

    .card p {
        font-size: 1.1rem;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .footer {
        text-align: center;
        padding: 1.5rem;
        background-color: #4a045a;
        font-weight: bold;
        color: white;
        margin-top: 3rem;
    }

    .dropdown {
        display: none;
        position: absolute;
        background-color: #4a045a;
        color: black;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 10px;
        border-radius: 5px;
        top: 25px;
        right: 0;
        min-width: 200px;
    }

    .dropdown a {
        display: block;
        color: black;
        padding: 5px 0;
        text-decoration: none;
    }

    .hero-images {
        display: flex;
        justify-content: center;
    }

    .hero-images img {
        margin-right: 10px;
    }

    /* 💡 Animaciones agregadas */
    section, img {
        transition: transform 0.3s ease;
    }

    section:hover {
        transform: translateY(-5px);
    }

    img:hover {
        transform: scale(1.05);
    }

</style>

<!-- Barra de navegación -->
<nav class="navbar">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" width="60px" alt="Logo">
    <div class="logo">RingMind</div>
    <ul class="icon-links">
        <li>
            <a href="https://www.instagram.com/empresa" target="_blank">
                <i class="fab fa-instagram"></i>
            </a>
        </li>
        <li>
            <a href="https://mail.google.com/mail/?view=cm&to=timbreautomatico2025@gmail.com" target="_blank">
                <i class="fas fa-envelope"></i>
            </a>
        </li>
        <li>
            <a href="https://www.google.com/maps?q=2 de abril 1175 Rio tercero cordoba" target="_blank">
                <i class="fas fa-map-marker-alt"></i>
            </a>
        </li>
    </ul>
</nav>

<script>
    function openGmail(event) {
        var email = "timbreautomatico2025@gmail.com";
        var subject = encodeURIComponent("Asunto del correo");
        var body = encodeURIComponent("Cuerpo del mensaje");

        if (/Android|iPhone|iPad|iPod/i.test(navigator.userAgent)) {
            event.preventDefault();
            window.location.href = `googlegmail://co?to=${email}&subject=${subject}&body=${body}`;
            setTimeout(function () {
                window.open(`https://mail.google.com/mail/?view=cm&to=${email}&su=${subject}&body=${body}`, "_blank");
            }, 100);
        }
    }

    function toggleDropdown(event) {
        event.preventDefault();
        event.stopPropagation();
        var dropdown = document.getElementById("contactDropdown");
        dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
    }

    function closeDropdown(event) {
        var dropdown = document.getElementById("contactDropdown");
        if (dropdown.style.display === "block" && !event.target.closest(".nav-links")) {
            dropdown.style.display = "none";
        }
    }

    function mostrarError() {
        const mensaje = document.getElementById('errorMensaje');
        mensaje.style.display = 'block';
    }
</script>

<!-- Sección principal -->
<header class="hero-section">
    <div class="hero-text">
        <h1>Bienvenido/a a SoniTek gestión de timbres</h1>
        <div class="hero-images">
            <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/bus.png" width="150px" alt="bus">
            <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/lcd.png" width="150px" alt="lcd">
        </div>
        <br>

        <a href="<?= base_url('/login'); ?>">
            <button>Ir al inicio de sesión</button>
        </a>

        <a href="<?= base_url('/registro'); ?>">
            <button>Comprar producto</button>
        </a>
    </div>
</header>

<!-- Sección de contenido -->
<section class="content">
    <div class="card">
        <br><h3>Gestión de timbres</h3>
        <p><br>Permite la configuración personalizada de los horarios de timbrado, adaptándolos a las necesidades específicas de la institución.</p>
    </div>
    <div class="card">
        <h3>Gestión Unificada de Instituciones</h3>
        <p> Podrá alternar entre sus cuentas activas, cada una vinculada a un establecimiento distinto, y gestionarlas fácilmente desde una misma interfaz.</p>
    </div>
    <div class="card">
        <h3>Programación Dinámica del Timbre</h3>
        <p>Ofrece un botón para activar manualmente el timbre en cualquier momento, junto con un calendario integrado que permite programar fechas en las que el sistema permanecerá inactivo.</p>
    </div>
</section>

<!-- Pie de página -->
<footer class="footer">
    <p>Tesis timbre automático 2025 <br>
        Marquez Juan - Mondino Xiomara
    </p>
</footer>

</body>
</html>
