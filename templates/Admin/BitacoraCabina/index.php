<div class="content">
	<div class="w3-dark-golden w3-padding">
		<h1>Bitácoras de cabina</h1>
	</div>
	
	<div class="w3-container">
		 <?= $this->Html->link('<i class="fa-solid fa-file-arrow-up"></i> Crear una bitácora faltante', ['action' => 'add'], ['class' => 'w3-button w3-golden w3-hover-dark-golden w3-right w3-section', 'escape' => false]) ?>
	</div>

	<table class="w3-table w3-table-all">
		<tr>
			<th>Bitácora</th>
			<th>Fecha</th>
			<th class="actions">Acciones</th>
		</tr>

		<?php foreach ($bitacoras as $bitacora): ?>
		<tr>
			<td>#<?= $bitacora->ID ?></td>
			<td><?= $this->Html->link($bitacora->fecha->i18nFormat(\IntlDateFormatter::FULL), ['action' => 'view', $bitacora->ID], ['escape' => false]) ?></td>

			<td class="actions">
				<?= $this->Html->link('<i class="fa-solid fa-square-arrow-up-right"></i>', ['action' => 'view', $bitacora->ID], ['escape' => false]) ?>
				<?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $bitacora->ID], ['escape' => false]) ?>
				<?= $this->Form->postLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $bitacora->ID, 'method' => 'DELETE'], ['confirm' => __('Are you sure you want to delete # {0}?', $bitacora->ID), 'escape' => false]) ?>
				| <?= $this->Html->link('<i class="fa-solid fa-arrow-up-right-from-square"></i> Ver en el INFO', ['controller' => 'BitacoraCabina', 'action' => 'display', '?' => ['d' => $bitacora->fecha->format('Y-m-d'), 'enable' => 1], 'prefix' => false], ['escape' => false])?>
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
