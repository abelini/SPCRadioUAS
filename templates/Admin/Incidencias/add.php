<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BitacoraVigilancium $bitacoraVigilancium
 * @var \Cake\Collection\CollectionInterface|string[] $vigilantes
 * @var \Cake\Collection\CollectionInterface|string[] $tipoBitacora
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Bitacora Vigilancia'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bitacoraVigilancia form content">
            <?= $this->Form->create($bitacoraVigilancium) ?>
            <fieldset>
                <legend><?= __('Add Bitacora Vigilancium') ?></legend>
                <?php
                    echo $this->Form->control('vigilanteID', ['options' => $vigilantes]);
                    echo $this->Form->control('tipoBitacora', ['options' => $tipoBitacora]);
                    echo $this->Form->control('fecha');
                    echo $this->Form->control('observaciones');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
