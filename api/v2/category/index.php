<?php
/**
 * v2 of the Maker Faire API - CATEGORY
 *
 * Built specifically for the mobile app but we have interest in building it further
 * This page is the controller to grabbing the appropriate API version and files.
 *
 * This page specifically handles the Category data.
 *
 * @version 2.0
 */

// Stop any direct calls to this file
defined( 'ABSPATH' ) or die( 'This file cannot be called directly!' );

$taxonomies = array(
	'category',
	'post_tag',
	'group',
);

// Double check again we have requested this file
if ( $type == 'category') {
	// Fetch the categories and tags as one
	$terms = get_terms( $taxonomies, array( 
		'hide_empty' => 0,
	) );

	// Define the API header (specific for Eventbase)
	$header = array(
		'header' => array(
			'version' => esc_html( MF_EVENTBASE_API_VERSION ), 
			'results' => count( $terms ),
		),
	);

	// Initalize the app container
	$venues = array();

	// Loop through the terms
	foreach ( $terms as $term ) {
		// REQUIRED: Category ID
		$venue['id'] = absint( $term->term_id );

		// List any child categories assigned to the cat
		$child_cats = get_terms( $taxonomies, array(
			'hide_empty' => 0,
			'child_of' => absint( $term->term_id ),
		) );
		var_dump($child_cats);

		// REQUIRED: Category Name
		$venue['name'] = esc_html( $term->name );

		// Put the application into our list of apps
		array_push( $venues, $venue );
	}
	
	$merged = array_merge( $header, array( 'entity' => $venues, ) );

	// Output the JSON
	// echo json_encode( $merged );
	var_dump($merged);
	
}