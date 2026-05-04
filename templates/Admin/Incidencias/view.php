<div class="page-header">
	<h5><i class="fa-solid fa-triangle-exclamation"></i> Incidencia #<?= $incidencia->ID ?></h5>
</div>

<div class="content-card">
	<table class="view-table">
		<tr>
			<th>Reportado por</th>
			<td><?= $incidencia->area->name ?></td>
		</tr>
		<tr>
			<th>Fecha</th>
			<td><?= $incidencia->fecha->i18nFormat("d 'de' MMMM")?></td>
		</tr>
	</table>
	
	<div class="stats-section">
		<strong style="color: var(--color-ghost-white);">Observaciones</strong>
		<blockquote class="blockquote">
			<i class="fa-solid fa-quote-left" style="font-size: 2rem; color: var(--color-subtle-gray);"></i>
			<?= $this->Text->autoParagraph(h($incidencia->observaciones)); ?>
		</blockquote>
		
		<?php if($incidencia->hasValue('attachment')) : ?>
		<strong style="color: var(--color-ghost-white);">Evidencia</strong>
		<div style="padding: var(--spacing-16);">
			<?= $this->Html->image($this->Url->image('Incidencias/' . $incidencia->attachment), ['style' => 'max-width: 100%; border: 1px solid var(--color-subtle-gray); border-radius: var(--radius-md); padding: var(--spacing-8);'])?>
		</div>
		<?php endif; ?>
	</div>
	
	<div class="stats-section">
		<div class="page-header">
			<h5><i class="fa-solid fa-clipboard-list"></i> Detalle</h5>
		</div>
		
		<table class="data-table">
			<thead>
				<tr>
					<th>Problema</th>
					<th>¿Se presentó?</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($incidencia->detalles->getLabels() as $label => $desc) : ?>
				<tr>
					<td><?= $desc ?></td>
					<td><?= $incidencia->detalles->get($label) == true? '<i class="fa-solid fa-check" style="color: #22c55e;"></i>' : '<i class="fa-solid fa-xmark" style="color: #ef4444;"></i>' ?></td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td>En caso de apagón ¿cuánto tiempo duró?</td>
					<td><?= $incidencia->detalles->blackout_duration ?> minutos</td>
				</tr>
				<tr>
					<td>En caso de pérdida de señal en el equipo de monitoreo ¿cuánto tiempo duró?</td>
					<td><?= $incidencia->detalles->lost_signal_duration ?> minutos </td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div class="stats-section">
		<div class="page-header">
			<h5><i class="fa-solid fa-clock-rotate-left"></i> Seguimiento</h5>
		</div>
		
		<?php if(count($incidencia->updates) == 0) { ?>
			<div class="alert alert-danger">No se ha dado seguimiento a este reporte</div>
		<?php } else { ?>
			
			<ul style="list-style: none; padding: 0;">
				<?php foreach($incidencia->updates as $update) : ?>
					<li style="padding: var(--spacing-12); margin-bottom: var(--spacing-12); background-color: var(--surface-floating-card); border-radius: var(--radius-cards); border-left: 4px solid var(--color-subtle-gray);">
						<div style="display: flex; align-items: center; gap: var(--spacing-12); margin-bottom: var(--spacing-8);">
							<?= $this->Html->image($update->usuario->getProfilePicture(), ['style' => 'width: 48px; height: 48px; border-radius: 50%; border: 2px solid var(--color-subtle-gray);'])?>
							<div>
								<div style="color: var(--color-ghost-white); font-weight: bold; margin: 0;"><?= $update->usuario ?></div>
								<div style="color: var(--color-faded-silver); font-style: italic; font-size: var(--text-caption);"><?= $update->date->i18nFormat(\IntlDateFormatter::LONG) ?></div>
							</div>
						</div>
						<p style="color: var(--color-faded-silver); margin: 0;"><?= $update->observacion ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		
		<?php } ?>
		
		<div class="content-card" style="background-color: var(--surface-code-canvas);">
			<?php if(! $incidencia->closed) : ?>
				<h3 style="text-align: center; text-transform: uppercase; color: var(--color-ghost-white);">Actualizar el seguimiento</h3>
			
				<?= $this->Form->create($comment, ['url' => ['controller' => 'Updates', 'action' => 'add']])?>
					<div class="form-group">
						<?= $this->Form->label('date', 'Fecha') ?>
						<?= $this->Form->datetime('date', ['value' => $date, 'class' => 'form-control'])?>
					</div>
					<div class="form-group">
						<?= $this->Form->label('observacion', 'Observaciones') ?>
						<?= $this->Form->textarea('observacion', ['class' => 'form-control'])?>
					</div>
					<?= $this->Form->hidden('incidenciaID')?>
					<div class="actions-bar">
						<?= $this->Form->button('<i class="fa-solid fa-check"></i> Actualizar', ['escapeTitle' => false]) ?>
					</div>
				<?= $this->Form->end()?>
			<?php else : ?>
				<h3 style="color: var(--color-ghost-white);"><i class="fa-regular fa-square-check"></i> Incidencia cerrada</h3>
			<?php endif;?>
		</div>
		
		<?php if(! $incidencia->closed) : ?>
			<div class="actions-bar">
				<?= $this->Form->postButton(
					'<i class="fa-solid fa-check-double"></i> Marcar esta incidencia «Solucionada»',
					['action' => 'close', '?' => ['ID' => $incidencia->ID]],
					['method' => 'PUT', 'class' => 'btn btn-success', 'escapeTitle' => false]
				)?>
			</div>
		<?php endif; ?>
	</div>
</div>

<div class="actions-bar">
	<?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $incidencia->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
	<?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $incidencia->ID], ['confirm' => '¿Estás seguro de eliminar esta incidencia?', 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
</div>