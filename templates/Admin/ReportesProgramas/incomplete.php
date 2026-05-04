<div class="content">
    <div class="page-header">
        <h5><i class="fa-solid fa-triangle-exclamation"></i> Reportes incompletos</h5>
    </div>
    
    <div class="alert alert-danger">
        <?= $this->Form->deleteLink(
            '<i class="fa-regular fa-trash-can"></i> Eliminar registros huérfanos',
            ['action' => 'deleteOrphans'],
            [
                'confirm' => '¿Estás completamente seguro? Esta acción borrará ' . count($reportesIncompletos) . ' registros y no se puede deshacer.',
                'class' => 'btn btn-danger',
                'escapeTitle' => false
            ]
        ?>
    </div>
    
    <p style="color: var(--color-faded-silver);">Se encontraron <?= count($reportesIncompletos) ?> reportes incompletos.</p>
    
    <div class="content-card">
        <ul style="list-style: none; padding: 0;">
            <?php foreach ($reportesIncompletos as $reporte): ?>
                <li style="padding: var(--spacing-8) var(--spacing-12); border-bottom: 1px solid var(--color-subtle-gray);">
                    <p style="margin: 0; color: var(--color-faded-silver);">
                        <?= $this->Html->link('Reporte Programa #' . $reporte->ID, ['controller' => 'BitacoraCabina', 'action' => 'view', $reporte->reporte->bitacoraID], ['target' => '_blank', 'style' => 'color: var(--color-ghost-white);']) ?>
                        <strong style="color: var(--color-ghost-white);"><?= $reporte->programa ?></strong> no tiene reporte.
                        <br>Reporte Cabina ID #<?= $reporte->reporte->bitacoraID ?>
                        <strong style="color: var(--color-ghost-white);"><?= $reporte->reporte->bitacora->fecha ?? 'Fecha no disponible' ?></strong> / Operador:
                        <?= $reporte->reporte->locutor->name ?? 'Operador no disponible' ?>
                        <?= $this->Html->link('<i class="fa-solid fa-external-link"></i> Ver en el INFO', ['controller' => 'BitacoraCabina', 'action' => 'display', '?' => ['d' => ($reporte->reporte->bitacora->fecha != null ? $reporte->reporte->bitacora->fecha->format('Y-m-d') : ''), 'enable' => 1], 'prefix' => false], ['escapeTitle' => false, 'target' => '_blank', 'class' => 'btn btn-outlined btn-sm']) ?>
                    </p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>