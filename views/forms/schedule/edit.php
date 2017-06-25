<?php
/**
 * Edit schedule form
 */

$schedule = $this->get_var( 'schedule' );

$interval_raw = $schedule->get_raw_human_interval();

?>

<?php $this->get_view( 'forms/header' ); ?>

<?php wp_nonce_field( 'acm/schedule/edit', 'nonce', false ); ?>

<label for="schedule-name">Display name</label>
<input type="text" id="schedule-name" name="name" class="widefat" value="<?php echo esc_attr( $schedule->label ); ?>">

<label for="schedule-slug">Slug</label>
<input type="text" id="schedule-slug" class="widefat" disabled="disabled" value="<?php echo esc_attr( $schedule->slug ); ?>">
<input type="hidden" name="slug" value="<?php echo esc_attr( $schedule->slug ); ?>">

<label>Interval</label>
<table>
	<tr>
		<td><?php _e( 'Days' ); ?>:</td>
		<td><input type="number" id="schedule-interval" min="0" value="<?php echo esc_attr( $interval_raw['days'] ); ?>" class="spinbox days"></td>
	</tr>
	<tr>
		<td><?php _e( 'Hours' ); ?>:</td>
		<td><input type="number" id="schedule-interval" min="0" max="24" value="<?php echo esc_attr( $interval_raw['hours'] ); ?>" class="spinbox hours"></td>
	</tr>
	<tr>
		<td><?php _e( 'Minutes' ); ?>:</td>
		<td><input type="number" id="schedule-interval" min="0" max="60" value="<?php echo esc_attr( $interval_raw['minutes'] ); ?>" class="spinbox minutes"></td>
	</tr>
	<tr>
		<td><?php _e( 'Seconds' ); ?>:</td>
		<td><input type="number" id="schedule-interval" min="0" max="60" value="<?php echo esc_attr( $interval_raw['seconds'] ); ?>" class="spinbox seconds"></td>
	</tr>
</table>

<div class="total-seconds"><?php _e( 'Total seconds:' ); ?> <span><?php echo esc_html( $schedule->interval ); ?></span></div>
<input type="hidden" name="interval" class="interval-input" value="<?php echo esc_attr( $schedule->interval ); ?>">

<?php $this->get_view( 'forms/footer' ); ?>
