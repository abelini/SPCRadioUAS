<div class="page-header">
    <h5><i class="fa-solid fa-calendar-check"></i> Modificar asignación</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($asignacion) ?>

    <div class="form-group">
        <?= $this->Form->label('locutorID', 'Operador') ?>
        <?= $this->Form->control('locutorID', ['options' => $locutores, 'label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('diaID', 'Día') ?>
        <?= $this->Form->control('diaID', ['options' => $dias, 'label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('horarioID', 'Horario') ?>
        <?= $this->Form->control('horarioID', ['options' => $horarios, 'label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

