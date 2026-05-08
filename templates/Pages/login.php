<div class="landing-form">
<?php
echo $this->Form->create(false, [
  'url' => ['controller' => 'Usuarios', 'action' => 'auth'],
  'class' => 'landing-form'
]);
?>

<div class="form-group">
  <label for="username">Usuario</label>
  <?php
  echo $this->Form->text('username', [
    'id' => 'username',
    'class' => 'form-control',
    'placeholder' => 'Ingresa tu usuario',
    'required' => true,
    'autocomplete' => 'username'
  ]);
  ?>
</div>

<div class="form-group">
  <label for="password">Contraseña</label>
  <?php
  echo $this->Form->password('password', [
    'id' => 'password',
    'class' => 'form-control',
    'placeholder' => 'Ingresa tu contraseña',
    'required' => true,
    'autocomplete' => 'current-password'
  ]);
  ?>
</div>

<div class="landing-remember">
  <label class="landing-remember-label">
    <?php
    echo $this->Form->checkbox('remember_me', [
      'id' => 'remember-me'
    ]);
    ?>
    Recordarme
  </label>
  <a href="#" class="landing-forgot">¿Olvidaste tu contraseña?</a>
</div>

<?php
echo $this->Form->button('Ingresar', [
  'type' => 'submit',
  'class' => 'landing-submit'
]);
echo $this->Form->end();
?>
</div>