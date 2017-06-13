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
			array( $this, 'load_page_view' )
		);

	}

	/**
	 * Loads the page screen
	 * @return void
	 */
	public function load_page_view() {

		echo 'This is the page';

	}

}
