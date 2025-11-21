<div class="content">

	<div class="w3-deep-blue w3-padding">
		<h5>Reporte de programa #<?= $reporte->ID ?></h5>
	</div>
	
	<table class="w3-table-all">
		<tr>
			<th>Programa</th>
			<td><?= $reporte->programa ?></td>
		</tr>
		<tr>
			<th>Status</th>
			<td><?= $reporte->getStatusText() ?></td>
		</tr>

	</table>
		
	<div class="w3-low-blue w3-padding">
		<h5>Bitácora</h5>
	</div>
	
	<table class="w3-table-all">
		<tr>
			<th>Fecha</th>
			<td><?= $reporte->reporte->bitacora->fecha->i18nFormat(\IntlDateFormatter::FULL) ?></td>
		</tr>
		<tr>
			<th>Reporte de cabina</th>
			<td>RC #<?= $reporte->reporte->ID ?></td>
		</tr>
		<tr>
			<th>Reportado por</th>
			<td><?= $reporte->reporte->locutor ?></td>
		</tr>
		<tr>
			<th>Turno</th>
			<td><?= $reporte->reporte->horaInicio ?> - <?= $reporte->reporte->horaFin ?></td>
		</tr>
	</table>
</div>

