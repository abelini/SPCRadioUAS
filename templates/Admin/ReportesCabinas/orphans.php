<div class="content">

    <div class="w3-container w3-section">
        <?= $this->Form->deleteLink(
            'Eliminar registros huérfanos',
            ['action' => 'deleteOrphans'],
            [
                'confirm' => '¿Estás completamente seguro? Esta acción borrará ' . count($reportesHuerfanos) . ' registros y no se puede deshacer.',
                'class' => 'w3-button w3-red w3-round-large',
            ]
        ) ?>
    </div>

    <ul class="w3-ul w3-border">
        <?php foreach ($reportesHuerfanos as $reporte): ?>
            <li class="w3-border-bottom">
                <p>Reporte ID <?= $reporte->ID ?> apunta a Bitácora <?= $reporte->bitacoraID ?> (Inexistente)</p>
            </li>
        <?php endforeach; ?>
    </ul>

</div>