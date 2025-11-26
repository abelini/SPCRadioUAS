<div class="row">

    <div class="column column-80">
        <div class="reportesCabinas view content">
            <h3><?= h($reportesCabina->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($reportesCabina->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bitacora Id') ?></th>
                    <td><?= $this->Number->format($reportesCabina->bitacora_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Locutor Id') ?></th>
                    <td><?= $this->Number->format($reportesCabina->locutor_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Controles') ?></th>
                    <td><?= $this->Number->format($reportesCabina->controles) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hora Inicio') ?></th>
                    <td><?= h($reportesCabina->hora_inicio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hora Fin') ?></th>
                    <td><?= h($reportesCabina->hora_fin) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($reportesCabina->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($reportesCabina->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Reporte') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($reportesCabina->reporte)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Reportes Programas') ?></h4>
                <?php if (!empty($reportesCabina->reportes_programas)): ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Reportes Cabina Id') ?></th>
                                <th><?= __('Programa Id') ?></th>
                                <th><?= __('Status') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($reportesCabina->reportes_programas as $reportesProgramas): ?>
                                <tr>
                                    <td><?= h($reportesProgramas->id) ?></td>
                                    <td><?= h($reportesProgramas->reportes_cabina_id) ?></td>
                                    <td><?= h($reportesProgramas->programa_id) ?></td>
                                    <td><?= h($reportesProgramas->status) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'ReportesProgramas', 'action' => 'view', $reportesProgramas->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'ReportesProgramas', 'action' => 'edit', $reportesProgramas->id]) ?>
                                        <?= $this->Form->deleteLink(__('Delete'), ['controller' => 'ReportesProgramas', 'action' => 'delete', $reportesProgramas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reportesProgramas->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>