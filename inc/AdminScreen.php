<?php
/**
 * AdminScreen class
 * Displays admin screen
 *
 * @package advanced-cron-manager
 */

namespace underDEV\AdvancedCronManager;

use underDEV\AdvancedCronManager\Cron\Element\Event;
use underDEV\Utils;
use underDEV\AdvancedCronManager\Cron;

/**
 * Admin Screen class.
 */
class AdminScreen {

	/**
	 * View class
	 *
	 * @var instance of underDEV\AdvancedCronManage\Utils\View
	 */
	public $view;

	/**
	 * Ajax class
	 *
	 * @var instance of underDEV\AdvancedCronManage\Utils\Ajax
	 */
	public $ajax;

	/**
	 * Schedules class
	 *
	 * @var instance of underDEV\AdvancedCronManage\Cron\Schedules
	 */
	public $schedules;

	/**
	 * Events class
	 *
	 * @var instance of underDEV\AdvancedCronManage\Cron\Events
	 */
	public $events;

	/**
	 * Default tab names for events
	 *
	 * @var array
	 */
	protected $default_event_details_tabs;

	/**
	 * Constructor
	 *
	 * @param Utils\View     $view      View class.
	 * @param Utils\Ajax     $ajax      Ajax class.
	 * @param Cron\Schedules $schedules Schedules class.
	 * @param Cron\Events    $events    Events class.
	 */
	public function __construct( Utils\View $view, Utils\Ajax $ajax, Cron\Schedules $schedules, Cron\Events $events ) {

		$this->view      = $view;
		$this->ajax      = $ajax;
		$this->schedules = $schedules;
		$this->events    = $events;

		$this->default_event_details_tabs = array(
			'logs'           => __( 'Logs', 'advanced-cron-manager' ),
			'arguments'      => __( 'Arguments', 'advanced-cron-manager' ),
			'schedule'       => __( 'Schedule', 'advanced-cron-manager' ),
			'implementation' => __( 'Implementation', 'advanced-cron-manager' ),
			'listeners'      => __( 'Listeners', 'advanced-cron-manager' ),
		);

	}

	/**
	 * Call method
	 *
	 * @param  string $method Called method.
	 * @param  array  $args   Arguments.
	 * @return mixed
	 */
	public function __call( $method, $args ) {

		if ( strpos( $method, 'ajax_rerender_' ) !== false ) {

			/**
			 * From: ajax_rerender_schedules_table
			 * To:   load_schedules_table_part
			 */
			$method_to_call = str_replace( 'ajax_rerender_', 'load_', $method . '_part' );

			ob_start();

			call_user_func( array( $this, $method_to_call ), $this );

			$this->ajax->success( ob_get_clean() );

		}

	}

	/**
	 * Loads the page screen
	 *
	 * @return void
	 */
	public function load_page_wrapper() {
		$this->view->get_view( 'wrapper' );
	}

	/**
	 * Loads searchbox
	 * There are used $this->view instead of passed instance
	 * because we want to separate scopes
	 *
	 * @param  object $view instance of parent view.
	 * @return void
	 */
	public function load_searchbox_part( $view ) {
		$this->view->get_view( 'parts/searchbox' );
	}

	/**
	 * Loads events table
	 * There are used $this->view instead of passed instance
	 * because we want to separate scopes
	 *
	 * @param  object $view instance of parent view.
	 * @return void
	 */
	public function load_events_table_part( $view ) {

		$this->view->set_var( 'events', $this->events->get_events() );
		$this->view->set_var( 'events_count', $this->events->count() );
		$this->view->set_var( 'schedules', $this->schedules );

		/**
		 * It should be an array in format: tab_slug => Tab Name
		 */
		$this->view->set_var( 'details_tabs', apply_filters( 'advanced-cron-manager/screen/event/details/tabs', array() ) );

		$this->view->get_view( 'parts/events/section' );

	}

	/**
	 * Loads schedules table
	 * There are used $this->view instead of passed instance
	 * because we want to separate scopes
	 *
	 * @param  object $view instance of parent view.
	 * @return void
	 */
	public function load_schedules_table_part( $view ) {

		$this->view->set_var( 'schedules', $this->schedules->get_schedules() );

		$this->view->get_view( 'parts/schedules/section' );

	}

