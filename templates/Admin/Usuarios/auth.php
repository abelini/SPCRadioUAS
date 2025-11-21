<div class="w3-section">

    <?= $this->Form->create() ?>

        <?= $this->Form->control('username', ['label' => false, 'placeholder' => 'Nombre de usuario', 'class' => 'w3-input w3-section']) ?>
        <?= $this->Form->control('password', ['label' => false, 'placeholder' => 'Contraseña', 'class' => 'w3-input w3-section']) ?>

		<?php if(isset($retrieveLink)) : ?>
			<p class="w3-medium w3-text-red w3-center w3-padding" style="margin:0;"><?= $this->Html->link('Olvidé la contraseña', ['action' => 'retrieve'])?></p>
		<?php endif; ?>

    <?= $this->Form->button('Iniciar sesión', ['class' => 'w3-button w3-galaxy-blue']); ?>
    <?= $this->Form->end() ?>
</div>