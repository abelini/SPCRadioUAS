<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $locutore
 * @var \Cake\Collection\CollectionInterface|string[] $permisos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Locutores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="locutores form content">
            <?= $this->Form->create($locutore) ?>
            <fieldset>
                <legend><?= __('Add Locutore') ?></legend>
                <?php
                    echo $this->Form->control('empleado');
                    echo $this->Form->control('username');
                    echo $this->Form->control('password');
                    echo $this->Form->control('name');
                    echo $this->Form->control('fullname');
                    echo $this->Form->control('email');
                    echo $this->Form->control('base');
                    echo $this->Form->control('photo');
                    echo $this->Form->control('permisos._ids', ['options' => $permisos]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
