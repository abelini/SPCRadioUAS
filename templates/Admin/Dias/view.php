<div class="page-header">
    <h5><i class="fa-solid fa-calendar-day"></i> Día #<?= $dia->ID ?> - <?= h($dia->name) ?></h5>
</div>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th>Nombre</th>
            <td><?= h($dia->name) ?></td>
        </tr>
        <tr>
            <th>ID</th>
            <td><?= $this->Number->format($dia->ID) ?></td>
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
                <?php foreach ($dia->horarios as $horarios): ?>
                    <tr>
                        <td><?= h($horarios->ID) ?></td>
                        <td><?= h($horarios->horaInicio) ?></td>
                        <td><?= h($horarios->horaFin) ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['controller' => 'Horarios', 'action' => 'view', $horarios->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'Horarios', 'action' => 'edit', $horarios->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['controller' => 'Horarios', 'action' => 'delete', $horarios->ID], ['confirm' => '¿Estás seguro?', 'escapeTitle' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="stats-section">
        <div class="page-header">
            <h5><i class="fa-solid fa-radio"></i> Programas relacionados</h5>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Producción</th>
                    <th>UO</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dia->programas as $programas): ?>
                    <tr>
                        <td><?= h($programas->ID) ?></td>
                        <td><?= h($programas->name) ?></td>
                        <td><?= h($programas->horaInicio) ?></td>
                        <td><?= h($programas->horaFin) ?></td>
                        <td><?= h($programas->produccion) ?></td>
                        <td><?= h($programas->uo) ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['controller' => 'Programas', 'action' => 'view', $programas->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'Programas', 'action' => 'edit', $programas->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['controller' => 'Programas', 'action' => 'delete', $programas->ID], ['confirm' => '¿Estás seguro?', 'escapeTitle' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="stats-section">
        <div class="page-header">
            <h5><i class="fa-solid fa-calendar-check"></i> Asignaciones relacionadas</h5>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Rol ID</th>
                    <th>Locutor ID</th>
                    <th>Día ID</th>
                    <th>Horario ID</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dia->asignaciones as $asignaciones): ?>
                    <tr>
                        <td><?= h($asignaciones->ID) ?></td>
                        <td><?= h($asignaciones->rolID) ?></td>
                        <td><?= h($asignaciones->locutorID) ?></td>
                        <td><?= h($asignaciones->diaID) ?></td>
                        <td><?= h($asignaciones->horarioID) ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['controller' => 'Asignaciones', 'action' => 'view', $asignaciones->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'Asignaciones', 'action' => 'edit', $asignaciones->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['controller' => 'Asignaciones', 'action' => 'delete', $asignaciones->ID], ['confirm' => '¿Estás seguro?', 'escapeTitle' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $dia->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $dia->ID], ['confirm' => '¿Estás seguro de eliminar este día?', 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>