<div class="page-header">
    <h5><i class="fa-solid fa-share-nodes"></i> Generación de contenido social</h5>
</div>

<div class="content-card">
    <div id="markdownTexto" style="color: var(--color-faded-silver);"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
    const markdownTexto = `<?= $prompt ?>`;
    const html = marked.parse(markdownTexto);
    document.querySelector('#markdownTexto').innerHTML = html;
</script>