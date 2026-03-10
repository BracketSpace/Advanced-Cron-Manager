=== Advanced Cron Manager - debug & control ===
Contributors: bracketspace, Kubitomakita
Tags: cron, wpcron, cron manager, manager, crontrol
Requires at least: 5.0
Requires PHP: 5.3
Tested up to: 6.9
Stable tag: 2.7.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

View, pause, remove, edit and add WP Cron events and schedules.

== Description ==

**Take full control of your WordPress cron system.** Advanced Cron Manager gives you complete visibility into every scheduled task running on your site — so you can find problems, fix them, and keep your site running smoothly.

WordPress relies on WP-Cron for critical background tasks: sending emails, publishing scheduled posts, running backups, syncing data, and more. But by default, you have zero visibility into what's happening. Events fail silently, schedules pile up, and debugging is guesswork. Advanced Cron Manager changes that.

**What you can do with the free version:**

* **See every scheduled event** — view all registered cron events with their hooks, arguments, schedules, and next execution times, all in one clean dashboard
* **Search and filter** — quickly find the event you're looking for, even on sites with hundreds of cron jobs
* **Run events manually** — trigger any cron event on demand to test it or force an immediate execution
* **Pause and resume events** — temporarily disable events without losing their configuration, perfect for troubleshooting
* **Add and remove events** — create new cron events or unschedule ones you no longer need
* **Copy-paste PHP implementation** — get ready-to-use code snippets for each event's action hook and callback
* **Bulk actions** — manage multiple events at once: remove, pause, or unpause in batch
* **Manage schedules** — view, add, edit, and remove custom cron schedules (intervals)
* **Server Scheduler** — disable WP-Cron's default page-load triggering and get instructions for setting up a real server cron job for more reliable execution

= Advanced Cron Manager PRO =

The free version shows you what's scheduled. **PRO shows you what actually happened.**

Without logging and diagnostics, cron issues are invisible until something breaks. PRO gives you the tools to monitor, debug, and optimize every cron job on your site.

* **Cron Logger** — full execution history with timestamps and status for every event. Know exactly what ran, when it ran, and whether it succeeded or failed.
* **Performance Stats** — execution time and peak memory usage tracked per event. Spot slow or resource-heavy cron jobs before they become a problem.
* **Error Catcher** — automatically catches fatal errors thrown by cron callbacks and displays them in the log. No more silent failures.
* **Debug Tool** — log custom data from inside your cron callbacks using `do_action('advanced-cron-manager/log')`. Get full visibility into what your code is doing during cron execution.
* **Event Rescheduling** — change the next execution date and schedule of any event. Shift heavy tasks away from peak hours to balance server load.
* **Event Listeners** — see every function and method hooked into each cron event. Understand exactly what code runs behind each hook.
* **Advanced Scheduling (Schyntax)** — go beyond simple intervals. Schedule events for specific times like noon on the last day of the month, only on weekdays, every Tuesday and Friday, and more.

14-day money-back guarantee — no risk, no questions asked.

