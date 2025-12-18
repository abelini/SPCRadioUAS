<?= $this->Flash->render()?>

<div class="w3-">
	<div class="w3-galaxy-blue w3-padding w3-center">
		<span class="w3-left w3-xxlarge"><?= $bitacora->previous() != null ? $this->Html->link('<i class="fa-solid fa-circle-chevron-left"></i>', ['?' => ['d' => $bitacora->previous()->fecha->format('Y-m-d')]], ['escape' => false]) : '' ?></span>
		<span class="w3-right w3-xxlarge"><?= $bitacora->next() != null ? $this->Html->link('<i class="fa-solid fa-circle-chevron-right"></i>', ['?' => ['d' => $bitacora->next()->fecha->format('Y-m-d')]], ['escape' => false]) : '' ?></span>
		<h1><?= $bitacora ?></h1>
		
	</div>
	
	<div class="w3-row w3-low-blue w3-padding">
		<div class="w3-col l2 w3-bold">Operador</div>
		<div class="w3-col l2 w3-bold">Turno</div>
		<div class="w3-col l3 w3-bold">Reporte de programas</div>
		<div class="w3-col l1 w3-bold">Enlaces</div>
		<div class="w3-col l4 w3-bold">Reporte de enlaces remotos</div>
	</div>
	
	<?= $this->Form->create($bitacora, ['url' => ['action' => 'update'], 'type' => 'PUT'])?>

		<?php for($i = 0; $i < count($asignaciones); $i ++) : ?>
			<?php $disableControl = $checkTimeToDisable($asignaciones[$i]->horario, $bitacora->reportes[$i]->ID ?? 0);?>
			
			<div class="w3-row-padding w3-padding <?= $asignaciones[$i]->classForCurrent($bitacora->fecha, 'w3-card-4 active'); ?>">
				<div class="w3-col l2">
					<p class="w3-bold"><?= $asignaciones[$i]->locutor->name ?></p>
					<?= $this->Html->image($asignaciones[$i]->locutor->photo, ['class' => 'w3-image profile'])?>
				</div>
				<div class="w3-col l2">
					<p><?= $asignaciones[$i]->horario ?></p>
					<p class="created-mod">
						<?= isset($bitacora->reportes[$i])? $bitacora->reportes[$i]->created .'<br/>'. $bitacora->reportes[$i]->modified : '' ?><br/>
					</p>
				</div>
				
				<div class="w3-col l3">
					<?php $programCounter = 0; ?>
					<?php foreach($asignaciones[$i]->dia->programas as $id => $programa) : ?>
					<fieldset>
						<legend><?= $programa ?></legend>
						<?= $this->Form->radio('reportes.'.$i.'.reportes_programas.'.$programCounter.'.status', $programStatuses, ['class' => 'w3-radio', 'disabled' => $disableControl])?>
						<?= $this->Form->hidden('reportes.'.$i.'.reportes_programas.'.$programCounter.'.programaID', ['value' => $programa->ID])?>
						<?= $this->Form->hidden('reportes.'.$i.'.reportes_programas.'.$programCounter.'.ID')?>
					</fieldset>
						<?php $programCounter++; ?>
					<?php endforeach; ?>
					<?php $programCounter = 0; ?>
					&nbsp;
				</div>
				
				<div class="w3-col l1">
					<?= $this->Form->control('reportes.'.$i.'.controles', ['label' => false, 'class' => 'w3-input', 'disabled' => $disableControl])?>
					<p class="created-mod">
						RC#<?= isset($bitacora->reportes[$i])? $bitacora->reportes[$i]->ID : '' ?>
					</p>
				</div>
				
				<div class="w3-col l4">
					<?= $this->Form->control('reportes.'.$i.'.reporte', ['label' => false, 'class' => 'w3-input', 'placeholder' => 'Sin novedad', 'disabled' => $disableControl])?>
				</div>
				<?= $this->Form->hidden('reportes.'.$i.'.ID')?>
				<?= $this->Form->hidden('reportes.'.$i.'.bitacoraID', ['value' => $bitacora->ID])?>
				<?= $this->Form->hidden('reportes.'.$i.'.locutorID', ['value' => $asignaciones[$i]->locutorID])?>
				<?= $this->Form->hidden('reportes.'.$i.'.horaInicio', ['value' => $asignaciones[$i]->horario->getTimeAsString('horaInicio')])?>
				<?= $this->Form->hidden('reportes.'.$i.'.horaFin', ['value' => $asignaciones[$i]->horario->getTimeAsString('horaFin')])?>
			</div>
		<?php endfor; ?>
		
		
		<?= $this->Form->hidden('ID')?>
		<?//= $this->Form->hidden('fecha', ['value' => $bitacora->fecha->toIso8601String()])?>
		
		<div class="w3-row w3-padding w3-low-blue w3-center">
			Valores: <span style="font-weight:normal">(V) Programa en vivo, (G) Programa grabado, (S) Programa suspendido por la Dirección, (X) El conductor no se presentó</span>
		</div>
		<div class="w3-padding w3-galaxy-blue w3-center">
			En caso de haber, registrar un enlace remoto por línea. Si no, favor de dejar en blanco el espacio.
		</div>
		
		<div class="w3-center">
			<?= $this->Form->button('<i class="fa-solid fa-paper-plane"></i> ACTUALIZAR', ['type' => 'submit', 'disabled' => $disabledSubmit, 'class' => 'w3-button w3-padding-large w3-section w3-center w3-round w3-galaxy-blue w3-large', 'escapeTitle' => false])?>
		</div>
	<?= $this->Form->end();?>
	
</div>

<style>
.w3-row-padding {  background-color: #fafafa;} .uas-dorado {font-weight:bold;background:#c49e0d;color:#fff;} .uas-amarillo{background:#877514;color:#fff;}
.w3-row-padding.active {  background-color: #eee; margin-bottom:8px;position:relative;z-index:10;}
img.profile{width:40%;display:block;margin:auto;filter:grayscale(95%);border:2px #333 solid;}
.active img.profile{filter:none;width:60%;} fieldset label {padding-right:12px;}
body{background:#fff;} .w3-padding{padding16px !important;} .created-mod{color:#dbdbdb;}
</style>  
	  
<?php $this->assign('title', $bitacora);?>