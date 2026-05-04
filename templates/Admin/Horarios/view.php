<div class="page-header">
    <h5><i class="fa-solid fa-clock"></i> Horario #<?= $horario->ID ?></h5>
</div>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th>Turno</th>
            <td><?= $horario->hasValue('turno') ? $this->Html->link($horario->turno->name, ['controller' => 'Turnos', 'action' => 'view', $horario->turno->ID]) : '' ?>
            </td>
        </tr>
        <tr>
            <th>ID</th>
            <td><?= $this->Number->format($horario->ID) ?></td>
        </tr>
        <tr>
            <th>Hora Inicio</th>
            <td><?= h($horario->horaInicio) ?></td>
        </tr>
        <tr>
            <th>Hora Fin</th>
            <td><?= h($horario->horaFin) ?></td>
        </tr>
    </table>

    <div class="stats-section">
        <div class="page-header">
            <h5><i class="fa-solid fa-calendar-day"></i> Días relacionados</h5>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horario->dias as $dia): ?>
                    <tr>
                        <td><?= h($dia->ID) ?></td>
                        <td><?= h($dia->name) ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['controller' => 'Dias', 'action' => 'view', $dia->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'Dias', 'action' => 'edit', $dia->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['controller' => 'Dias', 'action' => 'delete', $dia->ID], ['confirm' => '¿Estás seguro?', 'escapeTitle' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $horario->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $horario->ID], ['confirm' => '¿Estás seguro de eliminar este horario?', 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>