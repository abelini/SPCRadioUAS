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
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<style>
    /* Estilos específicos para el contenido generado por IA */
    #resultado-ia-contenido ul {
        list-style-type: disc;
        margin-left: 20px;
        margin-bottom: 10px;
    }

    #resultado-ia-contenido ol {
        list-style-type: decimal;
        margin-left: 20px;
        margin-bottom: 10px;
    }

    #resultado-ia-contenido h1,
    #resultado-ia-contenido h2,
    #resultado-ia-contenido h3 {
        font-family: "Segoe UI", Arial, sans-serif;
        margin-top: 15px;
        color: #3f51b5;
        /* Un tono deep-purple acorde a tu diseño */
    }

    #resultado-ia-contenido strong {
        color: #000;
        font-weight: bold;
    }

    #resultado-ia-contenido p {
        margin-bottom: 10px;
        line-height: 1.6;
    }

    /* Si la IA devuelve código */
    #resultado-ia-contenido pre {
        background-color: #f4f4f4;
        padding: 10px;
        border-radius: 4px;
        border-left: 4px solid #673ab7;
        overflow-x: auto;
    }
</style>

<div class="w3-padding w3-center w3-margin-top">
    <button id="btn-generar-ia" class="w3-button w3-black w3-hover-deep-purple w3-round-large"
        onclick="consultarGemini(<?= $temasPrograma->ID ?>)">
        <i class="fa-solid fa-robot"></i> Generar análisis con IA
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
        // Limpiamos contenido previo y ponemos spinner
        contentDiv.innerHTML = '<div class="w3-center w3-padding"><i class="fa fa-spinner fa-spin w3-xxlarge w3-text-deep-purple"></i><p>Analizando...</p></div>';

        fetch('<?= $this->Url->build(['action' => 'executePrompt']) ?>/' + id, {
            method: 'POST',
            headers: {
                'X-CSRF-Token': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                if (!response.ok) throw new Error("Error en la petición");
                return response.text(); // Recibimos el Markdown crudo
            })
            .then(textoMarkdown => {
                // 3. AQUÍ LA MAGIA: Convertimos Markdown a HTML
                // marked.parse devuelve el string HTML listo
                const htmlBonito = marked.parse(textoMarkdown);

                contentDiv.innerHTML = htmlBonito;
            })
            .catch(error => {
                console.error('Error:', error);
                contentDiv.innerHTML = '<div class="w3-panel w3-pale-red w3-border-red">Error al consultar la IA.</div>';
            })
            .finally(() => {
                btn.disabled = false;
            });
    }
</script>