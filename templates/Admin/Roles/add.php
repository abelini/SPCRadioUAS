<div class="page-header">
    <h5><i class="fa-solid fa-table-list"></i> Crear un rol de cabina</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($rol) ?>

    <div class="form-group">
        <?= $this->Form->label('fechaInicio', 'Fecha inicial') ?>
        <?= $this->Form->control('fechaInicio', ['label' => false, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('fechaFin', 'Fecha final') ?>
        <?= $this->Form->control('fechaFin', ['label' => false, 'class' => 'form-control', 'readonly' => true]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('turnoID', 'Tipo de horario') ?>
        <?= $this->Form->control('turnoID', ['options' => $turnos, 'label' => false, 'class' => 'form-control']) ?>
    </div>

    <div id="schedule"></div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
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