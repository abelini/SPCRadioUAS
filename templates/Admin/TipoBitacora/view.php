<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TipoBitacora $tipoBitacora
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tipo Bitacora'), ['action' => 'edit', $tipoBitacora->ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tipo Bitacora'), ['action' => 'delete', $tipoBitacora->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $tipoBitacora->ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tipo Bitacora'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tipo Bitacora'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tipoBitacora view content">
            <h3><?= h($tipoBitacora->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($tipoBitacora->ID) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Name') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($tipoBitacora->name)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Turnos') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($tipoBitacora->turnos)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
