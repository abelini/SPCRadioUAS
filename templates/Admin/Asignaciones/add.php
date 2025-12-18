<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $asignacione
 * @var \Cake\Collection\CollectionInterface|string[] $roles
 * @var \Cake\Collection\CollectionInterface|string[] $locutores
 * @var \Cake\Collection\CollectionInterface|string[] $dias
 * @var \Cake\Collection\CollectionInterface|string[] $horarios
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Asignaciones'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="asignaciones form content">
            <?= $this->Form->create($asignacione) ?>
            <fieldset>
                <legend><?= __('Add Asignacione') ?></legend>
                <?php
                    echo $this->Form->control('rolID', ['options' => $roles]);
                    echo $this->Form->control('locutorID', ['options' => $locutores]);
                    echo $this->Form->control('diaID', ['options' => $dias]);
                    echo $this->Form->control('horarioID', ['options' => $horarios]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
