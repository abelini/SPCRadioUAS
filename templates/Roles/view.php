<div class="asignaciones w3-responsive">
	<div class="w3-galaxy-blue w3-padding w3-center">
		<span class="w3-left w3-xxlarge"><?= $rol->previous() != null ? $this->Html->link('<i class="fa-solid fa-circle-chevron-left"></i>', ['?' => ['rol' => $rol->previous()->ID]], ['escape' => false]) : '' ?></span>
		<span class="w3-right w3-xxlarge"><?= $rol->next() != null ? $this->Html->link('<i class="fa-solid fa-circle-chevron-right"></i>', ['?' => ['rol' => $rol->next()->ID]], ['escape' => false]) : '' ?></span>
		<h1 class=" w3-text-white">Semana del <?= $rol->fechaInicio->i18nFormat("EEEE d 'de' MMMM")?> al <?= $rol->fechaFin->i18nFormat("EEEE d 'de' MMMM 'de' YYYY")?></h1>
	</div>
	
	<?php foreach($asignaciones as $dia => $asignaciones) : ?>
		<div class="w3-row w3-white w3-border-left w3-border-bottom ">
			<div class="w3-col s12 m2 l2 w3-border-top w3-white day">
				<div class="w3-center w3-text-blue-gray w3-padding-16">
					<?= $rol->fechaInicio->addDays($dia - 1)->i18nFormat("EEEE")?> <?= $rol->fechaInicio->addDays($dia - 1)->day ?>
				</div>
			</div>
			<div class="w3-col s12 m10 l10 grid">
				<table class="w3-table w3-table-all by-time">
					<?php foreach($asignaciones as $asignacion) : ?>
					<tr>
						<td><i class="fa-solid fa-user"></i> <?= $asignacion->locutor->name ?></td>
						<td><?= $asignacion->horario->horaInicio ?></td>
						<td><i class="fa-solid fa-arrow-right-long"></i></td>
						<td><?= $asignacion->horario->horaFin ?></td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		
		</div>
	<?php endforeach;?>
	
	<div class="w3-section w3-border w3-round w3-white w3-padding-48 w3-center download">
		<?= $this->Html->link('<i class="fa-solid fa-file-arrow-down w3-xxxlarge"></i>', ['?' => ['action' => 'download', 'rol' => $rol->ID, 'format' => 'PDF']], ['escape' => false])?>
		<p style="margin:0">Descargar en PDF</p>
	</div>

</div>

<style>
	.by-time{margin:0;} .grid{padding:0 !important;} .day{letter-spacing:2px;font-size:20px;text-transform:uppercase;width:180px;}
	.rol-info{width:800px;} .download{width:300px;margin:auto;}
	@media only screen and (max-width: 600px) {
			.fa-user {display:none;}
	}
</style>  

<?php $this->assign('title', 'Rol de cabina ['. $rol->fechaInicio->i18nFormat("d 'de' MMMM").' al '.$rol->fechaFin->i18nFormat("d 'de' MMMM 'de' YYYY").']'); ?>