<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Feriados Argentina <?= date('Y') ?></title>
<style>
html, body {
    height: 100%;
    margin: 0;
    font-family: sans-serif;
    background: #091342;
    color: white;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Navbar */
.navbar {
    width: 100%;
    background-color: #081136;
    padding: 1rem 2rem;
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-sizing: border-box;
    z-index: 1000;
}

.navbar-left img {
    height: 60px;
}

.navbar-center .logo {
    color: white;
    font-size: 1.9rem;
    font-weight: bold;
    text-align: center;
}

.navbar-right .volver-btn {
    background: #081136;
    color: white;
    font-size: 1rem;
    cursor: pointer;
    padding: 0.3rem 0.8rem;
    text-decoration: none;
}

.navbar-right .volver-btn:hover {
    background: #081136;
}

main {
    flex: 1;
    padding: 120px 2rem 2rem 2rem;
}

h1, h2 {
    margin-top: 0;
}

table { 
    width: 100%; 
    border-collapse: collapse; 
    margin-top: 1rem; 
}

th, td { 
    padding: 0.5rem; 
    border: 1px solid #ccc; 
    text-align: left; 
}

th { 
    background: #081136; 
}

footer.footer {
    text-align: center;
    background-color: #081136;
    font-weight: bold;
    color: white;
    padding: 0.8rem;
    font-size: 0.95rem;
}

/* Formulario excepciones */
form input, form button {
    margin-right: 0.5rem;
    padding: 0.3rem 0.5rem;
    border-radius: 4px;
    border: none;
}

form button {
    background-color: #0a6eff;
    color: white;
    cursor: pointer;
}

form button:hover {
    background-color: #0951cc;
}

section#excepciones {
    margin-bottom: 2rem;
    background: #081136;
    padding: 1rem;
    border-radius: 8px;
}
.form-control {
    width: 300px; /* ancho fijo más razonable */
    max-width: 100%; /* responsive en pantallas chicas */
    padding: 0.4rem 0.6rem; /* menos padding */
    background-color: transparent;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 6px;
    color: white;
    font-size: 0.95rem; /* un poco más pequeño */
    margin-bottom: 0.8rem;
    transition: all 0.3s ease;
}

.form-control::placeholder {
    color: #bbb;
}

.form-control:focus {
    background-color: rgba(255, 255, 255, 0.08);
    color: #fff;
    border: 1px solid #6f42c1;
    box-shadow: 0 0 6px #6f42c1;
    caret-color: #fff;
}

input:-webkit-autofill,
input:-webkit-autofill:focus,
input:-webkit-autofill:hover,
input:-webkit-autofill:active {
    -webkit-text-fill-color: #fff;
    transition: background-color 9999s ease-in-out 0s;
    -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset;
    caret-color: #fff;
}
form button[type="submit"] {
    background-color: #091342;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.95rem;
    transition: background-color 0.3s ease;
}

form button[type="submit"]:hover {
    background-color: #666565;
}
/* Icono calendario blanco en inputs type=date */
input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1) brightness(2);
    cursor: pointer;
}

/* Para Firefox */
input[type="date"]::-moz-calendar-picker-indicator {
    filter: invert(1) brightness(2);
    cursor: pointer;
}

</style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-left">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" alt="Logo">
    </div>

    <div class="navbar-center">
        <div class="logo">RingMind</div>
    </div>

    <div class="navbar-right">
        <a href="<?= base_url('horarios') ?>" class="volver-btn">Volver a Horarios</a>
    </div>
</nav>

<main>
    <h1>Feriados de Argentina <?= date('Y') ?></h1>

    <?php if(!empty($dispositivos) && count($dispositivos) > 0): ?>
        <!-- Formulario para desactivar timbres -->
        <section id="excepciones">
            <h2>Desactivar timbres en un día específico</h2>
            <?php if(session()->getFlashdata('success')): ?>
                <p style="color: #0f0;"><?= session()->getFlashdata('success') ?></p>
            <?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?>
                <p style="color: #f00;"><?= session()->getFlashdata('error') ?></p>
            <?php endif; ?>
            <form action="<?= base_url('excepciones/registrar') ?>" method="post">
                <label for="fecha">Fecha:</label>
                <input class="form-control" type="date" id="fecha" name="fecha" required>

                <label for="motivo">Motivo (opcional):</label>
                <input class="form-control" type="text" id="motivo" name="motivo">

                <button type="submit">Desactivar todos los timbres de este día</button>
            </form>
        </section>
    <?php else: ?>
        <section id="excepciones">
            <h2>No se puede agregar feriados</h2>
            <p style="color: #f00;">
                No hay dispositivos asociados a tu institución. Por favor, registra al menos un dispositivo antes de desactivar timbres.
            </p>
        </section>
    <?php endif; ?>

    <!-- Tabla de feriados -->
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($feriados as $f): ?>
            <tr>
                <td><?= htmlspecialchars($f['date']) ?></td>
                <td><?= htmlspecialchars($f['localName']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<footer class="footer">
    <p>Tesis timbre automático 2025 <br>
    Marquez Juan - Mondino Xiomara</p>
</footer>
</body>
</html>
