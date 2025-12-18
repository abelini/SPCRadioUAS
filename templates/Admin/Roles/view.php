<div class="content">
	<div class="w3-deep-blue w3-padding">
		<h5>Rol de cabina #<?= $rol->ID ?></h5>
	</div>

	<table class="w3-table-all">

		<tr>
			<th>Tipo de horario</th>
			<td><?= $this->Html->link($rol->turno->name, ['controller' => 'Turnos', 'action' => 'view', $rol->turno->ID])?></td>
		</tr>
		<tr>
			<th>Empieza el día</th>
			<td><?= $rol->fechaInicio->i18nFormat("EEEE d 'de' MMMM 'de' YYYY") ?></td>
		</tr>
		<tr>
			<th>Termina el día</th>
			<td><?= $rol->fechaFin->i18nFormat("EEEE d 'de' MMMM 'de' YYYY") ?></td>
		</tr>

	</table>

	<div class="asignaciones">
		<div class="w3-low-blue w3-padding">
			<h5>Asignaciones de la semana</h5>
		</div>

	<table class="w3-table-all by-day">

	<?php foreach($asignaciones as $dia => $asignaciones) : ?>
		<tr>
			<td class="w3-display-container day">
				<span class="w3-display-middle dayname"><?= $rol->fechaInicio->addDays($dia - 1)->i18nFormat($this->request->is('mobile')? 'EEEEE' : 'EEEE')?></span>
			</td>
			<td class="grid">
				<table class="w3-table w3-table-all by-time">
					<tr>
						<th class="a w3-hide-small">Asignación</th>
						<th class="l">Operador</th>
						<th class="t">Turno</th>
						<th class="a"></th>
					</tr>
					<?php foreach($asignaciones as $asignacion) : ?>
					<tr>
						<td class="w3-hide-small"><?= $asignacion->ID ?></td>
						<td><i class="fa-solid fa-user w3-hide-small"></i> <?= $asignacion->locutor->name ?></td>
						<td><?= $asignacion->horario->horaInicio ?> <i class="fa-solid fa-arrow-right-long"></i> <?= $asignacion->horario->horaFin ?></td>
						<td>
							<?= $this->Html->link('<i class="fa-solid fa-rotate"></i>', ['controller' => 'asignaciones', 'action' => 'edit', $asignacion->ID], ['escape' => false]) ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</td>
		
		</tr>
	<?php endforeach;?>
	</table>
</div>

<style>
	.by-time{margin:0;} .grid{padding:0 !important;} .day{letter-spacing:2px;font-size:20px;text-transform:uppercase;width:180px;}

	.a{width:10%} .l{width:45%} .t{width:30%} .arr{5%} td i{padding:0 12px;}
	
	@media only screen and (max-width: 600px) {
		.day{width:40px !important;} .a{width:30px;} .l{width:45%} .t{width:45%;}
		td i{padding:0;}
	}
</style>