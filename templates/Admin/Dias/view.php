<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dia $dia
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Dia'), ['action' => 'edit', $dia->ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->deleteLink(__('Delete Dia'), ['action' => 'delete', $dia->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $dia->ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Dias'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Dia'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="dias view content">
            <h3><?= h($dia->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($dia->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($dia->ID) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Horarios') ?></h4>
                <?php if (!empty($dia->horarios)): ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('HoraInicio') ?></th>
                                <th><?= __('HoraFin') ?></th>
                                <th><?= __('TurnoID') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($dia->horarios as $horarios): ?>
                                <tr>
                                    <td><?= h($horarios->ID) ?></td>
                                    <td><?= h($horarios->horaInicio) ?></td>
                                    <td><?= h($horarios->horaFin) ?></td>
                                    <td><?= h($horarios->turnoID) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Horarios', 'action' => 'view', $horarios->ID]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Horarios', 'action' => 'edit', $horarios->ID]) ?>
                                        <?= $this->Form->deleteLink(__('Delete'), ['controller' => 'Horarios', 'action' => 'delete', $horarios->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $horarios->ID)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Programas') ?></h4>
                <?php if (!empty($dia->programas)): ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Name') ?></th>
                                <th><?= __('HoraInicio') ?></th>
                                <th><?= __('HoraFin') ?></th>
                                <th><?= __('Produccion') ?></th>
                                <th><?= __('Uo') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($dia->programas as $programas): ?>
                                <tr>
                                    <td><?= h($programas->ID) ?></td>
                                    <td><?= h($programas->name) ?></td>
                                    <td><?= h($programas->horaInicio) ?></td>
                                    <td><?= h($programas->horaFin) ?></td>
                                    <td><?= h($programas->produccion) ?></td>
                                    <td><?= h($programas->uo) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Programas', 'action' => 'view', $programas->ID]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Programas', 'action' => 'edit', $programas->ID]) ?>
                                        <?= $this->Form->deleteLink(__('Delete'), ['controller' => 'Programas', 'action' => 'delete', $programas->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $programas->ID)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Asignaciones') ?></h4>
                <?php if (!empty($dia->asignaciones)): ?>
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
                            <?php foreach ($dia->asignaciones as $asignaciones): ?>
                                <tr>
                                    <td><?= h($asignaciones->ID) ?></td>
                                    <td><?= h($asignaciones->rolID) ?></td>
                                    <td><?= h($asignaciones->locutorID) ?></td>
                                    <td><?= h($asignaciones->diaID) ?></td>
                                    <td><?= h($asignaciones->horarioID) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Asignaciones', 'action' => 'view', $asignaciones->ID]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Asignaciones', 'action' => 'edit', $asignaciones->ID]) ?>
                                        <?= $this->Form->deleteLink(__('Delete'), ['controller' => 'Asignaciones', 'action' => 'delete', $asignaciones->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $asignaciones->ID)]) ?>
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