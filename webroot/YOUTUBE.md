# Especificación técnica — `Api/Youtube::playlist()` + vista

> Origen: Sistema SPC (CakePHP 5.3, PHP 8.4+, namespace `SPC`).
> Objetivo de este documento: permitir replicar la funcionalidad al 100% en otro proyecto,
> concretamente como shortcode de WordPress `[youtube playlist="XXXXXX"]` con el mismo render,
> usando PHP OOP PSR-4 + Vite para los assets.
> Endpoint REST recomendado para la réplica: `POST /wp-json/youtube/v1/playlist`.

---

## 1. Descripción general

El endpoint `GET /api/youtube/playlist?list={YouTubePlaylistID}` devuelve una **galería de videos embebida**:

- Un título con el nombre de la playlist de YouTube.
- Un reproductor principal 16:9 (YouTube IFrame Player API).
- Un subtítulo con el título del video activo + un párrafo con su descripción.
- Un carril (grid responsivo) de miniaturas (thumbnails). Clic en una miniatura cambia el video
  del reproductor principal sin recargar la página, actualiza título/descripción y marca la
  miniatura como activa.

No requiere autenticación (prefijo `Api/` sin auth). No devuelve JSON: devuelve **HTML renderizado**
con layout propio `youtube` (página standalone, sin header/footer del sitio).

Ejemplo de uso documentado en el proyecto origen (`README.md:170`):

```text
GET /api/youtube/playlist?list={YouTubePlaylistID}
```

---

## 2. Archivos origen (referencia exacta)

| Pieza | Ruta en SPC | Notas |
|---|---|---|
| Controlador | `src/Controller/Api/YoutubeController.php:29` (`playlist(): Response`) | Hereda de `SPC\Controller\ApiController` (que a su vez hereda de `Cake\Controller\Controller`, **no** de `AppController`) |
| Base API | `src/Controller/ApiController.php` | Solo carga componente `Flash`. Sin auth, sin layout logic |
| Vista | `templates/Api/Youtube/playlist.php` (108 líneas) | Lógica de primer video + loop de thumbnails + JS inline |
| Layout | `templates/layout/youtube.php` (130 líneas) | HTML standalone + CSS inline, `<?= $this->fetch('content') ?>` |
| Ruta | `config/routes.php:27-28` | Prefijo `Api`, `setExtensions(['json'])`, catch-all `/{controller}/{action}` → resuelve `/api/youtube/playlist` |
| API key | `Configure::read('SensitiveData.YouTube.APIKey')` | Definida en `config/app_local.php` (no versionado), clave `SensitiveData.YouTube.APIKey` |
| Caché | `Cache::read/write(..., 'yt_rest_calls')` | **Hallazgo:** no existe definición `yt_rest_calls` en `config/app.php` ni `config/bootstrap.php`. CakePHP usa la config por defecto si falta. La réplica debe definir su propio TTL explícito (ver §5) |

---

## 3. Contrato actual (origen)

### 3.1 Request

```text
GET /api/youtube/playlist?list=PLxxxxxxxxxxxxxxxx
```

| Parámetro | Ubicación | Requerido | Validación origen | Comportamiento si falta |
|---|---|---|---|---|
| `list` | querystring | Sí | Solo verifica truthy (`if (!$playlistID)`) | Lanza `Cake\Http\Exception\NotFoundException('Identificador de lista no proporcionado.')` → 404 |

No hay validación de formato del ID. La réplica **sí debe validar**: `^[A-Za-z0-9_-]+$` (los IDs de playlist de YouTube cumplen esto).

### 3.2 Response (origen)

- `200 text/html`: layout `youtube` + vista `playlist` renderizados.
- `404`: si falta `list`.
- `200` con lista vacía (`<p>No se encontraron videos.</p>`) si la API falla y no hay caché, o si la playlist no existe / no es pública / cuota agotada.
- Nunca expone la API key al cliente. La key solo viaja server→Google.

### 3.3 Límite actual

- `maxResults = 20` fijo en `/playlistItems`. **Sin paginación** (no se usa `pageToken`).
- La réplica **debe agregar paginación de 20 en 20 vía AJAX** (ver §6, requisito obligatorio).

---

## 4. Flujo del controlador (paso a paso)

Archivo: `src/Controller/Api/YoutubeController.php`

