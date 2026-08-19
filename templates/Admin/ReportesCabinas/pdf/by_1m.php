<?php
$barColor = function (float $pct): string {
	if ($pct >= 90) {
		return 'bar-green';
	}
	if ($pct >= 80) {
		return 'bar-yellow';
	}
	if ($pct >= 70) {
		return 'bar-orange';
	}
	return 'bar-red';
};

$totalRegistros = $reportesProgramas->count();
$enlacesRemotos = $reportesCR->sumOf('controles');
$cumplimiento = $totalRegistros > 0 ? (($totalRegistros - count($RPByStatus['X'])) / $totalRegistros) * 100 : 0;
$mediaEnlaces = $enlacesRemotos > 0 ? round($enlacesRemotos / $reportStart->daysInMonth, 2) : 0;
?>
<div class="page-header">
	<h4>Reporte general de <?= $reportStart->i18nFormat("MMMM 'de' yyyy") ?></h4>
</div>

<h5 style="font-weight:700; margin: var(--spacing-20) 0 var(--spacing-10);">Información general</h5>

<div class="row g-3">
	<div class="col-12">
		<p>Hay <strong><?= $totalRegistros ?> registros</strong> distribuídos en <strong><?= $programsCount ?> programas</strong> en las bitácoras del mes.</p>
		<p>Se enlazó por control remoto <strong><?= $enlacesRemotos ?> ocasiones</strong> en el mes. Esto representa una media de <strong><?= $mediaEnlaces ?></strong> enlaces por día.</p>
		<p>El cumplimiento general en el mes es de: <strong><?= $this->Number->toPercentage($cumplimiento / 100, 1, ['multiply' => true]) ?></strong>.</p>
		<p><strong><?= count($RPByStatus['X'])?> (<?= $XtoWord ?>)</strong> faltas registradas.</p>
	</div>
	
	<div class="col-12">
		<p class="bar-label">Cumplimiento general (V + G + S)</p>
		<div class="bar-track">
			<div class="bar-fill <?= $barColor($cumplimiento) ?>" style="width:<?= $cumplimiento ?>%;"></div>
			<span class="bar-center"><?= number_format($cumplimiento, 1, '.', '') ?>%</span>
		</div>
	</div>
</div>

<h5 style="font-weight:700; margin: var(--spacing-20) 0 var(--spacing-10);">Informe de enlaces remotos en el período</h5>

<ul class="cr-list">
	<?php foreach($crs as $cr) : ?>
		<li title="<?= $this->Time->i18nFormat(\DateTime::createFromFormat('U', $cr['fecha']), "d 'de' MMMM yyy") ?>">
			<span class="cr-name"><?= $cr['cr'] ?></span>
			<span class="cr-date"><?= $this->Time->i18nFormat(\DateTime::createFromFormat('U', $cr['fecha']), 'd MMM yyy') ?></span>
		</li>
	<?php endforeach; ?>
</ul>

<h5 style="font-weight:700; margin: var(--spacing-20) 0 var(--spacing-10);">Reportes individuales de cumplimiento</h5>

<div class="row">
	<?php foreach($programas as $programa) : ?>
		<?php
		$p = $programa['reportes'];
		$pTotal = count($p['V']) + count($p['G']) + count($p['S']) + count($p['X']);
		$pCumplimiento = $pTotal > 0 ? ((count($p['V']) + count($p['G']) + count($p['S'])) / $pTotal) * 100 : 0;
		?>
		<div class="program-card">
			<p style="text-align: center; clear: both; margin: var(--spacing-4) 0;">
				<?= $programa['name'] ?><br/>
				<span style="font-weight: bold;"><?= $this->Number->toPercentage($programa['chart']['Cumplimiento'], 1, ['multiply' => true]) ?></span>
			</p>
			<div class="mini-track">
				<div class="mini-fill <?= $barColor($pCumplimiento) ?>" style="width:<?= $pCumplimiento ?>%;"></div>
				<span class="mini-center"><?= number_format($pCumplimiento, 1, '.', '') ?>%</span>
			</div>
		</div>
	<?php endforeach; ?>
</div>