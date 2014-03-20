<?php
/**
 * v2 of the Maker Faire API - LOCATION_CATEGORY
 *
 * Built specifically for the mobile app but we have interest in building it further
 * This page is the controller to grabbing the appropriate API version and files.
 *
 * This page specifically handles the Location Category data. This will output the categories for locations on the map in the mobile app
 * This API endpoint will generate location categories into the entity object for Eventbase
 *
 * @version 2.0
 */

// Stop any direct calls to this file
defined( 'ABSPATH' ) or die( 'This file cannot be called directly!' );

// Double check again we have requested this file
if ( $type == 'location_category' ) {
	// By default we have the taxonomy set to show_ui => false as these will never be updated
	$terms = get_terms( array( 'location_category' ), array( 'hide_empty' => 0 ) );

	// Define the API header (specific for Eventbase)
	$header = array(
		'header' => array(
			'version' => esc_html( MF_EVENTBASE_API_VERSION ),
			'results' => count($terms),
		),
	);

	// Init the entities header
	$loc_cats = array();

	foreach ( $terms as $term ) {

		// REQUIRED: Location Category ID
		$loc_cat['id'] = absint( $term->term_id );

		// REQUIRED: Location Category name
		$loc_cat['name'] = esc_html( $term->name );

		// Put the lcoation category into our list of location categories
		array_push( $loc_cats, $loc_cat );
	}

	$merged = array_merge( $header, array( 'entity' => $loc_cats ) );

	// Output the JSON
	echo json_encode( $merged );

	// Reset the Query
	wp_reset_postdata();
}