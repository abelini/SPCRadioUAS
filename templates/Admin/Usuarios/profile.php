<div class="page-header">
    <h5><i class="fa-solid fa-user-pen"></i> Mi Perfil</h5>
</div>

<div class="form-container">
    <h5 class="mb-4"><i class="fa-solid fa-user"></i> Datos del usuario</h5>

    <?= $this->Form->create($user, ['type' => 'file']) ?>

    <div class="form-group">
        <?= $this->Form->label('empleado', 'Número de empleado') ?>
        <?= $this->Form->control('empleado', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('username', 'Nombre de usuario') ?>
        <?= $this->Form->control('username', ['label' => false, 'class' => 'form-control']) ?>
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

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
    </div>

    <?= $this->Form->end() ?>

    <div style="margin-top: var(--spacing-32);"></div>

    <h5 class="mb-4"><i class="fa-solid fa-lock"></i> Cambiar contraseña</h5>

    <?= $this->Form->create($user, ['url' => ['action' => 'profile'], 'type' => 'file']) ?>

    <div class="form-group">
        <?= $this->Form->label('new_password', 'Nueva contraseña') ?>
        <?= $this->Form->control('new_password', ['label' => false, 'class' => 'form-control', 'type' => 'password', 'placeholder' => 'Nueva contraseña']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('confirm_password', 'Confirmar contraseña') ?>
        <?= $this->Form->control('confirm_password', ['label' => false, 'class' => 'form-control', 'type' => 'password', 'placeholder' => 'Confirmar contraseña']) ?>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Cambiar contraseña', ['escapeTitle' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>