<?php
/**
 * AdminScreen class
 * Registers and displays admin screen
 */

namespace underDEV\AdvancedCronManager;

class AdminScreen {

	/**
	 * Admin page hook
	 * @var string
	 */
	public $page_hook;

	/**
	 * View class
	 * @var instance of underDEV\AdvancedCronManage\View
	 */
	public $view;

	/**
	 * Contructor
	 * @param View $view View class
	 */
	public function __construct( Utils\View $view ) {

		$this->view = $view;

	}

	/**
	 * Registers the plugin page under Tools in WP Admin
	 * @return void
	 */
	public function register_screen() {

		$this->page_hook = add_management_page(
			__( 'Advanced Cron Manager', 'advanced-cron-manager' ),
			__( 'Cron Manager', 'advanced-cron-manager' ),
			'manage_options',
			'advanced-cron-manager',
			array( $this, 'load_page_wrapper' )
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
	 * Loads tasks table
	 * There are used $this->view instead of passed instance
	 * because we want to separate scopes
	 * @param  object $view instance of parent view
	 * @return void
	 */
	public function load_tasks_table_part( $view ) {
		echo '<pre>tasks table<br>';
		echo '</pre>';
	}

	/**
	 * Loads task adder form
	 * There are used $this->view instead of passed instance
	 * because we want to separate scopes
	 * @param  object $view instance of parent view
	 * @return void
	 */
	public function load_task_adder_part( $view ) {

	}

	/**
	 * Loads schedules table
	 * There are used $this->view instead of passed instance
	 * because we want to separate scopes
	 * @param  object $view instance of parent view
	 * @return void
	 */
	public function load_schedules_table_part( $view ) {
		echo '<pre>schedules table<br>';
		echo '</pre>';
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
