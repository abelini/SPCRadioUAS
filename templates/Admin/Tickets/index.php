<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Ticket> $tickets
 */
?>
<div class="page-header">
    <?= $this->Html->link(__('New Ticket'), ['action' => 'add'], ['class' => 'btn btn-outlined']) ?>
    <h3><?= __('Tickets') ?></h3>
</div>

<div class="content-card">
    <table class="data-table">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('ID') ?></th>
                <th><?= $this->Paginator->sort('bitacoraID') ?></th>
                <th><?= $this->Paginator->sort('userID') ?></th>
                <th><?= $this->Paginator->sort('date') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?= $this->Number->format($ticket->ID) ?></td>
                    <td><?= $ticket->hasValue('bitacora_vigilancium') ? $this->Html->link($ticket->bitacora_vigilancium->ID, ['controller' => 'BitacoraVigilancia', 'action' => 'view', $ticket->bitacora_vigilancium->ID]) : '' ?>
                    </td>
                    <td><?= $ticket->hasValue('usuario') ? $this->Html->link($ticket->usuario->name, ['controller' => 'Usuarios', 'action' => 'view', $ticket->usuario->ID]) : '' ?>
                    </td>
                    <td><?= h($ticket->date) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['action' => 'view', $ticket->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $ticket->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $ticket->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $ticket->ID), 'escapeTitle' => false]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination-counter">
        <?= $this->Paginator->counter('Página {{page}} de {{pages}}. Mostrando {{current}} resultados de un total de {{count}}') ?>
    </div>

    <div class="pagination">
        <?= $this->Paginator->first('<i class="fa-solid fa-angles-left"></i>', ['escape' => false]) ?>
        <?= $this->Paginator->prev('<i class="fa-solid fa-angle-left"></i>', ['escape' => false]) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next('<i class="fa-solid fa-angle-right"></i>', ['escape' => false]) ?>
        <?= $this->Paginator->last('<i class="fa-solid fa-angles-right"></i>', ['escape' => false]) ?>
    </div>
</div>