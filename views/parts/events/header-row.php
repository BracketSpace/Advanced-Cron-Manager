<?php
/**
 * Header row of events
 *
 * @package advanced-cron-manager
 */

?>

<div class="single-event header">
	<div class="columns">
		<div class="column cb"><input type="checkbox" class="select-all"></div>
		<div class="column event" data-name="event" data-order="1"><?php esc_html_e( 'Event', 'advanced-cron-manager' ); ?></div>
		<div class="column schedule" data-name="schedule" data-order="1"><?php esc_html_e( 'Schedule', 'advanced-cron-manager' ); ?></div>
		<div class="column arguments"><?php esc_html_e( 'Arguments', 'advanced-cron-manager' ); ?></div>
		<div class="column next-execution" data-name="next-execution" data-order="1"><?php esc_html_e( 'Next execution', 'advanced-cron-manager' ); ?></div>
	</div>
</div>
