<div class="page-header">
    <h5><i class="fa-solid fa-clock"></i> Turno #<?= $turno->id ?></h5>
</div>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th>Nombre</th>
            <td><?= h($turno->name) ?></td>
        </tr>
        <tr>
            <th>ID</th>
            <td><?= $this->Number->format($turno->id) ?></td>
        </tr>
    </table>

    <div class="stats-section">
        <div class="page-header">
            <h5><i class="fa-solid fa-clock"></i> Horarios relacionados</h5>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turno->horarios as $horarios): ?>
                    <tr>
                        <td><?= h($horarios->id) ?></td>
                        <td><?= h($horarios->hora_inicio) ?></td>
                        <td><?= h($horarios->hora_fin) ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['controller' => 'Horarios', 'action' => 'view', $horarios->id], ['escapeTitle' => false]) ?>
                            <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'Horarios', 'action' => 'edit', $horarios->id], ['escapeTitle' => false]) ?>
                            <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['controller' => 'Horarios', 'action' => 'delete', $horarios->id], ['confirm' => '¿Estás seguro?', 'escapeTitle' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="stats-section">
        <div class="page-header">
            <h5><i class="fa-solid fa-calendar-week"></i> Roles relacionados</h5>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turno->roles as $roles): ?>
                    <tr>
                        <td><?= h($roles->id) ?></td>
                        <td><?= h($roles->fecha_inicio) ?></td>
                        <td><?= h($roles->fecha_fin) ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['controller' => 'Roles', 'action' => 'view', $roles->id], ['escapeTitle' => false]) ?>
                            <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'Roles', 'action' => 'edit', $roles->id], ['escapeTitle' => false]) ?>
                            <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['controller' => 'Roles', 'action' => 'delete', $roles->id], ['confirm' => '¿Estás seguro?', 'escapeTitle' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $turno->id], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $turno->id], ['confirm' => '¿Estás seguro de eliminar este turno?', 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>