<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Area> $areas
 */
?>
<div class="areas index content">
    <?= $this->Html->link(__('New Area'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Areas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('ID') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('icon') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($areas as $area): ?>
                    <tr>
                        <td><?= $this->Number->format($area->ID) ?></td>
                        <td><?= h($area->name) ?></td>
                        <td><?= h($area->icon) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $area->ID]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $area->ID]) ?>
                            <?= $this->Form->deleteLink(__('Delete'), ['action' => 'delete', $area->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $area->ID)]) ?>
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