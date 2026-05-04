<div class="content">
	<div class="page-header">
 		<h5><i class="fa-solid fa-pen-to-square"></i> Modificar el reporte RC#<?= $reporte->ID ?></h5>
 	</div>
	
	<?= $this->Form->deleteLink(
 		'<i class="fa-regular fa-trash-can"></i> Eliminar este reporte',
 		['action' => 'delete', $reporte->ID],
 		['confirm' => '¿Estás seguro de eliminar este reporte?', 'class' => 'btn btn-danger', 'escapeTitle' => false]
 	) ?>
	
	<div class="form-container">
 		<?= $this->Form->create($reporte) ?>
	
        <div class="form-group">
            <?= $this->Form->label('bitacoraID', 'Bitácora') ?>
            <?= $this->Form->select('bitacoraID', $bitacoras, ['class' => 'form-control']) ?>
        </div>
        
        <div class="form-group">
            <?= $this->Form->label('locutorID', 'Locutor') ?>
            <?= $this->Form->select('locutorID', $locutores, ['class' => 'form-control']) ?>
        </div>
	
        <div class="form-group">
            <?= $this->Form->label('reporte', 'Reporte de controles remotos') ?>
            <?= $this->Form->textarea('reporte', ['placeholder' => 'Lista de controles remotos (uno por línea)', 'class' => 'form-control']) ?>
        </div>
	
        <div class="form-group">
            <?= $this->Form->label('controles', 'Controles') ?>
            <?= $this->Form->input('controles', ['class' => 'form-control', 'type' => 'number']) ?>
        </div>
	
 		<?= $this->Form->control('ID'); ?>
	
 		<div class="actions-bar">
            <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
            <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        </div>
 		<?= $this->Form->end() ?>
 	</div>
</div>