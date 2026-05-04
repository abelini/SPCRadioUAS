<div class="page-header">
        <h3><?= $temasPrograma->programa ?></h3>
    </div>

    <div class="content-card">
        <table class="view-table">
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
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<style>
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
    }

    #resultado-ia-contenido strong {
        color: #000;
        font-weight: bold;
    }

    #resultado-ia-contenido p {
        margin-bottom: 10px;
        line-height: 1.6;
    }

    #resultado-ia-contenido pre {
        background-color: #f4f4f4;
        padding: 10px;
        border-radius: 4px;
        border-left: 4px solid #673ab7;
        overflow-x: auto;
    }
</style>

<div class="content-card" style="text-align: center; margin-top: var(--spacing-16);">
    <button id="btn-generar-ia" class="btn"
        onclick="consultarGemini(<?= $temasPrograma->ID ?>)">
        <i class="fa-solid fa-robot"></i> Generar análisis con IA
    </button>
</div>

<div id="resultado-ia-container" class="content-card" style="display:none; margin-top: var(--spacing-16);">
    <div class="page-header">
        <h5><i class="fa-solid fa-sparkles"></i> Respuesta de Gemini</h5>
    </div>

    <div id="resultado-ia-contenido"></div>
</div>

<script>
    const csrfToken = <?= json_encode($this->request->getAttribute('csrfToken')); ?>;

    function consultarGemini(id) {
        const btn = document.getElementById('btn-generar-ia');
        const container = document.getElementById('resultado-ia-container');
        const contentDiv = document.getElementById('resultado-ia-contenido');

        btn.disabled = true;
        container.style.display = 'block';
        contentDiv.innerHTML = '<div style="text-align: center; padding: var(--spacing-16);"><i class="fa fa-spinner fa-spin fa-xxlarge" style="color: var(--color-deep-purple);"></i><p>Analizando...</p></div>';

        fetch('<?= $this->Url->build(['action' => 'executePrompt']) ?>/' + id, {
            method: 'POST',
            headers: {
                'X-CSRF-Token': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                if (!response.ok) throw new Error("Error en la petición");
                return response.text();
            })
            .then(textoMarkdown => {
                const htmlBonito = marked.parse(textoMarkdown);
                contentDiv.innerHTML = htmlBonito;
            })
            .catch(error => {
                console.error('Error:', error);
                contentDiv.innerHTML = '<div class="alert alert-danger">Error al consultar la IA.</div>';
            })
            .finally(() => {
                btn.disabled = false;
            });
    }
</script>