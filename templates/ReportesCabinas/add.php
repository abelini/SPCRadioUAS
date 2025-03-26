<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReportesCabina $reportesCabina
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Reportes Cabinas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="reportesCabinas form content">
            <?= $this->Form->create($reportesCabina) ?>
            <fieldset>
                <legend><?= __('Add Reportes Cabina') ?></legend>
                <?php
                    echo $this->Form->control('bitacora_id');
                    echo $this->Form->control('locutor_id');
                    echo $this->Form->control('hora_inicio');
                    echo $this->Form->control('hora_fin');
                    echo $this->Form->control('reporte');
                    echo $this->Form->control('controles');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
