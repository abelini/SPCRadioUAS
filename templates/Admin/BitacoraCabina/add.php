<div class="content">

	<div class="w3-deep-blue w3-padding">
		<h5><i class="fa-solid fa-table-list"></i> Agregar una bitácora faltante</h5>
	</div>
	
	<?= $this->Form->create($bitacora) ?>
		
		<p class="w3-section">Selecciona la fecha</p>
			
			<?= $this->Form->control('fecha', ['label' => false])?>

		<?= $this->Form->button('Crear bitácora', ['class' => 'w3-section']) ?>
	<?= $this->Form->end() ?>
</div>
