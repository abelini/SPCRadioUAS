<div class="content">
	<div class="w3-dark-golden w3-padding">
		<h1>Roles de cabina</h1>
	</div>
	
	<div class="w3-container">
		 <?= $this->Html->link('<i class="fa-solid fa-file-arrow-up"></i> Registrar un rol de semana', ['action' => 'add'], ['class' => 'w3-button w3-golden w3-hover-dark-golden w3-right w3-section', 'escape' => false]) ?>
	</div>
	

	<table class="w3-table-all">
		<tr>
			<th>Semana</th>
			<th class="w">Inicia</th>
			<th class="a"></th>
			<th class="w">Termina</th>
			<th>Horario</th>
			<th class="actions"></th>
	    </tr>
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

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

<style>
	.w{width:160px;} .a{width:40px;}
</style>