<?php
/**
 * Uninstall file
 * Called when plugin is uninstalled
 *
 * Does nothing when the "Remove plugin data on uninstall" setting is disabled,
 * so the data stays in the database for a reinstall.
 *
 * Tasks:
 * 1. reschedules paused events
 * 2. removes acm_* options from wp_options
 *
 * @package advanced-cron-manager
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

$acm_settings = get_option( 'acm_settings', array() );

if ( is_array( $acm_settings ) && isset( $acm_settings['uninstall_cleanup'] ) && ! $acm_settings['uninstall_cleanup'] ) {
	return;
}

$plugin_version = 'x';
$plugin_file    = __DIR__ . '/advanced-cron-manager.php';

/**
 * Fire up Composer's autoloader
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Bootstrap plugin
 */

$ajax = function () {
	return new underDEV\Utils\Ajax();
};

$schedules_library = new underDEV\AdvancedCronManager\Cron\SchedulesLibrary( $ajax() );

// The plugin is not loaded during uninstall, so the custom schedules have to be
// registered manually. Otherwise paused events using them cannot be rescheduled.
add_filter( 'cron_schedules', array( $schedules_library, 'register' ), 10, 1 ); // phpcs:ignore

$schedules = function () use ( $schedules_library ) {
	return new underDEV\AdvancedCronManager\Cron\Schedules( $schedules_library );
};

$events = function () use ( $schedules ) {
	return new underDEV\AdvancedCronManager\Cron\Events( $schedules() );
};

$events_library = new underDEV\AdvancedCronManager\Cron\EventsLibrary( $schedules(), $events() );

// 1.

$paused_events = $events_library->register_paused( array() );

foreach ( $paused_events as $event ) {
	$events_library->unpause( $event );
}

// 2.

delete_option( 'acm_paused_events' );
delete_option( 'acm_schedules' );
delete_option( 'acm_settings' );
delete_option( 'acm_server_settings' );
