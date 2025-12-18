<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReportesPrograma $reportesPrograma
 * @var \Cake\Collection\CollectionInterface|string[] $reportesCabinas
 * @var \Cake\Collection\CollectionInterface|string[] $programas
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Reportes Programas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="reportesProgramas form content">
            <?= $this->Form->create($reportesPrograma) ?>
            <fieldset>
                <legend><?= __('Add Reportes Programa') ?></legend>
                <?php
                    echo $this->Form->control('ReporteCabinaID', ['options' => $reportesCabinas]);
                    echo $this->Form->control('programaID', ['options' => $programas]);
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
