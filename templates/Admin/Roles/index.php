<div class="page-header">
    <h5><i class="fa-solid fa-table-list"></i> Roles de cabina</h5>
</div>

<div class="content-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Semana</th>
                <th>Inicia</th>
                <th></th>
                <th>Termina</th>
                <th>Configuración de horario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $rol): ?>
                <tr>
                    <td>#<?= $rol->ID ?></td>
                    <td><?= $rol->fechaInicio->nice() ?></td>
                    <td><i class="fa-solid fa-arrow-right-long"></i></td>
                    <td><?= $rol->fechaFin->nice() ?></td>
                    <td><?= $this->Html->link($rol->turno->name, ['controller' => 'Turnos', 'action' => 'view', $rol->turno->ID]) ?>
                    </td>
                    <td>
                        <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['action' => 'view', $rol->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $rol->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $rol->ID), 'escapeTitle' => false]) ?>
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