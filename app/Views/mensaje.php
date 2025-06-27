<!-- app/Views/mensaje.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Notificación</title>
    <style>
        /* Igual que antes... */
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 40px; text-align: center; }
        .mensaje { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
        .mensaje h2 { color: #2c3e50; }
        a.boton-mail { 
            display: inline-block; 
            margin-top: 15px; 
            padding: 10px 20px; 
            background: #2980b9; 
            color: white; 
            border-radius: 5px; 
            text-decoration: none;
        }
        a.boton-mail:hover {
            background: #3498db;
        }
    </style>
</head>
<body>
    <div class="mensaje">
        <h2>Resultado de la solicitud</h2>
        <p><?= esc($mensaje) ?></p>

        <?php if (isset($esNuevo) && $esNuevo === true): ?>
            <p>Por favor revisá tu correo electrónico para establecer tu contraseña.</p>
            <a href="https://mail.google.com/mail/u/0/#inbox" target="_blank" class="boton-mail">Abrir mi correo</a>

        <?php else: ?>
            <a href="<?= base_url('/') ?>">Volver al inicio</a>
        <?php endif; ?>
    </div>
</body>
</html>
