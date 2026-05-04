<div class="page-header">
	<h5><i class="fa-solid fa-pen-to-square"></i> Modificar bitácora de vigilancia</h5>
</div>

<div class="form-container">
	<?= $this->Flash->render() ?>
	
	<?= $this->Form->create($incidencia) ?>
	
	<div class="form-group">
		<?= $this->Form->label('areaID', 'Persona que reporta') ?>
		<?= $this->Form->select('areaID', $areas, ['label' => false, 'class' => 'form-control']);?>
	</div>

	<div class="form-group">
		<?= $this->Form->label('fecha', 'Fecha del reporte') ?>
		<?= $this->Form->control('fecha', ['label' => false, 'class' => 'form-control']);?>
	</div>

	<div class="form-group">
		<?= $this->Form->label('observaciones', 'Observaciones') ?>
		<?= $this->Form->control('observaciones', ['label' => false, 'class' => 'form-control']);?>
	</div>

	<div class="row g-3">
		<div class="col-md-6">
			<?php
				$labels = $incidencia->detalles->getLabels();
				echo $this->Form->control('reporte.fire', ['label' => $labels['fire']]);
				echo $this->Form->control('reporte.moist', ['label' => $labels['moist']]);
				echo $this->Form->control('reporte.ventilation', ['label' => $labels['ventilation']]);
				echo $this->Form->control('reporte.locks', ['label' => $labels['locks']]);
				echo $this->Form->control('reporte.blackout', ['label' => $labels['blackout']]);
				echo $this->Form->control('reporte.lost_signal', ['label' => $labels['lost_signal']]);
				echo $this->Form->control('reporte.alarm_on', ['label' => $labels['alarm_on']]);
			?>
			<hr>
			<?php
				echo $this->Form->label('reporte.blackout_duration', 'En caso de apagón ¿cuánto tiempo duró aproximadamente? (en minutos)');
				echo $this->Form->control('reporte.blackout_duration', ['label' => false, 'class' => 'form-control']);
			?>
		</div>
		<div class="col-md-6">
			<?php
				echo $this->Form->control('reporte.leds', ['label' => $labels['leds']]);
				echo $this->Form->control('reporte.burning_smell', ['label' => $labels['burning_smell']]);
				echo $this->Form->control('reporte.invaded', ['label' => $labels['invaded']]);
				echo $this->Form->control('reporte.walls_cracked', ['label' => $labels['walls_cracked']]);
				echo $this->Form->control('reporte.antenna_bent', ['label' => $labels['antenna_bent']]);
				echo $this->Form->control('reporte.antenna_lights_off', ['label' => $labels['antenna_lights_off']]);
			?>
			<hr>
			<?php
				echo $this->Form->label('reporte.lost_signal_duration', 'En caso de pérdida de señal ¿cuánto tiempo duró aproximadamente? (en minutos)');
				echo $this->Form->control('reporte.lost_signal_duration', ['label' => false, 'class' => 'form-control']);
			?>
		</div>
	</div>
					
	<div class="actions-bar">
		<?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
		<?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
	</div>
	<?= $this->Form->end() ?>
</div>
