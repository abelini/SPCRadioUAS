<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $locutores
 */
?>
<div class="locutores index content">
    <?= $this->Html->link(__('New Locutore'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Locutores') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('ID') ?></th>
                    <th><?= $this->Paginator->sort('empleado') ?></th>
                    <th><?= $this->Paginator->sort('username') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('fullname') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('base') ?></th>
                    <th><?= $this->Paginator->sort('photo') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locutores as $locutore): ?>
                <tr>
                    <td><?= $this->Number->format($locutore->ID) ?></td>
                    <td><?= $this->Number->format($locutore->empleado) ?></td>
                    <td><?= h($locutore->username) ?></td>
                    <td><?= h($locutore->name) ?></td>
                    <td><?= h($locutore->fullname) ?></td>
                    <td><?= h($locutore->email) ?></td>
                    <td><?= h($locutore->base) ?></td>
                    <td><?= h($locutore->photo) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $locutore->ID]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locutore->ID]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locutore->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $locutore->ID)]) ?>
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
