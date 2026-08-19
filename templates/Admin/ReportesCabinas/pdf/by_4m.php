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
$diasPeriodo = $reportStart->diffInDays($reportEnd) + 1;
$cumplimiento = $totalRegistros > 0 ? (($totalRegistros - count($RPByStatus['X'])) / $totalRegistros) * 100 : 0;
$mediaEnlaces = $enlacesRemotos > 0 ? round($enlacesRemotos / $diasPeriodo, 2) : 0;
$statusBarColors = ['V' => 'bar-green', 'G' => 'bar-orange', 'S' => 'bar-blue', 'X' => 'bar-red'];
?>

<div class="page-header">
	<h4>Reporte cuatrimestral - <?= $reportStart->i18nFormat("d 'de' MMMM yyyy") ?> a <?= $reportEnd->i18nFormat("d 'de' MMMM yyyy") ?></h4>
</div>

<h5 class="section-title">Información general</h5>

<div class="row g-3">
	<div class="col-12">
		<p>Hay <strong><?= $totalRegistros ?> registros</strong> distribuídos en <strong><?= $programsCount ?> programas</strong> en las bitácoras del mes.</p>
		
		<p>Se enlazó por control remoto <strong><?= $enlacesRemotos ?> ocasiones</strong> en los <?= $diasPeriodo ?> días que abarca el cuatrimestre. Esto representa una media de <strong><?= $mediaEnlaces ?></strong> enlaces por día.</p>
		
		<p>El cumplimiento general en el mes es de: <strong><?= $this->Number->toPercentage($cumplimiento / 100, 1, ['multiply' => true]) ?></strong>.</p>

		<p><strong><?= count($RPByStatus['X'])?> (<?= $XtoWord ?>)</strong> faltas registradas.</p>
	</div>
</div>

<h5 class="section-title">Desglose general de cumplimiento</h5>

<div class="row g-3">
	<div class="col-12">
		
		<?php foreach($RPByStatus as $status => $r) : ?>
		<?php $pct = $totalRegistros > 0 ? count($r) / $totalRegistros * 100 : 0; ?>
		<p class="bar-label"><?= $statusLongText[$status] ?> (<?= count($r)?>)</p>
		<div class="bar-track" style="margin-bottom: var(--spacing-12);">
			<div class="bar-fill <?= $statusBarColors[$status] ?>" style="width:<?= $pct ?>%;"></div>
			<span class="bar-center"><?= round($pct, 2) ?>%</span>
		</div>
		<?php endforeach; ?>
		<p class="bar-label">Cumplimiento general (Programas en vivo, grabados y justificadamente suspendidos)</p>
		<div class="bar-track">
			<div class="bar-fill bar-green" style="width:<?= $cumplimiento ?>%;"></div>
			<span class="bar-center"><?= $this->Number->toPercentage($cumplimiento / 100, 1, ['multiply' => true]) ?></span>
		</div>
	</div>
</div>


<h5 class="section-title">Informe de los <?= $enlacesRemotos ?> enlaces remotos del período</h5>


<ul class="cr-list">
	<?php foreach($crs as $cr) : ?>
		<li title="<?= $this->Time->i18nFormat(\DateTime::createFromFormat('U', $cr['fecha']), "d 'de' MMMM yyyy") ?>">
			<span class="cr-name"><?= $cr['cr'] ?></span>
			<span class="cr-date"><?= $this->Time->i18nFormat(\DateTime::createFromFormat('U', $cr['fecha']), 'd MMM yyy') ?></span>
		</li>
	<?php endforeach; ?>
</ul>


<h5 class="section-title">Reportes individuales de cumplimiento de programas</h5>


<div class="row">
	<?php foreach($programas as $programa) : ?>
		<?php
		$p = $programa['reportes'];
		$pTotal = count($p['V']) + count($p['G']) + count($p['S']) + count($p['X']);
		$pCumplimiento = $pTotal > 0 ? ((count($p['V']) + count($p['G']) + count($p['S'])) / $pTotal) * 100 : 0;
		?>
		<div class="program-card">
			<p style="text-align: center; clear: both; margin: var(--spacing-4) 0;">
				<?= $programa['name'] ?>
			</p>
			<div class="mini-track <?= $barColor($pCumplimiento) ?>">
				<span class="mini-center"><?= $this->Number->toPercentage($pCumplimiento / 100, 1, ['multiply' => true]) ?></span>
			</div>
		</div>
	<?php endforeach; ?>
</div>