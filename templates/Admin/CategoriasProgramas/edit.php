<?php
/**
 * @var \SPC\View\AppView $this
 * @var \SPC\Model\Entity\CategoriasPrograma $categoriasPrograma
 */
?>
<div class="page-header">
    <h5><i class="fa-regular fa-pen-to-square"></i> Modificar categoría de programa: <?= h($categoriasPrograma->name) ?></h5>
</div>

<div class="form-container">
    <?= $this->Form->create($categoriasPrograma) ?>
    <fieldset>
        <legend><?= __('Edit Categorias Programa') ?></legend>
        <?php
            echo $this->Form->control('name', ['class' => 'form-control']);
            echo $this->Form->control('slug', ['class' => 'form-control']);
        ?>
    </fieldset>
    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>