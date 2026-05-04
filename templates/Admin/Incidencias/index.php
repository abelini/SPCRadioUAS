<div class="page-header">
	<h5><i class="fa-solid fa-triangle-exclamation"></i> Registro de incidencias</h5>
</div>

<div class="content-card">
	<table class="data-table">
		<thead>
			<tr>
				<th>Folio</th>
				<th>Área</th>
				<th>Observaciones</th>
				<th>Fecha</th>
				<th>Estado</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($incidencias as $incidencia): ?>
				<tr>
					<td><?= $incidencia->ID ?></td>
					<td><?= $this->Html->link($incidencia->area->name, ['controller' => 'Areas', 'action' => 'view', $incidencia->area->ID]) ?>
					</td>
					<td><i class="fa-solid fa-angles-right"></i> <?= $incidencia->observaciones ?></td>
					<td><?= $incidencia->fecha->i18nFormat(\IntlDateFormatter::SHORT) ?></td>
					<td><?= $incidencia->getPrintStatus() ?></td>
					<td>
						<?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['action' => 'view', $incidencia->ID], ['escapeTitle' => false]) ?>
						<?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $incidencia->ID], ['escapeTitle' => false]) ?>
						<?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $incidencia->ID], ['confirm' => '¿Estás seguro?', 'escapeTitle' => false]) ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="pagination-counter">
		<?= $this->Paginator->counter('Página {{page}} de {{pages}}. Mostrando {{current}} resultados de un total de {{count}}') ?>
	</div>

	<div class="pagination">
		<?= $this->Paginator->first('<i class="fa-solid fa-angles-left"></i>', ['escape' => false]) ?>
		<?= $this->Paginator->prev('<i class="fa-solid fa-angle-left"></i>', ['escape' => false]) ?>
		<?= $this->Paginator->numbers() ?>
		<?= $this->Paginator->next('<i class="fa-solid fa-angle-right"></i>', ['escape' => false]) ?>
		<?= $this->Paginator->last('<i class="fa-solid fa-angles-right"></i>', ['escape' => false]) ?>
	</div>
</div>

<?= $this->Html->link('<i class="fa-solid fa-plus"></i> Agregar', ['action' => 'add'], ['class' => 'btn-circle', 'escapeTitle' => false]) ?>