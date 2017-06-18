<?php
/**
 * Schedule tab
 * View scope is the same as in the events/section view
 */
?>

<?php echo esc_html( $this->get_var( 'schedules' )->get_schedule( $this->get_var( 'event' )->schedule )->label ); ?>
