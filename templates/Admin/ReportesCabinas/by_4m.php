<div class="w3-galaxy-blue w3-padding report-title">
	<?= $this->Html->link('<i class="fa-solid fa-print"></i>', ['action' => 'download-report', '?' => $this->request->getQuery()], ['class' => 'w3-right', 'escape' => false])?>
	<h4 class="w3-left-align"><i class="fa-solid fa-flag-checkered"></i> Reporte general del período de <?= $reportStart->i18nFormat("d 'de' MMMM yyyy") ?> a <?= $reportEnd->i18nFormat("d 'de' MMMM yyyy") ?></h4>
</div>

<div class="w3-row">
	<div class="w3-col l3 w3-padding-16">
		<div class="message info">
			<p><i class="fa-solid fa-list-check"></i> Hay <strong><?= $reportesProgramas->count()?> registros</strong> distribuídos en <strong><?= $programsCount ?> programas</strong> en las bitácoras del mes.</p>
		</div>
		
		<div class="message warning">
			<p><i class="fa-solid fa-satellite-dish"></i> Se enlazó por control remoto <strong><?= $reportesCR->sumOf('controles')?> ocasiones</strong> en los <?= $reportStart->diffInDays($reportEnd) + 1 ?> días que abarca el presente cuatrimestre. Esto representa una media de <strong><?= round(($reportStart->diffInDays($reportEnd) + 1) / $reportesCR->sumOf('controles'), 2) ?></strong> enlaces por día.</p>
		</div>
		
		<div class="message success">
			<p><i class="fa-regular fa-circle-check"></i> El cumplimiento general en el mes es de: <strong><?=  $this->Number->toPercentage((count($RPByStatus['V']) + count($RPByStatus['G']) + count($RPByStatus['S'])) / $reportesProgramas->count(), 1, ['multiply' => true])?></strong>.</p>
		</div>
		
		<div class="message error">
			<p><i class="fa-regular fa-circle-xmark"></i> <strong><?= count($RPByStatus['X'])?> (<?= $XtoWord ?>)</strong> faltas registradas.</p>
		</div>
	</div>
	
	<div class="w3-col l9">
		<div id="main-chart" style="width:100%;height:360px;"></div>
	</div>
</div>

<div class="w3-galaxy-blue w3-padding report-title">
	<h5 class="w3-left-align"><i class="fa-solid fa-tower-cell"></i> Informe de enlaces remotos en el período</h5>
</div>

<div class="w3-row">
	<?php foreach($crs as $cr) : ?>
	<div class="w3-col s12 m12 l6 w3-padding cr-list">
		<span title="<?= $this->Time->i18nFormat(\DateTime::createFromFormat('U', $cr['fecha']), "d 'de' MMMM yyyy") ?>"><i class="fa-solid fa-satellite-dish"></i> <?= $cr['cr'] ?></span>
	</div>
	<?php endforeach; ?>
</div>

<div class="w3-galaxy-blue w3-padding report-title">
	<h5 class="w3-left-align"><i class="fa-solid fa-chart-line"></i> Reportes individuales de cumplimiento</h5>
</div>

<div class="w3-row-padding">
	<?php foreach($programas as $programa) : ?>
	<div class="w3-col s12 m6 l3 w3-border-bottom">
		<div id="chartForP<?= $programa['ID'] ?>" class="w3-padding minichart"></div>
		<p class="w3-center c"><?= $programa['name'] ?><br/>
			<span style="font-weight:bold"><?= $this->Number->toPercentage($programa['chart']['Cumplimiento'], 1, ['multiply' => true])?></span>
		</p>
	</div>
	<?php endforeach; ?>
</div>

<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
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
				0:{color:"green"},
				1:{color:"orange"},
				2:{color:"blue"},
				3:{color:"red"},
			}
		};

		let chart = new google.visualization.PieChart(document.getElementById("main-chart"));
		chart.draw(data, options);
	}
	var generalOptions = {
			pieHole: 0.4,
			legend:{position:"none"},
			slices:{0:{color:"green"}, 1:{color:"red"},}
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

<style>
	.report-title h4 {color:#fff !important;} .report-title h5{color:#fff !important;font-size:24px;} p{margin:0;} .cr-list span {padding:0 0 8px;text-transform:uppercase;}
	.minichart{width:256px;height:128px;margin:auto;display:block;} .c{clear:both;} .cr-list{display:inline-grid !important;} .cr-list span {border-bottom:1px solid #ccc !important;}
	h5 i, h4 i{margin-right:16px;} .fa-print{padding:16px;font-size:32px;}
</style>