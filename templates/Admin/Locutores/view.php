<div class="page-header">
    <h5><i class="fa-solid fa-user"></i> Locutor #<?= $locutore->ID ?> - <?= h($locutore->name) ?></h5>
</div>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th>Usuario</th>
            <td><?= h($locutore->username) ?></td>
        </tr>
        <tr>
            <th>Nombre</th>
            <td><?= h($locutore->name) ?></td>
        </tr>
        <tr>
            <th>Nombre completo</th>
            <td><?= h($locutore->fullname) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= h($locutore->email) ?></td>
        </tr>
        <tr>
            <th>Foto</th>
            <td><?= h($locutore->photo) ?></td>
        </tr>
        <tr>
            <th>ID</th>
            <td><?= $this->Number->format($locutore->ID) ?></td>
        </tr>
        <tr>
            <th>Empleado</th>
            <td><?= $this->Number->format($locutore->empleado) ?></td>
        </tr>
        <tr>
            <th>Base</th>
            <td><?= $locutore->base ? 'Sí' : 'No' ?></td>
        </tr>
    </table>

    <div class="stats-section">
        <div class="page-header">
            <h5><i class="fa-solid fa-key"></i> Permisos relacionados</h5>
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
                <?php foreach ($locutore->permisos as $permiso): ?>
                    <tr>
                        <td><?= h($permiso->ID) ?></td>
                        <td><?= h($permiso->name) ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['controller' => 'Permisos', 'action' => 'view', $permiso->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'Permisos', 'action' => 'edit', $permiso->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['controller' => 'Permisos', 'action' => 'delete', $permiso->ID], ['confirm' => '¿Estás seguro?', 'escapeTitle' => false]) ?>
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
                <?php foreach ($locutore->asignaciones as $asignacione): ?>
                    <tr>
                        <td><?= h($asignacione->ID) ?></td>
                        <td><?= h($asignacione->rolID) ?></td>
                        <td><?= h($asignacione->locutorID) ?></td>
                        <td><?= h($asignacione->diaID) ?></td>
                        <td><?= h($asignacione->horarioID) ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['controller' => 'Asignaciones', 'action' => 'view', $asignacione->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'Asignaciones', 'action' => 'edit', $asignacione->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['controller' => 'Asignaciones', 'action' => 'delete', $asignacione->ID], ['confirm' => '¿Estás seguro?', 'escapeTitle' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $locutore->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $locutore->ID], ['confirm' => '¿Estás seguro de eliminar este locutor?', 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>