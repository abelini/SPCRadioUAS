<div class="page-header">
    <h5><i class="fa-solid fa-pen-to-square"></i> Modificar el reporte de programa RP#<?= $reportePrograma->ID ?></h5>
</div>

<div class="form-container">
    <?= $this->Form->deleteLink(
        '<i class="fa-regular fa-trash-can"></i> Eliminar reporte',
        ['action' => 'delete', $reportePrograma->ID],
        ['confirm' => '¿Estás seguro de eliminar este reporte?', 'class' => 'btn btn-danger', 'escapeTitle' => false]
    ) ?>
    
    <?= $this->Form->create($reportePrograma) ?>
    
    <div class="form-group">
        <?= $this->Form->label('status', 'Status') ?>
        <?= $this->Form->select('status', $statuses, ['class' => 'form-control']) ?>
    </div>
    
    <div class="form-group">
        <?= $this->Form->label('programa', 'Programa') ?>
        <div style="color: var(--color-ghost-white); padding: var(--spacing-8) 0;"><?= $reportePrograma->programa ?></div>
    </div>
    
    <?= $this->Form->control('ID'); ?>
    
    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>
    
    <?= $this->Form->end() ?>
</div>