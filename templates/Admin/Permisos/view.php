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
            <?= $this->Html->link(__('Edit Permiso'), ['action' => 'edit', $permiso->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Permiso'), ['action' => 'delete', $permiso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permiso->id), 'class' => 'side-nav-item']) ?>
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
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($permiso->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Usuarios') ?></h4>
                <?php if (!empty($permiso->usuarios)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Empleado') ?></th>
                            <th><?= __('Username') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Fullname') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Base') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($permiso->usuarios as $usuarios) : ?>
                        <tr>
                            <td><?= h($usuarios->id) ?></td>
                            <td><?= h($usuarios->empleado) ?></td>
                            <td><?= h($usuarios->username) ?></td>
                            <td><?= h($usuarios->password) ?></td>
                            <td><?= h($usuarios->name) ?></td>
                            <td><?= h($usuarios->fullname) ?></td>
                            <td><?= h($usuarios->email) ?></td>
                            <td><?= h($usuarios->base) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Usuarios', 'action' => 'view', $usuarios->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Usuarios', 'action' => 'edit', $usuarios->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Usuarios', 'action' => 'delete', $usuarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usuarios->id)]) ?>
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
