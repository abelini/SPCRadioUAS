<?php
/**
 * @var \SPC\View\AppView $this
 * @var \SPC\Model\Entity\CategoriasPrograma $categoriasPrograma
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $categoriasPrograma->ID],
                ['confirm' => __('Are you sure you want to delete # {0}?', $categoriasPrograma->ID), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Categorias Programas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="categoriasProgramas form content">
            <?= $this->Form->create($categoriasPrograma) ?>
            <fieldset>
                <legend><?= __('Edit Categorias Programa') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('slug');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
