<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Permiso> $permisos
 */
?>
<div class="page-header">
    <?= $this->Html->link(__('New Permiso'), ['action' => 'add'], ['class' => 'btn btn-outlined']) ?>
    <h3><?= __('Permisos') ?></h3>
</div>

<div class="content-card">
    <table class="data-table">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('ID') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('plural') ?></th>
                <th><?= $this->Paginator->sort('singular') ?></th>
                <th><?= $this->Paginator->sort('icon') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($permisos as $permiso): ?>
                <tr>
                    <td><?= $this->Number->format($permiso->ID) ?></td>
                    <td><?= h($permiso->name) ?></td>
                    <td><?= h($permiso->plural) ?></td>
                    <td><?= h($permiso->singular) ?></td>
                    <td><?= h($permiso->icon) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['action' => 'view', $permiso->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $permiso->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $permiso->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $permiso->ID), 'escapeTitle' => false]) ?>
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