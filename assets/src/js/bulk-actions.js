( function( $ ) {

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
	wp.hooks.addAction( 'advanced-cron-manager/events/search/triggered', clear_all_checkboxes );

	// clear all checkboxes on filter
	wp.hooks.addAction( 'advanced-cron-manager/events/filter/schedule', clear_all_checkboxes );

} )( jQuery );
