<div class="row g-3">
	<div class="col-md-4">
		<div class="content-card">
			<h4>Por programa</h4>
		
			<?= $this->Form->create(null, ['type' => 'GET'])?>
		
				<div class="form-group">
					<?= $this->Form->label('p', 'Programa') ?>
					<?= $this->Form->select('p', $programas, ['id' => 'p1P', 'class' => 'form-control mb-2'])?>
				</div>
			
				<div class="form-group">
					<?= $this->Form->label('m', 'Mes') ?>
					<?= $this->Form->select('m', $meses, ['id' => 'm1P', 'class' => 'form-control mb-2'])?>
				</div>
			
				<?= $this->Form->hidden('type', ['value' => '1P'])?>
			
				<?= $this->Form->button('<i class="fa-solid fa-chart-bar"></i> Generar', ['id' => 'Sbt1P', 'class' => 'btn'])?>
			<?= $this->Form->end()?>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="content-card">
			<h4>Por mes</h4>
	
			<?= $this->Form->create(null, ['type' => 'GET'])?>
			
				<?= $this->Form->hidden('type', ['value' => '1M'])?>
			
				<?= $this->Form->submit('Generar', ['class' => 'btn'])?>
			<?= $this->Form->end()?>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="content-card">
			<h4>Por cuatrimestre</h4>
	
			<?= $this->Form->create(null, ['type' => 'GET'])?>
			
				<?= $this->Form->hidden('type', ['value' => '4M'])?>
			
				<?= $this->Form->submit('Generar', ['class' => 'btn'])?>
			<?= $this->Form->end()?>
		</div>
	</div>
</div>

<div class="row">
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
<style>
button{letter-spacing:0;} h6{color:#fff;}
</style>