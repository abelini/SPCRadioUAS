<div class="page-header">
    <h5><i class="fa-solid fa-eye"></i> Ver área: <?= h($area->name) ?></h5>
</div>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($area->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Icon') ?></th>
            <td><?= h($area->icon) ?></td>
        </tr>
        <tr>
            <th><?= __('ID') ?></th>
            <td><?= $this->Number->format($area->ID) ?></td>
        </tr>
    </table>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $area->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $area->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $area->ID), 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>