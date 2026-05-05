<div class="page-header">
    <h5><i class="fa-solid fa-clock"></i> Horarios</h5>
</div>

<div class="content-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Turno</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($horarios as $horario): ?>
                <tr>
                    <td><?= $this->Number->format($horario->ID) ?></td>
                    <td><?= h($horario->horaInicio) ?></td>
                    <td><?= h($horario->horaFin) ?></td>
                    <td><?= $horario->hasValue('turno') ? $this->Html->link($horario->turno->name, ['controller' => 'Turnos', 'action' => 'view', $horario->turno->ID]) : '' ?>
                    </td>
                    <td>
                        <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['action' => 'view', $horario->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $horario->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $horario->ID], ['confirm' => '¿Estás seguro de eliminar este horario?', 'escapeTitle' => false]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination-counter">
        <?= $this->Paginator->counter('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de un total de {{count}}') ?>
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