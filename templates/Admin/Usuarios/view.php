<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Usuario'), ['action' => 'edit', $usuario->ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Usuario'), ['action' => 'delete', $usuario->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $usuario->ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Usuarios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Usuario'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="usuarios view content">
            <h3><?= h($usuario->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Username') ?></th>
                    <td><?= h($usuario->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($usuario->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fullname') ?></th>
                    <td><?= h($usuario->fullname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($usuario->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($usuario->ID) ?></td>
                </tr>
                <tr>
                    <th><?= __('Empleado') ?></th>
                    <td><?= $this->Number->format($usuario->empleado) ?></td>
                </tr>
                <tr>
                    <th><?= __('Base') ?></th>
                    <td><?= $usuario->base ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Permisos') ?></h4>
                <?php if (!empty($usuario->permisos)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($usuario->permisos as $permisos) : ?>
                        <tr>
                            <td><?= h($permisos->ID) ?></td>
                            <td><?= h($permisos->name) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Permisos', 'action' => 'view', $permisos->ID]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Permisos', 'action' => 'edit', $permisos->ID]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Permisos', 'action' => 'delete', $permisos->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $permisos->ID)]) ?>
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
