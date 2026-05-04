<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TipoBitacora $tipoBitacora
 */
?>
<div class="page-header">
    <h3><?= h($tipoBitacora->name) ?></h3>
</div>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th><?= __('ID') ?></th>
            <td><?= $this->Number->format($tipoBitacora->ID) ?></td>
        </tr>
    </table>

    <div class="stats-section">
        <div class="page-header">
            <h5><?= __('Name') ?></h5>
        </div>
        <blockquote class="blockquote">
            <?= $this->Text->autoParagraph(h($tipoBitacora->name)); ?>
        </blockquote>
    </div>

    <div class="stats-section">
        <div class="page-header">
            <h5><?= __('Turnos') ?></h5>
        </div>
        <blockquote class="blockquote">
            <?= $this->Text->autoParagraph(h($tipoBitacora->turnos)); ?>
        </blockquote>
    </div>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $tipoBitacora->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $tipoBitacora->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $tipoBitacora->ID), 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>