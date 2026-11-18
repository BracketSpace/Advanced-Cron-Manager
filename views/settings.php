<?php
/**
 * Plugin settings part
 *
 * @package advanced-cron-manager
 */

$settings = $this->get_var( 'settings' );

?>

<div id="plugin-settings">

	<div class="tile">

		<h3 class="tile-header"><?php esc_html_e( 'Plugin data', 'advanced-cron-manager' ); ?></h3>

		<div class="tile-content">

			<form id="plugin-settings-form">

				<label>
					<input type="checkbox" name="uninstall_cleanup" value="1" <?php checked( ! empty( $settings['uninstall_cleanup'] ), true ); ?>>
					<?php esc_html_e( 'Remove plugin data on uninstall', 'advanced-cron-manager' ); ?>
					<p class="description"><?php esc_html_e( 'When unchecked, custom schedules, paused events and settings stay in the database after the plugin is deleted.', 'advanced-cron-manager' ); ?></p>
				</label>

				<input type="submit" class="button-secondary" data-nonce="<?php echo esc_attr( wp_create_nonce( 'acm/settings/save' ) ); ?>" value="<?php esc_attr_e( 'Save settings', 'advanced-cron-manager' ); ?>">

			</form>

		</div>

	</div>

</div>
