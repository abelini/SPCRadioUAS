<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ticket $ticket
 * @var string[]|\Cake\Collection\CollectionInterface $bitacoraVigilancia
 * @var string[]|\Cake\Collection\CollectionInterface $usuarios
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->deleteLink(
                __('Delete'),
                ['action' => 'delete', $ticket->ID],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ticket->ID), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Tickets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tickets form content">
            <?= $this->Form->create($ticket) ?>
            <fieldset>
                <legend><?= __('Edit Ticket') ?></legend>
                <?php
                echo $this->Form->control('bitacoraID', ['options' => $bitacoraVigilancia]);
                echo $this->Form->control('userID', ['options' => $usuarios]);
                echo $this->Form->control('updates');
                echo $this->Form->control('date');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>