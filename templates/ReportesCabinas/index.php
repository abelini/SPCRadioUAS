<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ReportesCabina> $reportesCabinas
 */
?>
<div class="reportesCabinas index content">
    <?= $this->Html->link(__('New Reportes Cabina'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Reportes Cabinas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('bitacora_id') ?></th>
                    <th><?= $this->Paginator->sort('locutor_id') ?></th>
                    <th><?= $this->Paginator->sort('hora_inicio') ?></th>
                    <th><?= $this->Paginator->sort('hora_fin') ?></th>
                    <th><?= $this->Paginator->sort('controles') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportesCabinas as $reportesCabina): ?>
                    <tr>
                        <td><?= $this->Number->format($reportesCabina->id) ?></td>
                        <td><?= $this->Number->format($reportesCabina->bitacora_id) ?></td>
                        <td><?= $this->Number->format($reportesCabina->locutor_id) ?></td>
                        <td><?= h($reportesCabina->hora_inicio) ?></td>
                        <td><?= h($reportesCabina->hora_fin) ?></td>
                        <td><?= $this->Number->format($reportesCabina->controles) ?></td>
                        <td><?= h($reportesCabina->created) ?></td>
                        <td><?= h($reportesCabina->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $reportesCabina->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reportesCabina->id]) ?>
                            <?= $this->Form->deleteLink(__('Delete'), ['action' => 'delete', $reportesCabina->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reportesCabina->id)]) ?>
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