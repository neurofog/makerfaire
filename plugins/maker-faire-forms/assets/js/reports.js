jQuery(document).ready(function($) {

	$( '.deleteme' ).on( 'click', function( e ) {

		// Prevent the button from triggering
		e.preventDefault();

		var meta = $(this).data();

		meta.action = 'mf_delete_scheduled_event';

		// Make the ajax request with the form data.
		$.ajax({
			url: ajaxurl,
			data: meta,
			type: 'POST',
			success: function( data ){
				blurb = JSON.parse( data );
				if ( blurb.pid ) {
					$('.post-' + blurb.pid ).slideUp();
				}
			}
		});
	});

	console.log('loaded');
	// Listen for a click on the editoral button
	$('input[type="submit"].export_comments').click(function(e) {
		// e.preventDefault();
		$('input#export-comments').val('true');
	});
});