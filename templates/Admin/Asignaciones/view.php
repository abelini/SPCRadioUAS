<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $asignacione
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Asignacione'), ['action' => 'edit', $asignacione->ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Asignacione'), ['action' => 'delete', $asignacione->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $asignacione->ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Asignaciones'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Asignacione'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="asignaciones view content">
            <h3><?= h($asignacione->ID) ?></h3>
            <table>
                <tr>
                    <th><?= __('Rol') ?></th>
                    <td><?= $asignacione->hasValue('rol') ? $this->Html->link($asignacione->rol->fechaInicio, ['controller' => 'Roles', 'action' => 'view', $asignacione->rol->ID]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Locutor') ?></th>
                    <td><?= $asignacione->hasValue('locutor') ? $this->Html->link($asignacione->locutor->name, ['controller' => 'Locutores', 'action' => 'view', $asignacione->locutor->ID]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Dia') ?></th>
                    <td><?= $asignacione->hasValue('dia') ? $this->Html->link($asignacione->dia->name, ['controller' => 'Dias', 'action' => 'view', $asignacione->dia->ID]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Horario') ?></th>
                    <td><?= $asignacione->hasValue('horario') ? $this->Html->link($asignacione->horario->ID, ['controller' => 'Horarios', 'action' => 'view', $asignacione->horario->ID]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($asignacione->ID) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>