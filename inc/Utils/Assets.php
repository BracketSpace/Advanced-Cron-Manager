<?php
/**
 * Assets class
 * Loads plugin assets
 */

namespace underDEV\AdvancedCronManager\Utils;

class Assets {

	/**
	 * Current plugin version
	 * @var string
	 */
	public $plugin_version;

	/**
	 * Files class
	 * @var instance of underDEV\AdvancedCronManager\Files
	 */
	public $files;

	public function __construct( $version, Files $files ) {

		$this->plugin_version = $version;
		$this->files          = $files;

	}

	/**
	 * Enqueue admin scripts
	 * @return void
	 */
	public function enqueue_admin() {



	}

}
