<?php
/**
 * Add schedule form
 */
?>

<?php $this->get_view( 'forms/header' ); ?>

<?php wp_nonce_field( 'acm/schedule/insert', 'nonce', false ); ?>

<label for="schedule-name">Display name</label>
<input type="text" id="schedule-name" name="name" class="widefat">

<label for="schedule-slug">Slug</label>
<input type="text" id="schedule-slug" name="slug" class="widefat">

<label>Interval</label>
<table>
	<tr>
		<td><?php _e( 'Days' ); ?>:</td>
		<td><input type="number" id="schedule-interval" min="0" value="0" class="spinbox days"></td>
	</tr>
	<tr>
		<td><?php _e( 'Hours' ); ?>:</td>
		<td><input type="number" id="schedule-interval" min="0" max="24" value="0" class="spinbox hours"></td>
	</tr>
	<tr>
		<td><?php _e( 'Minutes' ); ?>:</td>
		<td><input type="number" id="schedule-interval" min="0" max="60" value="0" class="spinbox minutes"></td>
	</tr>
	<tr>
		<td><?php _e( 'Seconds' ); ?>:</td>
		<td><input type="number" id="schedule-interval" min="0" max="60" value="0" class="spinbox seconds"></td>
	</tr>
</table>

<div class="total-seconds"><?php _e( 'Total seconds:' ); ?> <span>0</span></div>
<input type="hidden" name="interval" class="interval-input" value="0">

<?php $this->get_view( 'forms/footer' ); ?>
