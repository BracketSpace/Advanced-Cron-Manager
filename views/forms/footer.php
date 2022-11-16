<?php
/**
 * Forms footer
 *
 * @package advanced-cron-manager
 */

?>

<div class="submit-row">
	<button type="submit" class="button button-primary send-form"><?php echo esc_attr( $this->get_var( 'cta' ) ); ?></button>
	<a href="#" class="button button-secondary add-argument"><?php esc_html_e( 'Add argument', 'advanced-cron-manager' ); ?></a>
	<span class="spinner"></span>
</div>

</form>
