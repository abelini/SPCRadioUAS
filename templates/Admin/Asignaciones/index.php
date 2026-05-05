<div class="page-header">
    <h5><i class="fa-solid fa-calendar-check"></i> Asignaciones</h5>
</div>

<div class="content-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Rol</th>
                <th>Locutor</th>
                <th>Día</th>
                <th>Horario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($asignaciones as $asignacione): ?>
                <tr>
                    <td><?= $this->Number->format($asignacione->ID) ?></td>
                    <td><?= $asignacione->hasValue('rol') ? $this->Html->link($asignacione->rol->fechaInicio, ['controller' => 'Roles', 'action' => 'view', $asignacione->rol->ID]) : '' ?></td>
                    <td><?= $asignacione->hasValue('locutor') ? $this->Html->link($asignacione->locutor->name, ['controller' => 'Locutores', 'action' => 'view', $asignacione->locutor->ID]) : '' ?></td>
                    <td><?= $asignacione->hasValue('dia') ? $this->Html->link($asignacione->dia->name, ['controller' => 'Dias', 'action' => 'view', $asignacione->dia->ID]) : '' ?></td>
                    <td><?= $asignacione->hasValue('horario') ? $this->Html->link($asignacione->horario->ID, ['controller' => 'Horarios', 'action' => 'view', $asignacione->horario->ID]) : '' ?></td>
                    <td>
                        <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['action' => 'view', $asignacione->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $asignacione->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $asignacione->ID], ['confirm' => __('¿Estás seguro de eliminar # {0}?', $asignacione->ID), 'escapeTitle' => false]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination-counter">
        <?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de un total de {{count}}')) ?>
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