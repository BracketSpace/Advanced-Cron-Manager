<?php
/**
 * Table navigation for events
 */
?>

<div class="alignleft actions">
	<select>
		<option value="-1"><?php esc_html_e( 'Bulk Actions' ); ?></option>
		<option value="run"><?php esc_html_e( 'Execute now' ); ?></option>
		<option value="pause"><?php esc_html_e( 'Pause' ); ?></option>
		<option value="remove"><?php esc_html_e( 'Remove' ); ?></option>
	</select>
	<input type="submit" class="button action" value="Apply">
</div>

<div class="alignleft actions">
	<select class="schedules-filter">
		<option value=""><?php esc_html_e( 'All Schedules' ); ?></option>
		<?php foreach ( $this->get_var( 'schedules' )->get_schedules() as $schedule ): ?>
			<option value="<?php echo esc_attr( $schedule->slug ); ?>"><?php echo esc_html( $schedule->label ); ?></option>
		<?php endforeach ?>
		<option value="<?php echo esc_attr( $this->get_var( 'schedules' )->get_single_event_schedule()->slug ); ?>"><?php echo esc_html( $this->get_var( 'schedules' )->get_single_event_schedule()->label ); ?></option>
	</select>
</div>

<div class="tablenav-pages one-page">
	<span class="displaying-num"><?php echo esc_html( $this->get_var( 'events_count' ) . ' ' . __( 'events' ) ); ?></span>
</div>
