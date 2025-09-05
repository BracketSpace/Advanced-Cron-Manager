<?php
/**
 * Schedules Actions class
 * Handles actions on schedules
 *
 * @package advanced-cron-manager
 */

namespace underDEV\AdvancedCronManager\Cron;

use underDEV\Utils;

/**
 * SchedulesActions class
 */
class SchedulesActions {

	/**
	 * Ajax class
	 *
	 * @var instance of underDEV\AdvancedCronManage\Utils\Ajax
	 */
	private $ajax;

	/**
	 * SchedulesLibrary class
	 *
	 * @var instance of underDEV\AdvancedCronManage\Cron\SchedulesLibrary
	 */
	private $library;

	/**
	 * Constructor
	 *
	 * @since 2.4.0
	 * @param Utils\Ajax       $ajax    Ajax object.
	 * @param SchedulesLibrary $library SchedulesLibrary object.
	 */
	public function __construct( Utils\Ajax $ajax, SchedulesLibrary $library ) {
		$this->ajax    = $ajax;
		$this->library = $library;
	}

	/**
	 * Insert schedule
	 *
	 * @return void
	 */
	public function insert() {

		$this->ajax->verify_nonce( 'acm/schedule/insert' );

		if ( ! current_user_can( 'manage_options' ) ) {
			$this->ajax->response( false, array(
				__( "You're not allowed to do that.", 'advanced-cron-manager' ),
			) );
		}

		// phpcs:ignore
		$data = wp_parse_args( $_REQUEST['data'], array() );

		$slug = sanitize_title_with_dashes( $data['slug'], null, 'save' );
		$slug = str_replace( '-', '_', $slug );

		// Validate interval - must be between 60 seconds and 1 year.
		$interval = absint( $data['interval'] );
		if ( $interval < 60 || $interval > YEAR_IN_SECONDS ) {
			$this->ajax->response( false, array(
				__( 'Interval must be between 60 seconds and 1 year.', 'advanced-cron-manager' ),
			) );
		}

		$result = $this->library->insert( $slug, sanitize_text_field( $data['name'] ), $interval );

		if ( is_array( $result ) ) {
			$errors = $result;
		} else {
			$errors = array();
		}

		// Translators: schedule slug.
		$success = sprintf( __( 'Schedule "%s" has been added', 'advanced-cron-manager' ), $data['name'] );

		$this->ajax->response( $success, $errors );
	}

	/**
	 * Edit schedule
	 *
	 * @return void
	 */
	public function edit() {

		$this->ajax->verify_nonce( 'acm/schedule/edit' );

		if ( ! current_user_can( 'manage_options' ) ) {
			$this->ajax->response( false, array(
				__( "You're not allowed to do that.", 'advanced-cron-manager' ),
			) );
		}

		// phpcs:ignore
		$data = wp_parse_args( $_REQUEST['data'], array() );

		$slug = sanitize_title_with_dashes( $data['slug'], null, 'save' );
		$slug = str_replace( '-', '_', $slug );

		// Validate interval - must be between 60 seconds and 1 year.
		$interval = absint( $data['interval'] );
		if ( $interval < 60 || $interval > YEAR_IN_SECONDS ) {
			$this->ajax->response( false, array(
				__( 'Interval must be between 60 seconds and 1 year.', 'advanced-cron-manager' ),
			) );
		}

		$result = $this->library->insert( $slug, sanitize_text_field( $data['name'] ), $interval, true );

		if ( is_array( $result ) ) {
			$errors = $result;
		} else {
			$errors = array();
		}

		// Translators: schedule slug.
		$success = sprintf( __( 'Schedule "%s" has been edited', 'advanced-cron-manager' ), $data['name'] );

		$this->ajax->response( $success, $errors );
	}

	/**
	 * Remove schedule
	 *
	 * @return void
	 */
	public function remove() {

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Need schedule slug for nonce string.
		$schedule_slug = sanitize_key( isset( $_REQUEST['schedule'] ) ? $_REQUEST['schedule'] : '' );

		if ( empty( $schedule_slug ) ) {
			$this->ajax->response( false, array(
				__( 'Invalid schedule slug.', 'advanced-cron-manager' ),
			) );
		}

		$this->ajax->verify_nonce( 'acm/schedule/remove/' . $schedule_slug );

		if ( ! current_user_can( 'manage_options' ) ) {
			$this->ajax->response( false, array(
				__( "You're not allowed to do that.", 'advanced-cron-manager' ),
			) );
		}

		$result = $this->library->remove( $schedule_slug );

		if ( is_array( $result ) ) {
			$errors = $result;
		} else {
			$errors = array();
		}

		// Translators: schedule slug.
		$success = sprintf( __( 'Schedule "%s" has been removed', 'advanced-cron-manager' ), $schedule_slug );

		$this->ajax->response( $success, $errors );
	}
}
