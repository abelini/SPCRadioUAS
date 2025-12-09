<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReportesCabina $reportesCabina
 * @var string[]|\Cake\Collection\CollectionInterface $locutores
 * @var string[]|\Cake\Collection\CollectionInterface $bitacoraCabina
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $reportesCabina->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $reportesCabina->ID), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Reportes Cabinas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="reportesCabinas form content">
            <?= $this->Form->create($reportesCabina) ?>
            <fieldset>
                <legend><?= __('Edit Reportes Cabina') ?></legend>
                <?php
                    echo $this->Form->control('bitacoraID', ['options' => $bitacoraCabina]);
                    echo $this->Form->control('locutorId', ['options' => $locutores]);
                    echo $this->Form->control('horaInicio');
                    echo $this->Form->control('horaFin');
                    echo $this->Form->control('reporte');
                    echo $this->Form->control('controles');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
