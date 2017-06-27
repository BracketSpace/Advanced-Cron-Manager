<?php
/**
 * Events Library class
 * Handles DB operations on events
 */

namespace underDEV\AdvancedCronManager\Cron;
use underDEV\AdvancedCronManager\Utils;

class EventsLibrary {

	/**
	 * Schedules class
	 * @var instance of underDEV\AdvancedCronManage\Cron\Schedules
	 */
	public $schedules;

	/**
	 * Constructor
	 */
	public function __construct( Schedules $schedules ) {

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

}
