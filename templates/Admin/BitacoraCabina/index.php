<div class="content">
	<div class="w3-deep-blue w3-padding">
		<h5><i class="fa-solid fa-list-check"></i> Bitácoras de cabina</h5>
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
	
	<?= $this->Html->link('<i class="fa-solid fa-plus"></i>', ['action' => 'add'], ['class' => 'w3-button w3-circle w3-xxlarge w3-golden w3-hover-dark-golden add', 'escape' => false]) ?>
	
	<div class="w3-center w3-padding-48">
		<div class="w3-bar w3-border">
		<?= $this->Paginator->first('<i class="fa-solid fa-angles-left"></i>', ['escape' => false]) ?>
		<?= $this->Paginator->prev('<i class="fa-solid fa-angle-left"></i>', ['escape' => false]) ?>
		<?= $this->Paginator->numbers() ?>
		<?= $this->Paginator->next('<i class="fa-solid fa-angle-right"></i>', ['escape' => false]) ?>
		<?= $this->Paginator->last('<i class="fa-solid fa-angles-right"></i>', ['escape' => false]) ?>
		</div>
	</div>
</div>
