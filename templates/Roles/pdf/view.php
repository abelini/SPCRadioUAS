<div class="asignaciones w3-responsive">
	<div class="w3-galaxy-blue w3-padding w3-center">
		<h1 class=" w3-text-white">Semana del <?= $rol->fechaInicio->i18nFormat("EEEE d 'de' MMMM")?> al <?= $rol->fechaFin->i18nFormat("EEEE d 'de' MMMM 'de' YYYY")?></h1>
	</div>
	
	<?php foreach($asignaciones as $dia => $asignaciones) : ?>
		<div class="w3-row w3-white w3-border-left">
			<div class="w3-col l20 w3-border-top w3-white day">
				<div class="w3-center w3-text-blue-gray w3-padding-16">
					<?= $rol->fechaInicio->addDays($dia - 1)->i18nFormat("EEEE")?> <?= $rol->fechaInicio->addDays($dia - 1)->day ?>
				</div>
			</div>
			<div class="w3-col l80 grid">
				<table class="w3-table w3-table-all by-time">
					<?php foreach($asignaciones as $asignacion) : ?>
					<tr>
						<td><i class="fa-solid fa-user"></i> <?= $asignacion->locutor->name ?></td>
						<td><?= $asignacion->horario->horaInicio ?></td>
						<td>&#10230;</td>
						<td><?= $asignacion->horario->horaFin ?></td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	<?php endforeach;?>
	<div class="uas-dorado w3-padding w3-center">
		Dirección de Radio Universidad Autónoma de Sinaloa &copy; <?= $rol->fechaInicio->year ?>
	</div>
</div>
<style>
	.by-time{margin:0;} .grid{padding:0 !important;} .day{letter-spacing:2px;font-size:18px;text-transform:uppercase;width:180px;}
	.rol-info{width:800px;} .l80{width:79.99%} .l20{width:19.99%}
	.uas-dorado {background:#c49e0d;color:#fff;}
</style>