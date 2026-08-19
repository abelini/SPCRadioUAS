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

$totalRegistros = $reportes->count();
$cumplimiento = $totalRegistros > 0 ? (($totalRegistros - count($ocurrences['X'])) / $totalRegistros) * 100 : 0;
?>
<div class="page-header">
	<h4><?= $programa->name ?></h4>
	<p style="margin:0;color:#fff;font-size:10pt;"><?= $start->i18nFormat("d 'de' MMMM YYYY") ?> a <?= $end->i18nFormat("d 'de' MMMM YYYY") ?></p>
</div>

<div class="row g-3">
	<div class="col-lg-3">
		<p style="color: var(--color-faded-silver);">Hay <?= $totalRegistros ?> registros en las bitácoras del período.</p>

		<p style="color: var(--color-faded-silver);">Este programa tiene un cumplimiento del:
			<strong style="color: var(--color-ghost-white);"><?= $this->Number->toPercentage($cumplimiento / 100, 1, ['multiply' => true]) ?></strong>.
		</p>

		<p style="color: var(--color-faded-silver);"><strong style="color: var(--color-ghost-white);"><?= count($ocurrences['X']) ?>
				(<?= $programa->get('XtoWord') ?>)</strong> faltas registradas.</p>
	</div>

	<div class="col-lg-9">
		<p class="bar-label">Cumplimiento general (V + G + S)</p>
		<div class="bar <?= $barColor($cumplimiento) ?>"><?= number_format($cumplimiento, 1, '.', '') ?>%</div>
	</div>
</div>