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
 * Check requirements
 */
require_once( 'inc/Requirements.php' );

$requirements = new underDEV_Requirements( __( 'Advanced Cron Manager' ), array(
	'php'         => '5.3.9',
	'wp'          => '3.6',
	'old_plugins' => array(
		'advanced-cron-manager-pro/acm-pro.php' => array(
			'name' => 'Advanced Cron Manager PRO',
			'version' => '2.0'
		),
	)
) );

if ( ! $requirements->satisfied() ) {

	add_action( 'admin_notices', array( $requirements, 'notice' ) );
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
