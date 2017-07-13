<?php
/**
 * Assets class
 * Loads plugin assets
 */

namespace underDEV\AdvancedCronManager\Utils;
use underDEV\AdvancedCronManager\AdminScreen;

class Assets {

	/**
	 * Current plugin version
	 * @var string
	 */
	public $plugin_version;

	/**
	 * Files class
	 * @var instance of underDEV\AdvancedCronManager\Utils\Files
	 */
	public $files;

	/**
	 * Screen hook handle
	 * @var string
	 */
	public $screen_hook;

	public function __construct( $version, Files $files, $screen_hook ) {

		$this->plugin_version = $version;
		$this->files          = $files;
		$this->screen_hook    = $screen_hook;

	}

	/**
	 * Enqueue admin scripts
	 * @return void
	 */
	public function enqueue_admin( $current_page_hook ) {

		if ( $current_page_hook != $this->screen_hook ) {
			return;
		}

		wp_register_script( 'sprintf', $this->files->vendor_asset_url( 'sprintf', 'sprintf.min.js' ), array(), '1.1.1', true );

		wp_register_script( 'event-manager', $this->files->vendor_asset_url( 'event-manager', 'event-manager.min.js' ), array( 'jquery' ), $this->plugin_version, true );

		wp_register_script( 'materialize', $this->files->vendor_asset_url( 'materialize', 'js/materialize.min.js' ), array( 'jquery' ), '0.98.2', true );
		wp_register_style( 'materialize', $this->files->vendor_asset_url( 'materialize', 'css/materialize.min.css' ), array(), '0.98.2' );

		wp_enqueue_style( 'advanced-cron-manager', $this->files->asset_url( 'css', 'style.css' ), array(), $this->plugin_version );
		wp_enqueue_script( 'advanced-cron-manager', $this->files->asset_url( 'js', 'scripts.min.js' ), array( 'jquery', 'sprintf', 'event-manager', 'materialize' ), $this->plugin_version, true );

		wp_localize_script( 'advanced-cron-manager', 'advanced_cron_manager', array(
			'i18n' => array(
				'executed_with_errors' => __( 'Event has been executed with errors' ),
				'events'               => __( 'events' ),
				'removing'             => __( 'Removing...' ),
				'pausing'              => __( 'Pausing...' )
			)
		) );

		do_action( 'advanced-cron-manager/screen/enqueue', $current_page_hook );

	}

}
