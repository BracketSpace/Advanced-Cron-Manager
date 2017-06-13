<?php
/**
 * RuntimeProvider class
 */

namespace underDEV\AdvancedCronManager;
use tad_DI52_ServiceProvider;

class RuntimeProvider extends tad_DI52_ServiceProvider {

	public function register() {

		$this->container->singleton( 'underDEV\AdvancedCronManager\Files', function( $c ) {
			return new Files( $c->getVar( 'plugin_file' ) );
		} );

		$this->container->singleton( 'underDEV\AdvancedCronManager\AdminScreen', function( $c ) {
			return new AdminScreen();
		} );

		$this->container->singleton( 'underDEV\AdvancedCronManager\Assets', function( $c ) {
			return new Assets( $c->getVar( 'plugin_version' ), $c->make( 'underDEV\AdvancedCronManager\Files' ) );
		} );

	}

}
