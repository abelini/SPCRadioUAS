<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dia $dia
 * @var \Cake\Collection\CollectionInterface|string[] $horarios
 * @var \Cake\Collection\CollectionInterface|string[] $programas
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Dias'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="dias form content">
            <?= $this->Form->create($dia) ?>
            <fieldset>
                <legend><?= __('Add Dia') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('horarios._ids', ['options' => $horarios]);
                    echo $this->Form->control('programas._ids', ['options' => $programas]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
