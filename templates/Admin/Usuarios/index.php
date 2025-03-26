<div class="content">
	
	
	<?= $this->Html->link('Agregar usuario', ['action' => 'add'], ['class' => 'button float-right']) ?>
	
	
	<?php foreach($permisos as $tipoDeUsuario) : ?>
	
	<div class="w3-dark-golden w3-padding">
		<h1><?= $tipoDeUsuario->icon ?> &nbsp;&nbsp; <?= $tipoDeUsuario->plural ?></h1>
	</div>
	
	<table class="w3-table w3-table-all">
		<?php foreach($tipoDeUsuario->usuarios as $usuario) : ?>
		<tr>
			<td class="d"><?= $usuario->empleado ?></td>
			
			<td class="p">@<?= $usuario->username ?></td>
			<td class="n"><?= $usuario->name ?></td>
			<td class="e"><?= $usuario->email ?></td>
			<td class="actions">
				<?= $this->Html->link(__('View'), ['action' => 'view', $usuario->ID]) ?>
				<?= $this->Html->link(__('Edit'), ['action' => 'edit', $usuario->ID]) ?>
				<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $usuario->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $usuario->ID)]) ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	
	<?php endforeach; ?>
</div>

<style>
.d{width:10%} .p{width:15%} .n{width:20%;} .e{width:20%;}
</style>