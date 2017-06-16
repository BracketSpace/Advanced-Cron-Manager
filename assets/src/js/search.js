( function( $ ) {

	var search_input_delay = 400,
		timer;

	$( '#search' ).bind( 'input', function() {
		window.clearTimeout( timer );
		timer = window.setTimeout( function() {
			wp.hooks.doAction( 'advanced-cron-manager/events/search/triggered', $( '#search' ).val() );
		}, search_input_delay );
	} );

	// filter the events list
	wp.hooks.addAction( 'advanced-cron-manager/events/search/triggered', function( search_word ) {

		$( '#events .events .single-event.row' ).each( function() {

			var $row = $( this );
			var event_name = $row.find( '.columns .event .event-name' ).text();

			if ( event_name.toLowerCase().indexOf( search_word.toLowerCase() ) == -1 ) {
				$row.hide();
			} else {
				$row.show();
			}

		} );

	} );

	// clear search input while using filters
	wp.hooks.addAction( 'advanced-cron-manager/events/filter/schedule', function() {
		$( '#search' ).val( '' );
	} );

} )( jQuery );
