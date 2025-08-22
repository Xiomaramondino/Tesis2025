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
    justify-content: space-between; /* logo izquierda, titulo centro, boton derecha */
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
    padding: 100px 2rem 2rem 2rem; /* espacio para navbar */
}

h1 {
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

.footer {
    text-align: center;
    background-color: #081136;
    font-weight: bold;
    color: white;
    padding: 0.8rem;
    font-size: 0.95rem;
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
