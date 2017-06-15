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
	 * Files class
	 * @var instance of underDEV\AdvancedCronManager\AdminScreen
	 */
	public $screen;

	public function __construct( $version, Files $files, AdminScreen $screen ) {

		$this->plugin_version = $version;
		$this->files          = $files;
		$this->screen         = $screen;

	}

	/**
	 * Enqueue admin scripts
	 * @return void
	 */
	public function enqueue_admin( $current_page_hook ) {

		if ( $current_page_hook != $this->screen->page_hook ) {
			return;
		}

		wp_enqueue_style( 'advanced-cron-manager', $this->files->asset_url( 'css', 'style.css' ), array(), $this->plugin_version );

	}

}
