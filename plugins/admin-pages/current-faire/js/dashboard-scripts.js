jQuery( document ).ready( function( $ ) {

	// Sort the custom table and enable zebra stripes
	$.tablesorter.defaults.widgets = ['zebra'];
	$( 'table#current-faire' ).tablesorter();


	// Setup Ajax for our screen options
	$( 'input.hide-column-tog:checkbox' ).on( 'click', function() {

		// Save our new options to the database
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: {
				'action' : 'current_faire_screen_opt',
				'nonce' : $( '#current-faire-screen-options input#maker-faire-current-faire' ).val(),
				'submission' : $( '#current-faire-screen-options input[name="submission"]:hidden' ).val(),
				'data'   : $( '#current-faire-screen-options input:checked' ).serialize()
			}
		});

		// show or hide our columns on click
		var column = '.column-' + $(this).val();

		$( column ).each( function() {
			if ( $(this).is(':visible') ) {
				$(this).hide();
			} else {
				$(this).show();
			}
		});
	});
});