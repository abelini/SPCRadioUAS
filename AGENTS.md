# AGENTS.md

## Project: SPC (Sistema de Producción y Cabina)

Radio UAS internal ops system. CakePHP 5.3 on PHP 8.4+.

## CRITICAL — never modify

- `config/routes.php` — authentication routing, prefix wiring, CSRF-skip config
- `src/Application.php` — AuthenticationService setup, middleware stack, CSRF skip callback
- Changing either breaks login, redirects, or CSRF.

## Namespace & base class

- Root namespace: `SPC` (not `App`). Declared in `composer.json` autoload.
- `src/Controller/AppController.php` extends `Cake\Controller\Controller`
- **Important**: `ApiController` extends `Controller` directly (not `AppController`). No auth, no layout logic.
- `tests/` namespace: `SPC\Test\`

## Commands

```bash
composer test           # phpunit --colors=always
composer cs-check       # phpcs --colors -p
composer cs-fix         # phpcbf --colors -p
composer stan           # phpstan analyse (level 8)
composer check          # test + cs-check (run this before committing)
bin/cake migrations migrate
bin/cake reset_stream   # reboot MediaCP stream (cron-friendly)
bin/cake broadcast update  # push NowPlaying metadata → Shoutcast + RDS
bin/cake ssl_renew <domain> [email] [pfx-destination]  # renew SSL cert via acme.sh (LE/ZeroSSL) + generate .pfx
bin/cake cpanel_dns <add|remove> <domain> <challenge>  # manage TXT records via cPanel API (SSL hook)
```

CS exceptions: `phpcs.xml` exempts `src/Controller/*` from native return type hints (`SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint`).

PHPStan at **level 8**. Psalm at **error level 2** (both in config).

## Architecture

- **Prefix routing**: `Admin/*` (authenticated panels), `Api/*` (REST, CSRF-skipped — see middleware in Application.php)
- **Auth**: CakePHP Authentication plugin. Session + Cookie + Form authenticators. Login URL: `Admin/Usuarios::auth`.
- **Layout**: `AppController::beforeFilter()` sets layout from `$user->permisos[0]->name`. Maps constants (`ADMINISTRATOR`, `CAPTURISTA`, `FONOTECARIO`) to lowercase layout names. Home = `home` layout.
- **Login page**: Root `/` → `Pages::display('home')` → `templates/Pages/home.php` with `templates/layout/home.php`. Form POSTs to `Admin/Usuarios::auth`.
- **Permisos (permissions)**: M:N user-to-permission via `permisos` + `permisos_usuarios` tables. `Permiso` entity has constants: `ADMINISTRATOR`, `CAPTURISTA`, `FONOTECARIO`, plus numeric constants for `PRODUCTORES_TECNICOS` (3), `CORRESPONSALES` (5), `PROGRAMADOR` (8), `VIGILANTE` (9), `LOCUTOR` (10).
- **`AppController::getDateNow()`**: Returns cached `DateTime` (set once per request in `beforeFilter`). Use instead of `new DateTime()` for consistency.
- **Pagination default**: `limit => 40` (set in `AppController`).
- **Paginator templates**: Custom W3.CSS-style templates set in `AppView::initialize()`.
- **Custom finders**: Declared in Table classes (e.g., `findForDay`, `findDiasFeriadosAsignados`, `findMaestrosAsignados`, `findOpen`, `findPrevious`, `findNext`, `findOrphans`, `findStats`). Use `matching`/`contain` for complex queries.

## Theme system

- Two CSS files: `webroot/css/github-midday.css` and `webroot/css/github-midnight.css` (custom properties).
- Cookie `Theme` (default: `'midday'`), set server-side via `Admin/Usuarios::setTheme`. Cookie is `httpOnly: false` (JS reads it for toggle) + `secure: true`.
- Loaded in admin layouts as: `$this->Html->css('github-' . $this->request->getCookie('Theme', 'midday'))`.
- Never use `$_COOKIE`; use `$this->request->getCookie()`.

## Database

- **Production**: MySQL (`Cake\Database\Driver\Mysql`).
- **Local dev** (`config/app_local.php`): SQLite.
- **Tests**: Migrations build the test DB automatically (`tests/bootstrap.php` runs `(new Migrator())->run()`). Falls back to SQLite with `DATABASE_TEST_URL` env var.
- **Sensitive config** stored in `config/app_local.php` under `SensitiveData` key (Gemini, Facebook, MediaCP, Gmail OAuth2, Emby, YouTube) and `SSLGeneration` key (SSL cert renewal). Not in `.env`.
- **`SSLGeneration.dnsProvider`**: `'cpanel'` (default) or `'webroot'`. When `'cpanel'`, uses `CpanelDnsService` + `CpanelDnsCommand` to auto-add/remove TXT records via cPanel UAPI during acme.sh DNS-01 challenge.
- **`SSLGeneration.cpanel`**: Required when `dnsProvider = 'cpanel'`. Keys: `baseUrl` (e.g. `https://radiouas.org:2083`), `username`, `apiToken` (cPanel API token with DNS perms), `zone` (e.g. `radiouas.org`).
- **Hook mechanism**: `SslService::renew()` / `SslRenewCommand` create a temp bash script that calls `bin/cake cpanel_dns`, set `ACMESH_DNS_MANUAL_CMD` / `ACMESH_DNS_MANUAL_CLEANUP`, then invoke `acme.sh --dns dns_manual_hook`. The hook script is cleaned up after renewal.
- **`SSLGeneration.pfxDestination`**: Absolute path. Use `ROOT . DS . 'webroot' . DS . 'cert' . DS . 'cert.pfx'` for a path relative to the project webroot.

## Conventions

- DocBlocks in **Spanish**, method names in **English**
- Fully typed params, return types, and properties
- `declare(strict_types=1);` on every PHP file
- One class per file, filename = classname
- `camelCase` for vars/methods, `PascalCase` for classes
- CakePHP ORM conventions: Table class = plural (e.g., `UsuariosTable`), Entity = singular (`Usuario`)
- Models in `src/Model/Entity/` and `src/Model/Table/`
- `src/Controller/Component/` for shared controller logic
- `src/Service/` for business logic (GeminiService, ShoutcastService, EpgBuilder, DeviceDetectorService)
- `src/Trait/APICacheTrait.php` — constants for remote control cache key and broadcast types
- `src/Mailer/` — custom mailers (GoogleMailer, RolMailer, UserMailer)
- **RDS (RDI 20) + Shoutcast**: `BroadcastCommand` (`bin/cake broadcast update`) → `NowPlayingService::get()` → `ShoutcastService::update($data)` + `Rdi20TelnetService::update($data)`. RDS uses TCP/Telnet, sends `XTXT=...\r\n`, confirms with `+`. Cache `last_sent_rds` dedup.
- **SSL auto-renew via cPanel DNS**: `CpanelDnsService` (`src/Service/CpanelDnsService.php`) manages TXT records via cPanel UAPI at `baseUrl/execute/DNS/*`. Used automatically by `SslService::renew()` and `SslRenewCommand` when `dnsProvider = 'cpanel'`. The workflow: acme.sh calls temp hook → `bin/cake cpanel_dns add|remove <domain> <challenge>` → `CpanelDnsService` talks to cPanel API.

## Testing

- PHPUnit with fixtures in `tests/Fixture/` (32 fixture files).
- Test files parallel `src/` under `tests/TestCase/`.
- Test database schema built from migrations (not from `tests/schema.sql`).
- Integration tests use `IntegrationTestTrait`.

## Notable quirks

- **CSRF**: Skipped only for `Api/` prefix. All `Admin/` POST requests require `_csrfToken`.
- **Form styling**: Input overrides live in `webroot/css/github-midday.css` and `github-midnight.css` (`.form-control`, `input[type=...]`). No `form.php` element file.
- **`.page-header h5`**: Gradient background + white uppercase text via CSS.
- **Plugins loaded via `config/plugins.php`**: DebugKit (debug only), Bake (CLI), Migrations (CLI only).
- **`composer.json` platform**: `"php": "8.5.2"` — ensures consistent dependency resolution.
- **`DESIGN.md`**: Design token reference for GitHub dark theme (custom properties, spacing scale, typography). Not an instruction file for agents.
