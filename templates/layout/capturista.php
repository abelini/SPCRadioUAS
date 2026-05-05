<!DOCTYPE html>
<html lang="es">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $AppName ?></title>
    <?= $this->Html->meta('favicon.png', 'https://radio.uas.edu.mx/wp-content/uploads/2020/06/cropped-RADIOUAS-LOGO-IOS-32x32.png', ['type' => 'icon']) ?>

    <?php $theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'midday'; ?>
    <?php if ($theme === 'midnight'): ?>
        <?= $this->Html->css('github-midnight') ?>
    <?php else: ?>
        <?= $this->Html->css('github-midday') ?>
    <?php endif; ?>

    <?= $this->Html->script('jquery-3.7.1') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
    <div class="admin-layout">
        <nav class="admin-sidebar w3-collapse" id="menu">
            <div class="admin-sidebar-header">
                <?= $this->Html->image('https://radio.uas.edu.mx/wp-content/images/logo.webp', ['alt' => 'Logo']) ?>
            </div>

            <div class="admin-sidebar-header">
                <span class="title"><?= $this->Html->link($AppName, ['controller' => 'dashboard']) ?></span>
            </div>

            <div class="admin-sidebar-nav">
                <?= $this->Html->link('<i class="fa-solid fa-microphone-lines"></i> Roles de Cabina', ['controller' => 'roles'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-regular fa-folder-open"></i> Solicitudes', ['controller' => 'solicitudes'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-regular fa-clock"></i> Horas extras', ['controller' => 'locutores', 'action' => 'horas_extras'], ['escape' => false]) ?>

                <a href="#" class="theme-toggle-btn" onclick="toggleTheme()">
                    <i class="fa-solid fa-moon"></i> <span>Modo oscuro</span>
                </a>

                <?= $this->Html->link('<i class="fa-solid fa-right-from-bracket"></i> Salir', ['controller' => 'usuarios', 'action' => 'logout'], ['class' => 'nav-logout', 'escape' => false]) ?>
            </div>
        </nav>

        <main class="admin-main">
            <header class="admin-header">
                <button class="mobile-menu-btn" onclick="w3_open()">
                    <i class="fa-solid fa-bars"></i>
                </button>
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
        function w3_open() {
            document.getElementById("menu").classList.add("open");
        }

        function w3_close() {
            document.getElementById("menu").classList.remove("open");
        }

        function toggleTheme() {
            var currentTheme = '<?= $theme ?>';
            var newTheme = currentTheme === 'midday' ? 'midnight' : 'midday';
            var expires = new Date();
            expires.setFullYear(expires.getFullYear() + 1);
            document.cookie = 'theme=' + newTheme + ';expires=' + expires.toUTCString() + ';path=/';
            location.reload();
        }

        function updateToggleText() {
            var currentTheme = '<?= $theme ?>';
            var btn = document.querySelector('.theme-toggle-btn');
            var icon = btn.querySelector('i');
            var span = btn.querySelector('span');
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