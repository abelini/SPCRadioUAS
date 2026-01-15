<?php
/**
 * @var \SPC\View\AppView $this
 * @var \SPC\Model\Entity\TemasPrograma $temasPrograma
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Temas Programa'), ['action' => 'edit', $temasPrograma->ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Temas Programa'), ['action' => 'delete', $temasPrograma->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $temasPrograma->ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Temas Programas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Temas Programa'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="temasProgramas view content">
            <h3><?= h($temasPrograma->tema) ?></h3>
            <table>
                <tr>
                    <th><?= __('Programa') ?></th>
                    <td><?= $temasPrograma->hasValue('programa') ? $this->Html->link($temasPrograma->programa->name, ['controller' => 'Programas', 'action' => 'view', $temasPrograma->programa->ID]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tema') ?></th>
                    <td><?= h($temasPrograma->tema) ?></td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($temasPrograma->ID) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>