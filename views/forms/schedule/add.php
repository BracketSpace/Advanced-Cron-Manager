<?php
/**
 * Add schedule form
 */
?>

<?php $this->get_view( 'forms/header' ); ?>

<?php wp_nonce_field( 'acm/schedule/insert', 'nonce', false ); ?>

<label for="schedule-name"><?php esc_html_e( 'Display name', 'advanced-cron-manager' ); ?></label>
<input type="text" id="schedule-name" name="name" class="widefat">

<label for="schedule-slug"><?php esc_html_e( 'Slug', 'advanced-cron-manager' ); ?></label>
<input type="text" id="schedule-slug" name="slug" class="widefat">

<label><?php esc_html_e( 'Interval', 'advanced-cron-manager' ); ?></label>
<table>
	<tr>
		<td><?php _e( 'Days', 'advanced-cron-manager' ); ?>:</td>
		<td><input type="number" id="schedule-interval" min="0" value="0" class="spinbox days"></td>
	</tr>
	<tr>
		<td><?php _e( 'Hours', 'advanced-cron-manager' ); ?>:</td>
		<td><input type="number" id="schedule-interval" min="0" max="24" value="0" class="spinbox hours"></td>
	</tr>
	<tr>
		<td><?php _e( 'Minutes', 'advanced-cron-manager' ); ?>:</td>
		<td><input type="number" id="schedule-interval" min="0" max="60" value="0" class="spinbox minutes"></td>
	</tr>
	<tr>
		<td><?php _e( 'Seconds', 'advanced-cron-manager' ); ?>:</td>
		<td><input type="number" id="schedule-interval" min="0" max="60" value="0" class="spinbox seconds"></td>
	</tr>
</table>

<div class="total-seconds"><?php _e( 'Total seconds:', 'advanced-cron-manager' ); ?> <span>0</span></div>
<input type="hidden" name="interval" class="interval-input" value="0">

<?php $this->get_view( 'forms/footer' ); ?>
