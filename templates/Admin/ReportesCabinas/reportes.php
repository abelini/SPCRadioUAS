<div class="content-card">
	<div class="page-header">
		<h5><i class="fa-solid fa-chart-pie"></i> Reportes</h5>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="content-card" style="border-left: 4px solid var(--color-polar-blue);">
				<h6>Por programa</h6>
				
				<?= $this->Form->create(null, ['type' => 'GET', 'class' => 'w3-section']) ?>
				
				<div class="form-group">
					<?= $this->Form->label('p', 'Programa') ?>
					<?= $this->Form->select('p', $programas, ['id' => 'p1P', 'class' => 'form-control'])?>
				</div>
				
				<div class="form-group">
					<?= $this->Form->label('m', 'Mes') ?>
					<?= $this->Form->select('m', $meses, ['id' => 'm1P', 'class' => 'form-control'])?>
				</div>

				<?= $this->Form->hidden('type', ['value' => '1PM']) ?>
				<?= $this->Form->button('Generar', ['id' => 'Sbt1PM', 'class' => 'btn'])?>

				<div class="form-group mt-3">
					<?= $this->Form->label('y', 'Período') ?>
					<?= $this->Form->select('y', $periodos, ['id' => 'y1P', 'class' => 'form-control'])?>
				</div>

				<?= $this->Form->hidden('type', ['value' => '1PP']) ?>
				<?= $this->Form->button('Por período', ['id' => 'Sbt1PP', 'class' => 'btn'])?>
				<?= $this->Form->end() ?>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="content-card" style="border-left: 4px solid var(--color-polar-blue);">
				<h6>Por mes</h6>
				
				<?= $this->Form->create(null, ['type' => 'GET', 'class' => 'w3-section']) ?>
				
				<div class="form-group">
					<?= $this->Form->label('m', 'Mes') ?>
					<?= $this->Form->select('m', $meses, ['id' => 'm1M', 'class' => 'form-control'])?>
				</div>

				<?= $this->Form->hidden('type', ['value' => '1M']) ?>
				<?= $this->Form->button('Generar', ['id' => 'Sbt1M', 'class' => 'btn'])?>
				<?= $this->Form->end() ?>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="content-card" style="border-left: 4px solid var(--color-polar-blue);">
				<h6>Por cuatrimestre</h6>
				
				<?= $this->Form->create(null, ['type' => 'GET', 'class' => 'w3-section']) ?>
				
				<div class="form-group">
					<?= $this->Form->label('m', 'Cuatrimestre') ?>
					<?= $this->Form->select('m', $cuatrimestres, ['id' => 'm4M', 'class' => 'form-control'])?>
				</div>

				<?= $this->Form->hidden('type', ['value' => '4M']) ?>
				<?= $this->Form->button('Generar', ['id' => 'Sbt4M', 'class' => 'btn'])?>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div id="result"></div>
	</div>
</div>

<?= $this->Html->script('https://www.gstatic.com/charts/loader.js')?>

<script type="text/javascript">
	$(document).ready(function() {
		$("#Sbt1PM").on("click", function() {
			sendRequest({p: $("#p1P").val(), m: $("#m1P").val(), t: "1PM"});
			return false;
		});
	});
	$(document).ready(function() {
		$("#Sbt1PP").on("click", function() {
			sendRequest({p: $("#p1P").val(), y: $("#y1P").val(), t: "1PP"});
			return false;
		});
	});
	$(document).ready(function() {
		$("#Sbt1M").on("click", function() {
			sendRequest({m: $("#m1M").val(), t: "1M"});
			return false;
		});
	});
	$(document).ready(function() {
		$("#Sbt4M").on("click", function() {
			sendRequest({m: $("#m4M").val(), t: "4M"});
			return false;
		});
	});
	function sendRequest(data) {
		$.ajax({
			method: "GET",
			url: "<?= $this->Url->build(['action' => 'getReportBy'])?>",
			data: data
		})
		.done(function(response) {
			$("#result").html(response);
		});
	}
</script>

<style>
	h6 {
		color: #fff;
	}

	.mt-3 {
		margin-top: var(--spacing-16);
	}
</style>