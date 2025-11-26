<div class="content">
	<?= $this->Html->link(__('New Tipo Bitacora'), ['action' => 'add'], ['class' => 'button float-right']) ?>
	<h1><?= __('Tipo Bitacora') ?></h1>


	<table class="w3-table-all">
		<tr>
			<th><?= $this->Paginator->sort('ID') ?></th>
			<th>Nombre</th>
			<th>Turnos</th>
			<th class="actions"><?= __('Actions') ?></th>
		</tr>

		<?php foreach ($tipoBitacora as $tipoBitacora): ?>
			<tr>
				<td><?= $this->Number->format($tipoBitacora->ID) ?></td>
				<td><?= $tipoBitacora->name ?></td>
				<td><?= $tipoBitacora->getPrintableTurnos() ?></td>
				<td class="actions">
					<?= $this->Html->link(__('View'), ['action' => 'view', $tipoBitacora->ID]) ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $tipoBitacora->ID]) ?>
					<?= $this->Form->deleteLink(__('Delete'), ['action' => 'delete', $tipoBitacora->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $tipoBitacora->ID)]) ?>
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
		<p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
		</p>
	</div>
</div>