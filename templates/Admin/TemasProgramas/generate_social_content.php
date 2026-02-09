<div class="content">
    <div class="w3-deep-blue w3-padding">
        <h5>Generación de contenido social</h5>
    </div>

    <div class="w3-container w3">
        <p id="markdownTexto"></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
    const markdownTexto = `<?= $prompt ?>`;
    const html = marked.parse(markdownTexto);
    document.querySelector('#markdownTexto').innerHTML = html;
</script>