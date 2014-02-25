<?php
/**
 * v2 of the Maker Faire API - SCHEDULE
 *
 * Built specifically for the mobile app but we have interest in building it further
 * This page is the controller to grabbing the appropriate API version and files.
 *
 * This page specifically handles the Schedule data.
 *
 * @version 2.0
 */

if ($type == 'schedule') {
/**
 * Schedule Feed
 */

	// Set the query args.
	$args = array(
		'no_found_rows'		=> true,
		'post_type' 		=> 'event-items',
		'post_status' 		=> 'publish',
		'posts_per_page' 	=> 1000,
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

		$id = get_post_meta(get_the_ID(), 'mfei_record', true );
		$day = get_post_meta(get_the_ID(), 'mfei_day', true );
		$start = get_post_meta(get_the_ID(), 'mfei_start', true );
		$stop = get_post_meta(get_the_ID(), 'mfei_stop', true );

		// Really? We need a better data structure here... 
		if ( $faire == MF_CURRENT_FAIRE ) {
			if ( $day == 'Saturday' ) {
				$date = '5/17/2013';
			} elseif ( $day == 'Sunday' ) {
				$date = '5/18/2013';
			}
		} elseif ( $faire == 'world-maker-faire-new-york-2013' ) {
			if ( $day == 'Saturday' ) {
				$date = '9/21/2013';
			} elseif ( $day = 'Sunday') {
				$date = '9/22/2013';
			}
		} elseif ( $faire == 'maker-faire-bay-area-2013') {
			if ( $day == 'Saturday' ) {
				$date = '5/18/2013';
			} elseif ( $day = 'Sunday') {
				$date = '5/19/2013';
			}
		}

		$jsonpost["id"] = get_the_ID();
		$jsonpost["entity_id_refs"] = array( $id ); // Make this an array
		$json = json_decode( mf_clean_content( get_page( $id )->post_content ) );
		$url = mf_get_the_maker_image( $json );
		$jsonpost["large_img_url"] = $url;
		$size = array ( 'h' => '80', 'w' => '80', 'crop' => 1 );
		$jsonpost["thumb_img_url"] = ($url) ? add_query_arg( $size, $url ) : null;
		$jsonpost["name"] = str_replace( array( '&#8217;', '&#038;'), array( '\'', '&'), htmlspecialchars_decode( get_the_title( $id ) ) );
		$jsonpost["original_id"] = $id;
		if ( strpos( $faire, 'new-york' ) !== false ) { // Check if the faire variable contains the 'new-york' in it. If it does, spit out the dates with a EST instead of PST
			$jsonpost["time_start"] = date( DATE_ATOM, strtotime( '-1 hour', strtotime( $date . $start . ' EST' ) ) );
			$jsonpost["time_stop"] = date( DATE_ATOM, strtotime( '-1 hour', strtotime( $date . $stop . ' EST') ) );	
		} else {
			$jsonpost["time_start"] = date( DATE_ATOM, strtotime( '-1 hour', strtotime( $date . $start . ' PST' ) ) );
			$jsonpost["time_stop"] = date( DATE_ATOM, strtotime( '-1 hour', strtotime( $date . $stop . ' PST') ) );
		}
		$locs = get_the_terms( get_the_ID(), 'location' );
		$term = array_shift( array_values( $locs ) );
		$jsonpost["venue_id_ref"] = $term->term_id;

		// Put the content into the entity
		array_push($entities, $jsonpost);
	}

	// Merge the header and the entities
	$merged = array_merge($header,array('schedule' => $entities, ) );

	// Output the JSON
	echo json_encode( $merged );

	// Reset the Query
	wp_reset_postdata();
	
}