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
            <?= $this->Html->link(__('Edit Categorias Programa'), ['action' => 'edit', $categoriasPrograma->ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Categorias Programa'), ['action' => 'delete', $categoriasPrograma->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $categoriasPrograma->ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Categorias Programas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Categorias Programa'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="categoriasProgramas view content">
            <h3><?= h($categoriasPrograma->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($categoriasPrograma->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Slug') ?></th>
                    <td><?= h($categoriasPrograma->slug) ?></td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($categoriasPrograma->ID) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>