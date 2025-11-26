<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\BitacoraCabina> $bitacoraCabina
 */
?>
<div class="bitacoraCabina index content">
    <?= $this->Html->link(__('New Bitacora Cabina'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Bitacora Cabina') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('fecha') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bitacoraCabina as $bitacoraCabina): ?>
                    <tr>
                        <td><?= $this->Number->format($bitacoraCabina->id) ?></td>
                        <td><?= h($bitacoraCabina->fecha) ?></td>
                        <td><?= h($bitacoraCabina->created) ?></td>
                        <td><?= h($bitacoraCabina->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $bitacoraCabina->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bitacoraCabina->id]) ?>
                            <?= $this->Form->deleteLink(__('Delete'), ['action' => 'delete', $bitacoraCabina->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bitacoraCabina->id)]) ?>
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