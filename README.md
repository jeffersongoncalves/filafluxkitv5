<div class="filament-hidden">

![FilaFluxKit](https://raw.githubusercontent.com/jeffersongoncalves/filafluxkitv5/main/art/jeffersongoncalves-filafluxkitv5.png)

</div>

# FilaFluxKit Start Kit Filament 5.x and Laravel 13.x

## About FilaFluxKit

FilaFluxKit is a robust starter kit built on Laravel 13.x and Filament 5.x, designed to accelerate the development of modern
web applications with a ready-to-use multi-panel structure and Livewire Flux UI components integrated via the
[`jeffersongoncalves/filament-flux`](https://github.com/jeffersongoncalves/filament-flux) plugin.

## Features

- **Laravel 13.x** - The latest version of the most elegant PHP framework
- **Filament 5.x** - Powerful and flexible admin framework
- **Livewire 4.x + Flux 2.x** - Modern reactive UI primitives wired into every panel
- **filament-flux plugin** - Native Filament Form Fields, Table Columns, Infolist Entries and Actions backed by Livewire Flux
- **Tailwind CSS v4** - Configured per-panel theme with Flux palette safelist
- **Multi-Panel Structure** - Includes three pre-configured panels:
    - Admin Panel (`/admin`) - For system administrators
    - App Panel (`/app`) - For authenticated application users
    - Guest Panel (frontend interface) - For visitors
- **Multi-Guard Authentication** - Separate `Admin` and `User` models, tables, guards and login pages
- **Environment Configuration** - Centralized configuration through the `config/filafluxkit.php` file

## System Requirements

- PHP 8.3 or higher
- Composer
- Node.js and PNPM

## Installation

Clone the repository
``` bash
laravel new my-app --using=jeffersongoncalves/filafluxkitv5 --database=mysql
```

### Using FilaFluxKit CLI

Or use [FilaFluxKit CLI](https://github.com/jeffersongoncalves/filafluxkit-cli) for a simplified setup:

```bash
filafluxkit new my-app --kit=jeffersongoncalves/filafluxkitv5
```

> Install FilaFluxKit CLI: `composer global require jeffersongoncalves/filafluxkit-cli`

###  Easy Installation

FilaFluxKit can be easily installed using the following command:

```bash
php install.php
```

This command automates the installation process by:
- Installing Composer dependencies
- Setting up the environment file
- Generating application key
- Setting up the database
- Running migrations
- Installing Node.js dependencies
- Building assets
- Configuring Herd (if used)

### Manual Installation

Install JavaScript dependencies
``` bash
pnpm install
```
Install Composer dependencies
``` bash
composer install
```
Set up environment
``` bash
cp .env.example .env
php artisan key:generate
```

Configure your database in the .env file

Run migrations
``` bash
php artisan migrate
```
Run the server
``` bash
php artisan serve
```

## Installation with Docker

Clone the repository
```bash
laravel new my-app --using=jeffersongoncalves/filafluxkitv5 --database=mysql
```

Move into the project directory
```bash
cd my-app
```

Install Composer dependencies
```bash
composer install
```

Set up environment
```bash
cp .env.example .env
```

Configuring custom ports may be necessary if you have other services running on the same ports.

```bash
# Application Port (ex: 8080)
APP_PORT=8080

# MySQL Port (ex: 3306)
FORWARD_DB_PORT=3306

# Redis Port (ex: 6379)
FORWARD_REDIS_PORT=6379

# Mailpit Port (ex: 1025)
FORWARD_MAILPIT_PORT=1025
```

Start the Sail containers
```bash
./vendor/bin/sail up -d
```
You won’t need to run `php artisan serve`, as Laravel Sail automatically handles the development server within the container.

Attach to the application container
```bash
./vendor/bin/sail shell
```

Generate the application key
```bash
php artisan key:generate
```

Install JavaScript dependencies
```bash
pnpm install
```

## Authentication Structure

FilaFluxKit comes pre-configured with a custom authentication system that supports different types of users:

- `Admin` - For administrative panel access
- `User` - For application panel access

## Development

``` bash
# Run the development server with logs, queues and asset compilation
composer dev

# Or run each component separately
php artisan serve
php artisan queue:listen --tries=1
pnpm run dev
```

## Customization

### Panel Configuration

Panels can be customized through their respective providers:

- `app/Providers/Filament/AdminPanelProvider.php`
- `app/Providers/Filament/AppPanelProvider.php`
- `app/Providers/Filament/GuestPanelProvider.php`

Alternatively, these settings are also consolidated in the `config/filafluxkit.php` file for easier management.

### Themes and Colors

Each panel can have its own color scheme, which can be easily modified in the corresponding Provider files or in the
`filafluxkit.php` configuration file.

### Configuration File

The `config/filafluxkit.php` file centralizes the configuration of the starter kit, including:

- Panel routes
- Middleware for each panel
- Branding options (logo, colors)
- Authentication guards

## Livewire Flux UI — jeffersongoncalves/filament-flux

This kit ships with [`filament-flux`](https://github.com/jeffersongoncalves/filament-flux) (`^1.11`) preinstalled and registered on every panel. Resources keep calling native Filament classes — the plugin swaps them for Flux subclasses or rewrites the rendered Blade markup at three layers:

```php
FilamentFluxPlugin::make()
    ->useEverywhere()       // Form Fields (container bindings)
    ->useFluxNavigation()   // Sidebar + topbar items
    ->useFluxComponents();  // Atomic <x-filament::*> Blade components
```

Plugin registration lives in:
- `app/Providers/Filament/AdminPanelProvider.php`
- `app/Providers/Filament/AppPanelProvider.php`
- `app/Providers/Filament/GuestPanelProvider.php`

Each panel theme imports Flux + filament-flux CSS:

```css
@import '../../../../vendor/filament/filament/resources/css/theme.css';
@import '../../../../vendor/livewire/flux/dist/flux.css';
@import '../../../../vendor/jeffersongoncalves/filament-flux/dist/filament-flux.css';
```

To wire it on a new panel run:

```bash
php artisan filament-flux:install --panel={panel-id}
pnpm build
```

### `useEverywhere()` — Form Field auto-replace

Container bindings rewrite every native Form Field call to its Flux subclass. No code changes in your Resources.

| Slug | Filament native | Flux replacement |
|---|---|---|
| `input` | `TextInput` | `FluxInput` |
| `textarea` | `Textarea` | `FluxTextarea` |
| `select` | `Select` | `FluxSelect` |
| `checkbox` | `Checkbox` | `FluxCheckbox` |
| `checkboxList` | `CheckboxList` | `FluxCheckboxGroup` |
| `radio` | `Radio` | `FluxRadio` |
| `toggle` | `Toggle` | `FluxSwitch` |
| `otp` | `OneTimeCodeInput` | `FluxOtpInput` |

Granular opt-out:

```php
FilamentFluxPlugin::make()->useEverywhere([
    'select' => false,    // keep native <select>
    'otp' => false,
]);
```

### `useFluxNavigation()` — Sidebar + topbar

Replaces Filament's sidebar/topbar Blade items with `<flux:navlist>` / `<flux:navbar>` markup while keeping Filament's data layer (active state, badges, child items, registered Resources/Pages) intact.

```php
FilamentFluxPlugin::make()->useFluxNavigation([
    'sidebar' => true,
    'topbar' => true,
    'shell' => false,         // outer <flux:sidebar>/<flux:main> shell — invasive, opt-in
    'themeSwitcher' => false, // single <flux:dropdown> theme switcher — opt-in
]);
```

### `useFluxComponents()` — Atomic Blade components

Replaces `<x-filament::*>` with `<x-flux::*>`. Each slug is opt-in.

| Slug | Filament view | Flux replacement |
|---|---|---|
| `badge` | `filament::components.badge` | `<flux:badge>` |
| `avatar` | `filament::components.avatar` | `<flux:avatar>` |
| `icon` | `filament::components.icon` | `<flux:icon>` |
| `iconButton` | `filament::components.icon-button` | `<flux:button square icon>` |
| `link` | `filament::components.link` | `<flux:link>` |
| `breadcrumbs` | `filament::components.breadcrumbs` | `<flux:breadcrumbs>` |
| `callout` | `filament::components.callout` | `<flux:callout>` |
| `card` | `filament::components.card` | `<flux:card>` |
| `fieldset` | `filament::components.fieldset` | `<flux:fieldset>` |
| `section` | `filament::components.section` | `<flux:card>` w/ heading + collapsible/persist |
| `dropdown` | `filament::components.dropdown` | `<flux:dropdown>` + `<flux:menu>` |
| `dropdownHeader` | `filament::components.dropdown.header` | `<flux:heading size="sm">` |
| `modalHeading` | `filament::components.modal.heading` | `<flux:heading size="lg">` |
| `modalDescription` | `filament::components.modal.description` | `<flux:text>` |
| `schemaText` | `filament-schemas::components.text` | `<flux:text>` |
| `statsCard` | `filament-widgets::stats-overview-widget.stat` | `<flux:card>` + heading/subheading/text |
| `notifications` | `filament-notifications::notifications` | `<flux:toast.group>` envelope |
| `pagination` | `filament::components.pagination.index` | `<flux:pagination>` |

Granular opt-out:

```php
FilamentFluxPlugin::make()->useFluxComponents([
    'badge' => true,
    'avatar' => true,
    'icon' => true,
    // omit/false → keep Filament's view
]);
```

Mixed icon sets (Heroicons + Font Awesome / Tabler / Lucide / Phosphor / Material / etc.) are detected by the bundled `HeroiconNormalizer` and routed back through Blade Icons when needed — only Heroicons go through `<flux:icon>`.

### Plugin options

```php
FilamentFluxPlugin::make()
    ->scopeClass('filament-flux-scope')   // CSS scope wrapper; pass null to use Flux's native zinc palette
    ->injectAppearance(true)              // @fluxAppearance in <head> + theme bridge
    ->injectScripts(true);                // @fluxScripts before </body>
```

Reference: https://github.com/jeffersongoncalves/filament-flux

## User Profile — joaopaulolndev/filament-edit-profile

This project already comes with the Filament Edit Profile plugin integrated for the Admin and App panels. It adds a complete profile editing page with avatar, language, theme color, security (tokens, MFA), browser sessions, and email/password change.

- Routes (defaults in this project):
  - Admin: /admin/my-profile
  - App: /app/my-profile
- Navigation: by default, the page does not appear in the menu (shouldRegisterNavigation(false)). If you want to show it in the sidebar menu, change it to true in the panel provider.

Where to configure
- Panel providers
  - Admin: app/Providers/Filament/AdminPanelProvider.php
  - App: app/Providers/Filament/AppPanelProvider.php
  In these files you can adjust:
  - ->slug('my-profile') to change the URL (e.g., 'profile')
  - ->setTitle('My Profile') and ->setNavigationLabel('My Profile')
  - ->setNavigationGroup('Group Profile'), ->setIcon('heroicon-o-user'), ->setSort(10)
  - ->shouldRegisterNavigation(true|false) to show/hide it in the menu
  - Shown forms: ->shouldShowEmailForm(), ->shouldShowLocaleForm([...]), ->shouldShowThemeColorForm(), ->shouldShowSanctumTokens(), ->shouldShowMultiFactorAuthentication(), ->shouldShowBrowserSessionsForm(), ->shouldShowAvatarForm()

- General settings: config/filament-edit-profile.php
  - locales: language options available on the profile page
  - locale_column: column used in your model for language/locale (default: locale)
  - theme_color_column: column for theme color (default: theme_color)
  - avatar_column: avatar column (default: avatar_url)
  - disk: storage disk used for the avatar (default: public)
  - visibility: file visibility (default: public)

Migrations and models
- The required columns are already included in this kit’s default migrations (users and admins): avatar_url, locale and theme_color, using the names defined in config/filament-edit-profile.php.
- The App\Models\User and App\Models\Admin models already read the avatar using the plugin configuration (getFilamentAvatarUrl).

Avatar storage
- Make sure the filesystem disk is configured and that the storage link exists:
  php artisan storage:link
- Adjust the disk and visibility in the config file according to your infrastructure.

Quick access
- Via direct URL: /admin/my-profile or /app/my-profile
- To make it visible in the sidebar navigation, set shouldRegisterNavigation(true) in the respective Provider.

Reference
- Plugin repository: https://github.com/joaopaulolndev/filament-edit-profile

## Resources

FilaFluxKit includes support for:

- User and admin management
- Multi-guard authentication system
- Tailwind CSS integration
- Database queue configuration
- Customizable panel routing and branding

## License

This project is licensed under the [MIT License](LICENSE).

## Credits

Developed by [Jefferson Gonçalves](https://github.com/jeffersongoncalves).
