<div class="page-header">
    <?= $this->Html->link(__('New Tipo Bitacora'), ['action' => 'add'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    <h3><?= __('Tipo Bitacora') ?></h3>
</div>

<div class="content-card">
    <table class="data-table">
        <tr>
            <th><?= $this->Paginator->sort('ID') ?></th>
            <th>Nombre</th>
            <th>Turnos</th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>

        <?php foreach ($tipoBitacora as $tipoBitacora): ?>
            <tr>
                <td><?= $this->Number->format($tipoBitacora->ID) ?></td>
                <td><?= $tipoBitacora->name ?></td>
                <td><?= $tipoBitacora->getPrintableTurnos() ?></td>
                <td class="actions">
                    <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['action' => 'view', $tipoBitacora->ID], ['escapeTitle' => false]) ?>
                    <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $tipoBitacora->ID], ['escapeTitle' => false]) ?>
                    <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $tipoBitacora->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $tipoBitacora->ID), 'escapeTitle' => false]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
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