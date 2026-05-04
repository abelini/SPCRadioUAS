<div class="page-header">
    <h5><i class="fa-solid fa-pen-to-square"></i> Modificar bitácora</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($bitacoraCabina) ?>

    <div class="form-group">
        <?= $this->Form->label('fecha', 'Fecha') ?>
        <?= $this->Form->control('fecha', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>