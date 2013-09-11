jQuery( document ).ready( function( $ ) {

	if ( $( '#post-lock-dialog' ).length === 1 ) {
		// Append a custom button to allow editors to at least view the application, but not save.
		$( '#post-lock-dialog .post-locked-message p:last' ).append( '<a class="button hide-locker" href="#" style="position:absolute;">View</a>' );

		// If we click our custom button, we want to remove the post locker and disable the publish button
		$( '.hide-locker' ).click( function() {
			// Disable any actions a user can take...
			$( '#delete-action .submitdelete, #publishing-action #publish' ).attr( 'disabled', 'disabled' );

			// Remove the post lock dialog
			$( '#post-lock-dialog' ).remove();
		} );
	}

	// Remove any terms that are from previous faires.
	$( '#locationchecklist > li > label' ).each( function() {
		// Get the current text
		var location_name = $(this).text();
		var selected = $(this).find('input').attr('checked');
		
		// Check if the string does NOT start with a_ (our unique identifiyer for WMFNY13)
		// In the future we will be removing this and finding a better solution.
		if ( location_name.indexOf('a_') === -1 && selected !== 'checked' ) {
			$(this).parent().hide();
		}
	});

	
} );