<div class="content">
	<div class="w3-deep-blue w3-padding">
		<h5><i class="fa-solid fa-table-list"></i> Crear un rol de cabina</h5>
	</div>

	<?= $this->Form->create($rol) ?>

		<div class="w3-row">
			<div class="w3-col w3-s12 l6">
				<?= $this->Form->label('fechaInicio', 'Fecha incial')?>
				<?= $this->Form->control('fechaInicio', ['class' => 'w3-input w3-margin-bottom', 'label' => false])?>
			</div>
			<div class="w3-col w3-s12 l6">
				<?= $this->Form->label('fechaFin', 'Fecha final')?>
				<?= $this->Form->control('fechaFin', ['class' => 'w3-input w3-margin-bottom', 'label' => false, 'readonly' => true])?>
			</div>
		</div>
		
		<?= $this->Form->label('turnoID', 'Tipo de horario')?>
		<?= $this->Form->control('turnoID', ['class' => 'w3-select w3-margin-bottom', 'options' => $turnos, 'label' => false])?>

		<?= $this->Form->button('<i class="fa-solid fa-file-arrow-up"></i> Guardar', ['class' => 'w3-button w3-section w3-golden w3-hover-dark-golden', 'escapeTitle' => false]) ?>

	<div id="schedule"></div>
	
	<?= $this->Form->end()?>
	
	
	
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#fechainicio").on("change", function() {
			generateGrid();
		});
		$("#turnoid").on("change", function() {
			if($("#fechainicio").val() == "" || $("#fechafin").val() == "" ) {
				return;
			} else {
				generateGrid();
			}
		});
	});
	function generateGrid() {
		let selectedDate = $("#fechainicio").val();
		const start = Date.parse(selectedDate).is().monday() ? Date.parse(selectedDate) : Date.parse(selectedDate).last().monday();
		
		$("#fechainicio").val(start.toString("yyyy-MM-dd"));
 		$("#fechafin").val(Date.parse(selectedDate).next().sunday().toString("yyyy-MM-dd"));
		
		$.ajax({
			url:"<?= $this->Url->build(['controller' => 'asignaciones', 'action' => 'generate'])?>",
			method:"POST",
			data: {starts:start.toISOString(), turno:$("#turnoid").val()},
			headers: {"X-CSRF-Token":<?= json_encode($this->request->getAttribute('csrfToken'))?>},
			success: function(response) {
				$("#schedule" ).html(response);
			}
		});
	}
</script>


<?= $this->Html->script('datejs', ['block' => true])?>

<style>
	.roles{width:600px;} label{font-size:16px;padding:12px 0;} 
	#schedule select{height:auto;background:#fff;font-size:16px;padding:4px;}
</style>