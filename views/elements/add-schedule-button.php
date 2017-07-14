<?php
/**
 * Add schedule button
 */
?>

<a href="#" class="add-schedule page-title-action" data-nonce="<?php echo wp_create_nonce( 'acm/schedule/add' ); ?>"><?php esc_html_e( 'Add new schedule', 'advanced-cron-manager' ); ?></a>
