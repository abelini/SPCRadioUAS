<div class="page-header">
    <h5><i class="fa-solid fa-table-list"></i> Modificar rol de cabina #<?= $role->id ?></h5>
</div>

<div class="form-container">
    <?= $this->Form->create($role) ?>

    <div class="form-group">
        <?= $this->Form->label('fechaInicio', 'Fecha inicial') ?>
        <?= $this->Form->control('fechaInicio', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('fechaFin', 'Fecha final') ?>
        <?= $this->Form->control('fechaFin', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('turnoID', 'Tipo de horario') ?>
        <?= $this->Form->control('turnoID', ['options' => $turnos, 'label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>