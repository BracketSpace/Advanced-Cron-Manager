<?php
/**
 * Header row of events
 */
?>

<div class="single-event header">
	<div class="columns">
		<div class="column cb"><input type="checkbox" class="select-all"></div>
		<div class="column event"><?php esc_html_e( 'Event' ); ?></div>
		<div class="column schedule"><?php esc_html_e( 'Schedule' ); ?></div>
		<div class="column arguments"><?php esc_html_e( 'Arguments' ); ?></div>
		<div class="column next-execution"><?php esc_html_e( 'Next execution' ); ?></div>
	</div>
</div>
