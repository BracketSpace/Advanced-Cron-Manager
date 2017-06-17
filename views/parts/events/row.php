<?php
/**
 * Single row of event
 * Needs `event` var set which is instance of underDEV\AdvancedCronManager\Cron\Object\Event
 */

$event                 = $this->get_var( 'event' );
$schedules             = $this->get_var( 'schedules' );
$single_event_schedule = $schedules->get_single_event_schedule();

$time_offset = get_option( 'gmt_offset' ) * 3600;
$date_format = get_option( 'date_format' );
$time_format = get_option( 'time_format' );

?>

<div class="single-event row" data-schedule="<?php echo esc_attr( $event->schedule ? $event->schedule : $single_event_schedule->slug ); ?>">
	<div class="columns">
		<div class="column cb"><input type="checkbox" name="bulk-actions" value=""></div>
		<div class="column event">
			<a href="#" class="event-name"><?php echo esc_html( $event->hook ); ?></a>
			<div class="row-actions">
				<span class="details"><a href="#"><?php esc_html_e( 'Details' ); ?></a> | </span>
				<span class="run"><a href="#"><?php esc_html_e( 'Execute now' ); ?></a> | </span>
				<span class="pause"><a href="#"><?php esc_html_e( 'Pause' ); ?></a> | </span>
				<span class="trash"><a href="#"><?php esc_html_e( 'Remove' ); ?></a></span>
			</div>
		</div>
		<div class="column schedule"><?php echo esc_html( $schedules->get_schedule( $event->schedule )->label ); ?></div>
		<div class="column arguments">
			<?php foreach ( $event->args as $arg ): ?>
				<span><?php echo esc_html( $arg ); ?></span>
			<?php endforeach ?>
		</div>
		<div class="column next-execution">
			<?php if ( $event->next_call <= time() ): ?>
				<?php esc_html_e( 'In queue' ); ?>
			<?php else: ?>
				<?php echo esc_html( sprintf( __( 'In %s' ), human_time_diff( time(), $event->next_call ) ) ); ?><br>
				<span title="<?php echo esc_attr( 'UTC: ' . date( $date_format . ' ' . $time_format, $event->next_call ) ); ?>">
					<?php echo date( $date_format . ' ' . $time_format, $event->next_call + $time_offset ); ?>
				</span>
			<?php endif ?>
		</div>
	</div>
	<div class="details">
		<ul class="tabs">
			<?php $active = 'active'; ?>
			<?php foreach ( $this->get_var( 'details_tabs' ) as $tab_slug => $tab_name ): ?>
				<li class="<?php echo $active; ?> <?php echo esc_attr( $tab_slug ); ?>">
					<a href="#" data-section="<?php echo esc_attr( $tab_slug ); ?>"><?php echo esc_html( $tab_name ); ?></a>
				</li>
				<?php $active = ''; ?>
			<?php endforeach ?>
		</ul>
		<?php $active = 'active'; ?>
		<?php foreach ( $this->get_var( 'details_tabs' ) as $tab_slug => $tab_name ): ?>
			<div class="content <?php echo esc_attr( $tab_slug ); ?> <?php echo $active; ?>">
				<?php do_action( 'advanced-cron-manager/screep/event/details/tab/' . $tab_slug, $this ); ?>
			</div>
			<?php $active = ''; ?>
		<?php endforeach ?>
	</div>
</div>
