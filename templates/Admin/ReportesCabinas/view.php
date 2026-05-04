<div class="content">
	<div class="page-header">
 		<h5><i class="fa-solid fa-chart-bar"></i> Reporte de cabina #<?= $reporte->ID ?></h5>
 	</div>
	
	<div class="content-card">
        <table class="view-table">
            <tr>
                <th>Bitácora</th>
                <td><?= $this->Html->link('#' . $reporte->bitacoraID, ['controller' => 'BitacoraCabina', 'action' => 'view', $reporte->bitacoraID]) ?> | <?= $reporte->bitacora->fecha->i18nFormat(\IntlDateFormatter::FULL) ?></td>
            </tr>
            <tr>
                <th>Operador</th>
                <td><?= $reporte->locutor->name ?></td>
            </tr>
            <tr>
                <th>Enlaces remotos</th>
                <td><?= $reporte->controles ?></td>
            </tr>
            <tr>
                <th>Turno reportado</th>
                <td><?= h($reporte->horaInicio) ?> a <?= h($reporte->horaFin) ?></td>
            </tr>
        </table>
	
	    <div class="stats-section">
            <strong><?= ($reporte->controles > 0) ? 'Lista de enlaces remotos' : 'Reporte de cabina' ?></strong>
            <blockquote class="blockquote">
                <?= $reporte->getPrintableReport(); ?>
            </blockquote>
        </div>
	
	    <div class="stats-section">
            <div class="page-header">
                <h5><i class="fa-solid fa-radio"></i> Reportes individuales de programas</h5>
            </div>
	
 	        <?php if (!empty($reporte->reportes_programas)): ?>
	
 		        <table class="data-table">
			        <thead>
				        <tr>
					        <th>Reporte</th>
					        <th>Programa</th>
					        <th>Status</th>
					        <th>Acciones</th>
				        </tr>
			        </thead>
			        <tbody>
			        <?php foreach ($reporte->reportes_programas as $rp): ?>
				        <tr>
					        <td>#<?= $rp->ID ?></td>
					        <td><?= $this->Html->link($rp->programa->name, ['controller' => 'Programas', 'action' => 'view', $rp->programa->ID]) ?></td>
					        <td><?= $rp->getStatusText(true) ?></td>
					        <td>
						        <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['controller' => 'ReportesProgramas', 'action' => 'view', $rp->ID], ['escapeTitle' => false]) ?>
						        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'ReportesProgramas', 'action' => 'edit', $rp->ID], ['escapeTitle' => false]) ?>
						        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['controller' => 'ReportesProgramas', 'action' => 'delete', $rp->ID], ['confirm' => '¿Estás seguro?', 'escapeTitle' => false]) ?>
					        </td>
				        </tr>
			        <?php endforeach; ?>
			        </tbody>
		        </table>
	
 	        <?php else: ?>
		        <p class="no-results"><i class="fa-regular fa-file-excel"></i> No se reportaron programas en este turno</p>
 	        <?php endif; ?>
        </div>
    </div>
	
	<div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $reporte->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $reporte->ID], ['confirm' => '¿Estás seguro de eliminar este reporte?', 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>