```php
public function initialize(): void
{
    parent::initialize();
    $this->YoutubeAPIKey = Configure::read('SensitiveData.YouTube.APIKey');
}

public function playlist(): Response
{
    $playlistID = $this->request->getQuery('list');
    if (!$playlistID) {
        throw new NotFoundException(__('Identificador de lista no proporcionado.'));
    }

    $cacheKeyMeta  = 'yt_playlist_meta_' . $playlistID;
    $cacheKeyItems = 'yt_playlist_items_' . $playlistID;

    $cachedMeta  = Cache::read($cacheKeyMeta, 'yt_rest_calls');
    $cachedItems = Cache::read($cacheKeyItems, 'yt_rest_calls');

    $playlistTitle = $cachedMeta['title'] ?? '';
    $playlistItems = $cachedItems['items'] ?? [];

    try {
        $youtube = new Client([
            'scheme'   => 'https',
            'host'     => 'www.googleapis.com',
            'basePath' => 'youtube/v3',
        ]);

        // 1. Metadatos: título + ETag
        $metaHeaders = [];
        if (!empty($cachedMeta['etag'])) {
            $metaHeaders['If-None-Match'] = $cachedMeta['etag'];
        }
        $metaResponse = $youtube->get('/playlists', [
            'id'   => $playlistID,
            'part' => 'snippet',
            'key'  => $this->YoutubeAPIKey,
        ], ['headers' => $metaHeaders]);

        if ($metaResponse->isOk()) {
            $metaJson = json_decode($metaResponse->getStringBody());
            if (!empty($metaJson->items)) {
                $playlistTitle = $metaJson->items[0]->snippet->title;
                Cache::write($cacheKeyMeta, [
                    'title' => $playlistTitle,
                    'etag'  => $metaJson->etag ?? '',
                ], 'yt_rest_calls');
            }
        }
        // Nota: si Google responde 304 (Not Modified), isOk() es false
        // y se conserva el título cacheado. Correcto.

        // 2. Items: videos
        $itemsHeaders = [];
        if (!empty($cachedItems['etag'])) {
            $itemsHeaders['If-None-Match'] = $cachedItems['etag'];
        }
        $itemsResponse = $youtube->get('/playlistItems', [
            'playlistId' => $playlistID,
            'part'       => 'snippet',
            'maxResults' => 20,
            'key'        => $this->YoutubeAPIKey,
        ], ['headers' => $itemsHeaders]);

        if ($itemsResponse->isOk()) {
            $itemsJson = json_decode($itemsResponse->getStringBody());
            $playlistItems = $itemsJson->items ?? [];
            Cache::write($cacheKeyItems, [
                'items' => $playlistItems,
                'etag'  => $itemsJson->etag ?? '',
            ], 'yt_rest_calls');
        }
    } catch (NetworkException $e) {
        $this->Flash->error('Error de conexión a la API de YouTube: ' . $e->getMessage());
    }

    $this->set(compact('playlistItems', 'playlistTitle'));
    $this->viewBuilder()->setLayout('youtube');

    return $this->render();
}
```

Orden de precedencia del dato mostrado:

1. Si la API responde `200`, se usa el dato fresco y se refresca caché.
2. Si responde `304` / error HTTP / excepción de red, se usa lo cacheado.
3. Si no hay caché, se muestra título vacío + “No se encontraron videos.”

---

## 5. Contratos YouTube Data API v3 (lo que la réplica debe llamar)

Base: `https://www.googleapis.com/youtube/v3`

### 5.1 `GET /playlists` (título)

```text
GET /youtube/v3/playlists?id={playlistId}&part=snippet&key={API_KEY}
```

Respuesta mínima relevante:

```json
{
  "etag": "\"abc123\"",
  "items": [{ "snippet": { "title": "Nombre de la playlist" } }]
}
```

- Enviar `If-None-Match: {etag_guardado}` para ahorrar cuota. `304` = conservar caché.

### 5.2 `GET /playlistItems` (videos, paginado)

```text
GET /youtube/v3/playlistItems?playlistId={id}&part=snippet&maxResults=20&key={API_KEY}&pageToken={token_opcional}
```

Respuesta mínima relevante por item:

```json
{
  "etag": "\"xyz\"",
  "nextPageToken": "CAUQAA",
  "prevPageToken": "CAUQAA",
  "items": [
    {
      "snippet": {
        "title": "Título del video",
        "description": "Descripción",
        "resourceId": { "videoId": "dQw4w9WgXcQ" },
        "thumbnails": {
          "default": { "url": "https://i.ytimg.com/vi/.../default.jpg" },
          "medium":  { "url": "https://i.ytimg.com/vi/.../mqdefault.jpg" }
        }
      }
    }
  ]
}
```

Campos que usa la vista:

