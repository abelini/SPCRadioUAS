<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Permiso $permiso
 * @var string[]|\Cake\Collection\CollectionInterface $usuarios
 */
?>
<div class="page-header">
    <h5><i class="fa-regular fa-pen-to-square"></i> Modificar permiso: <?= h($permiso->name) ?></h5>
</div>

<div class="form-container">
    <?= $this->Form->create($permiso) ?>
    <fieldset>
        <legend><?= __('Edit Permiso') ?></legend>
        <?php
            echo $this->Form->control('name', ['class' => 'form-control']);
            echo $this->Form->control('plural', ['class' => 'form-control']);
            echo $this->Form->control('singular', ['class' => 'form-control']);
            echo $this->Form->control('icon', ['class' => 'form-control']);
            echo $this->Form->control('usuarios._ids', ['options' => $usuarios, 'class' => 'form-control']);
        ?>
    </fieldset>
    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>