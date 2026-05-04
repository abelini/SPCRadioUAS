<div style="max-width: 400px; margin: var(--spacing-24) auto; background-color: var(--surface-floating-card-translucent); border: 1px solid var(--color-subtle-gray); border-radius: var(--radius-cards); padding: var(--spacing-24);">
    
    <?= $this->Form->create() ?>
    
        <div class="form-group">
            <?= $this->Form->control('username', ['label' => false, 'placeholder' => 'Nombre de usuario', 'class' => 'form-control']) ?>
        </div>
        
        <div class="form-group">
            <?= $this->Form->control('password', ['label' => false, 'placeholder' => 'Contraseña', 'class' => 'form-control']) ?>
        </div>
    
    	<?php if(isset($retrieveLink)) : ?>
    		<p style="text-align: center; margin: var(--spacing-12) 0; color: var(--color-polar-blue);"><?= $this->Html->link('Olvidé la contraseña', ['action' => 'retrieve'], ['style' => 'color: var(--color-polar-blue);']) ?></p>
    	<?php endif; ?>
    
        <div style="display: flex; justify-content: center; margin-top: var(--spacing-16);">
            <?= $this->Form->button('<i class="fa-solid fa-right-to-bracket"></i> Iniciar sesión', ['escapeTitle' => false]) ?>
        </div>
        
    <?= $this->Form->end() ?>
</div>