	/**
	 * Loads slidebar template
	 * There are used $this->view instead of passed instance
	 * because we want to separate scopes
	 *
	 * @param  object $view instance of parent view.
	 * @return void
	 */
	public function load_slidebar_part( $view ) {
		$this->view->get_view( 'elements/slidebar' );
	}

	/**
	 * Loads preview modal template
	 * There are used $this->view instead of passed instance
	 * because we want to separate scopes
	 *
	 * @param  object $view instance of parent view.
	 * @return void
	 */
	public function load_preview_modal_part( $view ) {
		$this->view->get_view( 'elements/preview-modal' );
	}

	/**
	 * Adds default event details tabs
	 * It also registers the actions for the content
	 *
	 * @param array $tabs filtered tabs.
	 */
	public function add_default_event_details_tabs( $tabs ) {

		foreach ( $this->default_event_details_tabs as $tab_slug => $tab_name ) {
			$tabs[ $tab_slug ] = $tab_name;
			add_action( 'advanced-cron-manager/screen/event/details/tab/' . $tab_slug, array( $this, 'load_event_tab_' . $tab_slug ), 10, 1 );
		}

		return $tabs;

	}

	/**
	 * Loads Logs tab content for event details
	 * Scope for $view is the same as in events/section view
	 *
	 * @param  object $view local View instance.
	 * @return void
	 */
	public function load_event_tab_logs( $view ) {
		if ( apply_filters( 'advanced-cron-manager/screen/event/details/tabs/logs/display', true ) ) {
			$view->get_view( 'parts/events/tabs/logs' );
		}
	}

	/**
	 * Loads Listeners tab content for event details
	 * Scope for $view is the same as in events/section view
	 *
	 * @param  object $view local View instance.
	 * @return void
	 */
	public function load_event_tab_listeners( $view ) {
		if ( apply_filters( 'advanced-cron-manager/screen/event/details/tabs/listeners/display', true ) ) {
			$view->get_view( 'parts/events/tabs/listeners' );
		}
	}

	/**
	 * Loads Arguments tab content for event details
	 * Scope for $view is the same as in events/section view
	 *
	 * @param  object $view local View instance.
	 * @return void
	 */
	public function load_event_tab_arguments( $view ) {
		if ( apply_filters( 'advanced-cron-manager/screen/event/details/tabs/arguments/display', true ) ) {
			$view->get_view( 'parts/events/tabs/arguments' );
		}
	}

	/**
	 * Loads Schedule tab content for event details
	 * Scope for $view is the same as in events/section view
	 *
	 * @param  object $view local View instance.
	 * @return void
	 */
	public function load_event_tab_schedule( $view ) {
		if ( apply_filters( 'advanced-cron-manager/screen/event/details/tabs/schedule/display', true ) ) {
			$view->get_view( 'parts/events/tabs/schedule' );
		}
	}

	/**
	 * Loads Implementation tab content for event details
	 * Scope for $view is the same as in events/section view
	 *
	 * @param  object $view local View instance.
	 * @return void
	 */
	public function load_event_tab_implementation( $view ) {
		if ( apply_filters( 'advanced-cron-manager/screen/event/details/tabs/implementation/display', true ) ) {
			$view->get_view( 'parts/events/tabs/implementation' );
		}
	}

	/**
	 * Prepare event arguments for row
	 *
	 * @param  Event $event Event object.
	 * @return array<mixed>
	 */
	public static function prepare_event_arguments( $event ) {
		$parsed_args       = array();
		$show_args_preview = false;

		foreach ( $event->args as $arg ) {
			if ( is_array( $arg ) || is_bool( $arg ) ) {
				$parsed_args[] = array(
					'type' => gettype( $arg ),
					'msg'  => wp_json_encode( $arg ),
				);
			} elseif ( is_object( $arg ) ) {
				$parsed_args[] = array(
					'type'      => gettype( $arg ),
					'msg'       => wp_json_encode( $arg ),
					'className' => get_class( $arg ),
				);
			} else {
				$parsed_args[] = array(
					'type' => gettype( $arg ),
					'msg'  => $arg,
				);
			}

			$show_args_preview = is_array( $arg ) || is_object( $arg );
		}

		$args_length = array_sum( array_map( function( $ar ) {
			return strlen( $ar['msg'] );
		}, $parsed_args ) );

		return array(
			'args_length'       => $args_length,
			'parsed_args'       => $parsed_args,
			'show_args_preview' => $show_args_preview,
		);
	}

}
