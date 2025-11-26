<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Dia> $dias
 */
?>
<div class="dias index content">
    <?= $this->Html->link(__('New Dia'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Dias') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('ID') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dias as $dia): ?>
                    <tr>
                        <td><?= $this->Number->format($dia->ID) ?></td>
                        <td><?= h($dia->name) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $dia->ID]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $dia->ID]) ?>
                            <?= $this->Form->deleteLink(__('Delete'), ['action' => 'delete', $dia->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $dia->ID)]) ?>
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