<div class="content">
	<div class="w3-deep-blue w3-padding">
		<h5>Reporte de cabina #<?= $reporte->ID ?></h5>
	</div>
	<table class="w3-table-all">
		<tr>
			<th>Bitacora</th>
			<td>#<?= $reporte->bitacoraID ?> | <?= $reporte->bitacora->fecha->i18nFormat(\IntlDateFormatter::FULL) ?></td>
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
	
	<div class="text">
		<strong><?= ($reporte->controles > 0)? 'Lista de enlaces remotos' : 'Reporte de cabina' ?></strong>
		<blockquote>
			<?= $reporte->getPrintableReport(); ?>
		</blockquote>
	</div>

	<div class="related">
		<div class="w3-low-blue w3-padding">
			<h5>Reportes individuales de programas</h5>
		</div>
		
		    
		<?php if (!empty($reporte->reportes_programas)) : ?>

		<table class="w3-table-all">
			<tr>
			    <th>Reporte</th>
			    <th>Programa</th>
			    <th>Status</th>
			    <th class="actions">Acciones</th>
			</tr>
			<?php foreach ($reporte->reportes_programas as $rp) : ?>
			<tr>
			    <td>#<?= $rp->ID ?></td>
			    <td><?= $rp->programa->name ?></td>
				<td><?= $rp->getStatusText(true) ?></td>
				<td class="actions">
					<?= $this->Html->link('<i class="fa-solid fa-arrow-up-right-from-square"></i>', ['controller' => 'ReportesProgramas', 'action' => 'view', $rp->ID], ['escape' => false]) ?>
					<?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'ReportesProgramas', 'action' => 'edit', $rp->ID], ['escape' => false]) ?>
					<?= $this->Form->postLink('<i class="fa-regular fa-trash-can"></i>', ['controller' => 'ReportesProgramas', 'action' => 'delete', $rp->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $rp->ID), 'escape' => false]) ?>
			    </td>
			</tr>
			<?php endforeach; ?>
		  </table>

		<?php else : ?>
			<p class="w3-padding"><i class="fa-regular fa-file-excel"></i> No se reportaron programas en este turno</p>
		<?php endif; ?>
	</div>
  
</div>