<div class="content">
	<div class="w3-dark-golden w3-padding">
		<h2 class="w3-right">Bitácora #<?= $bitacora->ID ?></h2>
		<h1><?= $bitacora->fecha->i18nFormat(\IntlDateFormatter::FULL) ?></h1>
	</div>


	<?php if (!empty($bitacora->reportes)) : ?>
		
		<table class="w3-table-all">
			<tr>
				<th>Reporte</th>
				<th>Operador</th>
				<th>Turno</th>
				<th>CR</th>
				<th>Reporte de enlaces remotos</th>
				<th class="actions">Acciones</th>
			</tr>
			<?php foreach ($bitacora->reportes as $rc) : ?>
				<tr>
					<td>#<?= $rc->ID ?></td>
					<td><?= $rc->locutor ?></td>
					<td><?= $rc->horaInicio ?> a <?= $rc->horaFin ?></td>
					<td><?= $rc->controles ?></td>
					<td><?= $rc->getPrintableReport() ?></td>
	
					<td class="actions">
						<?= $this->Html->link('<i class="fa-solid fa-file-circle-plus"></i>', ['controller' => 'ReportesProgramas', 'action' => 'addMissing', $rc->ID], ['escape' => false])?>
						<?= $this->Html->link('<i class="fa-solid fa-arrow-up-right-from-square"></i>', ['controller' => 'ReportesCabinas', 'action' => 'view', $rc->ID], ['escape' => false]) ?>
						<?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'ReportesCabinas', 'action' => 'edit', $rc->ID], ['escape' => false]) ?>
						<?= $this->Form->postLink('<i class="fa-regular fa-trash-can"></i>', ['controller' => 'ReportesCabinas', 'action' => 'delete', $rc->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $rc->ID), 'escape' => false]) ?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td class="picture">
						<?= $this->Html->image($rc->locutor->photo, ['class' => 'w3-image w3-border'])?>
					</td>
					<td colspan="3">
						<table class="w3-table">
							<tr>
								<th>Reportes de programas</th>
								<th colspan="3"></th>
							</tr>
							<?php foreach ($rc->reportes_programas as $reportePrograma) : ?>
							<tr>
								<td style="width:10%">#<?= $reportePrograma->ID ?></td>
								<td style="width:40%"><i class="fa-solid fa-radio"></i> <?= $this->Html->link($reportePrograma->programa, ['controller' => 'Programas', 'action' => 'view', $reportePrograma->programa->ID]) ?></td>
								<td style="width:40%"><?= $reportePrograma->getStatusText(icons:true) ?></td>
								<td style="width:10%"><?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'ReportesProgramas', 'action' => 'edit', $reportePrograma->ID], ['escape' => false]) ?></td>
							</tr>
							<?php endforeach;?>
						</table>
					</td>
				</tr>
                        <?php endforeach; ?>
		</table>
		<?php endif; ?>

</div>
<style>
	td.picture {vertical-align:middle !important;} img{width:80px;padding:4px;}
</style>