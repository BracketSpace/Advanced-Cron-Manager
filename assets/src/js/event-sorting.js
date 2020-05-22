
(function ($) {

	// ///////////
	// Sorting  //
	// ///////////

	$( '.tools_page_advanced-cron-manager' ).on(
		'click',
		'#events .header .event, #events .header .schedule, #events .header .next-execution',
		function (event) {

			event.preventDefault();

			var event_rows_block = $( '.event-rows-block' );
			var event_rows       = event_rows_block.children();
			var column_name      = $( this ).data( 'name' );

			assign_order_class( $( this ) );

			event_rows.sort( get_comparator( column_name, get_order_direction( $( this ) ) ) );
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
			row1 = parseInt( $( row1 ).find( '.schedule' ).data( 'interval' ) );
			row2 = parseInt( $( row2 ).find( '.schedule' ).data( 'interval' ) );
			return row1 === row2 ? 0 : ( row1 > row2 ? 1 : -1 ) * order;
		}

		function compare_by_event_execution(row1, row2) {
			row1 = parseInt( $( row1 ).find( '.next-execution' ).data( 'time' ) );
			row2 = parseInt( $( row2 ).find( '.next-execution' ).data( 'time' ) );
			return row1 === row2 ? 0 : ( row1 > row2 ? 1 : -1 ) * order;
		}
	}

	function assign_order_class( column ) {
		if ( column.is( '.asc' ) || column.is( '.desc' ) ) {
			column.toggleClass( 'asc desc' );
		} else {
			column.addClass( 'asc' );
			column.siblings().removeClass( 'asc desc' );
		}

		set_item_to_storage( 'events_sorting_column_name',  column.data( 'name' ) );
		set_item_to_storage( 'events_sorting_order_class',  column.is( '.asc' ) ? 'acs' : 'desc' );
	}

	function set_item_to_storage( key, value ) {
		if (typeof(Storage) !== "undefined") {
			return sessionStorage.setItem( key, value );
		} else {
			console.warn( "Web Storage is not supported." );
		}
	}

	function get_order_direction( column ) {
		if ( column.is( '.asc' ) ) {
			return 1;
		} else if ( column.is( '.desc' ) ) {
			return -1;
		}
		return 0;
	}

})( jQuery );
