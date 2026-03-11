# Sistema de Producción y Cabina

<img src="https://radio.uas.edu.mx/wp-content/media/logo.png" alt="Radio UAS" style="display:block;margin:auto;width:30%;">

<p align="center">
  <img src="https://github.com/cakephp/app/actions/workflows/ci.yml/badge.svg?branch=master" alt="Build Status">
  <img src="https://img.shields.io/badge/CakePHP-5.3-red?logo=cakephp" alt="CakePHP 5.3">
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?logo=php" alt="PHP 8.5">
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
- [Comandos de consola](#comandos-de-consola)

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
- Reportes de incidencias de vigilancia

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

### Asistente IA
Interfaz interna para interactuar con Google Gemini. Permite generar prompts libres y también se usa de forma integrada en la generación de contenido para redes sociales.

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

---

## Integraciones externas

| Servicio | Uso |
|---|---|
| **Google Gemini** | Generación de contenido para redes sociales y asistente IA interno |
| **Facebook Graph API** | Comentarios en transmisiones en vivo |
| **MediaCP (MexiServer)** | Control del servidor de streaming HLS vía API REST |
| **Emby** | Fonoteca virtual (álbumes, artistas, playlists) |
| **YouTube Data API** | Playlists públicas de Radio UAS |
| **Google SMTP (OAuth2)** | Envío de correos (roles de cabina, notificaciones de usuario) |

---

## Stack técnico

| Componente | Versión |
|---|---|
| PHP | ≥ 8.4 |
| CakePHP | ^5.3 |
| CakePHP Authentication | ^3.0 |
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

---

## Configuración

Copiar el archivo de entorno de ejemplo y ajustar los valores:

```bash
cp config/.env.example config/.env
```

Las variables sensibles se gestionan en `config/app_local.php` bajo la clave `SensitiveData`:

```php
'SensitiveData' => [
    'Gemini' => ['APIKey' => '...'],
    'Facebook' => [
        'APIv'          => '/v19.0',
        'RadioUASAppID' => '...',
        'AccessTokens'  => ['token1', 'token2'],
    ],
    'MediaCP' => ['APIKey' => '...'],
    // Gmail OAuth2, Emby, YouTube...
]
```

Los prompts de Gemini para generación de contenido se configuran en:

```php
'Prompts' => [
    'live_show'      => 'Genera una publicación para Facebook sobre el programa %programa%...',
    'live_broadcast' => 'Genera una publicación para el evento %evento%...',
]
```

---

## Comandos de consola

### Reinicio automático del stream

Detiene y reinicia el servicio de streaming vía API de MediaCP. Útil para programarlo en `cron` ante caídas nocturnas.

```bash
bin/cake reset_stream
```

```
# Ejemplo: reinicio diario a las 3:00 AM
0 3 * * * /usr/bin/php /var/www/spc/bin/cake reset_stream >> /var/log/spc_stream.log 2>&1
```

---

> Uso exclusivo de **Radio Universidad Autónoma de Sinaloa**.  
> Dirección de Radio UAS — L.C.C. Brenda Rodríguez García