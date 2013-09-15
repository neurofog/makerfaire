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
	
} );