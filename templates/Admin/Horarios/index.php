<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Horario> $horarios
 */
?>
<div class="horarios index content">
    <?= $this->Html->link(__('New Horario'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Horarios') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('ID') ?></th>
                    <th><?= $this->Paginator->sort('horaInicio') ?></th>
                    <th><?= $this->Paginator->sort('horaFin') ?></th>
                    <th><?= $this->Paginator->sort('turnoID') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horarios as $horario): ?>
                    <tr>
                        <td><?= $this->Number->format($horario->ID) ?></td>
                        <td><?= h($horario->horaInicio) ?></td>
                        <td><?= h($horario->horaFin) ?></td>
                        <td><?= $horario->hasValue('turno') ? $this->Html->link($horario->turno->name, ['controller' => 'Turnos', 'action' => 'view', $horario->turno->ID]) : '' ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $horario->ID]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $horario->ID]) ?>
                            <?= $this->Form->deleteLink(__('Delete'), ['action' => 'delete', $horario->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $horario->ID)]) ?>
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