<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turno $turno
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Turno'), ['action' => 'edit', $turno->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->deleteLink(__('Delete Turno'), ['action' => 'delete', $turno->id], ['confirm' => __('Are you sure you want to delete # {0}?', $turno->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Turnos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Turno'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="turnos view content">
            <h3><?= h($turno->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($turno->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($turno->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Horarios') ?></h4>
                <?php if (!empty($turno->horarios)): ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Hora Inicio') ?></th>
                                <th><?= __('Hora Fin') ?></th>
                                <th><?= __('Turno Id') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($turno->horarios as $horarios): ?>
                                <tr>
                                    <td><?= h($horarios->id) ?></td>
                                    <td><?= h($horarios->hora_inicio) ?></td>
                                    <td><?= h($horarios->hora_fin) ?></td>
                                    <td><?= h($horarios->turno_id) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Horarios', 'action' => 'view', $horarios->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Horarios', 'action' => 'edit', $horarios->id]) ?>
                                        <?= $this->Form->deleteLink(__('Delete'), ['controller' => 'Horarios', 'action' => 'delete', $horarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $horarios->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Roles') ?></h4>
                <?php if (!empty($turno->roles)): ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Fecha Inicio') ?></th>
                                <th><?= __('Fecha Fin') ?></th>
                                <th><?= __('Turno Id') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($turno->roles as $roles): ?>
                                <tr>
                                    <td><?= h($roles->id) ?></td>
                                    <td><?= h($roles->fecha_inicio) ?></td>
                                    <td><?= h($roles->fecha_fin) ?></td>
                                    <td><?= h($roles->turno_id) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Roles', 'action' => 'view', $roles->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Roles', 'action' => 'edit', $roles->id]) ?>
                                        <?= $this->Form->deleteLink(__('Delete'), ['controller' => 'Roles', 'action' => 'delete', $roles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roles->id)]) ?>
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