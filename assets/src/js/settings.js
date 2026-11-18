( function( $ ) {

	/////////////////////
	// Form processing //
	/////////////////////

	$( '#plugin-settings-form' ).on( 'submit', function( event ) {

		event.preventDefault();
		wp.hooks.doAction( 'advanced-cron-manager.settings.action', $( this ) );

	} );

	/////////////
	// Actions //
	/////////////

	wp.hooks.addAction( 'advanced-cron-manager.settings.action', 'bracketspace/acm/settings-action', function( $form ) {

		var $button = $form.find( '.button-secondary' ).first();

		var data = {
			'action' : 'acm/settings/save',
			'data'   : $form.serialize(),
			'nonce'  : $button.data( 'nonce' )
		};

		var button_label = $button.val();

		$button.val( advanced_cron_manager.i18n.saving );
		$button.prop( 'disabled', true );

		$.post( ajaxurl, data, function( response ) {

			advanced_cron_manager.ajax_messages( response );

			$button.val( button_label );
			$button.prop( 'disabled', false );

		} );

	} );

} )( jQuery );
