<?php
/**
 * @var \SPC\View\AppView $this
 * @var \SPC\Model\Entity\StreamHit $streamHit
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Stream Hit'), ['action' => 'edit', $streamHit->ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Stream Hit'), ['action' => 'delete', $streamHit->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $streamHit->ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Stream Hits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Stream Hit'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="streamHits view content">
            <h3><?= h($streamHit->format) ?></h3>
            <table>
                <tr>
                    <th><?= __('Format') ?></th>
                    <td><?= h($streamHit->format) ?></td>
                </tr>
                <tr>
                    <th><?= __('Referer') ?></th>
                    <td><?= h($streamHit->referer) ?></td>
                </tr>
                <tr>
                    <th><?= __('RefererType') ?></th>
                    <td><?= h($streamHit->refererType) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ip') ?></th>
                    <td><?= h($streamHit->ip) ?></td>
                </tr>
                <tr>
                    <th><?= __('UserAgent') ?></th>
                    <td><?= h($streamHit->userAgent) ?></td>
                </tr>
                <tr>
                    <th><?= __('Country') ?></th>
                    <td><?= h($streamHit->country) ?></td>
                </tr>
                <tr>
                    <th><?= __('CountryCode') ?></th>
                    <td><?= h($streamHit->countryCode) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($streamHit->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('Zip') ?></th>
                    <td><?= h($streamHit->zip) ?></td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($streamHit->ID) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lat') ?></th>
                    <td><?= $streamHit->lat === null ? '' : $this->Number->format($streamHit->lat) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lon') ?></th>
                    <td><?= $streamHit->lon === null ? '' : $this->Number->format($streamHit->lon) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($streamHit->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($streamHit->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>