<div style="background-color: var(--color-galaxy-blue); padding: var(--spacing-16);" class="report-title">
	<h4 style="text-align: left; color: white;"><i class="fa-solid fa-flag-checkered"></i> Reporte general del período de <?= $reportStart->i18nFormat("d 'de' MMMM yyyy") ?> a <?= $reportEnd->i18nFormat("d 'de' MMMM yyyy") ?></h4>
</div>

<div style="display: flex; flex-wrap: wrap; margin: 0 -12px;">
	<div style="flex: 0 0 100%; max-width: 100%; padding: var(--spacing-16);">
		<p>Hay <strong><?= $reportesProgramas->count()?> registros</strong> distribuídos en <strong><?= $programsCount ?> programas</strong> en las bitácoras del mes.</p>
		
		<p>Se enlazó por control remoto <strong><?= $reportesCR->sumOf('controles')?> ocasiones</strong> en los <?= $reportStart->diffInDays($reportEnd) + 1 ?> días que abarca el cuatrimestre. Esto representa una media de <strong><?= round(($reportStart->diffInDays($reportEnd) + 1) / $reportesCR->sumOf('controles'), 2) ?></strong> enlaces por día.</p>
		
		<p>El cumplimiento general en el mes es de: <strong><?=  $this->Number->toPercentage((count($RPByStatus['V']) + count($RPByStatus['G']) + count($RPByStatus['S'])) / $reportesProgramas->count(), 1, ['multiply' => true])?></strong>.</p>

		<p><strong><?= count($RPByStatus['X'])?> (<?= $XtoWord ?>)</strong> faltas registradas.</p>
	</div>
	
	<div style="flex: 0 0 100%; max-width: 100%;">
		<?php foreach($RPByStatus as $status => $r) : ?>
		<div style="display: flex; flex-wrap: wrap; margin: 0 -12px;">
			<div style="flex: 0 0 25%; max-width: 25%; padding: 24px 0 12px;"><?= $statusLongText[$status] ?> (<?= count($r)?>)</div>
			<div style="flex: 0 0 75%; max-width: 75%; background-color: var(--color-faded-silver);">
				<div style="background-color: var(--color-<?= next($printBarColors)?>; padding: var(--spacing-16); color: white; width:<?= count($r) / $reportesProgramas->count() * 100 ?>%;"><?= round(count($r) / $reportesProgramas->count() * 100, 2) ?>%</div>
			</div>
		</div>
		<?php endforeach; ?>
		<div style="display: flex; flex-wrap: wrap; margin: 0 -12px;">
			<div style="flex: 0 0 25%; max-width: 25%; padding: 24px 0 12px;"><strong>Cumplimiento general (Programas en vivo, grabados y justificadamente suspendidos)</strong></div>
			<div style="flex: 0 0 75%; max-width: 75%; background-color: var(--color-faded-silver);">
				<div style="background-color: var(--color-green); padding: var(--spacing-16); text-align: center; width:<?= ($reportesProgramas->count() - count($RPByStatus['X'])) / $reportesProgramas->count() * 100 ?>%;"><?= $this->Number->toPercentage(($reportesProgramas->count() - count($RPByStatus['X'])) / $reportesProgramas->count(), 1, ['multiply' => true])?></div>
			</div>
		</div>
	</div>
</div>

<div style="background-color: var(--color-galaxy-blue); padding: var(--spacing-16);" class="report-subtitle">
	<h5 style="text-align: left; color: white;"><i class="fa-solid fa-tower-cell"></i> Informe de los <?= $reportesCR->sumOf('controles')?> enlaces remotos del período</h5>
</div>

<div style="display: flex; flex-wrap: wrap; margin: 0 -12px;">
	<?php foreach($crs as $cr) : ?>
	<div style="flex: 0 0 50%; max-width: 50%; padding: var(--spacing-16);" class="cr-list">
		<span><?= $this->Time->i18nFormat(\DateTime::createFromFormat('U', $cr['fecha']), "dd/MMM/yyyy") ?> - <?= (mb_strlen($cr['cr']) > 75)? mb_substr($cr['cr'], 0, 75).'...' : $cr['cr'] ?></span>
	</div>
	<?php endforeach; ?>
</div>

<div style="background-color: var(--color-galaxy-blue); padding: var(--spacing-16);" class="report-subtitle">
	<h5 style="text-align: left; color: white;"><i class="fa-solid fa-chart-line"></i> Reportes individuales de cumplimiento de programas</h5>
</div>

<div style="display: flex; flex-wrap: wrap; margin: 0 -12px;">
	<?php foreach($programas as $programa) : ?>
	<div style="flex: 0 0 33.333333%; max-width: 33.333333%; border-bottom: 1px solid var(--color-subtle-gray);">
		<p style="text-align: center;" class="c"><?= $programa['name'] ?><br/>
			<span style="font-weight:bold"><?= $this->Number->toPercentage($programa['chart']['Cumplimiento'], 1, ['multiply' => true])?></span>
		</p>
	</div>
	<?php endforeach; ?>
</div>

<style>
	.report-title h4 {color:#fff !important;} .report-title h5{color:#fff !important;font-size:24px;} 
	.c{clear:both;} .cr-list{display:inline-grid !important;} .cr-list span {border-bottom:1px solid #ccc !important;padding:0 0 8px;text-transform:uppercase;overflow-x:hidden;}
	h5 i, h4 i{margin-right:16px;} .report-subtitle {page-break-before:always;}
</style>