<div class="content">

	<div class="w3-deep-blue w3-padding">
		<h5><i class="fa-solid fa-radio"></i> Programa «<?= $programa ?>»</h5>
	</div>

	<table class="w3-table-all">

		<tr>
			<th>Producción</th>
			<td><?= $programa->produccion ?></td>
		</tr>

		<tr>
			<th>Horario</th>
			<td><?= $programa->horaInicio ?> <i class="fa-solid fa-arrow-right-long"></i> <?= $programa->horaFin ?></td>
		</tr>
		<tr>
			<th>Días</th>
			<td>
				<ul class="w3-ul">

					<?php foreach ($programa->dias as $dias): ?>

						<li><?= $dias->name ?></li>

					<?php endforeach; ?>

				</ul>
			</td>
		</tr>
	</table>

	<?php if ($programa->reportable): ?>

		<div class="related">
			<div class="w3-deep-blue w3-padding">
				<h5><i class="fa-solid fa-chart-simple"></i> Estadísticas del
					<?= $fechaInicial->i18nFormat("d 'de' MMMM 'de' YYYY") ?> a la fecha (<?= $diff ?>)</h5>
			</div>

			<div class="w3-row">

				<div class="w3-col l3 w3-padding">
					<p>Se han registrado <?= $reportes->count() ?> emisiones de este programa en las bitácoras.</p>

					<?php if ($reportes->count() > 0): ?>

						<p>Este programa tiene un cumplimiento del:
							<strong><?= $this->Number->toPercentage((count($ocurrences['V']) + count($ocurrences['G']) + count($ocurrences['S'])) / $reportes->count(), 1, ['multiply' => true]) ?></strong>.
						</p>

						<p>Solo existen <strong><?= count($ocurrences['X']) ?> (<?= $programa->get('XtoWord') ?>)</strong> faltas
							registradas.</p>

					<?php endif; ?>


				</div>

				<div class="w3-col l9 w3-padding">
					<div id="main-chart" style="width:100%;height:400px;"></div>
				</div>
			</div>

			<?= $this->Html->script('https://www.gstatic.com/charts/loader.js') ?>
			<script type="text/javascript">
				google.charts.load("current", { packages: ["corechart"] });
				google.charts.setOnLoadCallback(drawChart);
				function drawChart() {
					var data = google.visualization.arrayToDataTable([
						["Reporte de programa", "Incidencias en el período"],
						<?php foreach ($ocurrences as $status => $r): ?>
							["<?= $statusLongText[$status] ?>", <?= count($r) ?>],
						<?php endforeach; ?>
					]);

					var options = {
						title: "Desglose de reportes del programa",
						is3D: true,
						colors: ['green', 'orange', 'blue', 'red'],
						sliceVisibilityThreshold: 0
					};

					let chart = new google.visualization.PieChart(document.getElementById("main-chart"));
					chart.draw(data, options);
				}
			</script>

		</div>
	<?php endif; ?>

	<?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar este programa', ['action' => 'edit', $programa->ID], ['class' => 'w3-button w3-green w3-left w3-margin-right', 'escape' => false]) ?>


	<?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar este programa', ['action' => 'delete', $programa->ID], ['confirm' => 'Esto eliminará permanentemente esta solicitud', 'class' => 'w3-button w3-red w3-right', 'escape' => false]) ?>

	<div style="clear:both"></div>
</div>



<style>
	.report-title h4 {
		color: #fff !important;
	}
</style>