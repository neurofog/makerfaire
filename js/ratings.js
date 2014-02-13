/**
 * The script that will allow us to save reviews on applications
 * Only runs in the admin area and on the mf_form post type
 */

jQuery( document ).ready( function( $ ) {
	$( '.my-rating .label' ).click( function() {
		var data = {};

		// Get the selected rating
		data.rating = $(this).prev().val();

		// Get the author ID
		data.author_id = $( '.my-rating input:hidden[name="author-id"]' ).val();

		// Get the post ID
		// data.post_id = $( '')

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: {
				'action' : 'mf_form_save_review',
				'nonce' : $( '#mf_form_rating' ).val(),
				'data'   : data
			}
		});
	});
});
