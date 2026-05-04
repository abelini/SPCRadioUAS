<div class="page-header">
    <h5><i class="fa-solid fa-clock"></i> Modificar horario</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($horario) ?>

    <div class="form-group">
        <?= $this->Form->label('horaInicio', 'Hora de inicio') ?>
        <?= $this->Form->control('horaInicio', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('horaFin', 'Hora de finalización') ?>
        <?= $this->Form->control('horaFin', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('turnoID', 'Turno') ?>
        <?= $this->Form->control('turnoID', ['options' => $turnos, 'label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('dias._ids', 'Días') ?>
        <?= $this->Form->control('dias._ids', ['options' => $dias, 'size' => count($dias), 'label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>