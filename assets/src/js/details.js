( function( $ ) {

	var toggle_row_fold = function( event ) {

		event.preventDefault();

		$link = $( this );
		$row  = $link.parents( '.single-event' ).first();

		$row.toggleClass( 'unfolded' );

		if ( $row.hasClass( 'unfolded' ) ) {
			wp.hooks.doAction( 'advanced-cron-manager/event/details/unfolded', $row );
		}

	};

	$( '#events' ).on( 'click', '.columns .event .row-actions .details a', toggle_row_fold );
	$( '#events' ).on( 'click', '.columns .event .event-name', toggle_row_fold );

} )( jQuery );