[Get Advanced Cron Manager PRO](https://bracketspace.com/downloads/advanced-cron-manager-pro/?utm_source=wporg&utm_medium=readme&utm_campaign=readme "Advanced Cron Manager PRO")

= Good to know about WP-Cron =

WordPress Cron is triggered by page visits, which means scheduled tasks may not run exactly on time on low-traffic sites. For precise timing, use the Server Scheduler feature to set up a real system cron job. Note: custom schedules added by this plugin are only available while the plugin is active. Events you create will continue to exist after deactivation.

= Custom Development =

BracketSpace — the company behind this plugin — provides [custom WordPress plugin development services](https://bracketspace.com/custom-development/). We can build any custom plugin for you.

== Installation ==

Download and install this plugin from Plugins -> Add New admin screen.

Plugin's page sits under Tools menu item.

== Frequently Asked Questions ==

= Tasks and schedules will be still working after plugin deactivation/removal? =

Tasks yes. Schedules no.

= How does the pausing/unpausing work =

When you pause an event it's really unscheduled and stored in the wp_option. If you unpause it, it will be rescheduled. All paused events are rescheduled on plugin uninstall.

= What is the Event hook? =

It's used for action. For example if your hook is hook_name you'll need to add in PHP:
`add_action( 'hook_name', 'function_name' )`

= Does this plugin allow to add PHP to events like in WP Crontrol plugin? =

No. This is not safe. You can, however, copy the sample implementation and paste it into your own plugin or theme's function.php file.

= Can this plugin block WP Cron and help hooking it into Server Cron like WP-Cron Control plugin? =

Yes, but WP-Cron Control is quite old and it's tactics is not needed anymore. Advanced Cron Manager can disable spawning WP Cron on site visit and will give you useful information about added Server Cron task.

= Can you create a plugin for me? =

Yes! We're offering a [custom plugin development](https://bracketspace.com/custom-development/) services. Feel free to contact us to find out how we can help you.

= How does Advanced Cron Manager compare to WP Crontrol? =

WP Crontrol is a popular and well-maintained plugin — it's a solid choice for basic cron management. Both plugins let you view, edit, add, remove, pause, and manually run cron events, as well as manage custom schedules.

Where Advanced Cron Manager stands out in the free version: you get copy-paste PHP implementation snippets for every event's action hook and callback, plus bulk actions to manage multiple events at once.

The biggest difference is in the PRO upgrade. Advanced Cron Manager PRO adds cron execution logging, per-event performance stats, automatic error catching, and a debug tool for logging custom data from inside your callbacks. These diagnostic features are not available in WP Crontrol.

Switching between the two is seamless — both plugins read from the same underlying WP-Cron system, so there's nothing to migrate. You can install Advanced Cron Manager and immediately see all your existing events and schedules.

= What about Action Scheduler? Do I need both? =

Action Scheduler and Advanced Cron Manager solve different problems. Action Scheduler is a background job queue designed for processing large batches of tasks — it's used by WooCommerce and other plugins to handle things like webhook delivery, subscription payments, and bulk data operations. It has its own database-backed queue separate from WP-Cron.

Advanced Cron Manager focuses on WP-Cron — the built-in WordPress scheduling system that handles recurring tasks like checking for updates, publishing scheduled posts, sending emails, and running backups. If you need visibility into what WP-Cron is doing and tools to debug it, that's what Advanced Cron Manager is for.

The two plugins complement each other. Action Scheduler manages its own job queue, while Advanced Cron Manager gives you control over WP-Cron events and schedules. Many sites run both without any conflict.

= How does Advanced Cron Manager compare to WP Cron Status Checker? =

WP Cron Status Checker is a monitoring-only tool — it checks whether WP-Cron is running, logs hook executions, and sends email alerts when something fails. It does not let you view, edit, add, remove, or run cron events.

Advanced Cron Manager is a full management tool. You get a complete dashboard for all your cron events and schedules, with the ability to search, add, edit, remove, pause, and manually run any event. With the PRO version, you also get execution logging, performance stats, and error catching — covering the monitoring side as well.

If you only need a simple health check for WP-Cron, WP Cron Status Checker does the job. If you want both management and diagnostics in one plugin, Advanced Cron Manager (especially with PRO) replaces the need for a separate status checker.

== Screenshots ==

1. Plugin control panel
2. Adding, editing and removing Schedule
3. Adding Event
4. Event actions
5. Search and bulk actions
6. Server Scheduler section

== Changelog ==

= 2.7.0 =
* [Changed] Event hash no longer includes next execution timestamp, making it stable across reschedulings
* [Fixed] "In queue" cron events failing to delete, run, or pause with "wrong_nonce" error
* [Fixed] Bulk actions (remove, pause, unpause) failing due to parallel AJAX race conditions
* [Fixed] Undefined $errors variable when removing non-protected events
* [Security] Added nonce verification to rerender AJAX endpoints to prevent CSRF
* [Security] Added capability check to form provider endpoints
* [Security] Improved output escaping in implementation code and view templates

= 2.6.4 =
* [Security] Improved event hook sanitization using sanitize_text_field() to prevent XSS while allowing valid hook characters
* [Security] Added validation for schedule intervals to prevent invalid values
* [Security] Strengthened authorization checks in admin screen methods
* [Security] Enhanced output escaping in event row view template
* [Security] Standardized nonce verification in AJAX handlers with better input validation
* [Security] Added proper validation and sanitization for server settings
* [Security] Fixed unsanitized input in FormProvider.php schedule slug handling
* [Fixed] Fixed PHP 8.4 deprecation warning with trigger_error() by replacing with exception
* [Fixed] Fixed TypeError on PHP 8.3+ where count() was called on non-countable value in Event implementation
* [Changed] Updated WordPress Coding Standards to version 3.2 and resolved all coding standard warnings
* [Changed] Renamed reserved keyword parameters for better PHP compatibility ($protected to $is_protected, $new to $new_event)

= 2.6.3 =
* [Fixed] Fixed translation loading issue that was triggered too early in AdminScreen constructor.
* [Fixed] Fixed AdminScreen instance inconsistency that prevented CSS and JS assets from loading on plugin page.
* [Fixed] Fixed schedules variable conflict that prevented schedules table from displaying properly.
* [Changed] Merged ScreenRegisterer class with AdminScreen class for better code organization.

= 2.6.2 =
* [Fixed] Fixed stable package creation issues - moved package exclusions to .distignore and ensured vendor and assets directories are included.

= 2.6.1 =
* [Changed] Exclude Claude configuration files from plugin distribution exports.
* [Changed] Add composer and yarn build steps to stable release workflow.

= 2.6.0 =
* [Changed] Removed textdomain loading to fix WordPress 6.7+ localization warnings - translations now load automatically from GlotPress.
* [Changed] Server Scheduler section now detects when DISABLE_WP_CRON constant is defined in wp-config.php.
* [Changed] Updated GitHub Actions stable workflow to use latest action versions and simplified deployment process.

= 2.5.10 =
* [Fixed] Fixed security issue causing subscribers could see the schedules or events.

= 2.5.9 =
* [Fixed] Missing plugin assets in package.

= 2.5.8 =
* [Fixed] Undefined variable typo.

= 2.5.7 =
* [Fixed] Plugin package.

= 2.5.6 =
* [Fixed] Security vulnerability.

= 2.5.5 =
* [Added] Custom schedules availability info.

= 2.5.4 =
* [Added] Code filters and actions. Required by Advanced Cron Manager PRO v2.7.

= 2.5.3 =
* [Security] Some input fields were not sanitized properly.

= 2.5.2 =
* [Fixed] Warning while adding new event.
* [Changed] Adding a proper message when you try to delete non-existing event.

= 2.5.1 =
* [Fixed] Dynamic property notices.
* [Fixed] Notice when adding event without arguments.
* [Fixed] Server scheduler conditional display logic.
* [Fixed] PHP 8 deprecated dynamic property creation.
* [Changed] Fixed typos.
* [Added] New WordPress protected events.

= 2.5.0 =
* [Changed] Updated dependencies (Node >= 12)
* [Changed] Adding a new event form now has more user-friendly argument management.
* [Added] Listeners - with PRO version you can now see all the methods hooked into the particular event.
* [Added] Event argument preview - arguments that contain objects, arrays, or are longer than 10 characters are now nicely formatted inside a modal.

= 2.4.2 =
* [Fixed] Link to server scheduler documentation
* [Fixed] Unauthorized actions. Now all the plugin actions are checking if the user is allowed to run them.

= 2.4.1 =
* [Fixed] Composer dev dependencies are now not bundled in the production package
* [Fixed] "nul" typo causing fatal errors on newer PHP versions
* [Changed] Updated composer dependencies

= 2.4.0 =
* [Added] Event columns sorting
* [Fixed] Cron hook sanitizer doesn't allow usage of slashes
* [Fixed] Update list of protected events
* [Fixed] Preserve search when events table rerender
* [Changed] Don't allow to pause protected events

= 2.3.10 =
* [Fixed] A "Trying to get property 'hash' of non-object" warning fix when executed event doesn't exist anymore
* [Added] Action for adding own event row actions

= 2.3.9 =
* [Fixed] "non-numeric value encountered" error with event arguments
* [Fixed] Fatal error when even argument was an object. Now, class name is displayed
* [Changed] Now when event is executed manually, DOING_CRON constant is defined

= 2.3.8 =
* [Fixed] Events table width
* [Changed] ACF PRO download link

= 2.3.7 =
* [Fixed] WordPress <4.7 compatibility

= 2.3.6 =
* [Fixed] PHP 7.2 compatibility

= 2.3.5 =
* [Fixed] Fatal error when event argument was an object
* [Fixed] Notices
* [Fixed] Arguments list in the events table
* [Changed] Composer libraries updated
* [Changed] Node packages updated
* [Added] Plugin action link on Plugins table

= 2.3.4
* [Fixed] wp-hooks script handle, causing the page to not load plugin's JavaScript

= 2.3.3
* [Changed] JavaScript hooks library which was conflicting with Gutenberg

= 2.3.2 =
* [Fixed] i18n of Apply button
* [Added] Scheduled and Uncheduled actions for events

= 2.3.1 =
* [Fixed] Array to string conversion error fix for event arguments
* [Fixed] Missing old plugin file error fix
* [Added] Notification plugin promo box

= 2.3.0 =
* [Changed] Proper compatibility with PHP 5.3
* [Changed] Updated composer libraries
* [Changed] Dice Container is not longer used
* [Fixed] Problem with nested Composer environment, thanks to @v_decadence
* [Fixed] Assets vendor directory

= 2.2.3 =
* [Added] Compatibility with PHP 5.3 with Dice library
* [Changed] PHP 5.6 requirement to PHP 5.3
* [Changed] Moved Container to separate file

= 2.2.2 =
* [Changed] Minimum PHP version to 5.6

= 2.2.1 =
* [Fixed] Delete file where DI52 container was still used

= 2.2.0 =
* [Changed] Updated composer libraries
* [Changed] Changed DI52 Container to Dice in own namespace
* [Added] Server Scheduler section with information about hooking the WP Cron to server scheduler

= 2.1.2 =
* [Changed] Schedules can be registered in the system with 0s interval, thanks to @barryalbert

= 2.1.1 =
* [Changed] Requirements lib has been moved to Composer

= 2.1.0 =
* [Changed] Utilities classes has been moved to separate composer libraries
* [Changed] Requirements checks
* [Changed] date() function to date_i18n()
* [Fixed] Deprecated function has been updated
* [Fixed] Translations. There was few missing gettext functions
* [Added] Schedules dropdown in add new event form now includes schedule's slug
* [Added] Sanitization of Schedule and Event slugs in Add forms

= 2.0.0 =
* [Changed] Pretty much everything. There's new interface and code base.
* [Added] Events search
* [Added] Ability to pause/unpause events
* [Added] Ability to edit schedules
* [Added] Example PHP implementation for each event (action and callback function)
* [Added] Bulk actions

= 1.5 =
* [Fixed] Manual execution of task which is giving an errors

= 1.4.4 =
* [Added] French translation thanks to Laurent Naudier
* [Changed] Promo box from Popslide plugin to Notification

= 1.4.3 =
* Metabox promo update

= 1.4.1 =
* Fixed executing when args are provided

= 1.4 =
* Added hooks for PRO version
* Removed PHP closing tags
* Added settings widget

= 1.3.2 =
* Fixed arguments passed to the action on AJAX request

= 1.3 =
* Added promo metabox
* WordPress 4.1 comatybility check
* Updated translation
* Added plugin icon

= 1.2 =
* Readme improvement
* Added execution button
* Removed debug alert

= 1.1 =
* Fixed Schedules list from other plugins

= 1.0 =
* Plugin release

== Upgrade Notice ==

= 2.4.2 =
Security release.

= 2.0.0 =
* Plugin has been rebuilt from a scratch.
* If you are using Advanced Cron Manager PRO please upgrade it too!
* It's needed to reactivate the plugin!

= 1.2 =
Removed debug alert and added execution button

= 1.1 =
Fixed Schedules list from other plugins

= 1.0 =
Plugin release
