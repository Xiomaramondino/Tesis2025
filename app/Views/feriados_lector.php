<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feriados - Vista Lector</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #091342;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            width: 100%;
            background-color: #081136;
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
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
            cursor: pointer;
            text-decoration: none;
        }
        .volver-btn:hover { color: #d4b8e0; }

        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 120px 20px 20px 20px;
        }

        .card {
            background: #081136;
            border-radius: 1.5rem;
            padding: 2rem;
            max-width: 700px;
            width: 100%;
            color: white;
        }

        .card-title {
            text-align: center;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #d4b8e0;
        }

        .horarios-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .horario-card {
    background: #0a1033; /* fondo oscuro uniforme */
    border: 1px solid #4c4c6d; /* borde sutil */
    border-radius: 0.8rem;
    padding: 1rem 1.5rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* sombra ligera */
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.horario-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.4); /* leve elevación al pasar el mouse */
}

.horario-card p {
    margin: 0.2rem 0;
    font-size: 1rem;
    line-height: 1.3;
}


        .footer {
            text-align: center;
            background-color: #081136;
            color: white;
            padding: 0.8rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
    <div class="logo">RingMind</div>
    <a href="<?= base_url('/vista_admin'); ?>" class="volver-btn">Volver</a>
</nav>

<!-- Contenido principal -->
<div class="main-content">
    <div class="card" role="main" aria-label="Lista de feriados">

        <?php
        $session = session();
        $idcolegio = $session->get('idcolegio');
        $db = \Config\Database::connect();
        $dispositivo = $db->table('dispositivo')->where('idcolegio', $idcolegio)->get()->getRow();
        ?>

        <?php if ($dispositivo): ?>

            <!-- Excepciones del colegio -->
            <h2 class="card-title">Excepciones del Colegio</h2>
            <?php if(!empty($excepciones)): ?>
                <div class="horarios-list">
                    <?php foreach($excepciones as $feriado): ?>
                        <div class="horario-card">
                            <p><strong>Fecha:</strong> <?= htmlspecialchars($feriado['fecha']) ?></p>
                            <p><strong>Motivo:</strong> <?= htmlspecialchars($feriado['motivo']) ?></p>
                            <p><strong>Tipo:</strong> <?= htmlspecialchars($feriado['tipo']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="text-align:center;">No hay excepciones activas.</p>
            <?php endif; ?>

            <!-- Feriados nacionales -->
            <h2 class="card-title" style="margin-top:2rem;">Feriados Nacionales</h2>
            <?php if(!empty($feriadosNacionales)): ?>
                <div class="horarios-list">
                    <?php foreach($feriadosNacionales as $feriado): ?>
                        <div class="horario-card">
                            <p><strong>Fecha:</strong> <?= htmlspecialchars($feriado['fecha']) ?></p>
                            <p><strong>Motivo:</strong> <?= htmlspecialchars($feriado['motivo']) ?></p>
                            <p><strong>Tipo:</strong> <?= htmlspecialchars($feriado['tipo']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="text-align:center;">No hay feriados nacionales activos.</p>
            <?php endif; ?>

        <?php else: ?>
            <p style="text-align:center; color:#e24363; font-weight:bold;">No tienes un dispositivo asociado, no puedes ver los feriados.</p>
        <?php endif; ?>

    </div>
</div>

<footer class="footer">
    <p>Tesis timbre automático 2025 <br>Marquez Juan - Mondino Xiomara</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
