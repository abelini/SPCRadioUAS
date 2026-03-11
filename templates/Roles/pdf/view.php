<div class="asignaciones w3-responsive">
	<div style="background-color:#1a2b4c !important;padding:8px 0 !important;text-align:center;">
		<h1 style="color:#0094CD !important;font-size:24px;font-family:'Montserrat';">ROL DE CABINA</h1>
	</div>
	<div style="text-align:center;text-transform:uppercase;background-color:#0094CD !important;padding:1px;">
		<h2 style="font-size:20px;color:#fff;font-family:'Montserrat';">
			<?= $rol->fechaInicio->i18nFormat("EEEE d 'de' MMMM") ?> a
			<?= $rol->fechaFin->i18nFormat("EEEE d 'de' MMMM 'de' YYYY") ?>
		</h2>
	</div>

	<?php foreach ($asignaciones as $dateKey => $asignaciones): ?>
		<?php $dateObj = new \Cake\I18n\Date($dateKey); ?>
		<div class="w3-row w3-white w3-border-left">
			<div class="w3-col l20 w3-border-top w3-white day">
				<div class="w3-center w3-text-blue-gray w3-padding-16">
					<?= $dateObj->i18nFormat("EEEE") ?>
					<?= $dateObj->day ?>
				</div>
			</div>
			<div class="w3-col l80 grid">
				<table class="w3-table w3-table-all by-time">
					<?php foreach ($asignaciones as $asignacion): ?>
						<tr>
							<td><i class="fa-solid fa-user"></i>
								<?= $asignacion->locutor->name ?>
							</td>
							<td>
								<?= $asignacion->horario->horaInicio ?>
							</td>
							<td>&#10230;</td>
							<td>
								<?= $asignacion->horario->horaFin ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	<?php endforeach; ?>
	<div class="w3-padding w3-center"
		style="background:#c49e0d;color:#fff;font-family:'Montserrat';text-transform:uppercase;">
		Dirección de Radio Universidad Autónoma de Sinaloa &copy;
		<?= $rol->fechaInicio->year ?>
	</div>
</div>
<style>
	.by-time {
		margin: 0;
	}

	.grid {
		padding: 0 !important;
	}

	.day {
		letter-spacing: 2px;
		font-size: 18px;
		text-transform: uppercase;
		width: 180px;
	}

	.rol-info {
		width: 800px;
	}

	.l80 {
		width: 79.99%
	}

	.l20 {
		width: 19.99%
	}
</style>