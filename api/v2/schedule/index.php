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

// Stop any direct calls to this file
defined( 'ABSPATH' ) or die( 'This file cannot be called directly!' );

// Double check again we have requested this file
if ( $type == 'schedule' ) {

	// Set the query args.
	$args = array(
		'no_found_rows'	 => true,
		'post_type' 	 => 'event-items',
		'post_status' 	 => 'publish',
		'posts_per_page' => absint( MF_POSTS_PER_PAGE ),
		'faire'			 => sanitize_title( $faire )
	);
	$query = new WP_Query( $args );


	// Define the API header (specific for Eventbase)
	$header = array(
		'header' => array(
			'version' => esc_html( MF_EVENTBASE_API_VERSION ), 
			'results' => intval( $query->post_count ),
		),
	);

	// Initalize the schedule container
	$schedules = array();

	// Loop through the posts
	foreach ( $query->posts as $post ) {
		var_dump($post);
		die();
		// Return some post meta
		$app_id = get_post_meta( absint( $post->ID ), 'mfei_record', true );
		$day = get_post_meta( absint( $post->ID ), 'mfei_day', true );
		$start = get_post_meta( absint( $post->ID ), 'mfei_start', true );
		$stop = get_post_meta( absint( $post->ID ), 'mfei_stop', true );

		// Not happy with this... must figure out a better way to handle the dates for the different faires.
		if ( $faire == 'maker-faire-bay-area-2014' ) {
			if ( $day == 'Saturday' ) {
				$date = '5/17/2014';
			} elseif ( $day == 'Sunday' ) {
				$date = '5/18/2014';
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

		// REQUIRED: Schedule ID
		$schedule['id'] = absint( $post->ID );

		// REQUIED: Application title paired to scheduled item
		$schedule['name'] = html_entity_decode( get_the_title( absint( $app_id ) ), ENT_COMPAT, 'utf-8' );


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