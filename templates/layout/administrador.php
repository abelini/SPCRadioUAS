<!DOCTYPE html>
<html lang="es">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $AppName ?></title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('github-' . $this->request->getCookie('Theme', 'midday')) ?>

    <?= $this->Html->script('jquery-3.7.1') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
    <div class="admin-layout">
        <nav class="admin-sidebar" id="menu">
            <div class="admin-sidebar-header">
                <?= $this->Html->image($AppLogo, ['alt' => 'Logo']) ?>
            </div>

            <div class="admin-sidebar-header">
                <span class="title"><?= $this->Html->link($AppName, ['controller' => 'dashboard']) ?></span>
            </div>

            <div class="admin-sidebar-nav">
                <?= $this->Html->link('<i class="fa-solid fa-microphone-lines"></i> Roles de Cabina', ['controller' => 'roles'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-regular fa-folder-open"></i> Solicitudes', ['controller' => 'solicitudes'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-regular fa-clock"></i> Horas extras', ['controller' => 'locutores', 'action' => 'horas_extras'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-radio"></i> Programas', ['controller' => 'programas'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-file-contract"></i> Bitácora de cabina', ['controller' => 'bitacora_cabina'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-file-signature"></i> Registro de incidencias', ['controller' => 'incidencias'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-chart-pie"></i> Reportes de cabina', ['controller' => 'reportes_cabinas', 'action' => 'reportes'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-users"></i> Usuarios', ['controller' => 'usuarios'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-align-left"></i> Temas de programas', ['controller' => 'TemasProgramas', 'action' => 'index'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-align-left"></i> Categorías de programas', ['controller' => 'CategoriasProgramas', 'action' => 'index'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-tv"></i> Control de Streaming', ['controller' => 'stream'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-chart-simple"></i> Uso de streaming', ['controller' => 'StreamHits', 'action' => 'index'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-closed-captioning"></i> Monitor RDS', ['controller' => 'Rds'], ['escape' => false]) ?>

                <a href="#" class="theme-toggle-btn" onclick="toggleTheme()">
                    <i class="fa-solid fa-moon"></i> <span>Modo oscuro</span>
                </a>

                <?= $this->Html->link('<i class="fa-solid fa-right-from-bracket"></i> Salir', ['controller' => 'usuarios', 'action' => 'logout'], ['class' => 'nav-logout', 'escape' => false]) ?>

                <div class="admin-sidebar-footer">
                    <p>SPC v<?= $AppVersion ?></p>
                </div>
            </div>
        </nav>

        <main class="admin-main">
            <header class="admin-header">
                <p class="admin-header-user">
                    <i class="fa-solid fa-circle-user"></i>
                    <?= $this->Html->link($user->name, ['controller' => 'Usuarios', 'action' => 'profile']) ?>
                </p>
            </header>

            <div class="admin-content">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>

            <footer class="admin-footer">
                <p>Dirección de Radio Universidad Autónoma de Sinaloa &copy; <?= $datetime->format('Y') ?></p>
            </footer>
        </main>
    </div>

    <script src="https://kit.fontawesome.com/18176e4df9.js" crossorigin="anonymous"></script>
    <script>
        function toggleTheme() {
            const currentTheme = '<?= $this->request->getCookie('Theme', 'midday') ?>';
            const newTheme = currentTheme === 'midday' ? 'midnight' : 'midday';
            const formData = new FormData();
            formData.append('theme', newTheme);
            formData.append('_csrfToken', '<?= $this->request->getAttribute('csrfToken') ?>');
            fetch('<?= $this->Url->build(['controller' => 'Usuarios', 'action' => 'setTheme']) ?>', {
                method: 'POST',
                body: formData
            }).then((response) => location.reload());
        }

        function updateToggleText() {
            const currentTheme = '<?= $this->request->getCookie('Theme', 'midday') ?>';
            const btn = document.querySelector('.theme-toggle-btn');
            const icon = btn.querySelector('i');
            const span = btn.querySelector('span');
            if (currentTheme === 'midnight') {
                icon.className = 'fa-solid fa-sun';
                span.textContent = 'Modo claro';
            } else {
                icon.className = 'fa-solid fa-moon';
                span.textContent = 'Modo oscuro';
            }
        }
        updateToggleText();
    </script>
</body>

</html>