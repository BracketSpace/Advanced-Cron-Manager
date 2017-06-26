( function( $ ) {

	///////////////////
	// Form requests //
	///////////////////

	$( '.tools_page_advanced-cron-manager' ).on( 'click', '.add-event', function( event ) {

		event.preventDefault();
		wp.hooks.doAction( 'advanced-cron-manager/event/add', $(this) );

	} );

	/////////////////////
	// Form processing //
	/////////////////////

	$( '.slidebar' ).on( 'submit', '.schedule-add', function( event ) {

		event.preventDefault();
		wp.hooks.doAction( 'advanced-cron-manager/schedule/add/process', $(this) );

	} );

	/////////////
	// Actions //
	/////////////

	// add
	wp.hooks.addAction( 'advanced-cron-manager/event/add', function( $button ) {

		advanced_cron_manager.slidebar.open();
		advanced_cron_manager.slidebar.wait();

		var data = {
	        'action': 'acm/event/add/form',
	        'nonce' : $button.data( 'nonce' )
	    };

	    $.post( ajaxurl, data, function( response ) {
	        advanced_cron_manager.slidebar.fulfill( response.data );
	    } );

	} );

	wp.hooks.addAction( 'advanced-cron-manager/event/add/process', function( $button ) {

		advanced_cron_manager.slidebar.open();
		advanced_cron_manager.slidebar.wait();

		var data = {
	        'action': 'acm/schedule/add/form',
	        'nonce' : $button.data( 'nonce' )
	    };

	    $.post( ajaxurl, data, function( response ) {
	        advanced_cron_manager.slidebar.fulfill( response.data );
	    } );

	} );

	/////////////
	// Helpers //
	/////////////

	$( '.slidebar' ).on( 'blur', '.event-arguments .event-argument', function() {

		var $input = $( this );

		// add new arg
		if ( $input.next( '.event-argument' ).length == 0 && $input.val().length > 0 ) {
			$( '.slidebar .event-arguments' ).append( '<input type="text" name="arguments[]" class="event-argument widefat">' );
		}

		// remove empty arg
		if ( $input.val().length == 0 && $( '.slidebar .event-arguments .event-argument' ).length > 1 ) {
			$input.remove();
		}

	} );

	$( '.slidebar' ).on( 'keyup', '.event-arguments .event-argument', function( event ) {

		var $input = $( this );

		if ( event.keyCode == 8 && $input.val().length == 0 && $( '.slidebar .event-arguments .event-argument' ).length > 1  ) {
			$input.blur();
		}

	} );

} )( jQuery );
