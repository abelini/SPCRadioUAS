<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $reportesVigilancia
 */
?>
<div class="reportesVigilancia index content">
    <?= $this->Html->link(__('New Reportes Vigilancium'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Reportes Vigilancia') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('ID') ?></th>
                    <th><?= $this->Paginator->sort('bitacoraID') ?></th>
                    <th><?= $this->Paginator->sort('fire') ?></th>
                    <th><?= $this->Paginator->sort('moist') ?></th>
                    <th><?= $this->Paginator->sort('ventilation') ?></th>
                    <th><?= $this->Paginator->sort('locks') ?></th>
                    <th><?= $this->Paginator->sort('blackout') ?></th>
                    <th><?= $this->Paginator->sort('lost_signal') ?></th>
                    <th><?= $this->Paginator->sort('alarm_on') ?></th>
                    <th><?= $this->Paginator->sort('leds') ?></th>
                    <th><?= $this->Paginator->sort('burning_smell') ?></th>
                    <th><?= $this->Paginator->sort('invaded') ?></th>
                    <th><?= $this->Paginator->sort('walls_cracked') ?></th>
                    <th><?= $this->Paginator->sort('antenna_bent') ?></th>
                    <th><?= $this->Paginator->sort('antenna_lights_off') ?></th>
                    <th><?= $this->Paginator->sort('antenna_anchor_bent') ?></th>
                    <th><?= $this->Paginator->sort('blackout_duration') ?></th>
                    <th><?= $this->Paginator->sort('lost_signal_duration') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportesVigilancia as $reportesVigilancium): ?>
                    <tr>
                        <td><?= $this->Number->format($reportesVigilancium->ID) ?></td>
                        <td><?= $this->Number->format($reportesVigilancium->bitacoraID) ?></td>
                        <td><?= h($reportesVigilancium->fire) ?></td>
                        <td><?= h($reportesVigilancium->moist) ?></td>
                        <td><?= h($reportesVigilancium->ventilation) ?></td>
                        <td><?= h($reportesVigilancium->locks) ?></td>
                        <td><?= h($reportesVigilancium->blackout) ?></td>
                        <td><?= h($reportesVigilancium->lost_signal) ?></td>
                        <td><?= h($reportesVigilancium->alarm_on) ?></td>
                        <td><?= h($reportesVigilancium->leds) ?></td>
                        <td><?= h($reportesVigilancium->burning_smell) ?></td>
                        <td><?= h($reportesVigilancium->invaded) ?></td>
                        <td><?= h($reportesVigilancium->walls_cracked) ?></td>
                        <td><?= h($reportesVigilancium->antenna_bent) ?></td>
                        <td><?= h($reportesVigilancium->antenna_lights_off) ?></td>
                        <td><?= h($reportesVigilancium->antenna_anchor_bent) ?></td>
                        <td><?= $reportesVigilancium->blackout_duration === null ? '' : $this->Number->format($reportesVigilancium->blackout_duration) ?>
                        </td>
                        <td><?= $reportesVigilancium->lost_signal_duration === null ? '' : $this->Number->format($reportesVigilancium->lost_signal_duration) ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $reportesVigilancium->ID]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reportesVigilancium->ID]) ?>
                            <?= $this->Form->deleteLink(__('Delete'), ['action' => 'delete', $reportesVigilancium->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $reportesVigilancium->ID)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </p>
    </div>
</div>