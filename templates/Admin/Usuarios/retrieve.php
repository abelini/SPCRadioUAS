<p class="w3-text-gray">Proporciona tu nombre de usuario o tu correo.</p>

<?= $this->Flash->render()?>
		
<?= $this->Form->create() ?>
					
	<?= $this->Form->control('identifier', ['class' => 'w3-input', 'placeholder' => 'Nombre de usuaro o Correo electrónico', 'label' => false]) ?>
				
	<?= $this->Form->button('Enviar', ['class' => 'w3-button w3-green w3-galaxy-blue']); ?>
		
<?= $this->Form->end()?>

<style>
input[type=text]{margin-bottom:16px;}
</style>