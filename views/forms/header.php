<?php
/**
 * Forms header
 */
?>

<?php if ( $this->get_var( 'heading' ) ): ?>
	<h3><?php echo $this->get_var( 'heading' ); ?></h3>
<?php endif ?>

<form class="<?php echo $this->get_var( 'form_class' ); ?>">
