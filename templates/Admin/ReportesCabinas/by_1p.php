<div class="page-header">
	<h5><i class="fa-solid fa-radio"></i> <?= $programa->name ?></h5>
	<div style="position:absolute; right: var(--spacing-16); top: var(--spacing-16); color: var(--color-ghost-white);">
		<?= $start->i18nFormat("d 'de' MMMM YYYY") ?> a <?= $end->i18nFormat("d 'de' MMMM YYYY") ?> <i class="fa-solid fa-calendar-days"></i>
	</div>
</div>

<div class="row g-3">
	<div class="col-lg-3">
		<p style="color: var(--color-faded-silver);"><i class="fa-solid fa-list-check"></i> Hay <?= $reportes->count() ?> registros en las bitácoras del período.</p>
 
		<p style="color: var(--color-faded-silver);"><i class="fa-regular fa-circle-check"></i> Este programa tiene un cumplimiento del:
			<strong style="color: var(--color-ghost-white);"><?= $this->Number->toPercentage((count($ocurrences['V']) + count($ocurrences['G']) + count($ocurrences['S'])) / $reportes->count(), 1, ['multiply' => true]) ?></strong>.
		</p>
 
		<p style="color: var(--color-faded-silver);"><i class="fa-regular fa-circle-xmark"></i> <strong style="color: var(--color-ghost-white);"><?= count($ocurrences['X']) ?>
				(<?= $programa->get('XtoWord') ?>)</strong> faltas registradas.</p>
	</div>
 
	<div class="col-lg-9">
		<div id="main-chart" style="width:100%;height:400px;"></div>
	</div>
</div>

<script type="text/javascript">
	google.charts.load("current", { packages: ["corechart"] });
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
		<?php
		$chartRows = array_map(
			fn($status, $r) => [$statusLongText[$status], count($r)],
			array_keys($ocurrences),
			$ocurrences
		);
		$chartData = array_merge(
			[["Reporte de programa", "Incidencias en el período"]],
			$chartRows
		);
		?>
		var data = google.visualization.arrayToDataTable(<?= json_encode($chartData, JSON_UNESCAPED_UNICODE) ?>);

		var options = {
			title: "Desglose de reportes del programa",
			is3D: true,
			backgroundColor: 'transparent',
			titleTextStyle: { color: '#f0f6fc' },
			legendTextStyle: { color: '#c9d1d9' },
			slices: {
				0: {color: '#3fb950'},
				1: {color: '#d29922'},
				2: {color: '#58a6ff'},
				3: {color: '#f85149'}
			}
		};

		let chart = new google.visualization.PieChart(document.getElementById("main-chart"));
		chart.draw(data, options);
	}
</script>