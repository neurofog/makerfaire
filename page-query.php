<?php
/**
 * Template Name: Query
 */

// Prevent Errors locally. 
error_reporting('NONE');

// Simple API Keys. Basically, just XOMO needs this, and want to restrict access. Obviously not super secure, but doesn't need to be.
$keys = array(
		'make' => 123454321,
		'xomo' => 543212345,
		);

// Type Options: entity, venue, location, schedule

// Init the $key variable
$key = (!empty($_REQUEST['key']) ? $_REQUEST['key'] : null);
$type = (!empty($_REQUEST['type']) ? $_REQUEST['type'] : null);

// If key doesn't exist, return nothing.
if (!in_array($key, $keys)) {
	return;
}

// Set the JSON header
header('Content-type: application/json');


// Entity Type


if ($type == 'entity') {

	// Set the query args.
	$args = array(
		'no_found_rows' => true,
		'post_type' =>'mf_form',
		'post_status' => 'accepted',
		'posts_per_page' => 1000

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
		$exhibit = json_decode( str_replace( "\'", "'", $post->content ) );
		$jsonpost["id"] = get_the_ID();
		$jsonpost["name"] = get_the_title();
		$jsonpost["original_id"] = get_the_ID();
		$url = $exhibit->project_photo;
		if (!empty($url)) {
			$url = add_query_arg( 'w', 80, $url );
			$url = add_query_arg( 'h', 80, $url );
			$url = add_query_arg( 'crop', 1, $url );
			$jsonpost["thumb_img_url"] = $url;	
		} else {
			$jsonpost["thumb_img_url"] = null;
		}
		$jsonpost["thumb_img_url"] = $url;
		$jsonpost["large_img_url"] = $exhibit->project_photo;
		$locs = get_the_terms( get_the_ID(), 'location' );
		$jsonpost["venue_id_ref"] = key($locs);
		$cats = get_the_category( get_the_ID() );
		$category_id_refs = array();
		foreach ( $cats as $cat ) {
			array_push( $category_id_refs, $cat->term_id);
		}
		$jsonpost["category_id_refs"] = $category_id_refs;
		$jsonpost["description"] = $exhibit->public_description;
		$jsonpost["featured"] = $exhibit->public_description;
		$jsonpost["youtube_url"] = $exhibit->youtube_url;
		$jsonpost["website_url"] = $exhibit->project_website;
		$jsonpost["facebook_url"] = '';
		$jsonpost["email"] = $exhibit->email;
		$taggers = get_the_tags();
		$tags = null;
		foreach ( $taggers as $tag ) {
			$tags .= ', ' . $tag->name;
		}
		$jsonpost["tags"] = substr($tags, 2);
		$jsonpost["featured"] = '';
		
		$jsonpost["url"] = $exhibit->project_website;

		// Put the content into the entity
		array_push($entities, $jsonpost);
	}

	// Merge the header and the entities
	$merged = array_merge($header,array('entity' => $entities, ) );

	// Output the JSON
	echo json_encode( $merged );

	// Reset the Query
	wp_reset_postdata();
	
} elseif( $type == 'venue') {
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
		$venue['id'] = $term->term_id;
		$venue['original_id'] = $term->term_id;
		$venue['name'] = $term->name;
		$venue['description'] = $term->description;
		$venue['latitude'] = $term->lat;
		$venue['longitude'] = $term->long;
		array_push($venues, $venue);
	}
	
	$merged = array_merge($header,array('venue' => $venues, ) );

	// Output the JSON
	echo json_encode( $merged );
	
} elseif( $type == 'category') {
	$terms = get_terms('category', array( 'hide_empty' => 0 ) );
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
		$venue['name'] = $term->name;
		array_push($venues, $venue);
	}
	
	$merged = array_merge($header,array('entity' => $venues, ) );

	// Output the JSON
	echo json_encode( $merged );
	
} elseif ($type == 'schedule') {

	// Set the query args.
	$args = array(
		'no_found_rows' => true,
		'post_type' =>'event-items',
		'post_status' => 'publish',
		'posts_per_page' => 1000

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

		if ( $day == 'Saturday' ) {
			$date = '5/18/2013';
		} elseif ( $day = 'Sunday') {
			$date = '5/19/2013';
		}

		$jsonpost["id"] = get_the_ID();
		$jsonpost["name"] = get_the_title( $id );
		$jsonpost["original_id"] = intval( $id );
		$jsonpost["time_start"] = date( DATE_ATOM, strtotime( $date . $start ) );
		$jsonpost["time_stop"] = date( DATE_ATOM, strtotime( $date . $stop ) );
		$locs = get_the_terms( get_the_ID(), 'location' );
		$jsonpost["venue_id_ref"] = key($locs);

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
