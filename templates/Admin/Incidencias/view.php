<div class="content">
	<div class="w3-deep-blue w3-padding">
		<h5>Incidencias</h5>
	</div>

	

	<table class="w3-table w3-table-all w3-section">
                <tr>
                    <th>Reportado por</th>
                    <td><?= $incidencia->area ?></td>
                </tr>

                <tr>
                    <th><?= __('Fecha') ?></th>
                    <td><?= $incidencia->fecha->i18nFormat("d 'de' MMMM")?></td>
                </tr>
	</table>

	<div class="text">
		<strong>Observaciones</strong>
		<blockquote class="w3-xlarge">
			<i class="fa-solid fa-quote-left w3-xxxlarge"></i>
			<?= $this->Text->autoParagraph(h($incidencia->observaciones)); ?>
		</blockquote>
		
		<?php if($incidencia->hasValue('attachment')) : ?>
		<strong>Evidencia</strong>
		<div class="w3-section">
			<?= $this->Html->image($this->Url->image('Incidencias/' . $incidencia->attachment), ['class' => 'w3-image w3-border w3-padding w3-center'])?>
		</div>
		<?php endif; ?>
	</div>
	
	<div class="related">
		<div class="w3-row">
			<div class="w3-half w3-deep-blue w3-padding">
				<h5>Detalle</h5>
			</div>
			<div class="w3-half w3-low-blue w3-padding">
				<h5>Seguimiento</h5>
			</div>
		</div>
		
		<div class="w3-row">
			<div class="w3-half w3-padding-large">
				<div class="w3- w3-section">
					<table class="w3-table w3-table-all">
						<tr>
							<th>Problema</th>
							<th>¿Se presentó?</th>
						</tr>
						<?php foreach($incidencia->detalles->getLabels() as $label => $desc) : ?>
						<tr>
							<td><?= $desc ?></td>
							<td><?= $incidencia->detalles->get($label) == true? '<i class="fa-solid fa-check"></i>' : '' ?></td>
						</tr>
						<?php endforeach; ?>
						<tr>
							<td>En caso de apagón  ¿cuánto tiempo duró?</td>
							<td><?= $incidencia->detalles->blackout_duration ?> minutos</td>
						</tr>
						<tr>
							<td>En caso de pérdida de señal en el equipo de monitoreo ¿cuánto tiempo duró?</td>
							<td><?= $incidencia->detalles->lost_signal_duration ?> minutos </td>
						</tr>
					</table>
				</div>
				
				<div class="w3- w3-padding-large">
				</div>
			</div>
			<div class="w3-half">
				<?php if(count($incidencia->updates) == 0) { ?>
					<p class="w3-section message error">No se ha dado seguimiento a este reporte</p>
				<?php } else { ?>
					
					<ul class="w3-ul">
						<?php foreach($incidencia->updates as $update) : ?>
							<li class="w3-card">
								<i class="fa-regular fa-square-check w3-xxlarge w3-text-light-gray w3-right"></i>
								<?= $this->Html->image($update->usuario->getProfilePicture(), ['class' => 'w3-image w3-border w3-left author']) ?>
								<p>
									<span class="w3-large author"><?= $update->usuario ?></span> <br>
									<span class="w3-text-gray date"><?= $update->date->i18nFormat(\IntlDateFormatter::LONG) ?></span>
								</p>
								<p><blockquote><?= $update->observacion ?></blockquote></p>
							</li>
						<?php endforeach; ?>
					</ul>
					
					
					
					
				<?php } ?>
				
				<div class="w3-section w3-card w3-light-gray w3-padding-large">
					<?php if(! $incidencia->closed) : ?>
						<h3>Actualizar el seguimiento</h3>
					
						<?= $this->Form->create($comment, ['url' => ['controller' => 'Updates', 'action' => 'add']])?>
							<?= $this->Form->datetime('date', ['value' => $date])?>
							<?= $this->Form->textarea('observacion')?>
							<?= $this->Form->hidden('incidenciaID')?>
							<?= $this->Form->button('Actualizar seguimiento', ['class' => 'w3-section'])?>
						<?= $this->Form->end()?>
					<?php else : ?>
						<h3><i class="fa-regular fa-square-check"></i> Incidencia cerrada</h3>
					<?php endif;?>
				</div>
				
				<?php if(! $incidencia->closed) : ?>
				<?= $this->Form->postButton(
						'<i class="fa-solid fa-check-double"></i> Marcar esta incidencia «Solucionada»',
						['action' => 'close', '?' => ['ID' => $incidencia->ID]],
						['method' => 'PUT', 'class' => 'w3-green w3-border-teal w3-section', 'escapeTitle' => false]
					)?>
				<?php endif; ?>
			</div>
		</div>
	</div>

<style>
img.author {width:80px;padding:4px;margin-right:24px;} span.author{font-weight:bold;} span.date{font-style:italic;}
input, textarea{background-color:#fff;} h3{text-transform:uppercase;text-align:center;}
</style>