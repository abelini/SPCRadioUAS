<div class="page-header">
    <h5><i class="fa-solid fa-users"></i> Usuarios</h5>
</div>

<?php foreach ($permisos as $tipoDeUsuario): ?>

    <div class="page-header">
        <h5><?= $tipoDeUsuario->icon ?> <?= $tipoDeUsuario->plural ?></h5>
    </div>

    <div class="content-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Usuario</th>
                    <th>Nombre completo</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tipoDeUsuario->usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario->empleado ?></td>
                        <td><?= $this->Html->link('@' . $usuario->username, ['action' => 'view', $usuario->ID]) ?></td>
                        <td><?= $this->Html->link($usuario->fullname, ['action' => 'view', $usuario->ID]) ?></td>
                        <td><?= $usuario->email ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['action' => 'view', $usuario->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $usuario->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $usuario->ID], ['confirm' => '¿Estás seguro de eliminar este usuario?', 'escapeTitle' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endforeach; ?>

<?= $this->Html->link('<i class="fa-solid fa-plus"></i> Agregar', ['action' => 'add'], ['class' => 'btn-circle', 'escapeTitle' => false]) ?>