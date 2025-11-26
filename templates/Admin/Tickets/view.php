<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ticket $ticket
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Ticket'), ['action' => 'edit', $ticket->ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->deleteLink(__('Delete Ticket'), ['action' => 'delete', $ticket->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $ticket->ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tickets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Ticket'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tickets view content">
            <h3><?= h($ticket->updates) ?></h3>
            <table>
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
            <div class="text">
                <strong><?= __('Updates') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($ticket->updates)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>