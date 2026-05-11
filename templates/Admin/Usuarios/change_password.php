<div class="page-header">
    <h5><i class="fa-solid fa-key"></i> Cambiar contraseña</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($usuario, ['method' => 'delete']) ?>

    <div class="form-group">
        <?= $this->Form->label('new_password', 'Nueva contraseña') ?>
        <?= $this->Form->control('new_password', ['type' => 'password', 'label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('confirm_password', 'Confirmar contraseña') ?>
        <?= $this->Form->control('confirm_password', ['type' => 'password', 'label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>
