<?php
/**
 * Misc class
 */

namespace underDEV\AdvancedCronManager;
use underDEV\Utils;

class Misc {

	/**
	 * View class
	 * @var object
	 */
	public $view;

	/**
	 * Constructor
	 * @param object $view View class
	 */
	public function __construct( Utils\View $view ) {
		$this->view = $view;
	}

	/**
	 * Loads Notification plugin promo part
	 * @return void
	 */
	public function load_notification_promo_part() {
		$this->view->get_view( 'misc/notification-promo' );
	}

}
