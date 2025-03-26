<div class="content">

	<div class="w3-galaxy-blue w3-padding">
		<h1>Programa «<?= $programa ?>»</h1>
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
					
					<?php foreach ($programa->dias as $dias) : ?>

					<li><?= $dias->name ?></li>

					<?php endforeach; ?>
					
				</ul>
			</td>
		</tr>
	</table>
	
	<?php if($programa->reportable) : ?>
	
	<div class="related">
		<div class="w3-galaxy-blue w3-padding">
			<h1>Estadísticas del <?= $fechaInicial->i18nFormat("d 'de' MMMM 'de' YYYY") ?> a la fecha (<?= $diff ?>)</h1>
		</div>
	
		<div class="w3-row">

			<div class="w3-col l3 w3-padding">
				<p>Se han registrado <?= $reportes->count()?> emisiones de este programa en las bitácoras.</p>
				
				<p>Este programa tiene un cumplimiento del: <strong><?=  $this->Number->toPercentage((count($ocurrences['V']) + count($ocurrences['G']) + count($ocurrences['S'])) / $reportes->count(), 1, ['multiply' => true])?></strong>.</p>
				
				<p>Solo existen <strong><?= count($ocurrences['X'])?> (<?= $programa->get('XtoWord') ?>)</strong> faltas registradas.</p>
			</div>
			
			<div class="w3-col l9 w3-padding">
				<div id="main-chart" style="width:100%;height:400px;"></div>
			</div>
		</div>
		
		<?= $this->Html->script('https://www.gstatic.com/charts/loader.js')?>
		<script type="text/javascript">
			google.charts.load("current", {packages:["corechart"]});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				var data = google.visualization.arrayToDataTable([
					["Reporte de programa", "Incidencias en el período"],
					<?php foreach($ocurrences as $status => $r) : ?>
					["<?= $statusLongText[$status] ?>", <?= count($r)?>],
					<?php endforeach; ?>
				]);

				var options = {
					title: "Desglose de reportes del programa",
					is3D: true,
					colors:['green','orange', 'blue', 'red']
				};

				let chart = new google.visualization.PieChart(document.getElementById("main-chart"));
				chart.draw(data, options);
			}
		</script>
		
	</div>
	<?php endif; ?>
</div>



<style>
	.report-title h4{color:#fff !important;}
</style>