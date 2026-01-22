<div class="content">

	<div class="w3-galaxy-blue w3-padding">
		<h1>Crear un nuevo programa</h1>
	</div>

	<div class="w3-container">

		<?= $this->Form->create($programa) ?>

		<?= $this->Form->label('name', 'Nombre del programa') ?>
		<?= $this->Form->control('name', ['label' => false]) ?>

		<?= $this->Form->label('horaInicio', 'Hora de inicio') ?>
		<?= $this->Form->control('horaInicio', ['label' => false]) ?>

		<?= $this->Form->label('horaFin', 'Hora de finalización') ?>
		<?= $this->Form->control('horaFin', ['label' => false]) ?>

		<?= $this->Form->label('produccion', 'Producción') ?>
		<?= $this->Form->control('produccion', ['label' => false]) ?>

		<?= $this->Form->label('conduccion', 'Conducción') ?>
		<?= $this->Form->control('conduccion', ['label' => false]) ?>

		<?= $this->Form->label('uo', '¿Es una Unidad Académica u Organizacional?') ?>
		<?= $this->Form->control('uo', ['label' => false]) ?>

		<?= $this->Form->label('reportable', '¿Se debe reportar?') ?>
		<?= $this->Form->control('reportable', ['label' => false]) ?>

		<?= $this->Form->label('musical', '¿Es un segmento de música?') ?>
		<?= $this->Form->control('musical', ['label' => false]) ?>

		<?= $this->Form->label('dias', 'Días en que se transmite') ?>
		<?= $this->Form->control('dias._ids', ['options' => $dias, 'size' => 7, 'label' => false]); ?>

		<?= $this->Form->label('outOfAir', '¿Salió del aire?') ?>
		<?= $this->Form->control('outOfAir', ['label' => false]) ?>

		<?= $this->Form->button('Guardar') ?>

		<?= $this->Form->end() ?>

	</div>
</div>

<style>
	label,
	button {
		margin-top: 24px;
	}
</style>