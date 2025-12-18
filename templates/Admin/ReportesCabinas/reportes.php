<div class="content">

	<div class="w3-deep-blue w3-padding">
		<h5><i class="fa-solid fa-chart-pie"></i> Reportes </h5>
	</div>
	<div class="w3-row">

		<div class="w3-col l4">
			<div class="w3-low-blue w3-padding">
				<h6>Por programa</h6>
			</div>
			
			<div class="w3-container form">
				
				<?= $this->Form->select('p', $programas, ['id' => 'p1P', 'class' => 'w3-select'])?>
				
				<?= $this->Form->select('m', $meses, ['id' => 'm1P', 'class' => 'w3-select'])?>
				<?= $this->Form->button('Por mes', ['id' => 'Sbt1PM', 'class' => 'w3-button w3-golden w3-hover-dark-golden w3-section'])?>			

				<?= $this->Form->select('y', $periodos, ['id' => 'y1P', 'class' => 'w3-select'])?>
				<?= $this->Form->button('Por período', ['id' => 'Sbt1PP', 'class' => 'w3-button w3-golden w3-hover-dark-golden w3-section'])?>
			</div>
		</div>
		
		<div class="w3-col l4">
			<div class="w3-low-blue w3-padding w3-border-left w3-border-white">
				<h6>Por mes</h6>
			</div>
			<div class="w3-container form">

				<?= $this->Form->select('m', $meses, ['id' => 'm1M', 'class' => 'w3-select'])?>
				<?= $this->Form->button('Generar', ['id' => 'Sbt1M', 'class' => 'w3-button w3-golden w3-hover-dark-golden w3-section'])?>

			</div>
		</div>
		
		<div class="w3-col l4">
			<div class="w3-low-blue w3-padding w3-border-left w3-border-white">
				<h6>Por cuatrimestre</h6>
			</div>
			<div class="w3-container form">
			
				<?= $this->Form->select('m', $cuatrimestres, ['id' => 'm4M', 'class' => 'w3-select'])?>
				<?= $this->Form->button('Generar', ['id' => 'Sbt4M', 'class' => 'w3-button w3-golden w3-hover-dark-golden w3-section'])?>

			</div>
		</div>
	</div>

	<div class="w3-row w3-section">
		<div id="result"></div>
	</div>
</div>
<?= $this->Html->script('https://www.gstatic.com/charts/loader.js')?>

<script type="text/javascript">
	$(document).ready(function() {
		$("#Sbt1PM").on("click", function() {
			$(".form").removeClass("w3-card");
			$(this).parent().toggleClass("w3-card");
			sendRequest({p:$("#p1P").val(), m:$("#m1P").val(), t:"1PM"});
			return false;
		});
	});
	$(document).ready(function() {
		$("#Sbt1PP").on("click", function() {
			$(".form").removeClass("w3-card");
			$(this).parent().toggleClass("w3-card");
			sendRequest({p:$("#p1P").val(), y:$("#y1P").val(), t:"1PP"});
			return false;
		});
	});
	$(document).ready(function() {
		$("#Sbt1M").on("click", function() {
			$(".form").removeClass("w3-card");
			$(this).parent().toggleClass("w3-card");
			sendRequest({m:$("#m1M").val(), t:"1M"});
			return false;
		});
	});
	$(document).ready(function() {
		$("#Sbt4M").on("click", function() {
			$(".form").removeClass("w3-card");
			$(this).parent().toggleClass("w3-card");
			sendRequest({m:$("#m4M").val(), t:"4M"});
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