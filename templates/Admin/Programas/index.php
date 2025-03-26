<div class="content">
	<div class="w3-dark-golden w3-padding">
		<h1>Programas</h1>
	</div>
	
	<div class="w3-container">
		 <?= $this->Html->link('<i class="fa-solid fa-file-arrow-up"></i> Registrar un nuevo programa', ['action' => 'add'], ['class' => 'w3-button w3-golden w3-hover-dark-golden w3-right w3-section', 'escape' => false]) ?>
	</div>
	


	<table class="w3-table-all">
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Horario</th>
			<th>Producción</th>
			<th>UO</th>
			<th>Reportable</th>
			<th class="actions"><?= __('Actions') ?></th>
		</tr>
		<?php foreach ($programas as $programa): ?>
		<tr>
			<td><?= $programa->ID ?></td>
			<td><?= $this->Html->link($programa->name, ['action' => 'view', $programa->ID]) ?></td>
			<td><?= h($programa->horaInicio) ?> <i class="fa-solid fa-arrow-right-long"></i> <?= h($programa->horaFin) ?></td>
			<td><?= h($programa->produccion) ?></td>
			<td><?= $programa->uo ? 'Sí' : '-' ?></td>
			<td><?= $programa->isReportable() ? 'Sí' : 'No' ?></td>
			<td class="actions">
				<?//= $this->Html->link('<i class="fa-solid fa-arrow-up-right-from-square"></i>', ['action' => 'view', $programa->ID], ['escape' => false]) ?>
				<?= $this->Html->link('Modificar <i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $programa->ID], ['escape' => false]) ?>
				<?= $this->Form->postLink('Eliminar <i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $programa->ID, 'method' => 'DELETE'], ['confirm' => __('Are you sure you want to delete # {0}?', $programa->ID), 'escape' => false]) ?>
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
