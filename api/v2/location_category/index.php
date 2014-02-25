<?php
/**
 * v2 of the Maker Faire API - LOCATION_CATEGORY
 *
 * Built specifically for the mobile app but we have interest in building it further
 * This page is the controller to grabbing the appropriate API version and files.
 *
 * This page specifically handles the Location Category data.
 *
 * @version 2.0
 */

if( $type == 'location_category') {
	$terms = get_terms(array( 'location_category' ), array( 'hide_empty' => 0 ) );
	// Start of the XOMO header
	$header = array( 'header' =>
		array(
			'version' 			=> '2.0', 
			'results'			=> count($terms)
		) );

	// Init the entities header
	$venues = array();
	foreach ( $terms as $term ) {
		$venue['id'] = $term->term_id;
		$venue['name'] = mf_clean_content( $term->name );
		array_push($venues, $venue);
	}
	
	$merged = array_merge($header,array('entity' => $venues, ) );

	// Output the JSON
	echo json_encode( $merged );
	
}