
(function ($) {

	// ///////////
	// Sorting  //
	// ///////////

	$( '.tools_page_advanced-cron-manager' ).on(
		'click',
		'.columns .event, .columns .schedule, .columns .next-execution',
		function (event) {

			event.preventDefault();

			const event_rows_block = $( '.event-rows-block' );
			const event_rows       = event_rows_block.children();
			const column_name      = $( this ).data( 'name' );

			assign_order_class( $( this ) );

			event_rows.sort( get_comparator( column_name, get_order( $( this ) ) ) );
			event_rows_block.html( event_rows );
		}
	);

	function get_comparator ( name, order ) {
		switch ( name ) {
			case 'event':
				return compare_by_event_name;
			case 'schedule':
				return compare_by_event_schedule;
			case 'next-execution':
				return compare_by_event_execution;
			default:
				return;
		}

		function compare_by_event_name(row1, row2) {
			row1 = $( row1 ).find( '.event-name' ).prop( 'innerText' ).toLowerCase();
			row2 = $( row2 ).find( '.event-name' ).prop( 'innerText' ).toLowerCase();
			return row1.localeCompare( row2 ) * order;
		}

		function compare_by_event_schedule(row1, row2) {
			row1 = $( row1 ).find( '.schedule' ).data( 'interval' );
			row2 = $( row2 ).find( '.schedule' ).data( 'interval' );
			return row1 === row2 ? 0 : ( row1 > row2 ? 1 : -1 ) * order;
		}

		function compare_by_event_execution(row1, row2) {
			row1 = $( row1 ).find( '.next-execution' ).data( 'time' );
			row2 = $( row2 ).find( '.next-execution' ).data( 'time' );
			return row1 === row2 ? 0 : ( row1 > row2 ? 1 : -1 ) * order;
		}
	}

	function assign_order_class(column) {
		if ( column.is( '.asc' ) || column.is( '.desc' ) ) {
			column.toggleClass( 'asc desc' );
		} else {
			column.addClass( 'asc' );
			column.siblings().removeClass( 'asc desc' );
		}
	}

	function get_order(column) {
		if ( column.is( '.asc' ) ) {
			return 1;
		} else if ( column.is( '.desc' ) ) {
			return -1;
		}
		return 0;
	}

})( jQuery );
