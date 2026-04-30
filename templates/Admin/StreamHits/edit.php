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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $streamHit->ID],
                ['confirm' => __('Are you sure you want to delete # {0}?', $streamHit->ID), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Stream Hits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="streamHits form content">
            <?= $this->Form->create($streamHit) ?>
            <fieldset>
                <legend><?= __('Edit Stream Hit') ?></legend>
                <?php
                    echo $this->Form->control('format');
                    echo $this->Form->control('referer');
                    echo $this->Form->control('refererType');
                    echo $this->Form->control('ip');
                    echo $this->Form->control('userAgent');
                    echo $this->Form->control('country');
                    echo $this->Form->control('countryCode');
                    echo $this->Form->control('city');
                    echo $this->Form->control('zip');
                    echo $this->Form->control('lat');
                    echo $this->Form->control('lon');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
