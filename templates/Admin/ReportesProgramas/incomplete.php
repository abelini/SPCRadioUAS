<div class="content">

    <div class="w3-container w3-section">
        <?= $this->Form->deleteLink(
            'Eliminar registros huérfanos',
            ['action' => 'deleteOrphans'],
            [
                'confirm' => '¿Estás completamente seguro? Esta acción borrará ' . count($reportesIncompletos) . ' registros y no se puede deshacer.',
                'class' => 'w3-button w3-red w3-round-large',
            ]
        ) ?>
    </div>

    <p>Se encontraron <?= count($reportesIncompletos) ?> reportes incompletos.</p>

    <ul class="w3-ul w3-border">
        <?php foreach ($reportesIncompletos as $reporte): ?>
            <li class="w3-border-bottom">
                <p><?= $this->Html->link('Reporte Programa #' . $reporte->ID, ['controller' => 'BitacoraCabina', 'action' => 'view', $reporte->reporte->bitacoraID], ['target' => '_blank']) ?>
                    <strong><?= $reporte->programa ?></strong> no tiene reporte.
                    <br>Reporte Cabina ID #<?= $reporte->reporte->bitacoraID ?>
                    <strong><?= $reporte->reporte->bitacora->fecha ?? 'Fecha no disponible' ?></strong> / Operador:
                    <?= $reporte->reporte->locutor->name ?? 'Operador no disponible' ?>
                    <?= $this->Html->link('<i class="fa-solid fa-arrow-up-right-from-square"></i> Ver en el INFO', ['controller' => 'BitacoraCabina', 'action' => 'display', '?' => ['d' => ($reporte->reporte->bitacora->fecha != null ? $reporte->reporte->bitacora->fecha->format('Y-m-d') : ''), 'enable' => 1], 'prefix' => false], ['escape' => false, 'target' => '_blank']) ?>

                </p>
            </li>
        <?php endforeach; ?>
    </ul>

</div>