<?= $this->Form->create(null, ['url' => ['controller' => 'Usuarios', 'action' => 'auth', 'prefix' => 'admin']]) ?>

<div class="form-group">
  <label for="username">Usuario</label>
  <?= $this->Form->text('username', ['placeholder' => 'Ingresa tu usuario', 'required' => true]) ?>
</div>

<div class="form-group">
  <label for="password">Contraseña</label>
  <?= $this->Form->password('password', ['placeholder' => 'Ingresa tu contraseña', 'required' => true]) ?>
</div>

<div class="form-options">
  <label>
    <?= $this->Form->checkbox('remember_me') ?>
    Recordarme
  </label>
  <a href="<?= $this->Url->build(['controller' => 'Usuarios', 'action' => 'retrieve', 'prefix' => 'admin']) ?>">¿Olvidaste tu contraseña?</a>
</div>

<?= $this->Form->button('Ingresar', ['type' => 'submit', 'class' => 'form-submit']) ?>

<?= $this->Form->end() ?>