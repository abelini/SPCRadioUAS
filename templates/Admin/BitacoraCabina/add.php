<div class="content">
	
	<div class="page-header">
 		<h5><i class="fa-solid fa-table-list"></i> Agregar una bitácora faltante</h5>
 	</div>
	
	<?= $this->Form->create($bitacora) ?>
		
 		<div class="form-group">
            <?= $this->Form->label('fecha', 'Fecha') ?>
 			<?= $this->Form->control('fecha', ['label' => false, 'class' => 'form-control']) ?>
        </div>
	
 		<div class="actions-bar">
            <?= $this->Form->button('<i class="fa-solid fa-check"></i> Crear bitácora', ['escapeTitle' => false]) ?>
        </div>
 	<?= $this->Form->end() ?>
</div>
