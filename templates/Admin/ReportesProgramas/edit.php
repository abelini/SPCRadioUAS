<div class="content">
	<div class="w3-deep-blue w3-padding">
		<h5>Modificar el reporte de programa RP#<?= $reportePrograma->ID ?></h5>
	</div>
	<div class="w3-low-blue w3-padding">
		<h5><?= $reportePrograma->programa ?></h5>
	</div>

	<div class="w3-container w3-section">
		<?= $this->Form->deleteLink(
			'Eliminar reporte',
			['action' => 'delete', $reportePrograma->ID],
			['confirm' => __('Are you sure you want to delete # {0}?', $reportePrograma->ID), 'class' => 'w3-red w3-button w3-right w3-section']
		) ?>


		<?= $this->Form->create($reportePrograma, ['class' => 'w3-padding-64']) ?>
		<?= $this->Form->select('status', $statuses); ?>
		<?= $this->Form->control('ID'); ?>
		<?= $this->Form->button('Cambiar', ['class' => 'w3-section']) ?>
		<?= $this->Form->end() ?>
	</div>
</div>