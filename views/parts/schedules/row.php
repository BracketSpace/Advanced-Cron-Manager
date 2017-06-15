<?php
/**
 * Single row of schedule
 * Needs `schedule` var set which is instance of underDEV\AdvancedCronManager\Cron\Object\Schedule
 */

$schedule = $this->get_var( 'schedule' );

?>

<div class="single-schedule <?php echo $schedule->protected ? 'protected' : ''; ?>">
	<div class="column label"><?php echo $schedule->label; ?></div>
	<div class="column slug"><?php echo $schedule->slug; ?></div>
	<div class="column interval">
		<span title="<?php printf( esc_attr( _n( '%d second', '%d seconds', $schedule->interval, 'advanced-cron-manager' ) ), $schedule->interval ); ?>">
			<?php echo $schedule->get_human_interval(); ?>
		</span>
	</div>
	<div class="column actions">
		<a href="#" class="dashicons dashicons-edit" title="<?php _e( 'Edit' ); ?>"><span><?php _e( 'Edit' ); ?></span></a>
		<a href="#" class="dashicons dashicons-trash <?php echo $schedule->protected ? 'disabled' : ''; ?>" title="<?php echo $schedule->protected ? _e( 'This schedule is protected and you cannot remove it' ) : _e( 'Trash' ); ?>" <?php disabled( true, $schedule->protected ); ?>>
			<span><?php _e( 'Trash' ); ?></span>
		</a>
	</div>
</div>
