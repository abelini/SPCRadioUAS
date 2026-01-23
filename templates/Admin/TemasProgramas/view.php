<div class="w3-container">
    <div class="w3-padding">
        <h3><?= $temasPrograma->programa ?></h3>
    </div>
    <div class="w3-padding">
        <div class="temasProgramas view content">
            <table>
                <tr>
                    <th><?= __('Programa') ?></th>
                    <td><?= $temasPrograma->hasValue('programa') ? $this->Html->link($temasPrograma->programa->name, ['controller' => 'Programas', 'action' => 'view', $temasPrograma->programa->ID]) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th>Producción</th>
                    <td><?= $temasPrograma->programa->produccion ?></td>
                </tr>
                <tr>
                    <th>Conducción</th>
                    <td><?= $temasPrograma->programa->conduccion ?></td>
                </tr>
                <tr>
                    <th><?= __('Tema') ?></th>
                    <td><?= h($temasPrograma->tema) ?></td>
                </tr>
                <tr>
                    <th><?= __('Invitados') ?></th>
                    <td><?= h($temasPrograma->invitados) ?></td>
                </tr>
                <tr>
                    <th>
                        <?= __('Palabras clave') ?>
                    </th>
                    <td>
                        <?= h($temasPrograma->tags) ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="w3-padding w3-center w3-margin-top">
    <button id="btn-generar-ia" class="w3-button w3-black w3-hover-deep-purple w3-round-large"
        onclick="consultarGemini(<?= $temasPrograma->ID ?>)">
        <i class="fa-solid fa-robot"></i> Generar con IA
    </button>
</div>

<div id="resultado-ia-container" class="w3-padding w3-margin-top" style="display:none;">
    <div class="w3-card-4 w3-white">
        <header class="w3-container w3-deep-purple">
            <h5><i class="fa-solid fa-sparkles"></i> Respuesta de Gemini</h5>
        </header>
        <div class="w3-container w3-padding" id="resultado-ia-contenido"></div>
    </div>
</div>

<script>
    const csrfToken = <?= json_encode($this->request->getAttribute('csrfToken')); ?>;

    function consultarGemini(id) {
        const btn = document.getElementById('btn-generar-ia');
        const container = document.getElementById('resultado-ia-container');
        const contentDiv = document.getElementById('resultado-ia-contenido');

        // UI: Loading
        btn.disabled = true;
        container.style.display = 'block';
        contentDiv.innerHTML = '<p class="w3-opacity"><i class="fa fa-spinner fa-spin"></i> Procesando...</p>';

        fetch('<?= $this->Url->build(['action' => 'generarIa']) ?>/' + id, {
            method: 'POST',
            headers: {
                'X-CSRF-Token': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            // Si necesitas enviar datos extra, van aquí en el body
        })
            .then(response => {
                if (!response.ok) throw new Error("Error en la petición");
                // CAMBIO CLAVE: Esperamos texto plano, no JSON
                return response.text();
            })
            .then(texto => {
                // Insertamos el string directamente
                // Si Gemini devuelve saltos de línea (\n), usamos CSS white-space o un replace simple:
                contentDiv.innerHTML = texto.replace(/\n/g, "<br>");
            })
            .catch(error => {
                console.error('Error:', error);
                contentDiv.innerHTML = '<div class="w3-text-red">Ocurrió un error al cargar la respuesta.</div>';
            })
            .finally(() => {
                btn.disabled = false;
            });
    }
</script>