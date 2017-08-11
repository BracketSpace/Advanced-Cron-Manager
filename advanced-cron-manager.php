<?php
/**
 * Plugin Name: Advanced Cron Manager
 * Description: View, pause, remove, edit and add WP Cron events.
 * Version: 2.2.3
 * Author: underDEV
 * Author URI: https://underdev.it
 * License: GPL3
 * Text Domain: advanced-cron-manager
 */

$plugin_version = '2.2.3';
$plugin_file    = __FILE__;
$namespace      = 'underDEV\\AdvancedCronManager\\';

/**
 * Fire up Composer's autoloader
 */
require_once( 'vendor/autoload.php' );

$requirements = new underDEV_Requirements( __( 'Advanced Cron Manager', 'advanced-cron-manager' ), array(
	'php'         => '5.3',
	'wp'          => '3.6',
	'old_plugins' => array(
		'advanced-cron-manager-pro/acm-pro.php' => array(
			'name' => 'Advanced Cron Manager PRO',
			'version' => '2.0'
		),
	)
) );

/**
 * Check if old plugins are active
 * @param  array $plugins array with plugins,
 *                        where key is the plugin file and value is the version
 * @return void
 */
function acm_check_old_plugins( $plugins, $r ) {

	foreach ( $plugins as $plugin_file => $plugin_data ) {

		$old_plugin_version = @get_file_data( WP_PLUGIN_DIR . '/' . $plugin_file , array( 'Version' ) )[0];

		if ( ! empty( $old_plugin_version ) && version_compare( $old_plugin_version, $plugin_data['version'], '<' ) ) {
			$r->add_error( sprintf( '%s plugin at least in version %s', $plugin_data['name'], $plugin_data['version'] ) );
		}

	}

}

if ( method_exists( $requirements, 'add_check' ) ) {
	$requirements->add_check( 'old_plugins', 'acm_check_old_plugins' );
}

if ( ! $requirements->satisfied() ) {

	add_action( 'admin_notices', array( $requirements, 'notice' ) );
	return;

}

/**
 * Fire up dependency injection container and bootstrap all the classes
 */

$dice = require( 'container.php' );

/**
 * Actions
 */

// Load textdomain
add_action( 'plugins_loaded', array( $dice->create( $namespace . 'Internationalization' ), 'load_textdomain' ) );

// Add plugin's screen in the admin
add_action( 'admin_menu', array( $dice->create( $namespace . 'ScreenRegisterer' ), 'register_screen' ) );

// Add main section parts on the admin screen
add_action( 'advanced-cron-manager/screen/main', array( $dice->create( $namespace . 'AdminScreen' ), 'load_searchbox_part' ), 10, 1 );
add_action( 'advanced-cron-manager/screen/main', array( $dice->create( $namespace . 'AdminScreen' ), 'load_events_table_part' ), 20, 1 );

// Add sidebar section parts on the admin screen
add_action( 'advanced-cron-manager/screen/sidebar', array( $dice->create( $namespace . 'AdminScreen' ), 'load_schedules_table_part' ), 10, 1 );

// Add general parts on the admin screen
add_action( 'advanced-cron-manager/screen/wrap/after', array( $dice->create( $namespace . 'AdminScreen' ), 'load_slidebar_part' ), 10, 1 );

// Add tabs to event details
add_filter( 'advanced-cron-manager/screen/event/details/tabs', array( $dice->create( $namespace . 'AdminScreen' ), 'add_default_event_details_tabs' ), 10, 1 );

// Enqueue assets
add_action( 'admin_enqueue_scripts', array( $dice->create( $namespace . 'Assets' ), 'enqueue_admin' ), 10, 1 );

// Forms
add_action( 'wp_ajax_acm/schedule/add/form', array( $dice->create( $namespace . 'FormProvider' ), 'add_schedule' ) );
add_action( 'wp_ajax_acm/schedule/edit/form', array( $dice->create( $namespace . 'FormProvider' ), 'edit_schedule' ) );
add_action( 'wp_ajax_acm/event/add/form', array( $dice->create( $namespace . 'FormProvider' ), 'add_event' ) );

// Schedules
add_filter( 'cron_schedules', array( $dice->create( $namespace . 'Cron\SchedulesLibrary' ), 'register' ), 10, 1 );
add_action( 'wp_ajax_acm/rerender/schedules', array( $dice->create( $namespace . 'AdminScreen' ), 'ajax_rerender_schedules_table' ) );
add_action( 'wp_ajax_acm/schedule/insert', array( $dice->create( $namespace . 'Cron\SchedulesActions' ), 'insert' ) );
add_action( 'wp_ajax_acm/schedule/edit', array( $dice->create( $namespace . 'Cron\SchedulesActions' ), 'edit' ) );
add_action( 'wp_ajax_acm/schedule/remove', array( $dice->create( $namespace . 'Cron\SchedulesActions' ), 'remove' ) );

// Events
add_filter( 'advanced-cron-manager/events/array', array( $dice->create( $namespace . 'Cron\EventsLibrary' ), 'register_paused' ), 10, 1 );
add_action( 'wp_ajax_acm/rerender/events', array( $dice->create( $namespace . 'AdminScreen' ), 'ajax_rerender_events_table' ) );
add_action( 'wp_ajax_acm/event/insert', array( $dice->create( $namespace . 'Cron\EventsActions' ), 'insert' ) );
add_action( 'wp_ajax_acm/event/run', array( $dice->create( $namespace . 'Cron\EventsActions' ), 'run' ) );
add_action( 'wp_ajax_acm/event/remove', array( $dice->create( $namespace . 'Cron\EventsActions' ), 'remove' ) );
add_action( 'wp_ajax_acm/event/pause', array( $dice->create( $namespace . 'Cron\EventsActions' ), 'pause' ) );
add_action( 'wp_ajax_acm/event/unpause', array( $dice->create( $namespace . 'Cron\EventsActions' ), 'unpause' ) );

// Server scheduler
add_action( 'advanced-cron-manager/screen/sidebar', array( $dice->create( $namespace . 'Server\Settings' ), 'load_settings_part' ), 10, 1 );
add_action( 'wp_ajax_acm/server/settings/save', array( $dice->create( $namespace . 'Server\Settings' ), 'save_settings' ) );
add_action( 'plugins_loaded', array( $dice->create( $namespace . 'Server\Processor' ), 'block_cron_executions' ), 10, 1 );
