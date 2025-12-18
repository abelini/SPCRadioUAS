<div class="w3-container">

	<div class="w3-galaxy-blue w3-padding w3-center">
		<h1 class=" w3-text-white">Registro de incidencia</h1>
	</div>

	<div class="form content">
		
		<?= $this->Flash->render() ?>
		
		<?= $this->Form->create($incidencia, ['url' => ['controller' => 'incidencias', 'action' => 'add'], 'type' => 'file']) ?>
			
			<p>
				<?= $this->Form->label('areaID', 'Área o departamento que reporta', ['class' => 'w3-label']);?>
				<?= $this->Form->select('areaID', $areas, ['label' => false, 'class' => 'w3-input']);?>
			</p>

			<p>
				<?= $this->Form->label('fecha', 'Fecha del reporte', ['class' => 'w3-label']);?>
				<?= $this->Form->date('fecha', ['label' => false, 'class' => 'w3-input']);?>
			</p>
			<p>
				<?= $this->Form->label('observaciones', 'Observaciones', ['class' => 'w3-label']);?>
				<?= $this->Form->control('observaciones', ['label' => false, 'class' => 'w3-input']);?>
			</p>
			
			<p>
				<?= $this->Form->label('attachment', 'Incluir fotografía (opcional)', ['class' => 'w3-label']);?>
				<?= $this->Form->file('attachment', ['label' => false, 'class' => 'w3-input']);?>
			</p>
			
			<hr class="w3-padding-16 w3-section"/>
			
			<h4 class="w3-center">Detalles</h4>
			
			<div class="w3-row-padding w3-section">
				<div class="w3-half">
				<?php
				
				$labels = $incidencia->detalles->getLabels();

					echo $this->Form->control('detalles.fire', ['label' => $labels['fire']]);
					echo $this->Form->control('detalles.moist', ['label' => $labels['moist']]);
					echo $this->Form->control('detalles.ventilation', ['label' => $labels['ventilation']]);
					echo $this->Form->control('detalles.locks', ['label' => $labels['locks']]);
					echo $this->Form->control('detalles.blackout', ['label' => $labels['blackout']]);
					echo $this->Form->control('detalles.lost_signal', ['label' => $labels['lost_signal']]);
					echo $this->Form->control('detalles.alarm_on', ['label' => $labels['alarm_on']]);
					
				?>
				</div>
				<div class="w3-half">
				<?php
					echo $this->Form->control('detalles.leds', ['label' => $labels['leds']]);
					echo $this->Form->control('detalles.burning_smell', ['label' => $labels['burning_smell']]);
					echo $this->Form->control('detalles.invaded', ['label' => $labels['invaded']]);
					echo $this->Form->control('detalles.walls_cracked', ['label' => $labels['walls_cracked']]);
					echo $this->Form->control('detalles.antenna_bent', ['label' => $labels['antenna_bent']]);
					echo $this->Form->control('detalles.antenna_lights_off', ['label' => $labels['antenna_lights_off']]);
					echo $this->Form->control('detalles.antenna_anchor_bent', ['label' => $labels['antenna_anchor_bent']]);
				?>
				</div>
			</div>
			<hr>
			<div class="w3-row-padding w3-section">
				<div class="w3-half">
					<?= $this->Form->label('detalles.blackout_duration', 'En caso de apagón ¿cuánto tiempo duró aproximadamente? (en minutos)');?>
					<?= $this->Form->control('detalles.blackout_duration', ['label' => false, 'class' => 'w3-input']);?>
				</div>
				<div class="w3-half">
					<?= $this->Form->label('detalles.lost_signal_duration', 'En caso de pérdida de señal ¿cuánto tiempo duró aproximadamente? (en minutos)');?>
					<?= $this->Form->control('detalles.lost_signal_duration', ['label' => false, 'class' => 'w3-input']);?>
				</div>
			</div>
			
			<hr>
			
			<div class="w3-section w3-padding-large">
				<?= $this->Form->button('Enviar registro', ['class' => 'w3-button w3-blue']) ?>
			</div>
		<?= $this->Form->end() ?>
	</div>
</div>

<style>
	button[type=submit]{display:block;margin:auto;}
</style>