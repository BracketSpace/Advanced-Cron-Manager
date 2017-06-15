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
	 * Contructor
	 * @param View      $view      View class
	 * @param Schedules $schedules Schedules class
	 */
	public function __construct( Utils\View $view, Cron\Schedules $schedules ) {

		$this->view      = $view;
		$this->schedules = $schedules;

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
		echo '<pre>tasks table<br>';
		echo '</pre>';
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

}
