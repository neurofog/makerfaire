jQuery(document).ready(function($) {

	console.log('loaded');
	// Listen for a click on the editoral button
	$('input[type="submit"].export_comments').click(function(e) {
		// e.preventDefault();
		$('input#export-comments').val('true');
	});
});