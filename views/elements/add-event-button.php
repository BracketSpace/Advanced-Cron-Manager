<?php
/**
 * Add task button
 *
 * @package advanced-cron-manager
 */

?>

<a href="#" class="add-event page-title-action" data-nonce="<?php echo esc_attr( wp_create_nonce( 'acm/event/add' ) ); ?>"><?php esc_html_e( 'Add new event', 'advanced-cron-manager' ); ?></a>
