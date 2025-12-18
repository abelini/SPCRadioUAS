<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turno $turno
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->deleteLink(
                __('Delete'),
                ['action' => 'delete', $turno->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $turno->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Turnos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="turnos form content">
            <?= $this->Form->create($turno) ?>
            <fieldset>
                <legend><?= __('Edit Turno') ?></legend>
                <?php
                echo $this->Form->control('name');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>