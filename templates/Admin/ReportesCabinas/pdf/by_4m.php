<?php
$totalRegistros = $reportesProgramas->count();
$diasPeriodo = $reportStart->diffInDays($reportEnd) + 1;
$enlacesRemotos = $reportesCR->sumOf('controles');
$mediaEnlaces = $enlacesRemotos > 0 ? round($enlacesRemotos / $diasPeriodo, 2) : 0;
$cumplimiento = $totalRegistros > 0 ? (($totalRegistros - count($RPByStatus['X'])) / $totalRegistros) * 100 : 0;
?>
<div style="background-color: var(--color-galaxy-blue); padding: var(--spacing-16);" class="report-title">
	<h4 style="text-align: left; color: white;"> Reporte general del período de <?= $reportStart->i18nFormat("d 'de' MMMM yyyy") ?> a <?= $reportEnd->i18nFormat("d 'de' MMMM yyyy") ?></h4>
</div>

<div style="display: flex; flex-wrap: wrap; margin: 0 -12px;">
	<div style="flex: 0 0 100%; max-width: 100%; padding: var(--spacing-16);">
		<p>Hay <strong><?= $totalRegistros ?> registros</strong> distribuídos en <strong><?= $programsCount ?> programas</strong> en las bitácoras del mes.</p>
		
		<p>Se enlazó por control remoto <strong><?= $enlacesRemotos ?> ocasiones</strong> en los <?= $diasPeriodo ?> días que abarca el cuatrimestre. Esto representa una media de <strong><?= $mediaEnlaces ?></strong> enlaces por día.</p>
		
		<p>El cumplimiento general en el mes es de: <strong><?= $this->Number->toPercentage($cumplimiento / 100, 1, ['multiply' => true]) ?></strong>.</p>

		<p><strong><?= count($RPByStatus['X'])?> (<?= $XtoWord ?>)</strong> faltas registradas.</p>
	</div>
	
	<div style="flex: 0 0 100%; max-width: 100%;">
		<?php foreach($RPByStatus as $status => $r) : ?>
		<?php $pct = $totalRegistros > 0 ? count($r) / $totalRegistros * 100 : 0; ?>
		<div style="display: flex; flex-wrap: wrap; margin: 0 -12px;">
			<div style="flex: 0 0 25%; max-width: 25%; padding: 24px 0 12px;"><?= $statusLongText[$status] ?> (<?= count($r)?>)</div>
			<div style="flex: 0 0 75%; max-width: 75%; background-color: var(--color-faded-silver);">
				<div style="background-color: var(--color-<?= next($printBarColors)?>); padding: var(--spacing-16); color: white; width:<?= $pct ?>%;"><?= round($pct, 2) ?>%</div>
			</div>
		</div>
		<?php endforeach; ?>
		<div style="display: flex; flex-wrap: wrap; margin: 0 -12px;">
			<div style="flex: 0 0 25%; max-width: 25%; padding: 24px 0 12px;"><strong>Cumplimiento general (Programas en vivo, grabados y justificadamente suspendidos)</strong></div>
			<div style="flex: 0 0 75%; max-width: 75%; background-color: var(--color-faded-silver);">
				<div style="background-color: var(--color-green); padding: var(--spacing-16); text-align: center; width:<?= $cumplimiento ?>%;"><?= $this->Number->toPercentage($cumplimiento / 100, 1, ['multiply' => true]) ?></div>
			</div>
		</div>
	</div>
</div>

<div style="background-color: var(--color-galaxy-blue); padding: var(--spacing-16);" class="report-subtitle">
	<h5 style="text-align: left; color: white;"> Informe de los <?= $enlacesRemotos ?> enlaces remotos del período</h5>
</div>

<ul class="cr-list">
	<?php foreach($crs as $cr) : ?>
		<li title="<?= $this->Time->i18nFormat(\DateTime::createFromFormat('U', $cr['fecha']), "d 'de' MMMM yyyy") ?>">
			<span class="cr-name"><?= $cr['cr'] ?></span>
			<span class="cr-date"><?= $this->Time->i18nFormat(\DateTime::createFromFormat('U', $cr['fecha']), 'd MMM yyy') ?></span>
		</li>
	<?php endforeach; ?>
</ul>

<div style="background-color: var(--color-galaxy-blue); padding: var(--spacing-16);" class="report-subtitle">
	<h5 style="text-align: left; color: white;"> Reportes individuales de cumplimiento de programas</h5>
</div>

<div style="display: flex; flex-wrap: wrap; margin: 0 -12px;">
	<?php foreach($programas as $programa) : ?>
	<div style="flex: 0 0 25%; max-width: 25%; border-bottom: 1px solid var(--color-subtle-gray);">
		<p style="text-align: center;" class="c"><?= $programa['name'] ?><br/>
			<span style="font-weight:bold"><?= $this->Number->toPercentage($programa['chart']['Cumplimiento'], 1, ['multiply' => true])?></span>
		</p>
	</div>
	<?php endforeach; ?>
</div>

<style>
	.report-title h4 {color:#fff !important;} .report-title h5{color:#fff !important;font-size:18pt;} 
	.c{clear:both;}
	.report-subtitle {page-break-before:always;}
</style>