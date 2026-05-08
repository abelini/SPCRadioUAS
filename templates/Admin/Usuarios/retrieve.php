<?= $this->Flash->render() ?>

<p style="color: #656d76; margin-bottom: 24px;">Proporciona tu nombre de usuario o tu correo.</p>

<?= $this->Form->create() ?>

<div class="form-group" style="margin-bottom: 20px;">
    <?= $this->Form->text('identifier', ['id' => 'identifier', 'placeholder' => 'Nombre de usuario o correo electrónico', 'required' => true, 'style' => 'width: 100%; padding: 12px;']) ?>
</div>

<?= $this->Form->button('<i class="fa-solid fa-paper-plane"></i> Recuperar Contraseña', ['type' => 'submit', 'escapeTitle' => false, 'style' => 'width: 100%; padding: 14px; font-size: 16px; font-weight: 500; color: #fff; background: #0969da; border: none; border-radius: 6px; cursor: pointer;']) ?>

<?= $this->Form->end() ?>