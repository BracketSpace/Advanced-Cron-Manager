<?php
/**
 * Forms footer
 *
 * @package advanced-cron-manager
 */

?>

<div class="submit-row">
	<?php if ($this->get_var('is_add_event')) : ?>
		<a href="#" class="button button-secondary add-argument"><?php esc_html_e( 'Add argument', 'advanced-cron-manager' ); ?></a>
	<?php endif ?>

	<button type="submit" class="button button-primary send-form"><?php echo esc_attr( $this->get_var( 'cta' ) ); ?></button>
</div>
<span class="spinner"></span>

</form>
