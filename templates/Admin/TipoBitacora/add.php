<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TipoBitacora $tipoBitacora
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Tipo Bitacora'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tipoBitacora form content">
            <?= $this->Form->create($tipoBitacora) ?>
            <fieldset>
                <legend><?= __('Add Tipo Bitacora') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('turnos');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
