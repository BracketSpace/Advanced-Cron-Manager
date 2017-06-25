<?php
/**
 * Schedules Library class
 * Handles DB operations on schedules
 */

namespace underDEV\AdvancedCronManager\Cron;
use underDEV\AdvancedCronManager\Utils;

class SchedulesLibrary {

	/**
	 * Ajax class
	 * @var instance of underDEV\AdvancedCronManage\Utils\Ajax
	 */
	public $ajax;

	/**
	 * Option name
	 * @var string
	 */
	private $option_name;

	/**
	 * Saved schedules
	 * Format: schedule_slug => array( 'interval' => $interval, 'display' => $display )
	 * @var array
	 */
	private $schedules = array();

	/**
	 * Constructor
	 */
	public function __construct( Utils\Ajax $ajax ) {

		$this->ajax        = $ajax;
		$this->option_name = 'acm_schedules';

	}

	/**
	 * Gets all saved schedules
	 * Supports lazy loading
	 * @param  boolean $force if refresh stored schedules
	 * @return array          saved schedules
	 */
	public function get_schedules( $force = false ) {

		if ( empty( $this->schedules ) || $force ) {

			$this->schedules = array();

			$schedules = get_option( $this->option_name, array() );

			foreach ( $schedules as $schedule_slug => $params ) {
				$this->schedules[ $schedule_slug ] = new Object\Schedule( $schedule_slug, $params['interval'], $params['display'], false );
			}

		}

		return $this->schedules;

	}

	/**
	 * Gets single schedule
	 * @param  string $slug Schedule slug
	 * @return mixed        Schedule object on success or false
	 */
	public function get_schedule( $slug = '' ) {

		if ( empty( $slug ) ) {
			trigger_error( 'Schedule slug cannot be empty' );
		}

		$schedules = $this->get_schedules();

		return isset( $schedules[ $slug ] ) ? $schedules[ $slug ] : false;

	}

	/**
	 * Check if schedule is saved by ACM
	 * @param  string  $schedule_slug schedule slug
	 * @return boolean                true if yes
	 */
	public function has( $schedule_slug ) {
		$schedules = $this->get_schedules();
		return isset( $schedules[ $schedule_slug ] );
	}

	/**
	 * Inserts new schedule in the database
	 * It also refreshed the current schedules
	 * @param  string $slug     Schedule slug
	 * @param  string $name     Schedule name
	 * @param  int    $interval Schedule interval in seconds
	 * @param  bool   $edit     is this an edit action?
	 * @return mixed            true on success or array with errors
	 */
	public function insert( $slug, $name, $interval = 0, $edit = false ) {

		$errors = array();

		if ( empty( $name ) ) {
			$errors[] = __( 'Please, provide a name for your Schedule' );
		}

		if ( empty( $slug ) ) {
			$errors[] = __( 'Please, provide a slug for your Schedule' );
		}

		if ( $interval < 1 ) {
			$errors[] = __( 'Interval cannot be shorter than 1 second' );
		}

		if ( ! $edit && $this->has( $slug ) ) {
			$errors[] = sprintf( __( 'Schedule with slug "%s" already exists' ), $slug );
		}

		if ( $edit ) {

			if ( ! $this->has( $slug ) ) {
				$errors[] = sprintf( __( 'Schedule with slug "%s" doesn\'t exists' ), $slug );
			}

			if ( $this->get_schedule( $slug )->protected ) {
				$errors[] = sprintf( __( 'Schedule "%s" is protected and you cannot edit it' ), $slug );
			}

		}

		if ( ! empty( $errors ) ) {
			return $errors;
		}

		$schedules = get_option( $this->option_name, array() );

		$schedules[ $slug ] = array(
			'interval' => $interval,
			'display' => $name
		);

		update_option( $this->option_name, $schedules );

		$this->schedules[ $slug ] = new Object\Schedule( $slug, $interval, $name, false );

		return true;


	}

	/**
	 * Inserts new schedule in the database
	 * It also refreshed the current schedules
	 * @param  string $slug     Schedule slug
	 * @return mixed            true on success or array with errors
	 */
	public function remove( $slug ) {

		$errors = array();

		if ( ! $this->has( $slug ) ) {
			$errors[] = sprintf( __( 'Schedule with slug "%s" cannot be removed because it doesn\'t exists' ), $slug );
		}

		if ( ! empty( $errors ) ) {
			return $errors;
		}

		$schedules = get_option( $this->option_name, array() );
		unset( $schedules[ $slug ] );
		update_option( $this->option_name, $schedules );

		unset( $this->schedules[ $slug ] );

		return true;

	}

	/**
	 * Insert schedule
	 * @return void
	 */
	public function ajax_insert() {

		$this->ajax->verify_nonce( 'acm/schedule/insert' );

		$data = wp_parse_args( $_REQUEST['data'], array() );

		$result = $this->insert( $data['slug'], $data['name'], $data['interval'] );

		if ( is_array( $result ) ) {
			$errors = $result;
		} else {
			$errors = array();
		}

		$success = sprintf( __( 'Schedule "%s" has been added' ), $data['name'] );

		$this->ajax->response( $success, $errors );

	}

	/**
	 * Edit schedule
	 * @return void
	 */
	public function ajax_edit() {

		$this->ajax->verify_nonce( 'acm/schedule/edit' );

		$data = wp_parse_args( $_REQUEST['data'], array() );

		$result = $this->insert( $data['slug'], $data['name'], $data['interval'], true );

		if ( is_array( $result ) ) {
			$errors = $result;
		} else {
			$errors = array();
		}

		$success = sprintf( __( 'Schedule "%s" has been edited' ), $data['name'] );

		$this->ajax->response( $success, $errors );

	}

	/**
	 * Remove schedule
	 * @return void
	 */
	public function ajax_remove() {

		$schedule_slug = $_REQUEST['schedule'];

		$this->ajax->verify_nonce( 'acm/schedule/remove/' . $schedule_slug );

		$result = $this->remove( $schedule_slug );

		if ( is_array( $result ) ) {
			$errors = $result;
		} else {
			$errors = array();
		}

		$success = sprintf( __( 'Schedule "%s" has been removed' ), $schedule_slug );

		$this->ajax->response( $success, $errors );

	}

}
