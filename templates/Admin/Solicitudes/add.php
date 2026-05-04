<div class="page-header">
    <h5><i class="fa-solid fa-folder-open"></i> Registrar una nueva solicitud</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($solicitud) ?>

    <div class="form-group">
        <?= $this->Form->label('tipoSolicitudID', 'Tipo de solicitud') ?>
        <?= $this->Form->select('tipoSolicitudID', $tipos, ['class' => 'form-control', 'id' => 'TipoSolicitud']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('solicitante', 'UA/UO que solicita') ?>
        <?= $this->Form->text('solicitante', ['class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('evento', 'Descripción del evento a cubrir o grabar') ?>
        <?= $this->Form->textarea('evento', ['class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('observaciones', 'Observaciones adicionales') ?>
        <?= $this->Form->textarea('observaciones', ['class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('fecha', 'Fecha del evento') ?>
        <?= $this->Form->text('fecha', ['id' => 'fecha', 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('primerAsignadoID', 'Persona asignada') ?>
        <?= $this->Form->select('primerAsignadoID', $primerAsignado, ['class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('segundoAsignadoID', 'Segunda persona asignada (en caso de requerirse)') ?>
        <?= $this->Form->select('segundoAsignadoID', $segundoAsignado, ['class' => 'form-control', 'empty' => true]) ?>
    </div>

    <div id="productorContainer">
        <div class="form-group">
            <?= $this->Form->label('productorID', 'Productor técnico') ?>
            <?= $this->Form->select('productorID', $productorTecnico, ['class' => 'form-control', 'id' => 'productorID']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= $this->Form->label('autorizanteID', 'Autoriza') ?>
        <?= $this->Form->select('autorizanteID', $autorizante, ['class' => 'form-control']) ?>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

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
        });
    });
</script>