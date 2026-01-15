<h1>Pregúntale a Gemini (CakePHP 5)</h1>

<?= $this->Form->create(null) ?>
    <?= $this->Form->control('prompt', [
        'label' => 'Escribe tu pregunta',
        'type' => 'textarea',
        'rows' => '3',
        'class' => 'form-control' // Si usas Bootstrap
    ]) ?>
    <?= $this->Form->button('Enviar', ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>

<hr>

<?php if (!empty($respuesta)): ?>
    <div class="response-box" style="background: #f4f4f4; padding: 15px; border-radius: 8px;">
        <h3>Respuesta:</h3>
        <?= nl2br(h($respuesta)) ?>
    </div>
<?php endif; ?>