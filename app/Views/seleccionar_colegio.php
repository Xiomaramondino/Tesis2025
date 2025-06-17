<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Elegí un colegio</title>
<style>
    body {
        padding-top: 5px; /* espacio para navbar fija */
        min-height: 100vh;
        height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #b6a0d7;
        font-family: Arial, sans-serif;
        margin: 0;
    }

    h2 {
        color: #4a045a;
        margin-bottom: 20px;
    }

    form.seleccion {
        width: 80%;
        max-width: 900px;
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    button {
        background-color: #4a045a;
        border: none;
        color: white;
        padding: 8px 16px;
        font-size: 1rem;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #6a0c85;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #4a045a;
        color: white;
    }

    tr:hover {
        background-color: #f2e9f7;
    }

    /* Navbar fija arriba */
    .navbar {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #4a045a;
        padding: 1rem 2rem;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        box-sizing: border-box;
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
    }

    .navbar-buttons form {
        margin: 0;
        padding: 0;
        background: none;
        border: none;
    }

    .volver-btn {
        background: transparent !important;
        border: none !important;
        color: white;
        padding: 0;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
        font-family: inherit;
        box-shadow: none;
        outline: none;
    }

    .volver-btn:hover,
    .volver-btn:focus,
    .volver-btn:active {
        background: transparent !important;
        color: #d4b8e0;
        text-decoration: none;
        outline: none;
        box-shadow: none;
    }


</style>
</head>
<body>

<nav class="navbar">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/logo nuevo.png" width="60px" alt="Logo">
    <div class="logo">RingMind</div>
    <div class="navbar-buttons">
        <form action="<?= base_url('/login'); ?>" method="get">
            <button type="submit" class="volver-btn">Volver al login</button>
        </form>
    </div>
</nav>

<h2>Elegí un colegio</h2>

<form class="seleccion" action="<?= base_url('/seleccionar-contexto') ?>" method="post">
    <table>
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


</body>
</html>
