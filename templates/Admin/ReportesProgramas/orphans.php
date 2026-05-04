<div class="content">
    <div class="page-header">
        <h5><i class="fa-solid fa-triangle-exclamation"></i> Registros huérfanos</h5>
    </div>
    
    <div class="alert alert-danger">
        <?= $this->Form->deleteLink(
            '<i class="fa-regular fa-trash-can"></i> Eliminar registros huérfanos',
            ['action' => 'deleteOrphans'],
            [
                'confirm' => '¿Estás completamente seguro? Esta acción borrará ' . count($reportesHuerfanos) . ' registros y no se puede deshacer.',
                'class' => 'btn btn-danger',
                'escapeTitle' => false
            ]
        ?>
    </div>
    
    <div class="content-card">
        <ul style="list-style: none; padding: 0;">
            <?php foreach ($reportesHuerfanos as $reporte): ?>
                <li style="padding: var(--spacing-8) var(--spacing-12); border-bottom: 1px solid var(--color-subtle-gray);">
                    <p style="margin: 0; color: var(--color-faded-silver);">Reporte Programa ID <?= $reporte->ID ?> apunta a Reporte Cabina <?= $reporte->ReporteCabinaID ?>
                        (Inexistente)</p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>