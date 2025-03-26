
	<h1>Modificar asignación</h1>


<div class="asignaciones form content">
            <?= $this->Form->create($asignacion) ?>

			<?php
				echo $this->Form->label('locutorID', 'Operador');
				echo $this->Form->control('locutorID', ['options' => $locutores, 'label' => false]);
				
				echo $this->Form->label('diaID', 'Día');
				echo $this->Form->control('diaID', ['options' => $dias, 'label' => false]);
				
				echo $this->Form->label('horarioID', 'Horario');
				echo $this->Form->control('horarioID', ['options' => $horarios, 'label' => false]);
             ?>

            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>




