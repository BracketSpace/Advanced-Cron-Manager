<?php
/**
 * RuntimeProvider class
 */

namespace underDEV\AdvancedCronManager;
use tad_DI52_ServiceProvider;

class RuntimeProvider extends tad_DI52_ServiceProvider {

	public function register() {

		$this->container->singleton( 'underDEV\AdvancedCronManager\Utils\Files', function( $c ) {
			return new Utils\Files( $c->getVar( 'plugin_file' ) );
		} );

		$this->container->singleton( 'underDEV\AdvancedCronManager\Utils\Assets', function( $c ) {
			return new Utils\Assets( $c->getVar( 'plugin_version' ), $c->make( 'underDEV\AdvancedCronManager\Utils\Files' ) );
		} );

		$this->add_actions();

	}

	public function add_actions() {

		// Load textdomain
		add_action( 'plugins_loaded', $this->container->callback( 'underDEV\AdvancedCronManager\Internationalization', 'load_textdomain' ) );

		// Add plugin's screen in the admin
		add_action( 'admin_menu', $this->container->callback( 'underDEV\AdvancedCronManager\AdminScreen', 'register_screen' ) );

		// Enqueue assets
		add_action( 'admin_enqueue_scripts', $this->container->callback( 'underDEV\AdvancedCronManager\Utils\Assets', 'enqueue_admin' ), 10, 1 );

	}

}
