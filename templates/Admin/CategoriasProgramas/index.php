<?php
/**
 * @var \SPC\View\AppView $this
 * @var iterable<\SPC\Model\Entity\CategoriasPrograma> $categoriasProgramas
 */
?>
<div class="categoriasProgramas index content">
    <?= $this->Html->link(__('New Categorias Programa'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Categorias Programas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('ID') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('slug') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categoriasProgramas as $categoriasPrograma): ?>
                <tr>
                    <td><?= $this->Number->format($categoriasPrograma->ID) ?></td>
                    <td><?= h($categoriasPrograma->name) ?></td>
                    <td><?= h($categoriasPrograma->slug) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $categoriasPrograma->ID]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $categoriasPrograma->ID]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $categoriasPrograma->ID],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $categoriasPrograma->ID),
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