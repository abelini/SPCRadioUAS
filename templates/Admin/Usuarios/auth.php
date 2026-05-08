<?= $this->Flash->render() ?>

<?= $this->Form->create() ?>

<div class="form-group" style="margin-bottom: 20px;">
    <label for="username" style="display: block; margin-bottom: 8px; font-weight: 500;">Usuario</label>
    <?= $this->Form->text('username', ['id' => 'username', 'placeholder' => 'Ingresa tu usuario', 'required' => true, 'style' => 'width: 100%; padding: 12px;']) ?>
</div>

<div class="form-group" style="margin-bottom: 20px;">
    <label for="password" style="display: block; margin-bottom: 8px; font-weight: 500;">Contraseña</label>
    <?= $this->Form->password('password', ['id' => 'password', 'placeholder' => 'Ingresa tu contraseña', 'required' => true, 'style' => 'width: 100%; padding: 12px;']) ?>
</div>

<div class="form-options" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <label class="checkbox-label" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
        <?= $this->Form->checkbox('remember_me') ?>
        Recordarme
    </label>
    <?php if (isset($retrieveLink)): ?>
        <?= $this->Html->link(
            '<i class="fa-solid fa-circle-question"></i> ¿Olvidaste tu contraseña?',
            ['action' => 'retrieve'],
            ['class' => 'forgot-link', 'escape' => false]
        ) ?>
    <?php endif; ?>
</div>

<?= $this->Form->button('Ingresar', ['type' => 'submit', 'style' => 'width: 100%; padding: 14px; font-size: 16px; font-weight: 500; color: #fff; background: #0969da; border: none; border-radius: 6px; cursor: pointer;']) ?>

<?= $this->Form->end() ?>