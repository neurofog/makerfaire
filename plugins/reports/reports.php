<?php

function mf_reportomatic() {
	$file = sprintf( '/tmp/%s-htaccess.txt', date( 'Y-m-d' ) );
	$f = fopen( $file, 'w'); 
	$args = array(
		'post_type' => array( 'mf_form' ),
		'post_status' => 'proposed',
		'posts_per_page' => 1,
	);

	$query = new WP_Query( $args );
	global $post;
	if( $query->have_posts() ) :
		while ( $query->have_posts() ) : $query->the_post();
			var_dump( $post );
			fputcsv( $f, (array) json_decode( str_replace( "\'", "'", $post->post_content ) ), ';' );

		endwhile;
	endif;
	fseek($f, 0);
	// tell the browser it's going to be a csv file
	header( 'Content-Type: application/csv' );
	// tell the browser we want to save it instead of displaying it
	header( 'Content-Disposition: attachement; filename="' . $file . '"');
	// make php send the generated csv lines to the browser
	fpassthru($f);
}