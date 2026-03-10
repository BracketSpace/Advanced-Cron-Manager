( function( $ ) {

	////////////
	// Action //
	////////////

	$( '.tools_page_advanced-cron-manager' ).on( 'click', '.tablenav .action', function( event ) {

		event.preventDefault();

		var $apply_button = $( this );
		var $select_input = $( this ).prev( 'select' );
		var action        = $select_input.val();

		if ( action === '-1' ) {
			return;
		}

		$apply_button.prop( 'disabled', true );

		// Collect all items upfront before modifying the DOM.
		var items = [];

		get_all_checkboxes( true ).each( function() {
			var $checkbox      = $( this );
			var $row           = $checkbox.parents( '.single-event.row' ).first();
			var $action_button = $row.find( 'a.' + action + '-event' );

			if ( $action_button.length ) {
				items.push( {
					nonce: $action_button.data( 'nonce' ),
					event: $action_button.data( 'event' ),
					$row:  $row
				} );
			}

			$checkbox.prop( 'checked', false );
		} );

		if ( ! items.length ) {
			$apply_button.prop( 'disabled', false );
			$select_input.val( '-1' );
			return;
		}

		// Process items sequentially to avoid race conditions on the cron option.
		function processNext( index ) {

			if ( index >= items.length ) {
				$apply_button.prop( 'disabled', false );
				$select_input.val( '-1' );

				// Rerender the events table after destructive actions.
				if ( action !== 'run' ) {
					$( '#events' ).addClass( 'loading' );

					$.post(
						ajaxurl,
						{ 'action': 'acm/rerender/events', 'nonce': advanced_cron_manager.rerender_nonce },
						function( response ) {
							$( '#events' ).replaceWith( response.data );
							wp.hooks.doAction( 'advanced-cron-manager.event.search' );
							wp.hooks.doAction( 'advanced-cron-manager.event.sort' );
						}
					);
				}

				return;
			}

			var item = items[ index ];

			var data = {
				'action': 'acm/event/' + action,
				'nonce':  item.nonce,
				'event':  item.event
			};

			item.$row.addClass( 'removing' );

			$.post( ajaxurl, data, function( response ) {

				advanced_cron_manager.ajax_messages( response );

				if ( response.success === true && action !== 'run' ) {
					item.$row.slideUp();
				}

				item.$row.removeClass( 'removing' );

			} ).always( function() {
				processNext( index + 1 );
			} );

		}

		processNext( 0 );

	} );

	////////////////
	// Checkboxes //
	////////////////

	var $cb_all    = $( '.single-event.header .select-all' ),
		cb_checked = [];

	function get_all_checkboxes( checked ) {

		checked = typeof checked !== 'undefined' ? checked : false;

		if ( checked ) {
			var appendix = ':checked';
		} else {
			var appendix = '';
		}

		return $( '#events .events .single-event.row:visible .cb input:checkbox' + appendix );

	}

	function clear_all_checkboxes() {
		get_all_checkboxes().prop( 'checked', false );
		$cb_all.prop( 'checked', false );
	}

	// change all rows if parent checkboxes has been changed
	$cb_all.on( 'change', function() {
		get_all_checkboxes().prop( 'checked', this.checked );
		$cb_all.prop( 'checked', this.checked );
	});

	// check if parent checkboxes should be changed when changing row checkboxes
	get_all_checkboxes().on( 'change', function() {
		$cb_all.prop( 'checked', ( get_all_checkboxes( true ).length == get_all_checkboxes().length ) );
	} );

	// clear all checkboxes on search
	wp.hooks.addAction( 'advanced-cron-manager.events.search.triggered', 'bracketspace/acm/events-search-triggered', clear_all_checkboxes );

	// clear all checkboxes on filter
	wp.hooks.addAction( 'advanced-cron-manager.events.filter.schedule', 'bracketspace/acm/events-filter-schedule', clear_all_checkboxes );

} )( jQuery );
