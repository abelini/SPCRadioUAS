	<div class="w3-deep-blue w3-padding-small w3-margin-top">
		<h5 class="w3-center">Semana del <?= $starts->i18nFormat("EEEE d 'de' MMMM")?> al <?= $starts->next(7)->i18nFormat("EEEE d 'de' MMMM 'de' YYYY")?></h5>
	</div>
<?php $x = 0; ?>

<?php foreach($turno as $dia) : ?>
	<div class="w3-low-blue w3-padding-small">
		<h6 class="w3-center"><?= $dia->name ?> <?= $starts->addDays($offset++)->i18nFormat("d 'de' MMMM")?></h6>
	</div>
	<div class="w3-row">
		<?php $columnWidth = (100 / count($dia->horarios)); ?>
		<?php foreach($dia->horarios as $horario) : ?>
		
			<div class="w3-col" style="width:<?= $columnWidth ?>%;">
				<div class="w3-galaxy-blue w3-padding-small">
					<h6 class="w3-center w3-text-white"><i class="fa-regular fa-clock"></i> <?= $horario->horaInicio ?> - <?= $horario->horaFin?></h6>
				</div>
				<?= $this->Form->select('asignaciones.'.$x.'.locutorID', $locutores, ['size' => count($locutores), 'class' => 'w3-select'])?>
				<?= $this->Form->hidden('asignaciones.'.$x.'.rolID')?>
				<?= $this->Form->hidden('asignaciones.'.$x.'.diaID', ['value' => $dia->ID])?>
				<?= $this->Form->hidden('asignaciones.'.$x.'.horarioID', ['value' => $horario->ID])?>
			</div>
			<?php $x++; ?>
		<?php endforeach;?>
	</div>
<?php endforeach; ?>