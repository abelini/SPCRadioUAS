<div class="page-header">
    <h5><i class="fa-solid fa-table-list"></i> Crear un rol de cabina</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($rol) ?>

    <div class="row g-3">
        <div class="col-md-4">
            <?= $this->Form->label('fechaInicio', 'Fecha inicial') ?>
            <?= $this->Form->control('fechaInicio', ['label' => false, 'class' => 'form-control']) ?>
        </div>

        <div class="col-md-4">
            <?= $this->Form->label('fechaFin', 'Fecha final') ?>
            <?= $this->Form->control('fechaFin', ['label' => false, 'class' => 'form-control', 'readonly' => true]) ?>
        </div>

        <div class="col-md-4">
            <?= $this->Form->label('turnoID', 'Tipo de horario') ?>
            <?= $this->Form->control('turnoID', ['options' => $turnos, 'label' => false, 'class' => 'form-control']) ?>
        </div>
    </div>

    <div id="schedule" style="margin-top: 32px;"></div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<script type="module">
    const csrfToken = <?= json_encode($this->request->getAttribute('csrfToken')) ?>;
    const generateUrl = "<?= $this->Url->build(['controller' => 'asignaciones', 'action' => 'generate']) ?>";

    document.getElementById('fechainicio').addEventListener('change', generateGrid);
    document.getElementById('turnoid').addEventListener('change', () => {
        if (document.getElementById('fechainicio').value && document.getElementById('fechafin').value) {
            generateGrid();
        }
    });

    async function generateGrid() {
        const selectedDate = document.getElementById('fechainicio').value;
        const start = Date.parse(selectedDate).is().monday()
            ? Date.parse(selectedDate)
            : Date.parse(selectedDate).last().monday();

        document.getElementById('fechainicio').value = start.toString("yyyy-MM-dd");
        document.getElementById('fechafin').value = Date.parse(selectedDate).next().sunday().toString("yyyy-MM-dd");

        const formData = new FormData();
        formData.append('starts', start.toISOString());
        formData.append('turno', document.getElementById('turnoid').value);

        const response = await fetch(generateUrl, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-Token': csrfToken }
        });

        document.getElementById('schedule').innerHTML = await response.text();
    }
</script>

<?= $this->Html->script('datejs', ['block' => true]) ?>