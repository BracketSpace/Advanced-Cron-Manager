<?php
/**
 * Container initiation and it's rules
 */

// Initiation

$dice = new underDEV\Utils\Dice;

// Rules

$dice->addRule( 'underDEV\Utils\Files', array(
	'shared' => 'true',
	'constructParams' => array( $plugin_file )
) );

$dice->addRule( $namespace . 'ScreenRegisterer', array(
	'shared' => 'true',
) );

$dice->addRule( $namespace . 'Cron\SchedulesLibrary', array(
	'shared' => 'true',
) );

$dice->addRule( $namespace . 'Assets', array(
	'shared' => 'true',
	'constructParams' => array( $plugin_version )
) );

return $dice;
