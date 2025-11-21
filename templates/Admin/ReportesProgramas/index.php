<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ReportesPrograma> $reportesProgramas
 */
?>
<div class="reportesProgramas index content">
    <?= $this->Html->link(__('New Reportes Programa'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Reportes Programas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('ID') ?></th>
                    <th><?= $this->Paginator->sort('ReporteCabinaID') ?></th>
                    <th><?= $this->Paginator->sort('programaID') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportesProgramas as $reportesPrograma): ?>
                <tr>
                    <td><?= $this->Number->format($reportesPrograma->ID) ?></td>
                    <td><?= $reportesPrograma->hasValue('reporte') ? $this->Html->link($reportesPrograma->reporte->ID, ['controller' => 'ReportesCabinas', 'action' => 'view', $reportesPrograma->reporte->ID]) : '' ?></td>
                    <td><?= $reportesPrograma->hasValue('programa') ? $this->Html->link($reportesPrograma->programa->name, ['controller' => 'Programas', 'action' => 'view', $reportesPrograma->programa->ID]) : '' ?></td>
                    <td><?= h($reportesPrograma->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $reportesPrograma->ID]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reportesPrograma->ID]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $reportesPrograma->ID], ['method' => 'delete', 'confirm' => __('Are you sure you want to delete # {0}?', $reportesPrograma->ID)]) ?>
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
