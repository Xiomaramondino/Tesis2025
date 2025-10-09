<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RingMind - Solicitudes Pendientes</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root {
    --color-primary: #091342;
    --color-secondary: #081136;
    --color-tertiary: #070f2e;
    --color-accent: #7158e2;
    --color-text-white: white;
    --color-danger: #dc2626;
    --color-success: #48bb78;
    --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
body {
    font-family: var(--font-family);
    background-color: var(--color-primary);
    color: var(--color-text-white);
    padding-top: 80px;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
.card-custom {
    background: var(--color-secondary);
    border-radius: 1.5rem;
    box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
    padding: 30px;
    color: var(--color-text-white);
    border: 1px solid rgba(255, 255, 255, 0.05);
    margin-bottom: 2rem;
}
.btn-custom {
    background-color: var(--color-tertiary);
    color: var(--color-text-white);
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: background-color 0.3s ease, transform 0.3s ease;
}
.btn-custom:hover { background-color: #666565; transform: translateY(-2px); color: var(--color-text-white); }
.alert-info {
    background-color: rgba(59, 130, 246, 0.15);
    border: 1.5px solid rgba(59, 130, 246, 0.6);
    color: #3b82f6;
    border-radius: 1rem;
    padding: 0.8rem 1rem;
    text-align: center;
}
.footer {
    text-align: center;
    background-color: var(--color-secondary);
    font-weight: bold;
    color: white;
    padding: 0.8rem;
    width: 100%;
    margin-top: auto;
    font-size: 0.95rem;
}
</style>
</head>
<body>

<!-- Navbar idéntica a la de cursos -->
<nav class="navbar fixed top-0 w-full flex justify-between items-center bg-[var(--color-secondary)] p-4 md:p-6 z-50">
    <div class="navbar-left flex items-center">
        <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" alt="Logo" class="h-10 md:h-12">
    </div>
    <div class="logo text-xl md:text-2xl font-bold absolute left-1/2 transform -translate-x-1/2">
        RingMind
    </div>
    <div class="navbar-right flex items-center gap-2 md:gap-4">
        <a href="<?= base_url('vista_admin'); ?>" class="nav-btn flex items-center gap-1 text-sm md:text-base">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</nav>

<main class="flex-1 p-4 md:p-8">
    <div class="container mx-auto max-w-4xl">
        <h2 class="text-center text-xl md:text-3xl font-bold mb-6">Solicitudes Pendientes</h2>

        <?php if(empty($solicitudes)) : ?>
            <div class="alert-info">No hay solicitudes pendientes por el momento.</div>
        <?php else: ?>
            <?php foreach($solicitudes as $solicitud): ?>
                <div class="card-custom">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex-1">
                            <p><strong>Usuario:</strong> <?= esc($solicitud['usuario']) ?></p>
                            <p><strong>Email:</strong> <?= esc($solicitud['email']) ?></p>
                            <p><strong>Producto:</strong> <?= esc($solicitud['producto']) ?></p>
                            <p><strong>Cantidad:</strong> <?= esc($solicitud['cantidad']) ?></p>
                            <p><strong>Paypal Order ID:</strong> <?= esc($solicitud['paypal_order_id']) ?></p>
                            <p><strong>Fecha:</strong> <?= esc($solicitud['fecha_solicitud']) ?></p>
                        </div>
                        <div class="flex gap-2 mt-3 md:mt-0">
                            <button class="btn-custom bg-green-600 hover:bg-green-700" onclick="procesarSolicitud(<?= $solicitud['id'] ?>, 'aceptada')">
                                <i class="fas fa-check"></i> Aceptar
                            </button>
                            <button class="btn-custom bg-red-600 hover:bg-red-700" onclick="procesarSolicitud(<?= $solicitud['id'] ?>, 'rechazada')">
                                <i class="fas fa-times"></i> Rechazar
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<footer class="footer">
    <p>Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara</p>
</footer>

<script>
function procesarSolicitud(id, estado) {
    Swal.fire({
        title: '¿Confirmar acción?',
        text: `¿Deseas ${estado} esta solicitud?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if(result.isConfirmed) {
            fetch('<?= base_url("admin/procesar_solicitud") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ id: id, estado: estado })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'ok'){
                    Swal.fire('Listo', data.msg, 'success').then(() => location.reload());
                } else {
                    Swal.fire('Error', data.msg, 'error');
                }
            })
            .catch(() => Swal.fire('Error', 'Ocurrió un error al procesar la solicitud.', 'error'));
        }
    });
}
</script>

</body>
</html>
