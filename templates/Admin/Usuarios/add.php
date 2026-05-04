<div class="page-header">
    <h5><i class="fa-solid fa-users"></i> Crear un usuario</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($usuario) ?>

    <div class="form-group">
        <?= $this->Form->label('empleado', 'Número de empleado') ?>
        <?= $this->Form->control('empleado', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('username', 'Nombre de usuario') ?>
        <?= $this->Form->control('username', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('password', 'Contraseña') ?>
        <?= $this->Form->control('password', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('name', 'Nombre') ?>
        <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('fullname', 'Nombre completo') ?>
        <?= $this->Form->control('fullname', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('email', 'Correo electrónico') ?>
        <?= $this->Form->control('email', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('base', 'Base') ?>
        <?= $this->Form->control('base', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('permisos._ids', 'Permisos') ?>
        <?= $this->Form->control('permisos._ids', ['options' => $permisos, 'label' => false, 'class' => 'form-control', 'size' => count($permisos)]) ?>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>