- `snippet.resourceId.videoId` → reproductor + `data-video-id`
- `snippet.title` → subtítulo + `data-video-title` + `alt` + `.thumb-title`
- `snippet.description` → párrafo + `data-video-desc`
- `snippet.thumbnails.medium.url` (fallback a `default.url`) → `<img src>`
- Índice en el arreglo + 1 → `data-video-episode` (número de episodio)

`nextPageToken` / `prevPageToken` son **opacos**: se reenvían tal cual, no se parsean ni se confía en ellos para auth.

---

## 6. Requisito obligatorio: paginación cada 20 videos vía AJAX (WordPress)

El origen no pagina. La réplica **debe** paginar de 20 en 20 sin recargar la página.

### 6.1 UX especificada

- El shortcode pinta la **página 1 en server-side** (SEO + no-JS degradado).
- Debajo del grid, barra de paginación:

```html
<div class="yt-pager">
  <button type="button" class="yt-prev" disabled>← Anteriores</button>
  <span class="yt-page-info">Página 1</span>
  <button type="button" class="yt-next">Siguientes →</button>
</div>
```

- Reglas:
  - `maxResults = 20` siempre.
  - Si no hay `nextPageToken`, el botón Siguientes se deshabilita/oculta. Igual con Prev.
  - Al cambiar de página: estado `loading` (spinner o skeleton), swap del `.thumbnails-track`, actualización de tokens y del contador de página, y `scrollIntoView` suave al `.main-stage` (igual que el origen al cambiar de video).
  - El `YT.Player` existente se reutiliza: tras cargar nueva página se hace `loadVideoById` del primer video de esa página y se actualizan título/descripción. No se destruye el player.
  - Thumbs con `loading="lazy"`.

### 6.2 Transporte: REST (recomendado, no `admin-ajax.php`)

```text
POST /wp-json/youtube/v1/playlist
Content-Type: application/json
X-WP-Nonce: {wp_rest_nonce}
```

Body:

```json
{
  "playlistId": "PLxxxxxxxxxxxxxxxx",
  "pageToken": "CAUQAA",
  "direction": "next"
}
```

- `playlistId`: requerido, validado `^[A-Za-z0-9_-]{10,64}$` (ajustar longitud según necesidad).
- `pageToken`: opcional, string opaco de YouTube (máx. 512 chars, charset `[A-Za-z0-9_=-]`). Se reenvía tal cual a Google. Nunca se usa como clave de auth.
- `direction`: informativo (`next|prev|first`), el token es la fuente de verdad.

Respuesta:

```json
{
  "title": "Nombre de la playlist",
  "html": "<div class=\"video-thumb\" ...>...</div>...",
  "nextPageToken": "CAUQAA",
  "prevPageToken": null,
  "page": 2
}
```

Errores JSON con `code` + `message`:

| Caso | HTTP | `code` |
|---|---|---|
| Nonce inválido | 403 | `rest_forbidden` (manejado por WP) |
| `playlistId` inválido | 400 | `yt_invalid_playlist` |
| Playlist no encontrada / no pública | 404 | `yt_not_found` |
| Cuota YouTube agotada (`quotaExceeded`) | 429 | `yt_quota_exceeded` (devolver caché si existe) |
| `pageToken` inválido/expirado (`invalidPageToken`) | 400 | `yt_invalid_token` → el cliente reintenta con página 1 |

Registro WP (ejemplo):

```php
add_action('rest_api_init', function (): void {
    register_rest_route('youtube/v1', '/playlist', [
        'methods'             => 'POST',
        'callback'            => [YoutubePlaylistController::class, 'page'],
        'permission_callback' => function () {
            return wp_verify_nonce(
                $_SERVER['HTTP_X_WP_NONCE'] ?? '',
                'wp_rest'
            ) !== false;
        },
        'args' => [
            'playlistId' => ['required' => true, 'type' => 'string'],
            'pageToken'  => ['required' => false, 'type' => 'string'],
        ],
    ]);
});
```

> Si se prefiere `admin-ajax.php`: acción `wp_ajax_yt_playlist_page` + `wp_ajax_nopriv_yt_playlist_page`,
> con `check_ajax_referer('yt_playlist', 'nonce')`. El contrato de datos es idéntico.

### 6.3 Caché con tokens (transients)

Clave por combinación playlist + token:

```text
yt:{playlistId}:meta            → ['title', 'etag']            TTL 6h
yt:{playlistId}:{pageToken|first} → ['html_items|items', 'etag', 'next', 'prev']  TTL 1h
```

