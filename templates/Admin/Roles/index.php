<div class="content">
	<div class="w3-deep-blue w3-padding">
		<h5><i class="fa-solid fa-table-list"></i> Roles de cabina</h5>
	</div>

	<table class="w3-table">
		<thead>
			<tr>
				<th>Semana</th>
				<th class="w">Inicia</th>
				<th class="a"></th>
				<th class="w">Termina</th>
				<th>Configuración de horario</th>
				<th class="actions"></th>
		    </tr>
	    </thead>
	    <?php foreach ($roles as $rol): ?>
	    <tr>
			<td>#<?= $rol->ID ?></td>
			<td><?= $rol->fechaInicio->nice() ?></td>
			<td><i class="fa-solid fa-arrow-right-long"></i></td>
			<td><?= $rol->fechaFin->nice() ?></td>
			<td><?= $this->Html->link($rol->turno->name, ['controller' => 'Turnos', 'action' => 'view', $rol->turno->ID]) ?></td>
			<td class="actions">
				<?= $this->Html->link('<i class="fa-solid fa-arrow-up-right-from-square"></i>', ['action' => 'view', $rol->ID], ['escape' => false]) ?>
				<?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $rol->ID], ['escape' => false]) ?>
				<?= $this->Form->postLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $rol->ID, 'method' => 'DELETE'], ['confirm' => __('Are you sure you want to delete # {0}?', $rol->ID), 'escape' => false]) ?>
			</td>
	    </tr>
	    <?php endforeach; ?>
	</table>

	<div class="w3-center w3-padding-48">
		<div class="w3-bar w3-border">
		<?= $this->Paginator->first('<i class="fa-solid fa-angles-left"></i>', ['escape' => false]) ?>
		<?= $this->Paginator->prev('<i class="fa-solid fa-angle-left"></i>', ['escape' => false]) ?>
		<?= $this->Paginator->numbers() ?>
		<?= $this->Paginator->next('<i class="fa-solid fa-angle-right"></i>', ['escape' => false]) ?>
		<?= $this->Paginator->last('<i class="fa-solid fa-angles-right"></i>', ['escape' => false]) ?>
		</div>
	</div>
	<p class="w3-text-gray"><?= $this->Paginator->counter('Página {{page}} de {{pages}}. Mostrando {{current}} resultados de un total de {{count}}') ?></p>

</div>

<?= $this->Html->link('<i class="fa-solid fa-plus"></i>', ['action' => 'add'], ['class' => 'w3-button w3-circle w3-xxlarge w3-golden w3-hover-dark-golden add', 'escape' => false]) ?>

<style>
	.w{width:160px;} .a{width:40px;}
</style>