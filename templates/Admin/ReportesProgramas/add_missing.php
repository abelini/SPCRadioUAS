<div class="content">
    <div class="form">
		
		
		<div class="w3-dark-golden w3-padding">
			<h1>Agregar el reporte de un programa no incluído en la programación normal</h1>
		</div>
		
		<div class="w3-section">
		
			<?= $this->Form->create($reportesPrograma) ?>
					
					
					<?= $this->Form->label('ReporteCabina', 'Reporte de cabina al que se añadirá el reporte de programa', ['class' => 'w3-label']);?>
					<?= $this->Form->text('ReporteCabina', ['label' => false, 'value' => $rcDesc, 'class' => 'w3-input']);?>
					
					<?= $this->Form->hidden('ReporteCabinaID');?>
				
					<?= $this->Form->label('programaID', 'Programa', ['class' => 'w3-label']);?>
					<?= $this->Form->control('programaID', ['options' => $programas, 'label' => false, 'class' => 'w3-input']);?>
				
					<?= $this->Form->label('status', 'Status del programa', ['class' => 'w3-label']);?>
					<?= $this->Form->control('status', ['options' => $status, 'label' => false, 'empty' => false, 'class' => 'w3-input']);?>
				


				<?= $this->Form->button('Guardar', ['class' => 'w3-section']) ?>
			<?= $this->Form->end() ?>
		</div>
		
    </div>
</div>
