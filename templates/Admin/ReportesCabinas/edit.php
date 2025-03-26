
	<?= $this->Form->postLink(
	    'Eliminar este reporte',
	    ['action' => 'delete', $reporte->ID],
	    ['confirm' => __('Are you sure you want to delete # {0}?', $reporte->ID), 'class' => 'w3-red w3-button w3-right w3-section']
	) ?>
	<h3>Modificar el reporte RC#<?= $reporte->ID ?></h3>
	
	<div class="w3-galaxy-blue w3-padding">
		<h4>Reporte de <?= $reporte->horaInicio ?> a <?= $reporte->horaFin ?></h4>
	</div>
	
	
	<div class="w3-container">
		<?= $this->Form->create($reporte) ?>

		    
			<?= $this->Form->select('bitacoraID', $bitacoras, ['class' => 'w3-select']);?>
			<?= $this->Form->select('locutorID', $locutores, ['class' => 'w3-select']);?>
			
			<?= $this->Form->textarea('reporte', ['placeholder' => 'Sin novedad', 'class' => 'w3-input']);?>
			
			<?= $this->Form->input('controles', ['class' => 'w3-input']);?>
		    
		    <?= $this->Form->control('ID');?>
		    
			<?= $this->Form->button('Modificar', ['class' => 'w3-button w3-galaxy-blue']) ?>
		<?= $this->Form->end() ?>
	</div>

<style>
	input{margin:16px 0;}
</style>