<?php
/**
 * Plugin Name: Advanced Cron Manager
 * Description: View, pause, remove, edit and add WP Cron events.
 * Version: 2.1.0
 * Author: underDEV
 * Author URI: https://underdev.it
 * License: GPL3
 * Text Domain: advanced-cron-manager
 */

/**
 * Fire up Composer's autoloader
 */
require_once( 'vendor/autoload.php' );

$requirements = new underDEV_Requirements( __( 'Advanced Cron Manager', 'advanced-cron-manager' ), array(
	'php'         => '5.3.9',
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

$requirements->add_check( 'old_plugins', 'acm_check_old_plugins' );

if ( ! $requirements->satisfied() ) {

	add_action( 'admin_notices', array( $requirements, 'notice' ) );
	return;

}

/**
 * Fire up dependency injection container
 */
$container = new tad_DI52_Container();

$container->setVar( 'plugin_file', __FILE__ );
$container->setVar( 'plugin_version', '2.1.0' );

// Registers all classes and their dependencies
$container->register( 'underDEV\AdvancedCronManager\RuntimeProvider' );
