# Sistema de Producción y Cabina

<img src="https://radio.uas.edu.mx/wp-content/media/logo.png" alt="Radio UAS" style="display:block;margin:auto;width:30%;display:block;">

<p align="center">
  <img src="https://img.shields.io/badge/CakePHP-5.3-red?logo=cakephp" alt="CakePHP 5.3">
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?logo=php" alt="PHP 8.4">
  <img src="https://img.shields.io/badge/uso-interno-lightgrey" alt="Uso interno">
</p>

Sistema web interno de Radio Universidad Autónoma de Sinaloa para la gestión operativa de cabina: roles de transmisión, programación, personal, reportes de cumplimiento e incidencias. Construido sobre **CakePHP 5.3** y **PHP 8.4**.

---

## Índice

- [Características](#características)
- [Módulos del sistema](#módulos-del-sistema)
- [REST API](#rest-api)
- [Integraciones externas](#integraciones-externas)
- [Stack técnico](#stack-técnico)
- [Instalación](#instalación)
- [Configuración](#configuración)
- [Sistema de layouts y tema](#sistema-de-layouts-y-tema)
- [Comandos de consola](#comandos-de-consola)
- [Testing y calidad](#testing-y-calidad)

---

## Características

- Gestión completa del ciclo operativo de cabina: roles, asignaciones, programas y reportes
- Panel administrativo con control de acceso por roles y permisos granulares
- Generación y envío automático de roles de cabina en PDF por correo electrónico
- REST API para consumo desde la web de Radio UAS y la aplicación móvil
- Generación de contenido para redes sociales asistida por IA (Google Gemini)
- Visualización de comentarios de Facebook en transmisiones en vivo
- Control del servidor de streaming (MediaCP) desde la interfaz web
- Fonoteca virtual integrada vía Emby
- Transmisión de metadatos NowPlaying a SHOUTcast y encoder RDS (RDi20)
- Renovación automática de certificados SSL vía acme.sh + cPanel DNS-01
- Reportes de incidencias de vigilancia
- Estadísticas de audiencia del streaming
- Tema claro/oscuro intercambiable

---

## Módulos del sistema

### Roles de cabina
Administración semanal de turnos de operadores. Genera una vista pública, un PDF descargable y envía el rol por correo electrónico a todos los locutores al publicarse.

### Programas radiofónicos
CRUD completo de la parrilla de programación. Cada programa tiene categoría, días de transmisión, horario, conductor(es), productor(es) y un tema semanal actualizable. Soporta programas fuera del aire (`outOfAir`) que se ocultan automáticamente en todas las vistas públicas.

### Asignaciones
Asignación de locutores a días y horarios dentro de un rol. Administra múltiples asignados por turno (primer asignado, segundo asignado, productor técnico, autorizante).

### Bitácora de cabina
Registro diario de la operación de cabina. Cada entrada agrupa los reportes de los programas transmitidos en esa fecha.

### Reportes de programas
Control de cumplimiento por programa: estados `V` (en vivo), `G` (grabado), `S` (suspendido) y `X` (ausencia). Genera reportes por periodo con gráficas y cuenta de ausencias en texto (usando `NumberToWords`).

### Temas de programas
Gestión semanal de temas por programa. Incluye generación de contenido para redes sociales vía Google Gemini.

### Reportes de incidencias de vigilancia
Módulo independiente para el registro y consulta de incidencias del área de vigilancia.

### Personal (Locutores)
Alta, baja y modificación del personal operativo. Incluye foto, datos de contacto y vinculación con usuarios del sistema.

### Usuarios y permisos
Sistema de autenticación propio con permisos granulares por módulo. Cada usuario puede tener uno o varios permisos que habilitan o restringen el acceso a secciones del panel administrativo.

### Solicitudes
Módulo para el registro y seguimiento de solicitudes internas entre áreas.

### Stream
Panel de control del servidor de streaming (MediaCP). Permite verificar el estado del stream, detenerlo y reiniciarlo directamente desde la interfaz sin acceder al servidor externo.

### NowPlaying
Actualización en tiempo real de metadatos del programa actual hacia SHOUTcast (título de canción/nombre del programa) y encoder RDS (PS, RT, PTY) para datos de radio FM.

### Asistente IA
Interfaz interna para interactuar con Google Gemini. Permite generar prompts libres y también se usa de forma integrada en la generación de contenido para redes sociales.

### SSL/TLS
Panel de administración de certificados SSL. Muestra información del certificado actual (vigencia, emisor, SANs) y permite renovar automáticamente vía acme.sh con validación DNS-01 mediante cPanel UAPI. Descarga de archivos .pfx, .crt, .key y fullchain.

### Stream Hits
Estadísticas de audiencia del streaming con resúmenes, charts, top geo y datos recientes.

### RDS (RDi20)
Panel de monitoreo y control del encoder RDS. Permite ver el estado actual de los campos PS, RT, PTY y la conexión telnet al equipo.

### Actualizaciones (Updates)
Registro de cambios y actualizaciones del sistema visible desde el panel.

---

## REST API

La API es consumida principalmente por el sitio web de Radio UAS (`radio.uas.edu.mx`) y la aplicación móvil. Todas las rutas están bajo el prefijo `/api/`.

### Programación

```
GET /api/schedule/now
```
Devuelve el programa que está al aire en este momento. Soporta respuesta en `text/plain` (para equipos de cabina) o `application/json` (con `?format=json`). Si hay un *control remoto* activo, devuelve ese evento en lugar del programa regular.

```
GET /api/schedule/daily?day={1-7}
```
Devuelve la parrilla completa de un día de la semana. Soporta `?source=mobile-app` para adaptar los campos al formato de la app.

### RadioDNS

```
GET /radiodns/spi/3.1/SI.xml
GET /radiodns/spi/3.1/radiouas/{date}
```
Servicios de información de programa (SI/PI) para directorios de radio en línea (onlineradiobox.com). Formato XML RadioDNS EPG v10.

### Locutores

```
GET /api/locutores?ahora
```
Devuelve el operador asignado en el turno actual.

### Cabina

```
GET /api/cabina/social?type={live_show|live_broadcast}
```
Formulario AJAX para reportar un programa en vivo o una transmisión remota.

```
POST /api/cabina/generateSocialContent
```
Genera texto para redes sociales usando Google Gemini a partir de los datos del programa o evento. Si el tipo es `live_broadcast`, activa el *control remoto* que sobreescribe temporalmente el nombre del programa en `/api/schedule/now`.

```
GET /api/cabina/getComments
```
Obtiene los comentarios del video en vivo activo en Facebook (Graph API).

### Programas

```
GET /api/programas/list
GET /api/programas/get?id={id}
```
Listado y detalle de programas radiofónicos.

### Música (Fonoteca virtual — Emby)

```
GET /api/music/album?ID={EmbyItemID}
GET /api/music/artist?ID={EmbyItemID}
GET /api/music/playlist?ID={EmbyPlaylistID}
```

### YouTube

```
GET /api/youtube/playlist?list={YouTubePlaylistID}
```

### Metadata (NowPlaying)

```
POST /api/metadata/update
```
Endpoint interno para actualizar metadatos del stream. Autenticado con token compartido (`SensitiveData.Shoutcast.token`).

### Stream Hits

```
POST /api/hits/add
```
Registro de hits de audiencia del streaming.

---

## Integraciones externas

| Servicio | Uso |
|---|---|
| **Google Gemini** | Generación de contenido para redes sociales y asistente IA interno |
| **Facebook Graph API** | Comentarios en transmisiones en vivo |
| **MediaCP (MexiServer)** | Control del servidor de streaming HLS vía API REST |
| **SHOUTcast (DJ Protocol)** | Transmisión de metadatos NowPlaying (título, estación) vía admin.cgi |
| **RDi20 (RDS Encoder)** | Control del encoder RDS por TCP/Telnet para datos de radio FM (PS, RT, PTY) |
| **Emby** | Fonoteca virtual (álbumes, artistas, playlists) |
| **YouTube Data API** | Playlists públicas de Radio UAS |
| **Google SMTP (OAuth2)** | Envío de correos (roles de cabina, notificaciones de usuario) |
| **cPanel UAPI** | Gestión de registros DNS TXT para validación ACME DNS-01 |
| **Let's Encrypt** | Autoridad certificadora para renovación SSL vía acme.sh |

---

## Stack técnico

| Componente | Versión |
|---|---|
| PHP | ≥ 8.4 |
| CakePHP | ^5.3 |
| CakePHP Authentication | ^3.0 |
| CakePHP Migrations | ^4.0 |
| CakePDF (FriendsOfCake) | ^5.0 |
| google-gemini-php/client | ^2.7 |
| kwn/number-to-words | ^2.9 |
| mobiledetect/mobiledetectlib | ^3.74 |
| erusev/parsedown | ^1.7 |
| symfony/http-client | ^8.0 |

---

## Instalación

```bash
git clone <repo-url> spc
cd spc
composer install
```

Crear la base de datos y configurar las credenciales (ver [Configuración](#configuración)), luego ejecutar las migraciones:

```bash
bin/cake migrations migrate
```

### Requisitos del servidor

- PHP 8.4 con extensiones: `intl`, `mbstring`, `pdo_mysql`, `openssl`
- MySQL / MariaDB
- Servidor web con soporte para `mod_rewrite` (Apache) o configuración equivalente en Nginx
- OpenSSL (PHP nativo — no requiere binario openssl)
- Para SSL: acme.sh instalado, acceso a cPanel API con token

---

## Configuración

Copiar el archivo de entorno de ejemplo y ajustar los valores:

```bash
cp config/.env.example config/.env
```

Las variables sensibles se gestionan en `config/app_local.php` bajo la clave `SensitiveData`:

```php
'SensitiveData' => [
    'Gemini' => [
        'APIKey' => '...',     // Google Gemini AI API key
    ],
    'Facebook' => [
        'APIv'          => '/v25.0',          // Versión de Graph API
        'RadioUASAppID' => '...',             // App ID de Facebook
        'AccessTokens'  => ['token1', '...'], // Page access tokens
    ],
    'MediaCP' => [
        'APIKey' => '...',     // Bearer token para API de MediaCP
    ],
    'Shoutcast' => [
        'password' => '...',   // DJ password para admin.cgi
        'scheme'   => 'http',
        'host'     => '...',   // Host del servidor SHOUTcast
        'port'     => 8000,
        'token'    => '...',   // Token compartido para /api/metadata/update
    ],
    'GoogleMail' => [
        'email'    => 'radio@uas.edu.mx',
        'password' => '...',   // App password de Gmail (OAuth2)
    ],
    'Emby' => [
        'APIKey' => '...',     // API key del servidor Emby
    ],
    'YouTube' => [
        'APIKey' => '...',     // YouTube Data API key
    ],
    'Rdi20' => [
        'local_host'  => '192.168.1.xxx',  // IP local del encoder RDS
        'remote_host' => '200.xx.xx.xx',   // IP remota (VPN)
        'port'        => 8000,
        'username'    => '...',             // Usuario del encoder
        'password'    => '...',             // Password del encoder
    ],
]
```

### SSL Generation

Configuración para renovación automática de certificados SSL vía acme.sh con DNS-01 (cPanel):

```php
'SSLGeneration' => [
    'domain'         => 'emby.radiouas.org',     // Dominio a renovar
    'email'          => 'abel@uas.edu.mx',       // Email para CA
    'pfxPassword'    => '...',                   // Password del archivo .pfx
    'pfxDestination' => '/etc/ssl/emby.pfx',     // Ruta destino del .pfx
    'acmeHome'       => '/home/radiouas/.acme.sh',
    'ca'             => 'letsencrypt',            // CA: letsencrypt
    'dnsProvider'    => 'cpanel',
    'cpanel' => [
        'username' => 'radiouas',                // Usuario cPanel
        'apiToken' => '...',                     // API token de cPanel
        'zone'     => 'radiouas.org',            // Zona DNS
        'scheme'   => 'https',
        'host'     => 'cpanel.radiouas.org',
        'port'     => 2083,
    ],
]
```

### Prompts de Gemini

Los prompts para generación de contenido vía IA se configuran también en `config/app_local.php`:

```php
'Prompts' => [
    'live_show'      => 'Genera una publicación para Facebook sobre el programa %programa%...',
    'live_broadcast' => 'Genera una publicación para el evento %evento%...',
]
```

---

## Sistema de layouts y tema

### Layouts por rol

El layout del panel se selecciona automáticamente según el permiso del usuario autenticado:

| Permiso | Layout |
|---|---|
| `ADMINISTRATOR` | `administrador` |
| `CAPTURISTA` | `capturista` |
| `LOCUTOR` | `cabina` |
| `FONOTECARIO` | `programador` |

Usuarios no autenticados ven el layout `home` (pantalla de login) y la sección de bitácora.

### Tema claro/oscuro

El sistema soporta dos temas intercambiables mediante una cookie `Theme`:
- `github-midday.css` (claro, por defecto)
- `github-midnight.css` (oscuro)

El toggle se realiza desde el panel (`Admin/Usuarios::setTheme`). La cookie es legible por JavaScript para aplicar el tema sin recargar.

---

## Comandos de consola

### Gestión de streaming

```bash
# Reiniciar el stream de MediaCP (cron-friendly)
bin/cake reset_stream

# Actualizar metadatos NowPlaying → SHOUTcast + RDS
bin/cake broadcast update
```

Ejemplo de cron para reinicio nocturno:

```
0 3 * * * /usr/bin/php /var/www/spc/bin/cake reset_stream >> /var/log/spc_stream.log 2>&1
```

Ejemplo de cron para actualización de metadatos (cada minuto):

```
* * * * * /usr/bin/php /var/www/spc/bin/cake broadcast update >> /var/log/spc_broadcast.log 2>&1
```

### SSL / Certificados

```bash
# Renovar certificado SSL vía acme.sh + cPanel DNS-01
bin/cake ssl_renew <domain> [email] [pfx-destination]

# Gestionar registros DNS TXT para ACME (hook de acme.sh)
bin/cake cpanel_dns <add|remove> <domain> <challenge>
```

### Migración de datos

```bash
# Migrar stream_hits desde SQLite a MySQL
bin/cake migrate_data
```

---

## Testing y calidad

```bash
composer test      # PHPUnit --colors=always
composer cs-check  # PHP_CodeSniffer --colors -p
composer cs-fix    # PHPCBF --colors -p
composer stan      # PHPStan analyse (level 8)
composer check     # test + cs-check (pre-commit)
```

- PHPStan configurado en nivel **8**
- Psalm configurado en nivel **2** (error)
- CS exceptions: `src/Controller/*` exento de type hints nativos en returns
- Migraciones construyen la BD de tests automáticamente

---

> Uso exclusivo de **Radio Universidad Autónoma de Sinaloa**.  
> Desarrollado por Ing. Abel Bottello
