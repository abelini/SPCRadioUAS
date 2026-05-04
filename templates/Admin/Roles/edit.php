<div class="page-header">
    <h5><i class="fa-solid fa-table-list"></i> Modificar rol de cabina #<?= $role->id ?></h5>
</div>

<div class="form-container">
    <?= $this->Form->create($role) ?>

    <div class="form-group">
        <?= $this->Form->label('fecha_inicio', 'Fecha inicial') ?>
        <?= $this->Form->control('fecha_inicio', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('fecha_fin', 'Fecha final') ?>
        <?= $this->Form->control('fecha_fin', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('turno_id', 'Tipo de horario') ?>
        <?= $this->Form->control('turno_id', ['options' => $turnos, 'label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>