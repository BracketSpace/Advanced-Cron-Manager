<?php
/**
 * Events Actions class
 * Handles actions on events
 */

namespace underDEV\AdvancedCronManager\Cron;
use underDEV\AdvancedCronManager\Utils;

class EventsActions {

	/**
	 * Ajax class
	 * @var instance of underDEV\AdvancedCronManage\Utils\Ajax
	 */
	private $ajax;

	/**
	 * Events class
	 * @var instance of underDEV\AdvancedCronManage\Cron\Events
	 */
	private $events;

	/**
	 * EventsLibrary class
	 * @var instance of underDEV\AdvancedCronManage\Cron\EventsLibrary
	 */
	private $library;

	/**
	 * Schedules class
	 * @var instance of underDEV\AdvancedCronManage\Cron\Schedules
	 */
	private $schedules;

	/**
	 * Constructor
	 */
	public function __construct( Utils\Ajax $ajax, Events $events, EventsLibrary $library, Schedules $schedules ) {

		$this->ajax      = $ajax;
		$this->events    = $events;
		$this->library   = $library;
		$this->schedules = $schedules;

	}

	/**
	 * Insert event
	 * @return void
	 */
	public function insert() {

		$this->ajax->verify_nonce( 'acm/event/insert' );

		$data = wp_parse_args( $_REQUEST['data'], array() );

		$execution = strtotime( $data['execution'] ) ? strtotime( $data['execution'] ) + ( HOUR_IN_SECONDS * $data['execution_offset'] ) : time() + ( HOUR_IN_SECONDS * $data['execution_offset'] );

		$args = array();
		foreach ( $data['arguments'] as $arg_raw ) {
			if ( ! empty( $arg_raw ) ) {
				$args[] = $arg_raw;
			}
		}

		$result = $this->library->insert( $data['hook'], $execution, $data['schedule'], $args );

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

	/**
	 * Insert event
	 * @return void
	 */
	public function run() {

		$event = $this->events->get_event_by_hash( $_REQUEST['event'] );

		$this->ajax->verify_nonce( 'acm/event/run/' . $event->hash );

		do_action_ref_array( $event->hook, $event->args );

		$success = sprintf( __( 'Event "%s" has been executed' ), $event->hook );

		$this->ajax->response( $success, array() );

	}

}
