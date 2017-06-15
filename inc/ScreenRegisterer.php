<?php
/**
 * ScreenRegisterer class
 * Registers admin screen
 */

namespace underDEV\AdvancedCronManager;

class ScreenRegisterer {

	/**
	 * Admin page hook
	 * @var string
	 */
	private $page_hook;

	/**
	 * Admin screen object
	 * @var object
	 */
	private $admin_screen;

	public function __construct( AdminScreen $admin_screen ) {
		$this->admin_screen = $admin_screen;
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
			array( $this->admin_screen, 'load_page_wrapper' )
		);

	}

	public function get_page_hook() {
		return $this->page_hook;
	}

}
