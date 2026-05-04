<div style="max-width: 400px; margin: var(--spacing-24) auto; background-color: var(--surface-floating-card-translucent); border: 1px solid var(--color-subtle-gray); border-radius: var(--radius-cards); padding: var(--spacing-24);">
    
    <p style="color: var(--color-faded-silver); margin-bottom: var(--spacing-16);">Proporciona tu nombre de usuario o tu correo.</p>
    
    <?= $this->Flash->render()?>
    
    <?= $this->Form->create() ?>
    
        <div class="form-group">
            <?= $this->Form->control('identifier', ['class' => 'form-control', 'placeholder' => 'Nombre de usuario o Correo electrónico', 'label' => false]) ?>
        </div>
    
        <div style="display: flex; justify-content: center; margin-top: var(--spacing-16);">
            <?= $this->Form->button('<i class="fa-solid fa-paper-plane"></i> Enviar', ['escapeTitle' => false]) ?>
        </div>
    
    <?= $this->Form->end()?>
</div>