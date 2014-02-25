<?php
/**
 * v2 of the Maker Faire API - LOCATION
 *
 * Built specifically for the mobile app but we have interest in building it further
 * This page is the controller to grabbing the appropriate API version and files.
 *
 * This page specifically handles the Location data.
 *
 * @version 2.0
 */

if( $type == 'venue') {
	include_once 'plugins/query/bay-area-locations.php';
	$terms = get_terms('location', array( 'hide_empty' => 0 ) );
	// Start of the XOMO header
	$header = array( 'header' =>
		array(
			'version' 			=> '2.0', 
			'results'			=> count($terms)
		) );

	// Init the entities header
	$venues = array();
	foreach ( $terms as $term ) {
		if ( !in_array( $term->term_id, $bayarea_locations) ) {
			$term_id = intval( $term->term_id );
			$venue['id'] = $term->term_id;
			$venue['original_id'] = $term->term_id;
			if ( $term->parent == 0 ) {
				$venue['name'] = mf_clean_content( $term->name );
			} else {
				$parent = get_term( $term->parent, 'location' );
				$venue['name'] = mf_clean_content( $parent->name . ' » ' . $term->name );
			}
			$venue['description'] = mf_clean_content( $term->description );
			$venue['latitide'] = (isset($loc_data[$term_id]['lat'])) ? $loc_data[$term_id]['lat'] : null;
			$venue['longitude'] = (isset($loc_data[$term_id]['long'])) ? $loc_data[$term_id]['long'] : null;
			$stages = array( 654896, 921378, 27475665, 36578739, 129846826, 156780557, 164745398, 164745444, 164745603, 164940502, 166795193, 166939701, 166956526, 166958578, 166958636, 166959119, 166959439 );
			if ( in_array( $term->term_id, $stages) ) {
				$venue['category_id_ref_list']  = array( 81264 ); // Stage
			} else {
				$venue['category_id_ref_list']  = array( 39727 ); // Exhibit
			}
			array_push($venues, $venue);
		}
	}
	
	$merged = array_merge($header,array('venue' => $venues, ) );

	// Output the JSON
	echo json_encode( $merged );
	
}