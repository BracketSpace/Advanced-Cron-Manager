<?php
/**
 * Add schedule button
 *
 * @package advanced-cron-manager
 */

?>

<a href="#" class="add-schedule page-title-action" data-nonce="<?php echo esc_attr( wp_create_nonce( 'acm/schedule/add' ) ); ?>"><?php esc_html_e( 'Add new schedule', 'advanced-cron-manager' ); ?></a>
