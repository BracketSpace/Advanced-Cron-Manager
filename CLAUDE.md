# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

- **Build frontend assets** (after editing JS/CSS): `yarn build` (runs Gulp: compiles SCSS → CSS, concatenates/minifies JS)
- **PHP lint**: `lando composer phpcs`
- **PHP autofix**: `lando composer phpcbf`
- **All composer/PHP commands** must run through `lando` (Docker environment, PHP 8.2)

## Workflow & Conventions

- **Git flow**: Branch from `develop`, feature branches as `feature/Name`. Main branch is `develop`.
- **Conventional commits**: Follow [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) spec.
- **Changelog**: BEFORE committing, document changes in `readme.txt`. Use format `= X.Y.Z =` with `* [Added/Changed/Fixed] Description`. For unreleased changes, use `2.6.5` as the version header (e.g., `= 2.6.5 =`). Keep entries meaningful — don't bloat with granular changes. Group entries by type: Added first, then Changed, then Fixed.
- **Text domain**: `advanced-cron-manager`
- **Version**: Appears in two places in `advanced-cron-manager.php`: plugin header `Version:` and `$plugin_version` variable.

## Coding Standards

- **PHP**: WordPress Coding Standards (WPCS 3.2), configured in `phpcs.xml`. Notably allows short array syntax and non-underscored hook names.
- **JS/CSS**: [WordPress JS Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/) and [WordPress CSS Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/css/).

## Architecture

**WordPress plugin** for managing WP-Cron events and schedules. Namespace: `underDEV\AdvancedCronManager`, PSR-4 autoloaded from `inc/`.

### Entry Point & Wiring

`advanced-cron-manager.php` — bootstraps the entire plugin procedurally. Instantiates all classes, wires WordPress hooks (`add_action`/`add_filter`). No DI container; dependencies are composed via closures.

### Core Domain (`inc/Cron/`)

- **Element/Event.php, Element/Schedule.php** — value objects representing a single cron event or schedule
- **Events.php / Schedules.php** — collection managers that read from WP's cron system (`_get_cron_array()`, `wp_get_schedules()`)
- **EventsLibrary.php / SchedulesLibrary.php** — persistence layer (custom schedules stored in `wp_option`, paused events stored in `wp_option`)
- **EventsActions.php / SchedulesActions.php** — AJAX handlers for insert/edit/remove/run/pause operations

### UI Layer

- **AdminScreen.php** — registers the Tools menu page, renders main layout, handles AJAX re-renders of tables
- **Assets.php** — enqueues CSS/JS only on the plugin's admin page
- **FormProvider.php** — AJAX handlers that return form HTML (add schedule, edit schedule, add event)
- **views/** — PHP templates: `wrapper.php` is the main layout; `parts/` for sections (events table, schedules table, searchbox, slidebar); `elements/` for row templates; `forms/` for add/edit forms

### Server Scheduler (`inc/Server/`)

- **Settings.php** — settings UI and save handler for disabling WP-Cron spawning
- **Processor.php** — conditionally blocks WP-Cron execution based on saved settings

### Frontend Assets

- **Source**: `assets/src/js/` (individual JS modules) and `assets/src/sass/` (SCSS with components/mixins/parts)
- **Built**: `assets/dist/js/scripts.min.js` (concatenated+minified) and `assets/dist/css/style.css`
- **Gulp pipeline** (`gulpfile.js`): SCSS → autoprefixed CSS; JS → concatenated → uglified. Both with sourcemaps.

### AJAX Pattern

All admin operations use WordPress AJAX (`wp_ajax_acm/*`). Each action class verifies nonces and capabilities, then returns JSON. The JS code in `assets/src/js/` calls these endpoints and re-renders table HTML via AJAX.
