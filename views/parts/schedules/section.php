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

	<?php if ( ! class_exists( 'underDEV\AdvancedCronManagerPRO\Updater' ) ) : ?>
		<p class="pro-schedule-upsell">
			<?php
			// phpcs:ignore
			printf(
				// Translators: Link to ACM PRO.
				// phpcs:ignore
				__( "Add a custom schedule that will fire your events at a specific time, ie. at noon on the last day of the month, or only Fridays. Now it's super easy with %s.", 'advanced-cron-manager' ),
				'<a href="https://bracketspace.com/downloads/advanced-cron-manager-pro/?utm_source=wp&utm_medium=sidebar&utm_campaign=admin-upsell" target="_blank">Advanced Cron Manager PRO</a>'
			);
			?>
		</p>
	<?php endif ?>

</div>
