<?php
/**
 * Logs tab
 * View scope is the same as in the events/section view
 */
?>

<?php foreach ( $this->get_var( 'event' )->args as $arg ): ?>
	<span><?php echo esc_html( is_array( $arg ) ? __( 'Array' ) : $arg ); ?></span>
<?php endforeach ?>
