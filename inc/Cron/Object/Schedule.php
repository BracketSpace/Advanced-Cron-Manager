<?php
/**
 * Schedule class
 * Single instance of a schedule
 */

namespace underDEV\AdvancedCronManager\Cron\Object;

class Schedule {

	/**
	 * Unique slug
	 * @var string
	 */
	private $slug;

	/**
	 * Schedule interval
	 * @var int
	 */
	private $interval;

	/**
	 * Label, default to slug
	 * @var string
	 */
	private $label;

	/**
	 * Protected
	 * @var bool
	 */
	private $protected;

	/**
	 * Instantine object
	 * @param boolean $protected if Schedule is protected
	 */
	public function __construct( $slug = null, $interval = 0, $label = null, $protected = false ) {

		if ( empty( $slug ) ) {
			trigger_error( 'Slug cannot be empty', E_USER_ERROR );
		}

		if ( $interval <= 0 ) {
			trigger_error( 'Interval must be greater than 0', E_USER_ERROR );
		}

		if ( empty( $label ) ) {
			$label = $slug;
		}

		$this->slug      = $slug;
		$this->interval  = $interval;
		$this->label     = $label;
		$this->protected = $protected;

	}

	/**
	 * Magic method
	 * @param  string $property Schedule property
	 * @return mixed            property value
	 */
	public function __get( $property ) {
        return $this->$property;
    }

    /**
     * Gets interval in human readable format
     * @return string
     */
    public function get_human_interval() {

    	$human_time = '';

    	$secondsInAMinute = 60;
	    $secondsInAnHour  = 60 * $secondsInAMinute;
	    $secondsInADay    = 24 * $secondsInAnHour;

	    // extract days
	    $days = floor( $this->interval / $secondsInADay );

	    // extract hours
		$hourSeconds = $this->interval % $secondsInADay;
		$hours       = floor( $hourSeconds / $secondsInAnHour );

	    // extract minutes
		$minuteSeconds = $hourSeconds % $secondsInAnHour;
		$minutes       = floor( $minuteSeconds / $secondsInAMinute );

	    // extract the remaining seconds
		$remainingSeconds = $minuteSeconds % $secondsInAMinute;
		$seconds          = ceil( $remainingSeconds );

	    if ( $days > 0 ) {
	    	$human_time .= $days . 'd ';
	    }

	    if ( $hours > 0 ) {
	    	$human_time .= $hours . 'h ';
	    }

	    if ( $minutes > 0 ) {
	    	$human_time .= $minutes . 'm ';
	    }

	    if ( $seconds > 0 ) {
	    	$human_time .= $seconds . 's ';
	    }

	    return trim( $human_time );

    }

}
