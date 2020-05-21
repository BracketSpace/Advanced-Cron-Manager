
(function ($) {

	// ///////////
	// Sorting  //
	// ///////////

	$( '.tools_page_advanced-cron-manager' ).on(
		'click',
		'.columns .event, .columns .schedule, .columns .next-execution',
		function (event) {

			event.preventDefault();
			var comparator;
			switch ( $( this ).data( 'name' ) ) {
				case 'event':
					comparator = compare_by_event_hook;
					break;
				case 'schedule':
					comparator = compare_by_event_schedule;
					break;
				case 'next-execution':
					comparator = compare_by_event_execution;
					break;
				default:
					return;
			}
			const event_rows = $( '.event-rows' );
			const events     = event_rows.children();
			events.sort( comparator );
			event_rows.html( events );
		}
	);

	function compare_by_event_hook(row1, row2) {
		row1 = $( row1 ).find( '.event-name' ).prop( 'innerText' ).toLowerCase();
		row2 = $( row2 ).find( '.event-name' ).prop( 'innerText' ).toLowerCase();
		return row1.localeCompare( row2 );
	}

	function compare_by_event_schedule(row1, row2) {
		row1 = $( row1 ).find( '.schedule' ).data( 'interval' );
		row2 = $( row2 ).find( '.schedule' ).data( 'interval' );
		return row1 === row2 ? 0 : ( row1 > row2 ? 1 : -1 );
	}

	function compare_by_event_execution(row1, row2) {
		row1 = $( row1 ).find( '.next-execution' ).data( 'time' );
		row2 = $( row2 ).find( '.next-execution' ).data( 'time' );
		return row1 === row2 ? 0 : ( row1 > row2 ? 1 : -1 );
	}

})( jQuery );
