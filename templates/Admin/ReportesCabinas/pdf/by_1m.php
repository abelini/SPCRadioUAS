<div class="w3-galaxy-blue w3-padding report-title">
	<h4 class="w3-center"><i class="fa-solid fa-flag-checkered"></i> Reporte general de <?= $reportStart->i18nFormat("MMMM 'de' yyyy") ?></h4>
</div>

<div class="w3-row">
	<div class="w3-col s12 m12 l12 w3-padding-16">
		<p>Hay <strong><?= $reportesProgramas->count()?> registros</strong> distribuídos en <strong><?= $programsCount ?> programas</strong> en las bitácoras del mes.</p>

		<p>Se enlazó por control remoto <strong><?= $reportesCR->sumOf('controles')?> ocasiones</strong> en el mes. Esto representa una media de <strong><?= round($reportStart->daysInMonth / $reportesCR->sumOf('controles'), 2) ?></strong> enlaces por día.</p>
		
		<p>El cumplimiento general en el mes es de: <strong><?= $this->Number->toPercentage(($reportesProgramas->count() - count($RPByStatus['X'])) / $reportesProgramas->count(), 1, ['multiply' => true])?></strong>.</p>
		
		<p><strong><?= count($RPByStatus['X'])?> (<?= $XtoWord ?>)</strong> faltas registradas.</p>
	</div>
	
	<p class="w3-center" style="font-weight:bold;">Gráfico general</p>
	
	<div class="w3-col s12 m12 l12">
		<?php foreach($RPByStatus as $status => $r) : ?>
		<div class="w3-row">
			<div class="w3-col s12 m6 l3" style="padding:24px 0 12px;"><?= $statusLongText[$status] ?> (<?= count($r)?>)</div>
			<div class="w3-col s12 m6 l9 w3-light-grey">
				<div class="w3-container w3-<?= next($printBarColors)?> w3-padding-large w3-text-white" style="width:<?= count($r) / $reportesProgramas->count() * 100 ?>%"><?= round(count($r) / $reportesProgramas->count() * 100, 2) ?>%</div>
			</div>
		</div>
		<?php endforeach; ?>
		<div class="w3-row">
			<div class="w3-col s12 m6 l3" style="padding:24px 0 12px;"><strong>Cumplimiento general (Programas en vivo, grabados y justificadamente suspendidos)</strong></div>
			<div class="w3-col s12 m6 l9 w3-light-grey">
				<div class="w3-container w3-green w3-padding-large w3-center" style="width:<?= ($reportesProgramas->count() - count($RPByStatus['X'])) / $reportesProgramas->count() * 100 ?>%"><?= $this->Number->toPercentage(($reportesProgramas->count() - count($RPByStatus['X'])) / $reportesProgramas->count(), 1, ['multiply' => true])?></div>
			</div>
		</div>
	</div>
</div>

<div class="w3-galaxy-blue w3-padding report-subtitle">
	<h4><i class="fa-solid fa-tower-cell"></i> Informe de enlaces remotos en el mes</h4>
</div>

<div class="w3-row">
	<?php foreach($crs as $cr) : ?>
	<div class="w3-col s12 m12 l12 w3-padding">
		<span><?= $this->Time->i18nFormat(\DateTime::createFromFormat('U', $cr['fecha']), "dd/MMM/yyyy") ?> - <?= (mb_strlen($cr['cr']) > 75)? mb_substr($cr['cr'], 0, 75).'...' : $cr['cr'] ?></span>
	</div>
	<?php endforeach; ?>
</div>

<div class="w3-galaxy-blue w3-padding report-subtitle">
	<h4><i class="fa-solid fa-chart-line"></i> Reportes individuales de cumplimiento</h4>
</div>

<div class="w3-row-padding">
	<?php foreach($programas as $programa) : ?>
	<div class="w3-col s4 m4 l4 w3-border-bottom">
		<p class="w3-center c"><?= $programa['name'] ?><br/>
			<span style="font-weight:bold"><?= $this->Number->toPercentage($programa['chart']['Cumplimiento'], 1, ['multiply' => true])?></span>
		</p>
	</div>
	<?php endforeach; ?>
</div>

<style>
	.report-title h4 {color:#fff !important;} .report-title h5{color:#fff !important;font-size:24px;} 
	.c{clear:both;} .cr-list{display:inline-grid !important;} .cr-list span {border-bottom:1px solid #ccc !important;padding:0 0 8px;text-transform:uppercase;}
	h5 i, h4 i{margin-right:16px;} .w3-padding-16 p{margin-left:8px;}
	div.report-subtitle {page-break-before:always;}
</style>