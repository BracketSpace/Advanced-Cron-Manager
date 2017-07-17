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
 * Fire up dependency injection container
 */
$container = new tad_DI52_Container();

$container->setVar( 'plugin_file', __FILE__ );
$container->setVar( 'plugin_version', '2.0' );

// Registers all classes and their dependencies
$container->register( 'underDEV\AdvancedCronManager\RuntimeProvider' );
