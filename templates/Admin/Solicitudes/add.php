<div class="solicitudes form content">
	<h3>Registrar una nueva solicitud</h3>
	
	<?= $this->Form->create($solicitud) ?>
	
		<?= $this->Form->label('tipoSolicitudID', 'Tipo de solicitud')?>
		<?= $this->Form->select('tipoSolicitudID', $tipos, ['class' => 'w3-select', 'id' => 'TipoSolicitud']); ?>
		
		<?= $this->Form->label('solicitante', 'UA/UO que solicita')?>
		<?= $this->Form->text('solicitante', ['class' => 'w3-input'])?>
		
		<?= $this->Form->label('evento', 'Descripción del evento a cubrir o grabar')?>
		<?= $this->Form->textarea('evento', ['class' => 'w3-input'])?>
		
		<?= $this->Form->label('observaciones', 'Observaciones adicionales')?>
		<?= $this->Form->textarea('observaciones', ['class' => 'w3-input'])?>
		
		<?= $this->Form->label('fecha', 'Fecha del evento')?>
		<?= $this->Form->text('fecha', ['id' => 'fecha', 'class' => 'w3-input'])?>
		
		<?= $this->Form->label('primerAsignadoID', 'Persona asignada')?>
		<?= $this->Form->select('primerAsignadoID', $primerAsignado, ['class' => 'w3-select',])?>
		
		<?= $this->Form->label('segundoAsignadoID', 'Segunda persona asignada (en caso de requerirse)')?>
		<?= $this->Form->select('segundoAsignadoID', $segundoAsignado, ['class' => 'w3-select', 'empty' => true])?>
		
		<div id="productorContainer">
			<?= $this->Form->label('productorID', 'Productor técnico')?>
			<?= $this->Form->select('productorID', $productorTecnico, ['class' => 'w3-select', 'empty' => false, 'id' => 'productorID'])?>
		</div>
		
		<?= $this->Form->label('autorizanteID', 'Autoriza')?>
		<?= $this->Form->select('autorizanteID', $autorizante, ['class' => 'w3-select', 'empty' => false]) ?>
		
		<?= $this->Form->button('Guardar la solicitud', ['class' => 'w3-button w3-galaxy-blue w3-section']) ?>
	<?= $this->Form->end() ?>
</div>

<style>
	label{font-size:16px;margin:24px 0 8px;}
</style>

<?= $this->Html->css('jquery.datetimepicker.min.css', ['block' => true])?>
<?= $this->Html->script('jquery.datetimepicker.full.min.js', ['block' => true])?>

<script type="text/javascript">
	jQuery.datetimepicker.setLocale('es');
	jQuery('#fecha').datetimepicker({format:'Y-m-d H:i', lang:'es', minDate:'2013/12/03', step:30,
			value:'',
			i18n:{
				es:{
					months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
					dayOfWeek:['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
				}
			}
		});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#TipoSolicitud").on("change", function() {
			if($(this).val() == 2 || $(this).val() == 3) {
				$("#productorID").val(0).parent().hide();
			}
			//
		});
	});
</script>