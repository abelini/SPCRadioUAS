<div class="page-header">
    <h5><i class="fa-solid fa-magnifying-glass"></i> Buscar solicitudes</h5>
</div>

<div class="content-card" id="search-container">
    <?= $this->Form->create(null, ['type' => 'GET', 'id' => 'search-form']) ?>
    <div style="display: flex; gap: var(--spacing-12); align-items: flex-end;">
        <div class="form-group" style="flex: 1; margin-bottom: 0;">
            <?= $this->Form->text('q', [
                'value' => $q,
                'placeholder' => 'Buscar por solicitante o evento...',
                'class' => 'form-control',
                'id' => 'search-input',
                'autofocus' => true,
            ]) ?>
        </div>
        <?= $this->Form->button('<i class="fa-solid fa-magnifying-glass"></i> Buscar', ['class' => 'btn btn-primary', 'escapeTitle' => false]) ?>
    </div>
    <?= $this->Form->end() ?>

    <div id="search-results" style="margin-top: var(--spacing-24);">
        <?php if (strlen($q) > 0): ?>
            <?= $this->element('Solicitudes/search_results') ?>
        <?php endif; ?>
    </div>
</div>

<script>
    const CSRF = '<?= $this->request->getAttribute('csrfToken') ?>';
    const SEARCH_URL = '<?= $this->Url->build(['action' => 'search']) ?>';

    document.getElementById('search-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        await loadSearch();
    });

    document.getElementById('search-input').addEventListener('keyup', function (e) {
        if (e.key === 'Escape') {
            this.value = '';
            sessionStorage.removeItem('searchQuery');
            document.getElementById('search-results').innerHTML = '';
        }
    });

    document.getElementById('search-results').addEventListener('click', async function (e) {
        const link = e.target.closest('.pagination a');
        if (link) {
            e.preventDefault();
            const resp = await fetch(link.getAttribute('href'), {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-Token': CSRF }
            });
            if (resp.ok) {
                document.getElementById('search-results').innerHTML = await resp.text();
                const q = document.getElementById('search-input').value;
                sessionStorage.setItem('searchQuery', q);
                history.replaceState({ q }, '', SEARCH_URL + '?q=' + encodeURIComponent(q));
            }
        }
    });

    async function loadSearch() {
        const q = document.getElementById('search-input').value.trim();
        if (q.length === 0) return;

        sessionStorage.setItem('searchQuery', q);
        const resp = await fetch(SEARCH_URL + '?q=' + encodeURIComponent(q), {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-Token': CSRF }
        });
        if (resp.ok) {
            document.getElementById('search-results').innerHTML = await resp.text();
            history.replaceState({ q }, '', SEARCH_URL + '?q=' + encodeURIComponent(q));
        }
    }

    (function () {
        const saved = sessionStorage.getItem('searchQuery');
        if (saved && !document.getElementById('search-input').value) {
            document.getElementById('search-input').value = saved;
            loadSearch();
        }
        sessionStorage.removeItem('searchQuery');
    })();
</script>