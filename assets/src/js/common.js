advanced_cron_manager.notify = function( notification, icon ) {

	if ( typeof icon == 'undefined' ) {
		icon = '';
	} else {
		icon = '<span class="dashicons dashicons-' + icon + '"></span>';
	}

	Materialize.toast( icon + notification, 4000 );

};

advanced_cron_manager.ajax_messages = function( response ) {

	if ( response.success == true ) {
		advanced_cron_manager.notify( response.data, 'yes' );
	} else {
		jQuery.each( response.data, function( number, error ) {
			advanced_cron_manager.notify( error, 'warning' );
		} );
	}

};

function ACM_Preview_Modal() {
	this.container = jQuery('.preview-modal');
	this.close_button = jQuery('.preview-modal .close');

	this.close_button.click( { previewModal: this }, function ( event ) {
		event.data.previewModal.close();
	} );

	this.close = function () {
		this.container.css( 'visibility', 'hidden' );
	};

	this.open = function () {
		this.container.css( 'visibility', 'visible' );
	};

	this.fulfill = function( html ) {
		this.container.find( '.content' ).html( html );
	};
};

function ACM_Slidebar() {
	this.container    = jQuery( '.slidebar' );
	this.overlay      = jQuery( '.slidebar-overlay' );
	this.close_button = jQuery( '.slidebar .close' );

	this.close_button.click( { slidebar: this }, function( event ) {
		event.data.slidebar.close();
	} );

	this.overlay.click( { slidebar: this }, function( event ) {
		event.data.slidebar.close();
	} );

	this.open = function() {

		this.container.animate( {
			'margin-right': 0
		}, 400, 'easeInOutSine' );

		this.overlay.fadeIn( 400 );

		wp.hooks.doAction( 'advanced-cron-manager.slidebar.opened', this );

	};

	this.close = function() {

		var $form = this.container.find( '.content .form' );

		this.container.animate( {
			'margin-right': '-' + ( this.container.outerWidth() + 5 )
		}, 400, 'easeInOutSine', function () {
			$form.html( '' );
		} );

		this.overlay.fadeOut( 400 );

		wp.hooks.doAction( 'advanced-cron-manager.slidebar.closed', this );

	};

	this.wait = function() {
		this.container.find( '.content' ).addClass( 'loading' );
	};

	this.fulfill = function( html ) {
		this.container.find( '.content .form' ).html( html );
		this.container.find( '.content' ).removeClass( 'loading' );

		wp.hooks.doAction( 'advanced-cron-manager.slidebar.fulfilled', this );
	};

	this.form_process_start = function( html ) {
		this.container.find( '.content .send-form' ).attr( 'disabled', true );
		this.container.find( '.content .spinner' ).css( 'visibility', 'visible' );

		wp.hooks.doAction( 'advanced-cron-manager.slidebar.proces.started', this );
	};

	this.form_process_stop = function( html ) {
		this.container.find( '.content .send-form' ).attr( 'disabled', false );
		this.container.find( '.content .spinner' ).css( 'visibility', 'hidden' );

		wp.hooks.doAction( 'advanced-cron-manager.slidebar.proces.stopped', this );
	};

};

advanced_cron_manager.slidebar = new ACM_Slidebar;
advanced_cron_manager.previewModal = new ACM_Preview_Modal;
