<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Horario $horario
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Horario'), ['action' => 'edit', $horario->ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->deleteLink(__('Delete Horario'), ['action' => 'delete', $horario->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $horario->ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Horarios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Horario'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="horarios view content">
            <h3><?= h($horario->ID) ?></h3>
            <table>
                <tr>
                    <th><?= __('Turno') ?></th>
                    <td><?= $horario->hasValue('turno') ? $this->Html->link($horario->turno->name, ['controller' => 'Turnos', 'action' => 'view', $horario->turno->ID]) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($horario->ID) ?></td>
                </tr>
                <tr>
                    <th><?= __('HoraInicio') ?></th>
                    <td><?= h($horario->horaInicio) ?></td>
                </tr>
                <tr>
                    <th><?= __('HoraFin') ?></th>
                    <td><?= h($horario->horaFin) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Dias') ?></h4>
                <?php if (!empty($horario->dias)): ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Name') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($horario->dias as $dia): ?>
                                <tr>
                                    <td><?= h($dia->ID) ?></td>
                                    <td><?= h($dia->name) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Dias', 'action' => 'view', $dia->ID]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Dias', 'action' => 'edit', $dia->ID]) ?>
                                        <?= $this->Form->deleteLink(__('Delete'), ['controller' => 'Dias', 'action' => 'delete', $dia->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $dia->ID)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Asignaciones') ?></h4>
                <?php if (!empty($horario->asignaciones)): ?>
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
                            <?php foreach ($horario->asignaciones as $asignacione): ?>
                                <tr>
                                    <td><?= h($asignacione->ID) ?></td>
                                    <td><?= h($asignacione->rolID) ?></td>
                                    <td><?= h($asignacione->locutorID) ?></td>
                                    <td><?= h($asignacione->diaID) ?></td>
                                    <td><?= h($asignacione->horarioID) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Asignaciones', 'action' => 'view', $asignacione->ID]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Asignaciones', 'action' => 'edit', $asignacione->ID]) ?>
                                        <?= $this->Form->deleteLink(__('Delete'), ['controller' => 'Asignaciones', 'action' => 'delete', $asignacione->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $asignacione->ID)]) ?>
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