- Request a Google lleva `If-None-Match: {etag}` cuando hay ETag guardado.
- `304` = servir transient y extender TTL.
- `quotaExceeded` = servir transient aunque esté expirado (stale-while-revalidate casero) + mensaje visible discreto.

### 6.4 Seguridad (no negociable)

- La **API key jamás sale al navegador**. Solo el `pageToken` opaco viaja cliente↔WP, y WP↔Google lleva la key.
- Sanitizar/escapar todo lo que venga de YouTube antes de imprimir:
  `esc_attr()` para atributos, `esc_html()` para títulos, `esc_url()` para thumbs, `wp_kses_post()` si se permite HTML en descripciones (recomendado: texto plano con `esc_html` + `nl2br`).
- Nonce en cada request AJAX. Rate-limit básico (transient por IP, p. ej. 60 req/min).
- `pageToken` se valida por charset/longitud antes de reenviarlo.

---

## 7. Vista (DOM exacto a replicar)

Variables que recibe la plantilla: `$playlistTitle` (string), `$playlistItems` (array de objetos como §5.2).

Estructura (de `templates/Api/Youtube/playlist.php`):

```html
<h2 class="title">Nombre de la playlist</h2>

<div class="main-stage">
  <div id="yt-player"></div>
</div>
<h3 class="subtitle" id="video-title">Título del primer video</h3>
<p id="video-desc">Descripción del primer video</p>

<div class="thumbnails-track">
  <div class="video-thumb active"
       data-video-id="VIDEO_ID"
       data-video-title="Título"
       data-video-desc="Descripción"
       data-video-episode="1"
       onclick="changeVideo(this)">
    <img src="https://i.ytimg.com/vi/.../mqdefault.jpg" alt="Título" loading="lazy">
    <div class="thumb-overlay"><span class="play-icon">▶</span></div>
    <div class="thumb-title">Título</div>
  </div>
  <!-- ... resto de items, solo el primero con .active ... -->
</div>
```

Comportamiento JS original (a migrar a `src/js/youtube-playlist.js` vía Vite):

```js
// Carga asíncrona de la IFrame API
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
var initialVideoId = "VIDEO_ID_DEL_PRIMER_ITEM";

function onYouTubeIframeAPIReady() {
  if (!initialVideoId) return;
  player = new YT.Player('yt-player', {
    height: '100%',
    width: '100%',
    videoId: initialVideoId,
    playerVars: { rel: 0, modestbranding: 1 }
  });
}

function changeVideo(element) {
  let videoId = element.getAttribute('data-video-id');
  // ... actualiza #video-title, #video-desc, mueve .active ...
  if (player && typeof player.loadVideoById === 'function') {
    player.loadVideoById(videoId);
  }
  document.querySelector('.main-stage').scrollIntoView({ behavior: 'smooth', block: 'start' });
}
```

### 7.1 Bugs del origen (documentados, corregir en réplica)

1. `templates/Api/Youtube/playlist.php:17`: `<h3 ...><?= $firstVideoTitle ?></span></h3>` — `</span>` sobrante. Réplica: `<h3 class="subtitle" id="video-title">…</h3>` limpio.
2. Línea 94-96: `episode.textContent = videoEpisode` usa variable inexistente; debe ser `episodeElement.textContent`. Además no existe elemento `#episode` en el DOM — la réplica puede agregar `<span id="episode">` o eliminar el bloque.
3. Sin escapado HTML en atributos/texto. Réplica: escapar siempre (§6.4).
4. `thumbUrl` asume que existe `thumbnails->default`. Réplica: fallback a `https://i.ytimg.com/vi/{videoId}/hqdefault.jpg` si no hay thumbs.
5. Variables `$firstVideoTitle` / `$description` indefinidas cuando la lista está vacía (solo `$firstVideoId = ''`). Réplica: inicializar las tres.

---

## 8. Layout / CSS (paridad visual)

De `templates/layout/youtube.php` (CSS inline → migrar a `src/css/youtube-playlist.css`):

- Contenedor: `.video-gallery-container { max-width: 1000px; margin: 0 auto; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }`
- Player: `.main-stage { position: relative; padding-bottom: 56.25%; height: 0; background: #000; margin-bottom: 20px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }` + iframe absoluto 100%.
- Grid: `.thumbnails-track { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px; }`
- Thumb: `.video-thumb { cursor: pointer; position: relative; border-radius: 8px; overflow: hidden; aspect-ratio: 16/9; border: 2px solid transparent; transition: all .3s ease; }`, `img { width:100%; height:100%; object-fit: cover; }`
- Hover: `translateY(-5px)` + sombra. Activo: `border-color: #ff0000; opacity: .6; pointer-events: none;`
- Overlay play: fondo `rgba(0,0,0,.4)`, icono `▶` 30px blanco, aparece en hover.
- Título thumb: gradiente inferior, ellipsis 1 línea.
- `.title { color:#333; font-size:1.8em; border-bottom:2px solid #ff0000; }`, `#video-desc { margin-bottom:32px; padding:16px; border-bottom:2px solid #ff0000; }`
- Agregar para paginación: `.yt-pager { display:flex; gap:12px; align-items:center; justify-content:center; margin:20px 0; }`, `.yt-pager button:disabled { opacity:.4; cursor:not-allowed; }`, `.yt-loading { opacity:.5; pointer-events:none; }`.

