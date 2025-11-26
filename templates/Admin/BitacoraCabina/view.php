<div class="content">
	<div class="w3-deep-blue w3-padding">
		<h5 class="w3-right">Bitácora #<?= $bitacora->ID ?></h5>
		<h5><i class="fa-solid fa-list-check"></i> <?= $bitacora->fecha->i18nFormat(\IntlDateFormatter::FULL) ?></h5>
	</div>


	<?php if (!empty($bitacora->reportes)): ?>

		<table class="w3-table-all">
			<tr class="w3-low-blue">
				<th style="width:110px;">
					<h6>Reporte</h6>
				</th>
				<th style="width:160px;">
					<h6>Operador</h6>
				</th>
				<th style="width:180px;">
					<h6>Turno</h6>
				</th>
				<th style="width:70px;">
					<h6>CR</h6>
				</th>
				<th>
					<h6>Reporte de enlaces remotos</h6>
				</th>
				<th style="width:120px;">
					<h6>Acciones</h6>
				</th>
			</tr>
			<?php foreach ($bitacora->reportes as $rc): ?>
				<tr>
					<td>#<?= $rc->ID ?></td>
					<td><?= $rc->locutor ?></td>
					<td><?= $rc->horaInicio ?> a <?= $rc->horaFin ?></td>
					<td><?= $rc->controles ?></td>
					<td><?= $rc->getPrintableReport() ?></td>

					<td class="actions">

						<?= $this->Html->link('<i class="fa-solid fa-arrow-up-right-from-square"></i>', ['controller' => 'ReportesCabinas', 'action' => 'view', $rc->ID], ['escape' => false]) ?>
						<?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'ReportesCabinas', 'action' => 'edit', $rc->ID], ['escape' => false]) ?>
						<?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['controller' => 'ReportesCabinas', 'action' => 'delete', $rc->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $rc->ID), 'escape' => false]) ?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td class="picture">
						<?= $this->Html->image($rc->locutor->photo, ['class' => 'w3-image w3-border']) ?>
					</td>
					<td colspan="3">
						<table class="w3-table">
							<tr>
								<th>Reportes de programas</th>
								<th colspan="3"></th>
							</tr>
							<?php foreach ($rc->reportes_programas as $reportePrograma): ?>
								<tr>
									<td style="width:10%">#<?= $reportePrograma->ID ?></td>
									<td style="width:40%"><i class="fa-solid fa-radio"></i>
										<?= $this->Html->link($reportePrograma->programa, ['controller' => 'Programas', 'action' => 'view', $reportePrograma->programa->ID]) ?>
									</td>
									<td style="width:40%"><?= $reportePrograma->getStatusText(icons: true) ?></td>
									<td style="width:10%">
										<?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'ReportesProgramas', 'action' => 'edit', $reportePrograma->ID], ['escape' => false]) ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</table>
					</td>
					<td>
						<?= $this->Html->link('<i class="fa-solid fa-file-circle-plus"></i>', ['controller' => 'ReportesProgramas', 'action' => 'addMissing', $rc->ID], ['escape' => false]) ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>

</div>
<style>
	td.picture {
		vertical-align: middle !important;
	}

	img {
		width: 80px;
		padding: 4px;
	}

	td.actions {
		width: 110px;
	}
</style>