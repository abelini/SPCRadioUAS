<?php
/**
 * @var \SPC\View\AppView $this
 * @var iterable<\SPC\Model\Entity\CategoriasPrograma> $categoriasProgramas
 */
?>
<div class="page-header">
    <h5><i class="fa-solid fa-layer-group"></i> Categorías de Programas</h5>
</div>

<div class="content-card">
    <table class="data-table">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('ID') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('slug') ?></th>
                <th>Icono</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categoriasProgramas as $categoriasPrograma): ?>
                <tr>
                    <td><?= $this->Number->format($categoriasPrograma->ID) ?></td>
                    <td><?= h($categoriasPrograma->name) ?></td>
                    <td><?= h($categoriasPrograma->slug) ?></td>
                    <td>
                        <i class="<?= h($categoriasPrograma->icon) ?>"></i>

                    </td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['action' => 'view', $categoriasPrograma->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $categoriasPrograma->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $categoriasPrograma->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $categoriasPrograma->ID), 'escapeTitle' => false]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination-counter">
        <?= $this->Paginator->counter('Página {{page}} de {{pages}}. Mostrando {{current}} resultados de un total de {{count}}') ?>
    </div>

    <div class="pagination">
        <?= $this->Paginator->first('<i class="fa-solid fa-angles-left"></i>', ['escape' => false]) ?>
        <?= $this->Paginator->prev('<i class="fa-solid fa-angle-left"></i>', ['escape' => false]) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next('<i class="fa-solid fa-angle-right"></i>', ['escape' => false]) ?>
        <?= $this->Paginator->last('<i class="fa-solid fa-angles-right"></i>', ['escape' => false]) ?>
    </div>
</div>

<?= $this->Html->link('<i class="fa-solid fa-plus"></i>', ['action' => 'add'], ['class' => 'btn-circle', 'escapeTitle' => false]) ?>