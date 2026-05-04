<div class="page-header">
    <h5><i class="fa-solid fa-radio"></i> Modificar el programa <strong>«<?= $programa ?>»</strong></h5>
</div>

<div class="form-container">
    <?= $this->Form->create($programa) ?>

    <div class="form-group">
        <?= $this->Form->label('name', 'Nombre del programa') ?>
        <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('horaInicio', 'Hora de inicio') ?>
        <?= $this->Form->control('horaInicio', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('horaFin', 'Hora de finalización') ?>
        <?= $this->Form->control('horaFin', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('categoryID', 'Categoría') ?>
        <?= $this->Form->control('categoryID', ['options' => $categorias, 'label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('produccion', 'Producción') ?>
        <?= $this->Form->control('produccion', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('conduccion', 'Conducción') ?>
        <?= $this->Form->control('conduccion', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('uo', '¿Es una Unidad Académica u Organizacional?') ?>
        <?= $this->Form->control('uo', ['label' => false]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('reportable', '¿Se debe reportar?') ?>
        <?= $this->Form->control('reportable', ['label' => false]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('musical', '¿Es un segmento de música?') ?>
        <?= $this->Form->control('musical', ['label' => false]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('dias', 'Días en que se transmite') ?>
        <?= $this->Form->control('dias._ids', ['options' => $dias, 'size' => count($dias), 'label' => false, 'class' => 'form-control']); ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('outOfAir', '¿Salió del aire?') ?>
        <?= $this->Form->control('outOfAir', ['label' => false]) ?>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escape' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>