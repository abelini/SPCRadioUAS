<?php
/**
 * @var \SPC\View\AppView $this
 * @var \SPC\Model\Entity\CategoriasPrograma $categoriasPrograma
 */
?>
<div class="page-header">
    <h3><?= h($category->name) ?></h3>
</div>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($category->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($category->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('ID') ?></th>
            <td><?= $this->Number->format($category->ID) ?></td>
        </tr>
    </table>

    <div class="page-header">
        <h5><i class="fa-solid fa-calendar-check"></i> Programas relacionados</h5>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Producción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($category->programas as $programa): ?>
                    <tr>
                        <td>
                            <?= h($programa->ID) ?>
                        </td>
                        <td>
                            <?= h($programa->name) ?>
                        </td>
                        <td>
                            <?= h($programa->produccion) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $category->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $category->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $category->ID), 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>