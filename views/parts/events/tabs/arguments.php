<?php
/**
 * Logs tab
 * View scope is the same as in the events/section view
 */
?>

<?php foreach ( $this->get_var( 'event' )->args as $arg ): ?>
	<span><?php echo esc_html( $arg ); ?></span>
<?php endforeach ?>
