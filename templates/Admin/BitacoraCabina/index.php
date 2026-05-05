<div class="page-header">
    <h5><i class="fa-solid fa-list-check"></i> Bitácoras de cabina</h5>
</div>

<div class="content-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bitacoras as $bitacora): ?>
                <tr>
                    <td>#<?= $bitacora->ID ?></td>
                    <td><?= $this->Html->link($bitacora->fecha->i18nFormat(\IntlDateFormatter::FULL), ['action' => 'view', $bitacora->ID], ['escape' => false]) ?></td>
                    <td>
                        <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['action' => 'view', $bitacora->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $bitacora->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $bitacora->ID], ['confirm' => '¿Estás seguro de eliminar esta bitácora?', 'escapeTitle' => false]) ?>
                        <?= $this->Html->link('<i class="fa-solid fa-external-link"></i> Ver en INFO', ['controller' => 'BitacoraCabina', 'action' => 'display', '?' => ['d' => $bitacora->fecha->format('Y-m-d'), 'enable' => 1], 'prefix' => false], ['escapeTitle' => false, 'class' => 'btn btn-outlined']) ?>
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

    <?= $this->Html->link('<i class="fa-solid fa-plus"></i>', ['action' => 'add'], ['class' => 'btn-circle', 'escapeTitle' => false]) ?>
</div>