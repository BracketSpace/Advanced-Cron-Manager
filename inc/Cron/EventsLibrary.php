<?php
/**
 * Events Library class
 * Handles DB operations on events
 */

namespace underDEV\AdvancedCronManager\Cron;
use underDEV\AdvancedCronManager\Utils;

class EventsLibrary {

	/**
	 * Ajax class
	 * @var instance of underDEV\AdvancedCronManage\Utils\Ajax
	 */
	public $ajax;

	/**
	 * Schedules class
	 * @var instance of underDEV\AdvancedCronManage\Cron\Schedules
	 */
	public $schedules;

	/**
	 * Constructor
	 */
	public function __construct( Utils\Ajax $ajax, Schedules $schedules ) {

		$this->ajax      = $ajax;
		$this->schedules = $schedules;

	}

	/**
	 * Inserts new event
	 * @param  string $hook                action hook name
	 * @param  int    $execution_timestamp UTC timestamp for first execution
	 * @param  string $schedule_slug       Schedule slug
	 * @param  array  $args                arguments
	 * @return mixed                       array with errors on error or true
	 */
	public function insert( $hook, $execution_timestamp, $schedule_slug, $args ) {

		$errors = array();

		if ( empty( $hook ) ) {
			$errors[] = __( 'Please, provide a hook for your Event' );
		}

		$schedule = $this->schedules->get_schedule( $schedule_slug );

		if ( $schedule->slug != $schedule_slug ) {
			$errors[] = sprintf( __( 'Schedule "%s" cannot be found' ), $schedule_slug );
		}

		if ( ! empty( $errors ) ) {
			return $errors;
		}

		if ( $schedule->slug == $this->schedules->get_single_event_schedule()->slug ) {
			wp_schedule_single_event( $execution_timestamp, $hook, $args );
		} else {
			wp_schedule_event( $execution_timestamp, $schedule->slug, $hook, $args);
		}

		return true;

	}

	/**
	 * Insert event
	 * @return void
	 */
	public function ajax_insert() {

		$this->ajax->verify_nonce( 'acm/event/insert' );

		$data = wp_parse_args( $_REQUEST['data'], array() );

		$execution = strtotime( $data['execution'] ) ? strtotime( $data['execution'] ) + ( HOUR_IN_SECONDS * $data['execution_offset'] ) : time() + ( HOUR_IN_SECONDS * $data['execution_offset'] );

		$args = array();
		foreach ( $data['arguments'] as $arg_raw ) {
			if ( ! empty( $arg_raw ) ) {
				$args[] = $arg_raw;
			}
		}

		$result = $this->insert( $data['hook'], $execution, $data['schedule'], $args );

		if ( is_array( $result ) ) {
			$errors = $result;
		} else {
			$errors = array();
		}

		$schedule = $this->schedules->get_schedule( $data['schedule'] );

		$arg_num = count( $args );

		$success = sprintf(
			esc_html( _n( 'Event "%s" with %d argument has been scheduled (%s)', 'Event "%s" with %d arguments has been scheduled (%s)', $arg_num, 'advanced-cron-manager'  ) ),
			$data['hook'], $arg_num, $schedule->label
		);

		$this->ajax->response( $success, $errors );

	}

}
