<?php
/**
 * Events Actions class
 * Handles actions on events
 */

namespace underDEV\AdvancedCronManager\Cron;
use underDEV\Utils;

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

		$hook = sanitize_title_with_dashes( $data['hook'], null, 'save' );
		$hook = str_replace( '-', '_', $hook );

		$result = $this->library->insert( $hook, $execution, $data['schedule'], $args );

		if ( is_array( $result ) ) {
			$errors = $result;
		} else {
			$errors = array();
		}

		$schedule = $this->schedules->get_schedule( $data['schedule'] );

		$arg_num = count( $args );

		$success = sprintf(
			esc_html( _n( 'Event "%s" with %d argument has been scheduled (%s)', 'Event "%s" with %d arguments has been scheduled (%s)', $arg_num, 'advanced-cron-manager'  ) ),
			$hook, $arg_num, $schedule->label
		);

		$this->ajax->response( $success, $errors );

	}

	/**
	 * Insert event
	 * @return void
	 */
	public function run() {

		global $acm_current_event;

		$event = $this->events->get_event_by_hash( $_REQUEST['event'] );

		$this->ajax->verify_nonce( 'acm/event/run/' . $event->hash );

		$acm_current_event = $event;

		if ( ! defined( 'DOING_CRON' ) ) {
			define( 'DOING_CRON', true );
		}

		do_action_ref_array( $event->hook, $event->args );

		$success = sprintf( __( 'Event "%s" has been executed', 'advanced-cron-manager' ), $event->hook );

		$this->ajax->response( $success, array() );

	}

	/**
	 * Remove event
	 * @return void
	 */
	public function remove() {

		$event  = $this->events->get_event_by_hash( $_REQUEST['event'] );
		$errors = array();

		$this->ajax->verify_nonce( 'acm/event/remove/' . $event->hash );

		if ( $event->protected ) {
			$errors = array( sprintf( __( 'Event "%s" is protected and you cannot remove it', 'advanced-cron-manager' ), $event->hook ) );
		}

		$this->library->unschedule( $event );
		$this->library->remove_from_paused( $event );

		$success = sprintf( __( 'Event "%s" has been removed', 'advanced-cron-manager' ), $event->hook );

		$this->ajax->response( $success, $errors );

	}

	/**
	 * Pause event
	 * @return void
	 */
	public function pause() {

		$event = $this->events->get_event_by_hash( $_REQUEST['event'] );

		$this->ajax->verify_nonce( 'acm/event/pause/' . $event->hash );

		$result = $this->library->pause( $event );

		if ( is_array( $result ) ) {
			$errors = $result;
		} else {
			$errors = array();
		}

		$success = sprintf( __( 'Event "%s" has been paused', 'advanced-cron-manager' ), $event->hook );

		$this->ajax->response( $success, $errors );

	}

	/**
	 * Unpause event
	 * @return void
	 */
	public function unpause() {

		$event = $this->events->get_event_by_hash( $_REQUEST['event'] );

		$this->ajax->verify_nonce( 'acm/event/unpause/' . $event->hash );

		$result = $this->library->unpause( $event );

		if ( is_array( $result ) ) {
			$errors = $result;
		} else {
			$errors = array();
		}

		$success = sprintf( __( 'Event "%s" has been unpaused', 'advanced-cron-manager' ), $event->hook );

		$this->ajax->response( $success, $errors );

	}

}
