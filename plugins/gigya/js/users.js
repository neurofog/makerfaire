
// This file contains carry over from the original Gigya code from ISC
// For now we need this. In the next upcoming faire we will be removing this.

var path = window.location.pathname.substring(1);

jQuery(function($) {

	// Return our makers information. TODO: move this into PHP and store this info. Basically, move completely to the REST API.
	gigya.accounts.getAccountInfo({ callback: makerfaire_loggedin });
});


/**
 * The JavaScript that controls a number of things in the maker profile and forms page
 * Over time, we'll be replacing all of this JavaScript with the REST API
 * @param  object maker The object returned by gigya.accounts.getAccountInfo()
 * @return mixed
 *
 * @since  SPRINT_NAME
 */
function makerfaire_loggedin( maker ) {

	if ( gigya_debug )
		console.log( maker );

	if ( maker.errorCode === 0 ) {
		
		// Use jQuery to add some user info stuff on the forms
		if ( path.indexOf( 'exhibit' ) >= 0 || path.indexOf( 'presenter' ) >= 0 || path.indexOf( 'performer' ) >= 0 ) {

			if ( jQuery( '.mf-form #id' ).val() !== 0 && jQuery( '.mf-form #uid' ).val() !== maker.UID ) {
				
				if ( gigya_debug )
					console.log( make_gigya.root_path + jQuery( '.mf-form #form_type' ).val() + 'form' );

					document.location = '/' + jQuery( '.mf-form  #form_type' ).val() + 'form';
			}
		
			if ( jQuery( 'input.default-name' ).val() === '' ) {
				jQuery( 'input.default-name' ).val( maker.profile.firstName + ' ' + maker.profile.lastName );
				jQuery( 'input.default-email' ).val( maker.profile.email );
			}
			
			jQuery( 'h3.default-name' ).html( maker.profile.firstName + ' ' + maker.profile.lastName );
			jQuery( 'h3.default-email' ).html( maker.profile.email );
			
			jQuery( '#uid' ).val( maker.UID );
			jQuery( window ).bind( 'beforeunload', function() {
				return 'Are you sure you want to leave?';
			});
		} else if ( path.indexOf( 'makerprofile' ) >= 0 ) {
			if ( maker.profile.thumbnailURL !== undefined && maker.profile.thumbnailURL !== 'undefined' )
				jQuery( '.maker-image' ).attr( 'src', maker.profile.thumbnailURL );

			// Add our maker name to the page.
			jQuery( '.maker-name' ).html( maker.profile.firstName + ' ' + maker.profile.lastName );


			// Return the forms that belong to the current maker
			jQuery.post( make_gigya.ajax, {
				action: 'mfform_getforms', uid:maker.UID, e:maker.profile.email
			}, function( r ) {

				// Check if we are on a certain date or have passed
				var now = new Date();
				var end_date = new Date( '2014-08-04' ); // Set the end date here - YYYY-MM-DD

				for ( var i in r.forms ) {
					for ( var j in r.forms[ i ] ) {

						// Check if the date right now is before our end date, 'August 4th, 2013', or else close the forms
						if ( now.getTime() < end_date.getTime() ) {
							append = '<li><a href="/' + i + 'form/?id=' + j + '">' + j + ' - ' + r.forms[ i ][ j ]['post_title'] + ' (' + r.forms[ i ][ j ]['post_status'] + ')</a></li>';
						} else {
							append = '<li>' + j + ' - ' + r.forms[ i ][ j ]['post_title'] + ' (' + r.forms[ i ][ j ]['post_status'] + ')</li>';
						}

						if ( r.forms[ i ][ j ]['post_status'] == 'in-progress' )
							append = '<li><a href="/' + i + 'form/?id=' + j + '">' + j + ' - ' + r.forms[ i ][ j ]['post_title'] + ' (' + r.forms[ i ][ j ]['post_status'] + ')</a></li>';

						jQuery( '#' + i + ' ul' ).append( append );
					}
				}

				// Remove the loading notifications
				jQuery( 'div.loading' ).remove();
				
			}, 'json' );
		}
	}
}