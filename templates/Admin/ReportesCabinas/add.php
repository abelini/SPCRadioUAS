<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReportesCabina $reportesCabina
 */
?>
<div class="page-header">
    <h5><i class="fa-solid fa-plus"></i> Agregar reporte de cabina</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($reportesCabina) ?>
    <fieldset>
        <legend><?= __('Add Reportes Cabina') ?></legend>
        <?php
            echo $this->Form->control('bitacora_id', ['class' => 'form-control']);
            echo $this->Form->control('locutor_id', ['class' => 'form-control']);
            echo $this->Form->control('hora_inicio', ['class' => 'form-control']);
            echo $this->Form->control('hora_fin', ['class' => 'form-control']);
            echo $this->Form->control('reporte', ['class' => 'form-control']);
            echo $this->Form->control('controles', ['class' => 'form-control']);
        ?>
    </fieldset>
    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>