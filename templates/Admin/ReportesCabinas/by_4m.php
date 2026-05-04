<div class="page-header">
	<h5><i class="fa-solid fa-flag-checkered"></i> Reporte general del período de <?= $reportStart->i18nFormat("d 'de' MMMM yyyy") ?> a <?= $reportEnd->i18nFormat("d 'de' MMMM yyyy") ?></h5>
	<div style="position:absolute; right: var(--spacing-16); top: var(--spacing-16);">
		<?= $this->Html->link('<i class="fa-solid fa-print"></i>', ['action' => 'download-report', '?' => $this->request->getQuery()], ['escapeTitle' => false, 'class' => 'btn btn-outlined']) ?>
	</div>
</div>

<div class="row g-3">
	<div class="col-lg-3">
		<div class="alert alert-info">
			<p><i class="fa-solid fa-list-check"></i> Hay <strong><?= $reportesProgramas->count()?> registros</strong> distribuídos en <strong><?= $programsCount ?> programas</strong> en las bitácoras del mes.</p>
		</div>
		
		<div class="alert alert-warning">
			<p><i class="fa-solid fa-satellite-dish"></i> Se enlazó por control remoto <strong><?= $reportesCR->sumOf('controles')?> ocasiones</strong> en los <?= $reportStart->diffInDays($reportEnd) + 1 ?> días que abarca el presente cuatrimestre. Esto representa una media de <strong><?= round(($reportStart->diffInDays($reportEnd) + 1) / $reportesCR->sumOf('controles'), 2) ?></strong> enlaces por día.</p>
		</div>
		
		<div class="alert alert-success">
			<p><i class="fa-regular fa-circle-check"></i> El cumplimiento general en el mes es de: <strong><?=  $this->Number->toPercentage((count($RPByStatus['V']) + count($RPByStatus['G']) + count($RPByStatus['S'])) / $reportesProgramas->count(), 1, ['multiply' => true])?></strong>.</p>
		</div>
		
		<div class="alert alert-danger">
			<p><i class="fa-regular fa-circle-xmark"></i> <strong><?= count($RPByStatus['X'])?> (<?= $XtoWord ?>)</strong> faltas registradas.</p>
		</div>
	</div>
	
	<div class="col-lg-9">
		<div id="main-chart" style="width:100%;height:360px;"></div>
	</div>
</div>

<div class="stats-section">
	<div class="page-header">
		<h5><i class="fa-solid fa-tower-cell"></i> Informe de enlaces remotos en el período</h5>
	</div>
</div>

<div class="row g-2">
	<?php foreach($crs as $cr) : ?>
		<div class="col-12 col-md-6" style="padding: var(--spacing-8);">
			<span title="<?= $this->Time->i18nFormat(\DateTime::createFromFormat('U', $cr['fecha']), "d 'de' MMMM yyyy") ?>" style="text-transform:uppercase; padding: var(--spacing-4) var(--spacing-8); border-bottom:1px solid var(--color-subtle-gray); display: block;">
				<i class="fa-solid fa-satellite-dish"></i> <?= $cr['cr'] ?>
			</span>
		</div>
	<?php endforeach; ?>
</div>

<div class="stats-section">
	<div class="page-header">
		<h5><i class="fa-solid fa-chart-line"></i> Reportes individuales de cumplimiento</h5>
	</div>
</div>

<div class="row g-3">
	<?php foreach($programas as $programa) : ?>
		<div class="col-12 col-md-6 col-lg-3" style="border-bottom: 1px solid var(--color-subtle-gray); padding: var(--spacing-8);">
			<div id="chartForP<?= $programa['ID'] ?>" style="padding: var(--spacing-8); width: 256px; height: 128px; margin: 0 auto;"></div>
			<p style="text-align: center; clear: both; margin: var(--spacing-4) 0;">
				<?= $programa['name'] ?><br/>
				<span style="font-weight: bold;"><?= $this->Number->toPercentage($programa['chart']['Cumplimiento'], 1, ['multiply' => true])?></span>
			</p>
		</div>
	<?php endforeach; ?>
</div>

<script type="text/javascript">
	google.charts.load("current", { packages: ["corechart"] });
	google.charts.setOnLoadCallback(drawChart);
	
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			["Reporte de programa", "Incidencias en el período"],
			<?php foreach($RPByStatus as $status => $r) : ?>
				["<?= $statusLongText[$status] ?>", <?= count($r)?>],
			<?php endforeach; ?>
		]);

		var options = {
			title: "Desglose de reportes del programa",
			is3D: true,
			slices:{
				0:{color:"#22c55e"},
				1:{color:"#f59e0b"},
				2:{color:"#3b82f6"},
				3:{color:"#ef4444"},
			},
			backgroundColor: 'transparent',
			titleTextStyle: { color: '#f0f6fc' },
			legendTextStyle: { color: '#c9d1d9' }
		};

		let chart = new google.visualization.PieChart(document.getElementById("main-chart"));
		chart.draw(data, options);
	}
	var generalOptions = {
		pieHole: 0.4,
		legend:{position:"none"},
		slices:{0:{color:"#22c55e"}, 1:{color:"#ef4444"},},
		pieSliceText:"none",
		backgroundColor: 'transparent',
		legendTextStyle: { color: '#c9d1d9' }
	};
	
	<?php foreach($programas as $programa) : ?>
	google.charts.setOnLoadCallback(function() { 
		new google.visualization.PieChart(document.getElementById("chartForP<?= $programa['ID'] ?>")).draw(google.visualization.arrayToDataTable([
			['Reportes', 'Ocurrencias'],
			<?php foreach($programa['chart'] as $label => $value) : ?>
				["<?= $label ?>", <?= $value ?>],
			<?php endforeach; ?>
		]), generalOptions);
	});
	<?php endforeach; ?>
</script>