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

// Stop any direct calls to this file
defined( 'ABSPATH' ) or die( 'This file cannot be called directly!' );

// Double check again we have requested this file
if ( $type == 'venue' ) {

	// Set the query args.
	$args = array(
		'no_found_rows'  => true,
		'post_type' 	 => 'location',
		'post_status' 	 => 'any',
		'posts_per_page' => absint( MF_POSTS_PER_PAGE ),
		'faire'			 => sanitize_title( $faire ),
	);
	$query = new WP_Query( $args );

	// Define the API header (specific for Eventbase)
	$header = array(
		'header' => array(
			'version' => esc_html( MF_EVENTBASE_API_VERSION ),
			'results' => intval( $query->post_count ),
		),
	);


	// Init the entities header
	$venues = array();

	// Loop through the posts
	foreach ( $query->posts as $post ) {

		// Open the array.
		$venue = array();

		// REQUIRED: The venue ID
		$venue['id'] = absint( $post->ID );

		// REQUIRED: The venue name
		$venue['name'] = html_entity_decode( get_the_title(), ENT_COMPAT, 'utf-8' );

		// Get the child locations
		$kids = get_children( array( 'post_parent' => $venue['id'], ) );

		$venue['child_id_refs'] = array();

		foreach ( $kids as $kid => $values ) {
			$venue['child_id_refs'][] = $kid;
		}

		// Get the description, if it exists.
		$venue['description'] = html_entity_decode( trim( Markdown( get_the_excerpt() ) ), ENT_COMPAT, 'utf-8' );

		// Do we have a subtitle?
		$venue['subtitle'] = ( $post->post_parent != 0 ) ? get_the_title( $post->post_parent ) : '';

		// Do we have lat/long?
		$meta = get_post_meta( $post->ID );

		// Attach the lat/long to the data feed
		$venue['latitude']	= ( isset( $meta['latitude'] ) ) ? floatval( $meta['latitude'][0] ) : '';
		$venue['longitude']	= ( isset( $meta['longitude'] ) ) ? floatval( $meta['longitude'][0] ) : '';

		// They apparently changed the spec.
		$venue['gps_lat']	= ( isset( $meta['latitude'] ) ) ? floatval( $meta['latitude'][0] ) : '';
		$venue['gps_long']	= ( isset( $meta['longitude'] ) ) ? floatval( $meta['longitude'][0] ) : '';

		// Let's add the venue categories
		$cats = wp_get_post_terms( absint( $post->ID ), array( 'location_category' ) );

		$category_ids = array();

		if ( $cats && ! is_wp_error( $cats ) ) {
			foreach( $cats as $cat ) {
				$category_ids[] = absint( $cat->term_id );
			}
		} else {
			$category_ids = null;
		}

		$venue['category_id_refs'] = $category_ids;


		// Put the maker into our list of makers
		array_push( $venues, $venue );
	}

	// Merge the header and the entities
	$merged = array_merge( $header, array( 'entity' => $venues ) );

	// Output the JSON
	echo json_encode( $merged );

	// Reset the Query
	wp_reset_postdata();
}
