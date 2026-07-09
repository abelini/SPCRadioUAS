<div class="page-header">
    <h5><i class="fa-solid fa-radio"></i> Modificar el programa <strong>«<?= $programa ?>»</strong></h5>
</div>

<div class="form-container">
    <?= $this->Form->create($programa) ?>

    <div class="row">
        <div class="col-md-9">
            <div class="form-group">
                <?= $this->Form->label('name', 'Nombre del programa') ?>
                <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control']) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('horaInicio', 'Hora de inicio') ?>
                <?= $this->Form->control('horaInicio', ['label' => false, 'class' => 'form-control']) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('horaFin', 'Hora de finalización') ?>
                <?= $this->Form->control('horaFin', ['label' => false, 'class' => 'form-control']) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('categoryID', 'Categoría') ?>
                <?= $this->Form->control('categoryID', ['options' => $categorias, 'label' => false, 'class' => 'form-control']) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('pty', 'Tipo de programa (PTY)') ?>
                <?= $this->Form->control('pty', ['label' => false, 'class' => 'form-control', 'empty' => '-- Sin asignar --']) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('ptn', 'Etiqueta RDS (PTN, 8 caracteres)') ?>
                <?= $this->Form->control('ptn', ['label' => false, 'class' => 'form-control', 'maxlength' => 8]) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('produccion', 'Producción') ?>
                <?= $this->Form->control('produccion', ['label' => false, 'class' => 'form-control']) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('conduccion', 'Conducción') ?>
                <?= $this->Form->control('conduccion', ['label' => false, 'class' => 'form-control']) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('uo', '¿Es una Unidad Académica u Organizacional?') ?>
                <?= $this->Form->control('uo', ['label' => false]) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('reportable', '¿Se debe reportar?') ?>
                <?= $this->Form->control('reportable', ['label' => false]) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('musical', '¿Es un segmento de música?') ?>
                <?= $this->Form->control('musical', ['label' => false]) ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <?= $this->Form->label('image', 'Nombre del archivo de imagen') ?>
                <?= $this->Form->control('image', ['label' => false, 'class' => 'form-control', 'placeholder' => 'programme-cover-x.jpeg']) ?>
                <?php if ($programa->image): ?>
                    <div style="margin-top:8px;text-align:center">
                        <img src="<?= $programa->image_url ?>" alt="Preview" style="max-width:100%;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.3)">
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('dias', 'Días en que se transmite') ?>
                <?= $this->Form->control('dias._ids', ['options' => $dias, 'size' => count($dias), 'label' => false, 'class' => 'form-control']); ?>
            </div>

            <div class="form-group alert-danger" style="padding:12px">
                <?= $this->Form->label('outOfAir', '¿Salió del aire?', ['style' => 'color:#f85149']) ?>
                <?= $this->Form->control('outOfAir', ['label' => false]) ?>
            </div>
        </div>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escape' => false]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>