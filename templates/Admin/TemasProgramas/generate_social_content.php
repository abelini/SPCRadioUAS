<div class="page-header">
    <h5><i class="fa-solid fa-share-nodes"></i> Generación de contenido social</h5>
</div>

<div class="content-card">
    <div id="markdownTexto" class="markdown-content"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
    const markdownTexto = <?= json_encode($prompt, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) ?>;
    const html = marked.parse(markdownTexto);
    document.querySelector('#markdownTexto').innerHTML = html;

    const copyBtn = document.getElementById('copy-prompt-btn');
    const promptEl = document.getElementById('prompt-fallback-text');
    if (copyBtn && promptEl) {
        copyBtn.addEventListener('click', () => {
            navigator.clipboard.writeText(promptEl.value).then(() => {
                copyBtn.innerHTML = '<i class="fa-solid fa-check"></i> Copiado';
            });
        });
    }
</script>