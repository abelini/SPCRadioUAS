<div class="content">
	<div class="w3-deep-blue w3-padding">
		<h5><i class="fa-solid fa-radio"></i> Programas</h5>
	</div>

	<table class="w3-table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Categoría</th>
				<th>Horario</th>
				<th>Conducción</th>
				<th>Producción</th>
				<th>Reportable</th>

			</tr>
		</thead>
		<?php foreach ($programas as $programa): ?>
			<tr>
				<td><?= $programa->ID ?></td>
				<td><?= $this->Html->link($programa->name, ['action' => 'edit', $programa->ID]) ?></td>
				<td><?= $programa->hasValue('categoria') ? $programa->categoria->name : 'Sin categoría' ?></td>
				<td><?= $programa->horaInicio ?> <i class="fa-solid fa-arrow-right-long"></i> <?= $programa->horaFin ?></td>
				<td><?= $programa->conduccion ?></td>
				<td><?= $programa->produccion ?></td>

				<td><?= $programa->isReportable() ? 'Sí' : 'No' ?></td>
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
	<p class="w3-text-gray">
		<?= $this->Paginator->counter('Página {{page}} de {{pages}}. Mostrando {{current}} resultados de un total de {{count}}') ?>
	</p>

	<?= $this->Html->link('<i class="fa-solid fa-plus"></i>', ['action' => 'add'], ['class' => 'w3-button w3-circle w3-xxlarge w3-golden w3-hover-dark-golden add', 'escape' => false]) ?>

</div>