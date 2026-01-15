<?php
/**
 * @var \SPC\View\AppView $this
 * @var iterable<\SPC\Model\Entity\TemasPrograma> $temasProgramas
 */
?>
<div class="temasProgramas index content">
    <?= $this->Html->link(__('New Temas Programa'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Temas Programas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('ID') ?></th>
                    <th><?= $this->Paginator->sort('ProgramaID') ?></th>
                    <th><?= $this->Paginator->sort('tema') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($temasProgramas as $temasPrograma): ?>
                <tr>
                    <td><?= $this->Number->format($temasPrograma->ID) ?></td>
                    <td><?= $temasPrograma->hasValue('programa') ? $this->Html->link($temasPrograma->programa->name, ['controller' => 'Programas', 'action' => 'view', $temasPrograma->programa->ID]) : '' ?></td>
                    <td><?= h($temasPrograma->tema) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $temasPrograma->ID]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $temasPrograma->ID]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $temasPrograma->ID],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $temasPrograma->ID),
                            ]
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
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>