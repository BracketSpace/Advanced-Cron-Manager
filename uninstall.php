<?php
/**
 * Uninstall file
 * Called when plugin is uninstalled
 *
 * Tasks:
 * 1. reschedules paused events
 * 2. removes acm_* options from wp_options
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

/**
 * Fire up Composer's autoloader
 */
require_once( 'vendor/autoload.php' );

// 1.

$dice = new underDEV\Utils\Dice;

$events_library = $dice->create( 'underDEV\AdvancedCronManager\Cron\EventsLibrary' );
$paused_events  = $events_library->register_paused( array() );

foreach ( $paused_events as $event ) {
	$events_library->unpause( $event );
}

// 2.

delete_option( 'acm_paused_events' );
delete_option( 'acm_schedules' );
delete_option( 'acm_server_settings' );
