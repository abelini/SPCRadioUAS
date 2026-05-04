<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Permiso $permiso
 */
?>
<div class="page-header">
    <h3><?= h($permiso->name) ?></h3>
</div>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($permiso->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Plural') ?></th>
            <td><?= h($permiso->plural) ?></td>
        </tr>
        <tr>
            <th><?= __('Singular') ?></th>
            <td><?= h($permiso->singular) ?></td>
        </tr>
        <tr>
            <th><?= __('Icon') ?></th>
            <td><?= h($permiso->icon) ?></td>
        </tr>
        <tr>
            <th><?= __('ID') ?></th>
            <td><?= $this->Number->format($permiso->ID) ?></td>
        </tr>
    </table>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $permiso->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $permiso->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $permiso->ID), 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>

    <?php if (!empty($permiso->usuarios)): ?>
    <div class="stats-section">
        <div class="page-header">
            <h5><i class="fa-solid fa-users"></i> <?= __('Related Usuarios') ?></h5>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th><?= __('ID') ?></th>
                    <th><?= __('Empleado') ?></th>
                    <th><?= __('Username') ?></th>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Fullname') ?></th>
                    <th><?= __('Email') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($permiso->usuarios as $usuario): ?>
                    <tr>
                        <td><?= h($usuario->ID) ?></td>
                        <td><?= h($usuario->empleado) ?></td>
                        <td><?= h($usuario->username) ?></td>
                        <td><?= h($usuario->name) ?></td>
                        <td><?= h($usuario->fullname) ?></td>
                        <td><?= h($usuario->email) ?></td>
                        <td class="actions">
                            <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['controller' => 'Usuarios', 'action' => 'view', $usuario->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'Usuarios', 'action' => 'edit', $usuario->ID], ['escapeTitle' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>