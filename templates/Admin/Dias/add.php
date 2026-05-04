<div class="page-header">
    <h5><i class="fa-solid fa-calendar-day"></i> Crear un día</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($dia) ?>

    <div class="form-group">
        <?= $this->Form->label('name', 'Nombre') ?>
        <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('horarios._ids', 'Horarios') ?>
        <?= $this->Form->control('horarios._ids', ['options' => $horarios, 'label' => false, 'class' => 'form-control', 'size' => count($horarios)]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('programas._ids', 'Programas') ?>
        <?= $this->Form->control('programas._ids', ['options' => $programas, 'label' => false, 'class' => 'form-control', 'size' => count($programas)]) ?>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>
