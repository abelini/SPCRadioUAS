<div class="page-header">
    <h5><i class="fa-solid fa-plus"></i> Agregar el reporte de un programa no incluído en la programación normal</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($reportesPrograma) ?>
    
    <div class="form-group">
        <?= $this->Form->label('ReporteCabina', 'Reporte de cabina al que se añadirá el reporte de programa') ?>
        <?= $this->Form->text('ReporteCabina', ['label' => false, 'value' => $rcDesc, 'class' => 'form-control']);?>
        <?= $this->Form->hidden('ReporteCabinaID');?>
    </div>
    
    <div class="form-group">
        <?= $this->Form->label('programaID', 'Programa') ?>
        <?= $this->Form->control('programaID', ['options' => $programas, 'label' => false, 'class' => 'form-control']);?>
    </div>
    
    <div class="form-group">
        <?= $this->Form->label('status', 'Status del programa') ?>
        <?= $this->Form->control('status', ['options' => $status, 'label' => false, 'empty' => false, 'class' => 'form-control']);?>
    </div>
    
    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>
    
    <?= $this->Form->end() ?>
    </div>
