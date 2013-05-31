jQuery(document).ready(function($) {

	// Add our custom search box
	$('.search-box').prepend('<div id="project-id-search"><label for="project-id" class="screen-reader-text">Search by Project ID</label><input type="search" name="search-proj-id" id="project-id" /><input type="submit" value="Search by ID" id="search-submit" class="button" /></div>');

	// Disable the default action of our custom search button and instead redirect the user to the right page
	$('#search-submit').click(function(e) {

		// disable the defaults
		e.preventDefault();

		// Remove any error messages
		$('.search-error').fadeOut().remove();

		// Set some variables
		var app_id = $('#project-id').val();
		var app_url = ef_admin_url + 'post.php?post=' + app_id + '&action=edit';

		// Check that we are actually sending something valid first.
		if ( $.isNumeric(app_id) ) {

			// Use AJAX to ensure the page exists before just blindely walking off the cliff
			$.ajax({
				url: app_url,
				success: function(data, textStatus) {

					// Redirect the user to the edit window! Grab Edit Flows Admin URL variable for simplicity :)
					window.location = app_url;
				}, error: function(jqXHR, textStatus, errorThrown) {

					// Oops! Post ID doesn't exist... let's let them know they dun messed up.
					$('#project-id-search').prepend('<div class="search-error">Application Not Found. Please Double Check.</div>');
					$('.search-error').fadeIn('fast');
				}
			});
		} else {

			// If all else fails, we can assume this field is not being used right... Let the user know.
			$('#project-id-search').prepend('<div class="search-error">Not a valid Application ID! Numbers Only</div>');
			$('.search-error').fadeIn('fast');
		}
	});
});