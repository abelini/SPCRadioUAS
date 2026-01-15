<?php
/**
 * @var \SPC\View\AppView $this
 * @var \SPC\Model\Entity\TemasPrograma $temasPrograma
 * @var string[]|\Cake\Collection\CollectionInterface $programas
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $temasPrograma->ID],
                ['confirm' => __('Are you sure you want to delete # {0}?', $temasPrograma->ID), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Temas Programas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="temasProgramas form content">
            <?= $this->Form->create($temasPrograma) ?>
            <fieldset>
                <legend><?= __('Edit Temas Programa') ?></legend>
                <?php
                    echo $this->Form->control('ProgramaID', ['options' => $programas]);
                    echo $this->Form->control('tema');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
