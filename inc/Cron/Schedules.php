<?php
/**
 * Schedules class
 * Used to handle collection of schedules
 */

namespace underDEV\AdvancedCronManager\Cron;

class Schedules {

	/**
	 * Registered schedules
	 * @var array
	 */
	private $schedules = array();

	/**
	 * Protected schedules slugs
	 * @var array
	 */
	private $protected_schedules = array();

	public function __construct() {

		// protected schedules registered by WordPress' core
		$this->protected_schedules = array( 'hourly', 'twicedaily', 'daily' );

	}

	/**
	 * Gets all registered schedules
	 * Supports lazy loading
	 * @param  boolean $force if refresh stored schedules
	 * @return array          registered schedules
	 */
	public function get_schedules( $force = false ) {

		if ( empty( $this->schedules ) || $force ) {

			$this->schedules = array();

			foreach ( wp_get_schedules() as $slug => $params ) {

				if ( in_array( $slug, $this->protected_schedules ) ) {
					$protected = true;
				} else {
					$protected = false;
				}

				$this->schedules[] = new Object\Schedule( $slug, $params['interval'], $params['display'], $protected );

			}

		}

		return $this->schedules;

	}

}
