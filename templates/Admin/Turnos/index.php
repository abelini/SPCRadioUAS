<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Turno> $turnos
 */
?>
<div class="turnos index content">
    <?= $this->Html->link(__('New Turno'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Turnos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turnos as $turno): ?>
                <tr>
                    <td><?= $this->Number->format($turno->ID) ?></td>
                    <td><?= h($turno->name) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $turno->ID]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $turno->ID]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $turno->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $turno->ID)]) ?>
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
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
