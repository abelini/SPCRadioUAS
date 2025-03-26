<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Permiso $permiso
 * @var string[]|\Cake\Collection\CollectionInterface $usuarios
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $permiso->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $permiso->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Permisos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="permisos form content">
            <?= $this->Form->create($permiso) ?>
            <fieldset>
                <legend><?= __('Edit Permiso') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('usuarios._ids', ['options' => $usuarios]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
