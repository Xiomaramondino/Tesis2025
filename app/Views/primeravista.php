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
        background-color: #091342;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #081136;
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
        gap: 10px;
    }

    .icon-links li a {
        font-size: 20px;
        color: white;
    }

    .icon-links li a:hover {
        color: #ccc;
    }

    .hero-section {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
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
        background-color: #070F2E;
        border: none;
        color: white;
        cursor: pointer;
        border-radius: 5px;
    }

    .hero-section button:hover {
        background-color: #666565;
    }

    .content {
        display: flex;
        justify-content: space-around;
        padding: 3rem 2rem;
    }

    .card {
        padding: 2rem;
        border-radius: 1.5rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 30%;
        background-color: transparent;
        transition: transform 0.3s ease;
        text-align: center;
    }

    .card h3 {
        font-size: 1.6rem;
        margin-bottom: 1rem;
        color: white;
    }

    .card p {
        font-size: 1.1rem;
        color: white;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card .icon {
        font-size: 2rem; 
        color: white; 
        margin-bottom: 1rem;
    }

    .footer {
        text-align: center;
        padding: 1.5rem;
        background-color: #081136;
        font-weight: bold;
        color: white;
        margin-top: 3rem;
    }

    .hero-images { 
        justify-content: center;
    }

    section, img {
        transition: transform 0.7s ease;
    }

    section:hover {
        transform: translateY(-5px);
    }

    img:hover {
        transform: scale(1.05);
    }
</style>

<nav class="navbar">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
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
</script>

<header class="hero-section">
    <div class="hero-text">
        <h1>Bienvenido/a a SoniTek gestión de timbres</h1>
        <div class="hero-images">
            <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/st.png" width="170px" alt="bus">
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

<section class="content">
    <div class="card">
        <i class="fa-solid fa-bell icon"></i>
        <h3>Gestión de timbres</h3>
        <p>Permite la configuración personalizada de los horarios de timbrado, adaptándolos a las necesidades específicas de la institución.</p>
    </div>
    <div class="card">
        <i class="fa-solid fa-building icon"></i>
        <h3>Gestión Unificada de Instituciones</h3>
        <p> Podrá alternar entre sus cuentas activas, cada una vinculada a un establecimiento distinto, y gestionarlas fácilmente desde una misma interfaz.</p>
    </div>
    <div class="card">
        <i class="fa-solid fa-clock icon"></i>
        <h3>Programación Dinámica del Timbre</h3>
        <p>Ofrece un botón para activar manualmente el timbre en cualquier momento, junto con un calendario integrado que permite programar fechas en las que el sistema permanecerá inactivo.</p>
    </div>
</section>

<footer class="footer">
    <p>Tesis timbre automático 2025 <br>
        Marquez Juan - Mondino Xiomara
    </p>
</footer>

</body>
</html>