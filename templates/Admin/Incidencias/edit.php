<div class="content">

	<div class="w3-galaxy-blue w3-padding w3-center">
		<h1 class=" w3-text-white">Bitácora de vigilancia</h1>
	</div>

	<div class="form ">
		
		<?= $this->Flash->render() ?>
		
		<?= $this->Form->create($incidencia) ?>
			
			<p>
				<?= $this->Form->label('areaID', 'Persona que reporta', ['class' => 'w3-label']);?>
				<?= $this->Form->select('areaID', $areas, ['label' => false, 'class' => 'w3-input']);?>
			</p>

			<p>
				<?= $this->Form->label('fecha', 'Fecha del reporte', ['class' => 'w3-label']);?>
				<?= $this->Form->control('fecha', ['label' => false, 'class' => 'w3-input']);?>
			</p>
			<p>
				<?= $this->Form->label('observaciones', 'Observaciones', ['class' => 'w3-label']);?>
				<?= $this->Form->control('observaciones', ['label' => false, 'class' => 'w3-input']);?>
			</p>
			
			<div class="w3-row-padding w3-section">
				<div class="w3-half">
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
					echo $this->Form->control('reporte.blackout_duration', ['label' => false, 'class' => 'w3-input']);
				?>
				</div>
				<div class="w3-half">
				<?php
					echo $this->Form->control('reporte.leds', ['label' => $labels['leds']]);
					echo $this->Form->control('reporte.burning_smell', ['label' => $labels['burning_smell']]);
					echo $this->Form->control('reporte.invaded', ['label' => $labels['invaded']]);
					echo $this->Form->control('reporte.walls_cracked', ['label' => $labels['walls_cracked']]);
					echo $this->Form->control('reporte.antenna_bent', ['label' => $labels['antenna_bent']]);
					echo $this->Form->control('reporte.antenna_lights_off', ['label' => $labels['antenna_lights_off']]);
					echo $this->Form->control('reporte.antenna_anchor_bent', ['label' => $labels['antenna_anchor_bent']]);
				?>
				<hr>
				<?php
					echo $this->Form->label('reporte.blackout_duration', 'En caso de pérdida de señal ¿cuánto tiempo duró aproximadamente? (en minutos)');
					echo $this->Form->control('reporte.lost_signal_duration', ['label' => false, 'class' => 'w3-input']);
				?>
				</div>
			</div>
						
			<div class="w3-section">
				<?= $this->Form->button('Registrar la bitácora', ['class' => 'w3-button w3-blue']) ?>
			</div>
		<?= $this->Form->end() ?>
	</div>
</div>
