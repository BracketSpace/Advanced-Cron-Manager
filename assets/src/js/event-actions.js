( function( $ ) {

	$( '.tools_page_advanced-cron-manager' ).on( 'click', '.argument-preview', function( event ) {
		const data = event.currentTarget.dataset.args;

		if ( data ) {
			const parsedData = JSON.parse(data);

			let arr = [];

			for ( let data of parsedData ) {
				//Check whether type is array or object if true parse it and add tabs.
				if ( data.type === 'array' || data.type === 'object' ) {
					let formatedData =  `(${data.type}) ` + JSON.stringify(JSON.parse(data.msg), null, 2);
					// if data is type of array, we send it as JSON anyway,
					// change characters to make it look like associative array
					 if ( data.type === 'array' ) {
						 formatedData = formatedData
							 .replace(/\{/g, '[')
							 .replace(/}/g, ']')
							 .replace(/:/g, ' =>')
					 }
					arr.push(formatedData);

				} else {
					arr.push( `(${data.type}) ${data.msg}` );
				}
			}

			arr.forEach( (element, index) => {
				arr[index] = "<pre>" + element + "</pre>";
			} );

			advanced_cron_manager.previewModal.open();
			advanced_cron_manager.previewModal.fulfill( arr.join('\n') );
		}
	} );

	///////////////////
	// Form requests //
	///////////////////

	$( '.tools_page_advanced-cron-manager' ).on( 'click', '.add-event', function( event ) {

		event.preventDefault();
		wp.hooks.doAction( 'advanced-cron-manager.event.add', $(this) );

	} );

	/////////////////////
	// Form processing //
	/////////////////////

	$( '.slidebar' ).on( 'submit', '.event-add', function( event ) {

		event.preventDefault();
		wp.hooks.doAction( 'advanced-cron-manager.event.add.process', $(this) );

	} );

	$( '.tools_page_advanced-cron-manager' ).on( 'click', '#events .run-event', function( event ) {

		event.preventDefault();
		wp.hooks.doAction( 'advanced-cron-manager.event.run.process', $(this) );

	} );

	$( '.tools_page_advanced-cron-manager' ).on( 'click', '#events .remove-event', function( event ) {

		event.preventDefault();
		wp.hooks.doAction( 'advanced-cron-manager.event.remove.process', $(this) );

	} );

	$( '.tools_page_advanced-cron-manager' ).on( 'click', '#events .pause-event', function( event ) {

		event.preventDefault();
		wp.hooks.doAction( 'advanced-cron-manager.event.pause.process', $(this) );

	} );

	$( '.tools_page_advanced-cron-manager' ).on( 'click', '#events .unpause-event', function( event ) {

		event.preventDefault();
		wp.hooks.doAction( 'advanced-cron-manager.event.unpause.process', $(this) );

	} );

	/////////////
	// Actions //
	/////////////

	// add
	wp.hooks.addAction( 'advanced-cron-manager.event.add', 'bracketspace/acm/event-add', function( $button ) {

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

	wp.hooks.addAction( 'advanced-cron-manager.event.add.process', 'bracketspace/acm/event-add-process', function( $form ) {

		advanced_cron_manager.slidebar.form_process_start();

		var data = {
	        'action': 'acm/event/insert',
	        'nonce' : $form.find( '#nonce' ).val(),
	        'data'  : $form.serialize()
	    };

	    $.post( ajaxurl, data, function( response ) {

	    	advanced_cron_manager.ajax_messages( response );

	        if ( response.success == true ) {
	        	wp.hooks.doAction( 'advanced-cron-manager.event.added', $form.find( '#event-hook' ).val() );
	        } else {
	        	advanced_cron_manager.slidebar.form_process_stop();
	        }

	    } );

	} );

	// run
	wp.hooks.addAction( 'advanced-cron-manager.event.run.process', 'bracketspace/acm/event-run-process', function( $button ) {

		if ( $button.hasClass( 'busy' ) ) {
			return false;
		}

		var $event_row = $button.parents( '.single-event.row' ).first();

		$event_row.addClass( 'running' );
		$button.addClass( 'busy' );

		var data = {
	        'action': 'acm/event/run',
	        'nonce' : $button.data( 'nonce' ),
	        'event' : $button.data( 'event' )
	    };

	    $.post( ajaxurl, data, function( response ) {

	    	advanced_cron_manager.ajax_messages( response );

	        if ( response.success == true ) {
        		wp.hooks.doAction( 'advanced-cron-manager.event.executed', $button.data( 'event' ), $event_row );
	        }

	        $event_row.removeClass( 'running' );
	        $button.removeClass( 'busy' );

	    } ).error( function() {

	    	advanced_cron_manager.notify( advanced_cron_manager.i18n.executed_with_errors, 'warning' );

	    	wp.hooks.doAction( 'advanced-cron-manager.event.executed', $button.data( 'event' ), $event_row );

	    	$event_row.removeClass( 'running' );
	        $button.removeClass( 'busy' );

	    } );

	} );

	// remove
	wp.hooks.addAction( 'advanced-cron-manager.event.remove.process', 'bracketspace/acm/event-remove-process', function( $button ) {

		var $event_row = $button.parents( '.single-event.row' ).first();
		var event_hash = $button.data( 'event' );

		$button.replaceWith( advanced_cron_manager.i18n.removing );

		$event_row.addClass( 'removing' );

		var data = {
	        'action': 'acm/event/remove',
	        'nonce' : $button.data( 'nonce' ),
	        'event' : event_hash
	    };

	    $.post( ajaxurl, data, function( response ) {

	    	advanced_cron_manager.ajax_messages( response );

	        if ( response.success == true ) {
	        	$event_row.slideUp();
        		wp.hooks.doAction( 'advanced-cron-manager.event.removed', event_hash, $event_row );
	        }

	        $event_row.removeClass( 'removing' );

	    } );

	} );

	// pause
	wp.hooks.addAction( 'advanced-cron-manager.event.pause.process', 'bracketspace/acm/event-pause-process', function( $button ) {

		var $event_row = $button.parents( '.single-event.row' ).first();
		var event_hash = $button.data( 'event' );

		$button.replaceWith( advanced_cron_manager.i18n.pausing );

		$event_row.addClass( 'removing' );

		var data = {
	        'action': 'acm/event/pause',
	        'nonce' : $button.data( 'nonce' ),
	        'event' : event_hash
	    };

	    $.post( ajaxurl, data, function( response ) {

	    	advanced_cron_manager.ajax_messages( response );

	        if ( response.success == true ) {
        		wp.hooks.doAction( 'advanced-cron-manager.event.paused', event_hash, $event_row );
	        }

	        $event_row.removeClass( 'removing' );

	    } );

	} );

	// unpause
	wp.hooks.addAction( 'advanced-cron-manager.event.unpause.process', 'bracketspace/acm/event-unpause-process', function( $button ) {

		var $event_row = $button.parents( '.single-event.row' ).first();
		var event_hash = $button.data( 'event' );

		$button.replaceWith( advanced_cron_manager.i18n.pausing );

		$event_row.addClass( 'removing' );

		var data = {
	        'action': 'acm/event/unpause',
	        'nonce' : $button.data( 'nonce' ),
	        'event' : event_hash
	    };

	    $.post( ajaxurl, data, function( response ) {

	    	advanced_cron_manager.ajax_messages( response );

	        if ( response.success == true ) {
        		wp.hooks.doAction( 'advanced-cron-manager.event.unpaused', event_hash, $event_row );
	        }

	        $event_row.removeClass( 'removing' );

	    } );

	} );

	// refresh table and close slidebar.
	var events_table_rerender = function () {

		$( '#events' ).addClass( 'loading' );

		$.post(
			ajaxurl,
			{ 'action': 'acm/rerender/events' },
			function ( response ) {
				$( '#events' ).replaceWith( response.data );
				advanced_cron_manager.slidebar.form_process_stop();
				advanced_cron_manager.slidebar.close();
				wp.hooks.doAction( 'advanced-cron-manager.event.search' );
				wp.hooks.doAction( 'advanced-cron-manager.event.sort' );
			}
		);
	};

	wp.hooks.addAction( 'advanced-cron-manager.event.added', 'bracketspace/acm/event-added', events_table_rerender );
	wp.hooks.addAction( 'advanced-cron-manager.event.paused', 'bracketspace/acm/event-paused', events_table_rerender );
	wp.hooks.addAction( 'advanced-cron-manager.event.unpaused', 'bracketspace/acm/event-unpaused', events_table_rerender );

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
	wp.hooks.addAction( 'advanced-cron-manager.event.add.process', 'bracketspace/acm/event-add-process', function( $form ) {
		$form.find( '#event-offset' ).val( new Date().getTimezoneOffset() / 60 );
	}, 5 );

} )( jQuery );
