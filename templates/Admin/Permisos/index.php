<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Permiso> $permisos
 */
?>
<div class="permisos index content">
    <?= $this->Html->link(__('New Permiso'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Permisos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('ID') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('plural') ?></th>
                    <th><?= $this->Paginator->sort('singular') ?></th>
                    <th><?= $this->Paginator->sort('icon') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($permisos as $permiso): ?>
                    <tr>
                        <td><?= $this->Number->format($permiso->ID) ?></td>
                        <td><?= h($permiso->name) ?></td>
                        <td><?= h($permiso->plural) ?></td>
                        <td><?= h($permiso->singular) ?></td>
                        <td><?= h($permiso->icon) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $permiso->ID]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $permiso->ID]) ?>
                            <?= $this->Form->deleteLink(
                                __('Delete'),
                                ['action' => 'delete', $permiso->ID],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $permiso->ID)]
                            ) ?>
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