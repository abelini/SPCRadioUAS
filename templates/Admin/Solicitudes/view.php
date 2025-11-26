<div class="solicitudes view content">

	<?php if ($solicitud->cancelado): ?>
		<span class="w3-tag w3-xlarge w3-padding w3-red w3-right"><i class="fa-solid fa-box-archive"></i> DOCUMENTO
			CANCELADO</span>
	<?php endif; ?>

	<h3><?= h($solicitud->solicitante) ?></h3>
	<table class="w3-table w3-table-all">
		<tr>
			<th>Solicitud #</th>
			<td><?= $solicitud->ID ?></td>
		</tr>
		<tr>
			<th>UO/UA que solicita</th>
			<td><?= $solicitud->solicitante ?></td>
		</tr>
		<tr>
			<th>Tipo de solicitud</th>
			<td><?= $solicitud->tipoSolicitud->name ?></td>
		</tr>
		<tr>
			<th>Fecha</th>
			<td><?= $solicitud->fecha->i18nFormat(\IntlDateFormatter::LONG) ?></td>
		</tr>
		<tr>
			<th>Estado</th>
			<td><?= $solicitud->status ?></td>
		</tr>
		<tr>
			<th>Primer Asignado</th>
			<td><?= $solicitud->primerAsignado === null ? '' : $solicitud->primerAsignado ?></td>
		</tr>
		<tr>
			<th>Segundo Asignado</th>
			<td><?= $solicitud->segundoAsignado === null ? '' : $solicitud->segundoAsignado ?></td>
		</tr>
		<tr>
			<th>Autorizado por</th>
			<td><?= $solicitud->autorizanteID === null ? '' : $solicitud->autorizante ?></td>
		</tr>
		<tr>
			<th>Productor Tecnico</th>
			<td><?= $solicitud->hasValue('productorTecnico') ? $solicitud->productorTecnico : '' ?> </td>
		</tr>
		<tr>
			<th>Aceptado por la persona asignada</th>
			<td><?= $solicitud->aceptado ? __('Yes') : __('No'); ?></td>
		</tr>
		<tr>
			<th><?= __('Cancelado') ?></th>
			<td><?= $solicitud->cancelado ? __('Yes') : __('No'); ?></td>
		</tr>
	</table>

	<div class="text">
		<strong><?= __('Evento') ?></strong>
		<blockquote>
			<?= $this->Text->autoParagraph(h($solicitud->evento)); ?>
		</blockquote>
	</div>
	<div class="text">
		<strong><?= __('Observaciones') ?></strong>
		<blockquote>
			<?= $this->Text->autoParagraph(h($solicitud->observaciones)); ?>
		</blockquote>
	</div>
	<div class="text">
		<strong><?= __('ReporteGrabacion') ?></strong>
		<blockquote>
			<?= $this->Text->autoParagraph(h($solicitud->reporteGrabacion)); ?>
		</blockquote>
	</div>
	<div class="text">
		<strong><?= __('ReporteProgramacion') ?></strong>
		<blockquote>
			<?= $this->Text->autoParagraph(h($solicitud->reporteProgramacion)); ?>
		</blockquote>
	</div>

	<?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar esta solicitud', ['action' => 'edit', $solicitud->ID], ['class' => 'w3-button w3-green w3-left w3-margin-right', 'escape' => false]) ?>

	<?php if ($solicitud->cancelado): ?>
		<?= $this->Form->postLink('<i class="fa-solid fa-boxes-packing"></i> Restaurar esta solicitud', ['action' => 'edit', $solicitud->ID], ['method' => 'PUT', 'data' => ['cancelado' => false], 'class' => 'w3-button w3-orange w3-left', 'escape' => false]) ?>
	<?php else: ?>
		<?= $this->Form->postLink('<i class="fa-solid fa-box-archive"></i>Cancelar esta solicitud', ['action' => 'edit', $solicitud->ID], ['method' => 'PUT', 'data' => ['cancelado' => true], 'class' => 'w3-button w3-orange w3-left', 'escape' => false]) ?>
	<?php endif; ?>

	<?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar esta solicitud', ['action' => 'delete', $solicitud->ID], ['confirm' => 'Esto eliminará permanentemente esta solicitud', 'class' => 'w3-button w3-red w3-right', 'escape' => false]) ?>

	<div style="clear:both"></div>
</div>