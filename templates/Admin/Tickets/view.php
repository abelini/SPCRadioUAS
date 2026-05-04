<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ticket $ticket
 */
?>
<div class="page-header">
    <h3><?= h($ticket->updates) ?></h3>
</div>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th><?= __('Bitacora Vigilancium') ?></th>
            <td><?= $ticket->hasValue('bitacora_vigilancium') ? $this->Html->link($ticket->bitacora_vigilancium->ID, ['controller' => 'BitacoraVigilancia', 'action' => 'view', $ticket->bitacora_vigilancium->ID]) : '' ?>
            </td>
        </tr>
        <tr>
            <th><?= __('Usuario') ?></th>
            <td><?= $ticket->hasValue('usuario') ? $this->Html->link($ticket->usuario->name, ['controller' => 'Usuarios', 'action' => 'view', $ticket->usuario->ID]) : '' ?>
            </td>
        </tr>
        <tr>
            <th><?= __('ID') ?></th>
            <td><?= $this->Number->format($ticket->ID) ?></td>
        </tr>
        <tr>
            <th><?= __('Date') ?></th>
            <td><?= h($ticket->date) ?></td>
        </tr>
    </table>

    <div class="stats-section">
        <div class="page-header">
            <h5><?= __('Updates') ?></h5>
        </div>
        <blockquote class="blockquote">
            <?= $this->Text->autoParagraph(h($ticket->updates)); ?>
        </blockquote>
    </div>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $ticket->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $ticket->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $ticket->ID), 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>