---

## 9. Mapeo a WordPress (PSR-4 OOP + Vite)

Estructura sugerida del plugin/módulo:

```text
youtube-playlist/
  plugin.php                  ← bootstrap, define shortcode, REST route, enqueue
  composer.json               ← PSR-4: "YoutubePlaylist\\": "src/"
  src/
    Shortcode/YouTubePlaylistShortcode.php  ← [youtube playlist="ID"], render inicial
    Service/YouTubePlaylistService.php      ← llamadas a Google + ETag + pageToken
    Cache/TransientCache.php                ← wrapper transients (get/set con TTL)
    View/PlaylistRenderer.php               ← genera HTML de título + thumbs + pager
    Http/PlaylistRestController.php         ← callback REST, validación, nonces
    Config/Settings.php                     ← register_setting('yt_api_key'), página admin
  assets/
    js/youtube-playlist.js    ← fuente Vite (player + changeVideo + pager AJAX)
    css/youtube-playlist.css  ← fuente Vite (paridad §8 + pager)
  dist/                       ← build Vite (lo que se encola con wp_enqueue_*)
  vite.config.js
```

Shortcode:

```php
// [youtube playlist="PLxxxx"]
public function render(array $atts): string
{
    $id = sanitize_text_field($atts['playlist'] ?? '');
    if (!preg_match('/^[A-Za-z0-9_-]+$/', $id)) {
        return '<p>No se encontraron videos.</p>';
    }
    $page = $this->service->getFirstPage($id); // ['title','items','next','prev']
    return $this->renderer->render($id, $page);
}
```

Enqueue (solo cuando hay shortcode en el contenido):

```php
wp_enqueue_style('yt-playlist', plugins_url('dist/youtube-playlist.css', __FILE__), [], '1.0.0');
wp_enqueue_script('yt-playlist', plugins_url('dist/youtube-playlist.js', __FILE__), [], '1.0.0', true);
wp_localize_script('yt-playlist', 'YT_PLAYLIST', [
    'restUrl' => esc_url_raw(rest_url('youtube/v1/playlist')),
    'nonce'   => wp_create_nonce('wp_rest'),
]);
```

JS Vite (resumen, ver §6-7): un módulo por shortcode instanciado (soportar N shortcodes por página con scopes por `data-mount-id`), IFrame API cargada una sola vez, `fetch` con `X-WP-Nonce`, swap + tokens + contador.

---

## 10. Casos borde y criterios de aceptación

- [ ] `playlist` vacío/ausente → “No se encontraron videos.” (origen: 404; shortcode: mensaje inline, no romper página).
- [ ] Playlist inexistente / privada / ID inválido → mensaje + `400/404` en AJAX.
- [ ] Playlist con < 20 videos → sin paginador visible.
- [ ] Playlist con > 20 → Prev/Next funcionales vía AJAX, tokens rotando correctamente, sin recarga.
- [ ] Sin JS → página 1 visible y player carga (degradado del origen).
- [ ] Cuota agotada → muestra caché + aviso discreto, no pantalla blanca.
- [ ] N shortcodes en la misma página no colisionan (scopes + un solo `YT.Player` por mount).
- [ ] Sin API key expuesta en HTML/JS/red (auditar `view-source` + DevTools Network).
- [ ] Paridad visual con layout origen (screenshots lado a lado).

---

## 11. Lo que explícitamente NO se replica

- Componente `Flash` de CakePHP (solo para errores server-side del admin; en WP usar `WP_Error`/JSON).
- Layout admin de SPC ni su sistema de permisos/temas.
- `setExtensions(['json'])` del prefijo Api (el shortcode devuelve HTML; el AJAX devuelve JSON propio).

---

*Fin de la especificación. Fuente verificada contra `src/Controller/Api/YoutubeController.php`, `templates/Api/Youtube/playlist.php` y `templates/layout/youtube.php` del repo SPC.*
