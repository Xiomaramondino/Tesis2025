<h2 class="card-title text-center" style="color:#d4b8e0;">Avisos / Calendario</h2>
<div class="horarios-list">
<?php if(!empty($avisos)): ?>
    <?php foreach($avisos as $aviso): ?>
        <div class="horario-card">
            <div class="horario-info">
                <p><strong>Título:</strong> <?= esc($aviso->titulo) ?></p>
                <p><strong>Descripción:</strong> <?= esc($aviso->descripcion) ?></p>
                <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($aviso->fecha)) ?></p>
                <?php if($aviso->idcurso): ?>
                    <p><strong>Curso:</strong> <?= esc($aviso->idcurso) ?></p>
                <?php else: ?>
                    <p><strong>Curso:</strong> Todos los cursos</p>
                <?php endif; ?>
                <p><strong>Visibilidad:</strong> <?= esc($aviso->visibilidad) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p style="color:white; text-align:center;">No hay avisos activos.</p>
<?php endif; ?>
</div>
