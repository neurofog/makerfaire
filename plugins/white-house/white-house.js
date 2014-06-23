jQuery( document ).ready( function( $ ) {

	// Grab the URL for all of the posts from Make:
	// https://public-api.wordpress.com/rest/v1/sites/makezine.com/posts/?tag=white-house-maker-faire
	posts_url = 'https://public-api.wordpress.com/rest/v1/sites/makezine.com/posts/?tag=white-house-maker-faire';
	$.getJSON( posts_url, function( posts ) {
		the_posts = posts.posts;
		output = '<div class="row">';
		$.each( $( the_posts ), function( i, post ){
			console.log(post);
			output += '<div class="span3">';
			output += '<a href="' + post.URL  + '">';
			output += '<img class="thumbnail" src="' + post.featured_image + '?w=220&h=160&crop=1">';
			output += '</a>';
			output += '<a href="' + post.URL  + '">';
			output += '<h4>' + post.title + '</h4>';
			output += '</a>';
			output += post.excerpt;
			if ( ( i + 1 ) % 4 ) {
				output += '</div>';
			} else {
				output += '</div></div><div class="row">';
			}
		});
		output += '</div>';
		$( 'section.posts' ).html( output );
	});
});