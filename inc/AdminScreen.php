<?php
/**
 * AdminScreen class
 * Displays admin screen
 */

namespace underDEV\AdvancedCronManager;
use underDEV\AdvancedCronManager\Cron;

class AdminScreen {

	/**
	 * View class
	 * @var instance of underDEV\AdvancedCronManage\View
	 */
	public $view;

	/**
	 * Schedules class
	 * @var instance of underDEV\AdvancedCronManage\Cron\Schedules
	 */
	public $schedules;

	/**
	 * Events class
	 * @var instance of underDEV\AdvancedCronManage\Cron\Events
	 */
	public $events;

	/**
	 * Default tab names for events
	 * @var array
	 */
	protected $default_event_details_tabs;

	/**
	 * Contructor
	 * @param View      $view      View class
	 * @param Schedules $schedules Schedules class
	 */
	public function __construct( Utils\View $view, Cron\Schedules $schedules, Cron\Events $events ) {

		$this->view      = $view;
		$this->schedules = $schedules;
		$this->events    = $events;

		$this->default_event_details_tabs = array(
			'logs'           => __( 'Logs' ),
			'arguments'      => __( 'Arguments' ),
			'implementation' => __( 'Implementation' ),
		);

	}

	/**
	 * Loads the page screen
	 * @return void
	 */
	public function load_page_wrapper() {
		$this->view->get_view( 'wrapper' );
	}

	/**
	 * Loads searchbox
	 * There are used $this->view instead of passed instance
	 * because we want to separate scopes
	 * @param  object $view instance of parent view
	 * @return void
	 */
	public function load_searchbox_part( $view ) {
		$this->view->get_view( 'parts/searchbox' );
	}

	/**
	 * Loads events table
	 * There are used $this->view instead of passed instance
	 * because we want to separate scopes
	 * @param  object $view instance of parent view
	 * @return void
	 */
	public function load_events_table_part( $view ) {

		$this->view->set_var( 'events', $this->events->get_events() );
		$this->view->set_var( 'events_count', $this->events->count() );
		$this->view->set_var( 'schedules', $this->schedules );

		/**
		 * It should be an array in format: tab_slug => Tab Name
		 */
		$this->view->set_var( 'details_tabs', apply_filters( 'advanced-cron-manager/screep/event/details/tabs', array() ) );

		$this->view->get_view( 'parts/events/section' );

	}

	/**
	 * Loads event adder form
	 * There are used $this->view instead of passed instance
	 * because we want to separate scopes
	 * @param  object $view instance of parent view
	 * @return void
	 */
	public function load_event_adder_part( $view ) {

	}

	/**
	 * Loads schedules table
	 * There are used $this->view instead of passed instance
	 * because we want to separate scopes
	 * @param  object $view instance of parent view
	 * @return void
	 */
	public function load_schedules_table_part( $view ) {

		$this->view->set_var( 'schedules', $this->schedules->get_schedules() );

		$this->view->get_view( 'parts/schedules/section' );

	}

	/**
	 * Loads schedule adder form
	 * There are used $this->view instead of passed instance
	 * because we want to separate scopes
	 * @param  object $view instance of parent view
	 * @return void
	 */
	public function load_schedule_adder_part( $view ) {

	}

	/**
	 * Adds default event details tabs
	 * It also registers the actions for the content
	 * @param array $tabs filtered tabs
	 */
	public function add_default_event_details_tabs( $tabs ) {

		foreach ( $this->default_event_details_tabs as $tab_slug => $tab_name ) {
			$tabs[ $tab_slug ] = $tab_name;
			add_action( 'advanced-cron-manager/screep/event/details/tab/' . $tab_slug, array( $this, 'load_event_tab_' . $tab_slug ), 10, 1 );
		}

		return $tabs;

	}

	/**
	 * Loads Logs tab content for event details
	 * Scope for $view is the same as in events/section view
	 * @param  object $view local View instance
	 * @return void
	 */
	public function load_event_tab_logs( $view ) {
		$view->get_view( 'parts/events/tabs/logs' );
	}

	/**
	 * Loads Arguments tab content for event details
	 * Scope for $view is the same as in events/section view
	 * @param  object $view local View instance
	 * @return void
	 */
	public function load_event_tab_arguments( $view ) {
		$view->get_view( 'parts/events/tabs/arguments' );
	}

	/**
	 * Loads Implementation tab content for event details
	 * Scope for $view is the same as in events/section view
	 * @param  object $view local View instance
	 * @return void
	 */
	public function load_event_tab_implementation( $view ) {
		$view->get_view( 'parts/events/tabs/implementation' );
	}

}
