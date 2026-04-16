<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Monitor de Stream');
?>

<style>
    .stream-container {
        max-width: 800px;
        margin: 2rem auto;
        text-align: center;
        font-family: sans-serif;
    }

    .video-wrapper {
        margin-bottom: 2rem;
        background: #000;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-reset {
        background-color: #d35400;
        color: white;
        border: none;
        padding: 15px 30px;
        font-size: 18px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-reset:hover {
        background-color: #e67e22;
    }

    .btn-reset:disabled {
        background-color: #bdc3c7;
        cursor: not-allowed;
        opacity: 0.7;
    }

    #status-message {
        margin-top: 20px;
        font-weight: bold;
        font-size: 16px;
        min-height: 24px;
    }
</style>

<div class="stream-container">
    <h3>Monitor de Transmisión</h3>

    <div class="video-wrapper">
        <video id="video-player" controls autoplay muted playsinline style="width: 100%; display: block;"></video>
    </div>

    <button id="btn-reset" onclick="startResetCycle()" class="btn-reset">
        ⚠️ RESTABLECER SERVICIO
    </button>

    <div id="status-message"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

<script>
    // --- CONFIGURACIÓN DE URLS DESDE CAKEPHP ---
    // Generamos las URLs dinámicamente usando el Router de CakePHP
    const apiUrls = {
        stop: "<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Stream', 'action' => 'proxyStop']) ?>",
        restart: "<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Stream', 'action' => 'proxyRestart']) ?>",
        check: "<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Stream', 'action' => 'checkStreamStatus']) ?>"
    };

    document.addEventListener('DOMContentLoaded', function () {
        const video = document.getElementById('video-player');
        const videoSrc = 'https://stream.radiouas.org/?format=hls&ref=SPC%20Monitor'
        //const videoSrc = 'https://stream8.mexiserver.com:2000/hls/radiouasx/radiouasx.m3u8';
        const statusDiv = document.getElementById('status-message');
        const btnReset = document.getElementById('btn-reset');

        // --- LÓGICA DEL REPRODUCTOR ---
        function loadAndPlayVideo() {
            if (Hls.isSupported()) {
                const hls = new Hls();
                hls.loadSource(videoSrc);
                hls.attachMedia(video);
                hls.on(Hls.Events.MANIFEST_PARSED, function () {
                    video.play().catch(e => console.log("Autoplay requiere interacción del usuario."));
                });

                hls.on(Hls.Events.ERROR, function (event, data) {
                    if (data.fatal) {
                        hls.destroy();
                    }
                });
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                video.src = videoSrc;
                video.addEventListener('loadedmetadata', function () {
                    video.play();
                });
            }
        }

        // Autoplay al cargar
        updateStatus("Cargando reproductor...", "#7f8c8d");
        loadAndPlayVideo();

        // --- LÓGICA DEL BOTÓN RESTABLECER ---
        const wait = (ms) => new Promise(resolve => setTimeout(resolve, ms));

        window.startResetCycle = async function () {
            btnReset.disabled = true;
            btnReset.innerText = "Procesando...";

            // Detener reproductor local
            video.pause();
            video.removeAttribute('src');
            video.load();

            try {
                // 2. STOP SERVICE (Usando la variable apiUrls.stop)
                updateStatus("⏹ Enviando orden de detención...", "#c0392b");
                let stopRes = await fetch(apiUrls.stop).then(r => r.json());

                if (stopRes.status !== 'success') throw new Error(stopRes.message);
                updateStatus("✅ Servicio detenido. Esperando 10 segundos...", "#e67e22");

                // 3. ESPERA 10s
                await wait(10000);

                // 4. RESTART SERVICE (Usando la variable apiUrls.restart)
                updateStatus("🔄 Enviando orden de reinicio...", "#2980b9");
                let startRes = await fetch(apiUrls.restart).then(r => r.json());

                if (startRes.status !== 'success') throw new Error(startRes.message);
                updateStatus("✅ Servicio reiniciado. Esperando 10 segundos para estabilizar...", "#e67e22");

                // 5. ESPERA 10s
                await wait(10000);

                // 6. BUSCAR SEÑAL
                updateStatus("📡 Buscando señal de video...", "#8e44ad");
                checkStreamAndPlay();

            } catch (error) {
                console.error(error);
                updateStatus("❌ Error: " + error.message, "red");
                resetButtonState();
            }
        };

        function checkStreamAndPlay() {
            // Usando la variable apiUrls.check
            fetch(apiUrls.check)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'online') {
                        updateStatus("✅ ¡Señal recuperada! Reproduciendo.", "#27ae60");
                        loadAndPlayVideo();
                        resetButtonState();
                    } else {
                        console.log("Stream offline... reintentando en 2s");
                        setTimeout(checkStreamAndPlay, 2000);
                    }
                })
                .catch(() => {
                    setTimeout(checkStreamAndPlay, 2000);
                });
        }

        function updateStatus(msg, color) {
            statusDiv.innerText = msg;
            statusDiv.style.color = color;
        }

        function resetButtonState() {
            btnReset.disabled = false;
            btnReset.innerText = "⚠️ RESTABLECER SERVICIO";
        }
    });
</script>