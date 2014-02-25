<?php
/**
 * v2 of the Maker Faire API - MAKER
 *
 * Built specifically for the mobile app but we have interest in building it further
 * This page is the controller to grabbing the appropriate API version and files.
 *
 * This page specifically handles the Maker data.
 *
 * @version 2.0
 */

if( $type == 'maker' ) {
	// Set the query args.
	$args = array(
		'no_found_rows' 	=> true,
		'post_type' 		=>'maker',
		'post_status' 		=> 'any',
		'posts_per_page'	=> 2000,
		'faire'				=> $faire
	);


	// Run the query
	$query = new WP_Query( $args );
	$posts = $query->posts;


	// Start of the XOMO header
	$header = array( 'header' =>
		array(
			'version' 			=> '2.0', 
			'results'			=> $query->post_count
		) );

	// Init the entities header
	$entities = array();

	// Loop through the posts
	foreach ($posts as $post) {
		$pid = get_the_ID();
		$jsonpost["id"] = $pid;
		$jsonpost["child_id_refs"] = array_unique( get_post_meta( $pid, 'mfei_record' ) );
		$jsonpost['name'] = ucwords( mf_clean_content( get_the_title() ) );
		$url = get_post_meta( $pid, 'photo_url', true );
		$big = $url;
		if ( strlen($url) > 1 ) {
			$url = add_query_arg( 'w', 80, $url );
			$url = add_query_arg( 'h', 80, $url );
			$url = add_query_arg( 'crop', 1, $url );
			$jsonpost["thumb_img_url"] = $url;
			$jsonpost["large_img_url"] = $big;
		} else {
			$jsonpost["thumb_img_url"] = null;
			$jsonpost["large_img_url"] = null;
		}
		$jsonpost['description'] = ( !empty( $post->post_content ) ) ? mf_clean_content( $post->post_content ) : null;
		$video = get_post_meta( $pid, 'video', true );
		$jsonpost['youtube_url'] = ( !empty( $video ) ) ? $video : null ;
		array_push($entities, $jsonpost);
	} 
	// Merge the header and the entities
	$merged = array_merge( $header, array( 'entity' => $entities ) );

	// Output the JSON
	echo json_encode( $merged );

	// Reset the Query
	wp_reset_postdata();
}
