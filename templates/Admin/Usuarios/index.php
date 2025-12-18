<div class="content">

	<div class="w3-container">


	</div>

	<?php foreach ($permisos as $tipoDeUsuario): ?>

		<div class="w3-deep-blue w3-padding">
			<h5><?= $tipoDeUsuario->icon ?> &nbsp;&nbsp; <?= $tipoDeUsuario->plural ?></h5>
		</div>

		<table class="w3-table w3-table-all">
			<?php foreach ($tipoDeUsuario->usuarios as $usuario): ?>
				<tr>
					<td class="d"><?= $usuario->empleado ?></td>

					<td class="p"><?= $this->Html->link('@' . $usuario->username, ['action' => 'view', $usuario->ID]) ?></td>
					<td class="n"><?= $this->Html->link($usuario->fullname, ['action' => 'view', $usuario->ID]) ?></td>
					<td class="e"><?= $usuario->email ?></td>
					<td class="actions">
						<?= $this->Html->link(__('View'), ['action' => 'view', $usuario->ID]) ?>
						<?= $this->Html->link(__('Edit'), ['action' => 'edit', $usuario->ID]) ?>
						<?= $this->Form->deleteLink(__('Delete'), ['action' => 'delete', $usuario->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $usuario->ID)]) ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>

	<?php endforeach; ?>
</div>

<?= $this->Html->link('<i class="fa-solid fa-plus"></i>', ['action' => 'add'], ['class' => 'w3-button w3-circle w3-xxlarge w3-golden w3-hover-dark-golden add', 'escape' => false]) ?>


<style>
	.d {
		width: 10%
	}

	.p {
		width: 15%
	}

	.n {
		width: 20%;
	}

	.e {
		width: 20%;
	}
</style>