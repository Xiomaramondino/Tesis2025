<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Elegí un colegio</title>
<style>
body {
    height: 100vh;
    width: 100%;
    margin: 0;
    padding-top: 70px; 
    background-color: #091342;
    font-family: sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.navbar {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #081136;
    padding: 1rem 2rem;
    position: fixed;
    top: 0;
    left: 0;
    box-sizing: border-box;
}

.navbar .logo {
    color: white;
    font-size: 1.9rem;
    font-weight: bold;
}

.volver-btn {
    background: transparent;
    border: none;
    color: white;
    font-size: 1rem;
    cursor: pointer;
    text-decoration: none;
    padding: 0.3rem 0.8rem;
}

.volver-btn:hover {
    color: #d4b8e0;
}
form.seleccion {
    width: 90%;
    max-width: 950px;
    background: #081136;
    border-radius: 1.5rem;
    padding: 30px;
    box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.05);
}
h2 {
    color: white;
}

button {
    padding: 0.6rem 1.5rem;
    font-size: 1rem;
    background-color: #070F2E;
    border: none;
    color: white;
    border-radius: 5px;
}

button:hover {
    background-color: #666565;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    color: white;
}

th, td {
    padding: 8px 8px;
    text-align: left;
}

th {
    background-color: #070F2E;
    color: #ffffff;
    font-weight: bold;
}

tr:hover {
    background-color: rgba(255, 255, 255, 0.05);
}

.footer {
    text-align: center;
    background-color: #081136;
    font-weight: bold;
    color: white;
    padding: 0.8rem;
    width: 100%;
    position: relative;
    bottom: 0;
    margin-top: auto;
    font-size: 0.95rem;
  }
</style>
</head>
<body>

<nav class="navbar">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
    <div class="logo">RingMind</div>
    <div class="navbar-buttons">
        <form action="<?= base_url('/login'); ?>" method="get">
            <button type="submit" class="volver-btn">Volver al login</button>
        </form>
    </div>
</nav>
<br>
<h2>Seleccionar un colegio</h2>

<form class="seleccion" action="<?= base_url('/seleccionar-contexto') ?>" method="post">
    <table >
        <thead>
            <tr>
                <th>Colegio</th>
                <th>Rol</th>
                <th>Seleccionar</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($opciones as $opcion): ?>
            <tr>
                <td><?= esc($opcion['colegio']) ?></td>
                <td><?= esc($opcion['rol']) ?></td>
                <td>
                    <button type="submit" name="idcolegio" value="<?= $opcion['idcolegio'] ?>-<?= $opcion['idrol'] ?>">
                        Entrar
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</form>
<footer class="footer">
        <center><p>Tesis timbre automático 2025 <br>
            Marquez Juan - Mondino Xiomara
        </p></center>
    </footer>
</body>
</html>
