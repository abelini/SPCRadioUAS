# AGENTS.md

## Project: SPC (Sistema de Producción y Cabina)

Radio UAS internal operations system. CakePHP 5.3.4 on PHP 8.5.

## Rules

- **Namespace**: `SPC` — never use `App`
- **Not `App`**: `src/Controller/` uses `Cake\Controller\Controller`, and the project's namespace root is `SPC`.
- **Layout from entity**: `AppController::beforeFilter()` sets the layout from `$user->permisos[0]->name`.
- **CRITICAL**: `routes.php` and `src/Application.php` must NOT be modified — authentication configuration and routing live there. Changing either will break login/redirect/CSRF.
- **Only modify**: templates (HTML/CSS/JS), controllers, models — NOT config/Application.php.
- **Login page**: Root `/` maps to `templates/Pages/home.php` with layout `templates/layout/home.php`. Form POSTs to `Admin/Usuarios::auth`.
- **Theme system**: Two CSS files (`github-midday.css`, `github-midnight.css`) using custom properties. Cookie `Theme` set server-side via `Admin/Usuarios::setTheme`.
- **Never touch `$_COOKIE`**: use `$this->request->getCookie()` instead.

## Commands

```bash
composer test           # phpunit
composer cs-check       # phpcs
composer cs-fix         # phpcbf
composer stan           # phpstan analyse
bin/cake migrations migrate
bin/cake reset_stream   # reboot MediaCP stream (cron-friendly)
```

## Architecture

- **Prefix routing**: `Admin/*` (authenticated panels), `Api/*` (REST, CSRF-skipped)
- **Auth**: CakePHP Authentication plugin. `loginUrl` configured in `Application.php` as `['prefix' => 'Admin', 'controller' => 'Usuarios', 'action' => 'auth']`.
- **Permisos** (Permissions): Each user has one or more permissions stored in `permisos` table. The `Permiso` entity has constants like `ADMINISTRATOR`, `CAPTURISTA`, `FONOTECARIO`.
- **Layouts**: `home` (login), `administrador`, `capturista`, `programador`, `default`.
- **Table finders**: Custom finders declared in Table classes (e.g. `findDiasFeriadosAsignados`, `findMaestrosAsignados`). Use matching/contain for complex queries.

## Conventions

- DocBlocks in **Spanish** — method names in **English**
- Fully typed (params, return, properties)
- `declare(strict_types=1);` on every PHP file
- One class per file, file name = class name
- camelCase for vars/methods, PascalCase for classes
- Models use CakePHP ORM conventions: table class = plural, entity class = singular

## Notable quirks

- **CSRF is skipped** only for `Api/` prefix — all admin POST requests require `_csrfToken`.
- **`form.php` overrides**: CakePHP Form Helper overrides in `github-midday.css` (lines ~810) style inputs globally.
- **Small dataset**: ~5 locutors, pagination default `limit: 40`.
- **Custom DateTime** via `AppController::getDateNow()` — use this instead of `new DateTime()` for consistent "today" across the request.
- **`<h5>` in `.page-header`**: these get gradient background + white uppercase text via CSS.

## Testing

- PHPUnit with fixtures in `tests/Fixture/`.
- Test files parallel the `src/` structure under `tests/TestCase/`.
