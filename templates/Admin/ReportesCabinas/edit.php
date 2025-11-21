<div class="content">
	<div class="w3-deep-blue w3-padding">
		<h5>Modificar el reporte RC#<?= $reporte->ID ?></h5>
	</div>
	<div class="w3-low-blue w3-padding">
		<h5>Reporte de <?= $reporte->horaInicio ?> a <?= $reporte->horaFin ?></h5>
	</div>
	
	<?= $this->Form->postLink(
	    'Eliminar este reporte',
	    ['action' => 'delete', $reporte->ID],
	    ['confirm' => __('Are you sure you want to delete # {0}?', $reporte->ID), 'class' => 'w3-red w3-button w3-right w3-section']
	) ?>
	
	
	
	
	
	<div class="w3-container">
		<?= $this->Form->create($reporte) ?>

		    
			<?= $this->Form->select('bitacoraID', $bitacoras, ['class' => 'w3-select']);?>
			<?= $this->Form->select('locutorID', $locutores, ['class' => 'w3-select']);?>
			
			<?= $this->Form->textarea('reporte', ['placeholder' => 'Lista de controles remotos (uno por linea)', 'class' => 'w3-input']);?>

			<?= $this->Form->input('controles', ['class' => 'w3-input', 'type' => 'number']);?>
		    
		    <?= $this->Form->control('ID');?>
		    
			<?= $this->Form->button('Modificar', ['class' => 'w3-button w3-galaxy-blue']) ?>
		<?= $this->Form->end() ?>
	</div>
</div>
<style>
	input{margin:16px 0;}
</style>