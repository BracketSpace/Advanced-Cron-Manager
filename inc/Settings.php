<?php
/**
 * Settings class
 * General plugin settings
 *
 * @package advanced-cron-manager
 */

namespace underDEV\AdvancedCronManager;

use underDEV\Utils;

/**
 * Settings class.
 */
class Settings {

	/**
	 * View class
	 *
	 * @var object
	 */
	public $view;

	/**
	 * Ajax class
	 *
	 * @var object
	 */
	private $ajax;

	/**
	 * Option name
	 *
	 * @var string
	 */
	private $option_name;

	/**
	 * Defaults
	 *
	 * @var array|int[]
	 */
	private $default;

	/**
	 * Settings
	 *
	 * @var array
	 */
	private $settings;

	/**
	 * Constructor
	 *
	 * @param Utils\View $view View class.
	 * @param Utils\Ajax $ajax Ajax class.
	 */
	public function __construct( Utils\View $view, Utils\Ajax $ajax ) {
		$this->view = $view;
		$this->ajax = $ajax;

		$this->option_name = 'acm_settings';

		$this->default = array(
			'uninstall_cleanup' => 1,
		);
	}

	/**
	 * Loads plugin settings part
	 *
	 * @return void
	 */
	public function load_settings_part() {
		$this->view->set_var( 'settings', $this->get_settings() );
		$this->view->get_view( 'settings' );
	}

	/**
	 * Gets Settings
	 * Supports lazy loading
	 *
	 * @param  boolean $force if refresh stored settings.
	 * @return array          saved settings merged with defaults
	 */
	public function get_settings( $force = false ) {

		if ( empty( $this->settings ) || $force ) {
			$saved = get_option( $this->option_name, array() );

			$this->settings = wp_parse_args( is_array( $saved ) ? $saved : array(), $this->default );
		}

		return $this->settings;
	}

	/**
	 * Saves settings
	 * Called by AJAX
	 *
	 * @return void
	 */
	public function save_settings() {

		$this->ajax->verify_nonce( 'acm/settings/save' );

		if ( ! current_user_can( 'manage_options' ) ) {
			$this->ajax->response( false, array(
				__( "You're not allowed to do that.", 'advanced-cron-manager' ),
			) );
		}

		$errors = array();

		// Unchecked checkboxes are not submitted, so every known setting falls back to 0.
		$form_options = array_map( function () {
			return 0;
		}, $this->default );

		// phpcs:ignore
		$form_data = wp_parse_args( isset( $_REQUEST['data'] ) ? $_REQUEST['data'] : array(), $form_options );

		$sanitized_data = array();
		foreach ( $this->default as $key => $default_value ) {
			// All current settings are boolean (0 or 1).
			$sanitized_data[ $key ] = absint( $form_data[ $key ] ) === 1 ? 1 : 0;
		}

		update_option( $this->option_name, $sanitized_data );

		$this->settings = null;

		$this->ajax->response( __( 'Settings has been saved', 'advanced-cron-manager' ), $errors );
	}
}
