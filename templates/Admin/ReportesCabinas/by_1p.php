<div class="w3-deep-blue w3-padding report-title">
	<h5 class="w3-left-align w3-left"><?= $programa->name ?></h5>
	<h5 class="w3-right-align"><?= $start->i18nFormat("d 'de' MMMM YYYY") ?> a <?= $end->i18nFormat("d 'de' MMMM YYYY ") ?> <i class="fa-solid fa-calendar-days"></i></h5>
</div>

<div class="w3-row">

	<div class="w3-col l3 w3-padding">
		<p><i class="fa-solid fa-list-check"></i> Hay <?= $reportes->count()?> registros en las bitácoras del período.</p>
		
		<p><i class="fa-regular fa-circle-check"></i> Este programa tiene un cumplimiento del: <strong><?=  $this->Number->toPercentage((count($ocurrences['V']) + count($ocurrences['G']) + count($ocurrences['S'])) / $reportes->count(), 1, ['multiply' => true])?></strong>.</p>
		
		<p><i class="fa-regular fa-circle-xmark"></i> <strong><?= count($ocurrences['X'])?> (<?= $programa->get('XtoWord') ?>)</strong> faltas registradas.</p>
	</div>
	
	<div class="w3-col l9 w3-padding">
		<div id="main-chart" style="width:100%;height:400px;"></div>
	</div>
</div>

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
		};

		let chart = new google.visualization.PieChart(document.getElementById("main-chart"));
		chart.draw(data, options);
      }
</script>

<style>
	.report-title h4{color:#fff !important;}
</style>