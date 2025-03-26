<div class="content">
	<div class="w3-galaxy-blue w3-padding">
		<h2>Modificar el reporte de programa RP#<?= $reportePrograma->ID ?></h2>
	</div>
	<div class="w3-container w3-section">
		<?= $this->Form->postLink(
			'Eliminar reporte',
			['action' => 'delete', $reportePrograma->ID],
			['method' => 'DELETE', 'confirm' => __('Are you sure you want to delete # {0}?', $reportePrograma->ID), 'class' => 'w3-red w3-button w3-right w3-section']
		) ?>

		<h2><?= $reportePrograma->programa ?></h2>
		
		<?= $this->Form->create($reportePrograma, ['class' => 'w3-padding-64']) ?>
			<?= $this->Form->select('status', $statuses);?>
			<?= $this->Form->control('ID');?>
			<?= $this->Form->button('Cambiar', ['class' => 'w3-section']) ?>
		<?= $this->Form->end() ?>
	</div>
</div>
