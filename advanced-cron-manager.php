<?php
/**
 * Plugin Name: Advanced Cron Manager
 * Description: View, pause, remove, edit and add WP Cron events.
 * Version: 2.0.0
 * Author: underDEV
 * Author URI: https://underdev.it
 * License: GPL3
 * Text Domain: advanced-cron-manager
 */

/**
 * Fire up Composer's autoloader
 */
require_once( 'vendor/autoload.php' );

/**
 * Check minimum requirements of the plugin
 * @param string $php_ver The minimum PHP version.
 * @param string $wp_ver  The minimum WP version.
 * @param string $name    The name of the theme/plugin to check.
 * @param array  $plugins Required plugins format plugin_path/plugin_name.
 */
$requirements = new Minimum_Requirements( '5.3.9', '3.6', __( 'Advanced Cron Manager', 'advanced-cron-manager' ), array() );

/**
 * Check compatibility on activation
 */
register_activation_hook( __FILE__, array( $requirements, 'check_compatibility_on_install' ) );

/**
 * If it is already installed and activated check if example new version is compatible,
 * if is not don't load plugin code and print admin_notice
 */
if ( ! $requirements->is_compatible_version() ) {
	add_action( 'admin_notices', array( $requirements, 'load_plugin_admin_notices' ) );
	return;
}

/**
 * Fire up dependency injection container
 */
$container = new tad_DI52_Container();

$container->setVar( 'plugin_file', __FILE__ );
$container->setVar( 'plugin_version', '2.0' );

// Registers all classes and their dependencies
$container->register( 'underDEV\AdvancedCronManager\RuntimeProvider' );
