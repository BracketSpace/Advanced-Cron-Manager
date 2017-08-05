<?php
/**
 * Processor class
 * Blocks WP Cron execution
 */

namespace underDEV\AdvancedCronManager\Server;

class Processor {

	/**
	 * Settings class
	 * @var object
	 */
	public $settings;

	/**
	 * Constructor
	 * @param object $settings Settings class
	 */
	public function __construct( Settings $settings ) {
		$this->settings = $settings;
	}

	/**
	 * Blocks WP Cron default spawning on init action
	 *
	 * @return void
	 */
	public function block_cron_executions() {

		$settings = $this->settings->get_settings();

		if ( isset( $settings['server_enable'] ) && ! empty( $settings['server_enable'] ) ) {

			if ( ! defined( 'DISABLE_WP_CRON' ) ) {
				define( 'DISABLE_WP_CRON', true );
			}

			// just in case the constant is already set to true
			remove_action( 'init', 'wp_cron' );

		}

	}

}
