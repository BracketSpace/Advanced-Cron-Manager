<?php
/**
 * Schedules table part
 *
 * @package advanced-cron-manager
 */

?>

<div id="schedules">

	<div class="schedules tile">

		<h3 class="tile-header"><?php esc_html_e( 'Schedules', 'advanced-cron-manager' ); ?></h3>

		<div class="tile-content">

			<?php do_action( 'advanced-cron-manager/screen/sidebar/shedules/before', $this ); ?>

			<?php $this->get_view( 'parts/schedules/header-row' ); ?>

			<?php foreach ( $this->get_var( 'schedules' ) as $schedule ) : ?>
				<?php
				if ( ! apply_filters( 'advanced-cron-manager/screen/sidebar/shedules/display', true, $schedule ) ) {
					continue;
				}
				?>
				<?php $this->set_var( 'schedule', $schedule, true ); ?>
				<?php $this->get_view( 'parts/schedules/row' ); ?>
			<?php endforeach ?>

			<?php $this->remove_var( 'schedule' ); ?>

			<?php do_action( 'advanced-cron-manager/screen/sidebar/shedules/after', $this ); ?>

		</div>

	</div>

	<?php $this->get_view( 'elements/add-schedule-button' ); ?>

</div>
