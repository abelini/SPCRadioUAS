<div class="content">
	<div class="w3-deep-blue w3-padding">
		<h5>Registro de incidencias</h5>
	</div>
	
	<table class="w3-table w3-table-all ">
		<thead>
			<tr>
				<th>Folio</th>
				<th>Área</th>
				<th>Observaciones</th>
				<th>Fecha</th>
				<th>Estado</th>
				<th class="actions"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($incidencias as $incidencia): ?>
			<tr>
				<td><?= $incidencia->ID ?></td>
				<td><?= $this->Html->link($incidencia->area, ['controller' => 'Areas', 'action' => 'view', $incidencia->area->ID], ['escape' => false]) ?></td>
				<td><i class="fa-solid fa-angles-right"></i> <?= $incidencia->observaciones ?></td>
				<td><?= $incidencia->fecha->i18nFormat(\IntlDateFormatter::SHORT) ?></td>
				<td><?= $incidencia->getPrintStatus() ?></td>
				<td class="actions">
					<?= $this->Html->link('<i class="fa-solid fa-square-arrow-up-right"></i>', ['action' => 'view', $incidencia->ID], ['escape' => false]) ?>
					<?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $incidencia->ID], ['escape' => false]) ?>
					<?= $this->Form->postLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $incidencia->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $incidencia->ID), 'escape' => false]) ?>
				</td>
			</tr>
                <?php endforeach; ?>
		</tbody>
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
