<?php
/**
 * @var \SPC\View\AppView $this
 * @var iterable<\SPC\Model\Entity\StreamHit> $streamHits
 */
?>
<div class="streamHits index content">
    <?= $this->Html->link(__('New Stream Hit'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Stream Hits') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('ID') ?></th>
                    <th><?= $this->Paginator->sort('format') ?></th>
                    <th><?= $this->Paginator->sort('referer') ?></th>
                    <th><?= $this->Paginator->sort('refererType') ?></th>
                    <th><?= $this->Paginator->sort('ip') ?></th>
                    <th><?= $this->Paginator->sort('userAgent') ?></th>
                    <th><?= $this->Paginator->sort('country') ?></th>
                    <th><?= $this->Paginator->sort('countryCode') ?></th>
                    <th><?= $this->Paginator->sort('city') ?></th>
                    <th><?= $this->Paginator->sort('zip') ?></th>
                    <th><?= $this->Paginator->sort('lat') ?></th>
                    <th><?= $this->Paginator->sort('lon') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($streamHits as $streamHit): ?>
                <tr>
                    <td><?= $this->Number->format($streamHit->ID) ?></td>
                    <td><?= h($streamHit->format) ?></td>
                    <td><?= h($streamHit->referer) ?></td>
                    <td><?= h($streamHit->refererType) ?></td>
                    <td><?= h($streamHit->ip) ?></td>
                    <td><?= h($streamHit->userAgent) ?></td>
                    <td><?= h($streamHit->country) ?></td>
                    <td><?= h($streamHit->countryCode) ?></td>
                    <td><?= h($streamHit->city) ?></td>
                    <td><?= h($streamHit->zip) ?></td>
                    <td><?= $streamHit->lat === null ? '' : $this->Number->format($streamHit->lat) ?></td>
                    <td><?= $streamHit->lon === null ? '' : $this->Number->format($streamHit->lon) ?></td>
                    <td><?= h($streamHit->created) ?></td>
                    <td><?= h($streamHit->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $streamHit->ID]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $streamHit->ID]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $streamHit->ID],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $streamHit->ID),
                            ]
                        ) ?>
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