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
		<?php if ( $schedule->protected ): ?>
			<span class="dashicons dashicons-edit disabled" title="<?php esc_attr_e( 'This schedule is protected and you cannot edit it', 'advanced-cron-manager' ); ?>">
				<span><?php _e( 'Edit', 'advanced-cron-manager' ); ?></span>
			</span>
			<span class="dashicons dashicons-trash disabled" title="<?php esc_attr_e( 'This schedule is protected and you cannot remove it', 'advanced-cron-manager' ); ?>">
				<span><?php _e( 'Trash', 'advanced-cron-manager' ); ?></span>
			</span>
		<?php else: ?>
			<a href="#" data-nonce="<?php echo $schedule->nonce( 'edit' ); ?>" data-schedule="<?php echo esc_attr( $schedule->slug ); ?>" class="edit-schedule dashicons dashicons-edit" title="<?php esc_attr_e( 'Edit', 'advanced-cron-manager' ); ?>">
				<span><?php _e( 'Edit', 'advanced-cron-manager' ); ?></span>
			</a>
			<a href="#" data-nonce="<?php echo $schedule->nonce( 'remove' ); ?>" data-schedule="<?php echo esc_attr( $schedule->slug ); ?>" class="remove-schedule dashicons dashicons-trash" title="<?php esc_attr_e( 'Remove', 'advanced-cron-manager' ); ?>">
				<span><?php _e( 'Remove', 'advanced-cron-manager' ); ?></span>
			</a>
		<?php endif ?>
	</div>
</div>
