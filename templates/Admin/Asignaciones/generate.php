	<div class="w3-blue-gray w3-padding-small w3-margin-top">
		<h4 class="w3-text-white w3-center">Semana del <?= $starts->i18nFormat("EEEE d 'de' MMMM")?> al <?= $starts->next(7)->i18nFormat("EEEE d 'de' MMMM 'de' YYYY")?></h4>
	</div>
<?php $x = 0; ?>

<?php foreach($turno as $dia) : ?>
	<div class="w3-light-gray w3-padding-small">
		<p class="w3-text-blue-gray w3-center day"><?= $dia->name ?> <?= $starts->addDays($offset++)->i18nFormat("d 'de' MMMM")?></p>
	</div>
	<div class="w3-row">
		<?php $columnWidth = 100 / count($dia->horarios); ?>
		<?php foreach($dia->horarios as $horario) : ?>
		
			<div class="w3-col w3-light-gray" style="width:<?= $columnWidth ?>%;">
				<p class="w3-blue-gray w3-padding w3-center"><i class="fa-regular fa-clock"></i> <?= $horario->horaInicio ?> - <?= $horario->horaFin?></p>
				
				<?= $this->Form->select('asignaciones.'.$x.'.locutorID', $locutores, ['size' => count($locutores), 'class' => 'w3-select'])?>
				<?= $this->Form->hidden('asignaciones.'.$x.'.rolID')?>
				<?= $this->Form->hidden('asignaciones.'.$x.'.diaID', ['value' => $dia->ID])?>
				<?= $this->Form->hidden('asignaciones.'.$x.'.horarioID', ['value' => $horario->ID])?>
			</div>
			<?php $x++; ?>
		<?php endforeach;?>
	</div>
<?php endforeach; ?>

<style>
	p{margin:0;} h4.day{letter-spacing:1px;}
</style>