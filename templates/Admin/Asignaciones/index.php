<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $asignaciones
 */
?>
<div class="asignaciones index content">
    <?= $this->Html->link(__('New Asignacione'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Asignaciones') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('ID') ?></th>
                    <th><?= $this->Paginator->sort('rolID') ?></th>
                    <th><?= $this->Paginator->sort('locutorID') ?></th>
                    <th><?= $this->Paginator->sort('diaID') ?></th>
                    <th><?= $this->Paginator->sort('horarioID') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($asignaciones as $asignacione): ?>
                    <tr>
                        <td><?= $this->Number->format($asignacione->ID) ?></td>
                        <td><?= $asignacione->hasValue('rol') ? $this->Html->link($asignacione->rol->fechaInicio, ['controller' => 'Roles', 'action' => 'view', $asignacione->rol->ID]) : '' ?>
                        </td>
                        <td><?= $asignacione->hasValue('locutor') ? $this->Html->link($asignacione->locutor->name, ['controller' => 'Locutores', 'action' => 'view', $asignacione->locutor->ID]) : '' ?>
                        </td>
                        <td><?= $asignacione->hasValue('dia') ? $this->Html->link($asignacione->dia->name, ['controller' => 'Dias', 'action' => 'view', $asignacione->dia->ID]) : '' ?>
                        </td>
                        <td><?= $asignacione->hasValue('horario') ? $this->Html->link($asignacione->horario->ID, ['controller' => 'Horarios', 'action' => 'view', $asignacione->horario->ID]) : '' ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $asignacione->ID]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $asignacione->ID]) ?>
                            <?= $this->Form->deleteLink(__('Delete'), ['action' => 'delete', $asignacione->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $asignacione->ID)]) ?>
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
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </p>
    </div>
</div>