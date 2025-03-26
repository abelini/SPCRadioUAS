<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $locutore
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Locutore'), ['action' => 'edit', $locutore->ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Locutore'), ['action' => 'delete', $locutore->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $locutore->ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Locutores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Locutore'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="locutores view content">
            <h3><?= h($locutore->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Username') ?></th>
                    <td><?= h($locutore->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($locutore->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fullname') ?></th>
                    <td><?= h($locutore->fullname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($locutore->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Photo') ?></th>
                    <td><?= h($locutore->photo) ?></td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($locutore->ID) ?></td>
                </tr>
                <tr>
                    <th><?= __('Empleado') ?></th>
                    <td><?= $this->Number->format($locutore->empleado) ?></td>
                </tr>
                <tr>
                    <th><?= __('Base') ?></th>
                    <td><?= $locutore->base ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Permisos') ?></h4>
                <?php if (!empty($locutore->permisos)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('ID') ?></th>
                            <th><?= __('Name') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($locutore->permisos as $permiso) : ?>
                        <tr>
                            <td><?= h($permiso->ID) ?></td>
                            <td><?= h($permiso->name) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Permisos', 'action' => 'view', $permiso->ID]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Permisos', 'action' => 'edit', $permiso->ID]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Permisos', 'action' => 'delete', $permiso->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $permiso->ID)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Asignaciones') ?></h4>
                <?php if (!empty($locutore->asignaciones)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('ID') ?></th>
                            <th><?= __('RolID') ?></th>
                            <th><?= __('LocutorID') ?></th>
                            <th><?= __('DiaID') ?></th>
                            <th><?= __('HorarioID') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($locutore->asignaciones as $asignacione) : ?>
                        <tr>
                            <td><?= h($asignacione->ID) ?></td>
                            <td><?= h($asignacione->rolID) ?></td>
                            <td><?= h($asignacione->locutorID) ?></td>
                            <td><?= h($asignacione->diaID) ?></td>
                            <td><?= h($asignacione->horarioID) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Asignaciones', 'action' => 'view', $asignacione->ID]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Asignaciones', 'action' => 'edit', $asignacione->ID]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Asignaciones', 'action' => 'delete', $asignacione->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $asignacione->ID)]) ?>
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
