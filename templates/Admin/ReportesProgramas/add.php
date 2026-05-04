<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReportesPrograma $reportesPrograma
 * @var \Cake\Collection\CollectionInterface|string[] $reportesCabinas
 * @var \Cake\Collection\CollectionInterface|string[] $programas
 */
?>
<div class="page-header">
    <h5><i class="fa-solid fa-plus"></i> Agregar reporte de programa</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($reportesPrograma) ?>
    <fieldset>
        <legend><?= __('Add Reportes Programa') ?></legend>
        <?php
            echo $this->Form->control('ReporteCabinaID', ['options' => $reportesCabinas, 'class' => 'form-control']);
            echo $this->Form->control('programaID', ['options' => $programas, 'class' => 'form-control']);
            echo $this->Form->control('status', ['class' => 'form-control']);
        ?>
    </fieldset>
    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>