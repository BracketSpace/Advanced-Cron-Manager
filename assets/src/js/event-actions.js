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

	$( '.slidebar' ).on( 'submit', '.event-add', function( event ) {

		event.preventDefault();
		wp.hooks.doAction( 'advanced-cron-manager/event/add/process', $(this) );

	} );

	$( '.tools_page_advanced-cron-manager' ).on( 'click', '#events .run-event', function( event ) {

		event.preventDefault();
		wp.hooks.doAction( 'advanced-cron-manager/event/run/process', $(this) );

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

	wp.hooks.addAction( 'advanced-cron-manager/event/add/process', function( $form ) {

		advanced_cron_manager.slidebar.form_process_start();

		var data = {
	        'action': 'acm/event/insert',
	        'nonce' : $form.find( '#nonce' ).val(),
	        'data'  : $form.serialize()
	    };

	    $.post( ajaxurl, data, function( response ) {

	    	advanced_cron_manager.ajax_messages( response );

	        if ( response.success == true ) {
	        	wp.hooks.doAction( 'advanced-cron-manager/event/added', $form.find( '#event-hook' ).val() );
	        } else {
	        	advanced_cron_manager.slidebar.form_process_stop();
	        }

	    } );

	} );

	// run
	wp.hooks.addAction( 'advanced-cron-manager/event/run/process', function( $button ) {

		var $event_row = $button.parents( '.single-event.row' ).first();

		$event_row.addClass( 'running' );

		var data = {
	        'action': 'acm/event/run',
	        'nonce' : $button.data( 'nonce' ),
	        'event' : $button.data( 'event' )
	    };

	    $.post( ajaxurl, data, function( response ) {

	    	advanced_cron_manager.ajax_messages( response );

	        if ( response.success == true ) {
        		wp.hooks.doAction( 'advanced-cron-manager/event/executed', $button.data( 'event' ), $event_row );
	        }

	        $event_row.removeClass( 'running' );

	    } );

	} );

	// refresh table and close slidebar

	wp.hooks.addAction( 'advanced-cron-manager/event/added', function() {

		$( '#events' ).addClass( 'loading' );

	    $.post( ajaxurl, { 'action': 'acm/rerender/events' }, function( response ) {
	    	$( '#events' ).replaceWith( response.data );
	    	advanced_cron_manager.slidebar.form_process_stop();
			advanced_cron_manager.slidebar.close();
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

	// add user timezone offset
	wp.hooks.addAction( 'advanced-cron-manager/event/add/process', function( $form ) {
		$form.find( '#event-offset' ).val( new Date().getTimezoneOffset() / 60 );
	}, 5 );

} )( jQuery );
