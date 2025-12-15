# Sistema de Producción y Cabina

![Build Status](https://github.com/cakephp/app/actions/workflows/ci.yml/badge.svg?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)

## Radio UAS

![](https://radio.uas.edu.mx/wp-content/media/logo.png)

### Descripción

Software basado en CakePHP para administrar las tareas operativas del entorno de cabina.

* Roles de operación (turnos y horarios)
* Programas radiofónicos (altas, bajas y modificaciones)
* Manejo de personal
* Asignaciones de tareas (maestros de ceremonias, grabaciones de spots, etc)
* Reportes de cumplimiento de la programación
* Reportes de incidencias de vigilancia
* REST API para solicitar
    * Operador actual
      ```
      GET /api/locutores?ahora
        ```
    * Playlists de YouTube
      ```
      GET /api/youtube/playlist?list={YouTubePlaylistID}
        ```
    * Programación actual
      ```
      GET /api/schedule/daily?day={DayOfWeek}
        ```
      ```
      GET /api/schedule/now
        ```
    * Música de la Fonoteca Virtual
      ```
      GET /api/music/album?ID={EmbyItemID}
        ```
      ```
      GET /api/music/artist?ID={EmbyItemID}
        ```
      ```
      GET /api/music/playlist?ID={EmbyPlaylistID}
        ```
* Otras tareas internas propias de la estación

    
Par uso exclusivo de Radio UAS.


Esta versión de SPC utiliza CakePHP 5.2.9 y PHP 8.4
