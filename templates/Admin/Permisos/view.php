<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Permiso $permiso
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Permiso'), ['action' => 'edit', $permiso->ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->deleteLink(__('Delete Permiso'), ['action' => 'delete', $permiso->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $permiso->ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Permisos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Permiso'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="permisos view content">
            <h3><?= h($permiso->name) ?></h3>
            <table>
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
            <div class="related">
                <h4><?= __('Related Usuarios') ?></h4>
                <?php if (!empty($permiso->usuarios)): ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Empleado') ?></th>
                                <th><?= __('Username') ?></th>
                                <th><?= __('Password') ?></th>
                                <th><?= __('Name') ?></th>
                                <th><?= __('Fullname') ?></th>
                                <th><?= __('Email') ?></th>
                                <th><?= __('Base') ?></th>
                                <th><?= __('Photo') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($permiso->usuarios as $usuario): ?>
                                <tr>
                                    <td><?= h($usuario->ID) ?></td>
                                    <td><?= h($usuario->empleado) ?></td>
                                    <td><?= h($usuario->username) ?></td>
                                    <td><?= h($usuario->password) ?></td>
                                    <td><?= h($usuario->name) ?></td>
                                    <td><?= h($usuario->fullname) ?></td>
                                    <td><?= h($usuario->email) ?></td>
                                    <td><?= h($usuario->base) ?></td>
                                    <td><?= h($usuario->photo) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Usuarios', 'action' => 'view', $usuario->ID]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Usuarios', 'action' => 'edit', $usuario->ID]) ?>
                                        <?= $this->Form->deleteLink(
                                            __('Delete'),
                                            ['controller' => 'Usuarios', 'action' => 'delete', $usuario->ID],
                                            ['confirm' => __('Are you sure you want to delete # {0}?', $usuario->ID)]
                                        ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>