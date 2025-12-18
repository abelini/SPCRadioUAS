<div class="w3-row-padding w3-section">

	<div class="w3-col l4">
		<div class="w3-container w3-card">
			<h4>Reporte por programa</h4>
			
			<?= $this->Form->create(null, ['type' => 'GET'])?>
			
				<?= $this->Form->select('p', $programas, ['id' => 'p1P', 'class' => 'w3-select w3-section'])?>
				
				<?= $this->Form->select('m', $meses, ['id' => 'm1P', 'class' => 'w3-select w3-section'])?>
				
				<?= $this->Form->hidden('type', ['value' => '1P'])?>
				
				<?= $this->Form->button('Generar reporte', ['id' => 'Sbt1P', 'class' => 'w3-galaxy-blue w3-section'])?>
			<?= $this->Form->end()?>
		</div>
	</div>
	
	<div class="w3-col l4">
		<div class="w3-container w3-card">
			<h4>Reporte general mensual</h4>
		
			<?= $this->Form->create(null, ['type' => 'GET'])?>
				
				<?= $this->Form->hidden('type', ['value' => '1M'])?>
				
				<?= $this->Form->submit('Generar reporte')?>
			<?= $this->Form->end()?>
		</div>
	</div>
	
	<div class="w3-col l4">
		<div class="w3-container w3-card">
			<h4>Reporte general cuatrimestral</h4>
		
			<?= $this->Form->create(null, ['type' => 'GET'])?>
				
				<?= $this->Form->hidden('type', ['value' => '4M'])?>
				
				<?= $this->Form->submit('Generar reporte')?>
			<?= $this->Form->end()?>
		</div>
	</div>
</div>

<div class="w3-row">
	<div id="result"></div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$("#Sbt1P").on("click", function() {
			sendRequest({p:$("#p1P").val(), m:$("#m1P").val(), t:'1P'});
			return false;
		});
	});
	
	function sendRequest(data) {
		$.ajax({
			method: "GET",
			url:"<?= $this->Url->build(['action' => 'getReportBy'])?>",
			data:data
		})
		.done(function(response) {
			$("#result").html(response);
		});
	}
</script>