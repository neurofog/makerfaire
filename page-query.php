<?php
/**
 * Template Name: Query
 */

// Simple API Keys. Basically, just XOMO needs this, and want to restrict access. Obviously not super secure, but doesn't need to be.
$keys = array(
		'make' => '4eqU!eT74!Exuca',
		'xomo' => 'V_2az7na7RacrAp',
		);

// Type Options: entity, venue, location, schedule, makers

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
		$exhibit = json_decode( str_replace( "\'", "'", $post->post_content ) );
		if ( isset( $exhibit->form_type ) ) {
			$jsonpost["type"] = $exhibit->form_type;
		}
		
		$jsonpost["id"] = get_the_ID();
		$jsonpost["name"] = get_the_title();
		$jsonpost["original_id"] = get_the_ID();
		$url = mf_get_the_maker_image( $exhibit );
		if (!empty($url)) {
			$url = add_query_arg( 'w', 80, $url );
			$url = add_query_arg( 'h', 80, $url );
			$url = add_query_arg( 'crop', 1, $url );
			$jsonpost["thumb_img_url"] = $url;	
		} else {
			$jsonpost["thumb_img_url"] = null;
		}
		$jsonpost["thumb_img_url"] = $url;
		$jsonpost["large_img_url"] = mf_get_the_maker_image( $exhibit );
		$locs = get_the_terms( get_the_ID(), 'location' );
		$term = array_shift( array_values( $locs ) );
		$jsonpost["venue_id_ref"] = $term->term_id;
		
		$cats = get_the_category( get_the_ID() );
		$category_id_refs = array();
		foreach ( $cats as $cat ) {
			array_push( $category_id_refs, $cat->term_id);
		}
		$jsonpost["category_id_refs"] = $category_id_refs;
		if ( !empty($exhibit->public_description) ) {
			$jsonpost["description"] = $exhibit->public_description;
		}
		//$jsonpost["featured"] = $exhibit->public_description;
		if (isset($exhibit->project_video)) {
			$jsonpost["youtube_url"] = ( $exhibit->project_video ) ? $exhibit->project_video : '';
		}
		if (isset($exhibit->project_website)) {
			$jsonpost["website_url"] = $exhibit->project_website;
		} elseif ( isset( $exhibit->group_website ) ) {
			$jsonpost["website_url"] = $exhibit->group_website;
		} elseif ( isset( $exhibit->presentation_website ) ) {
			$jsonpost["website_url"] = $exhibit->presentation_website;
		}
		if ( !empty( $exhibit->email ) ) {
			$jsonpost["email"] = $exhibit->email;
		} else {
			$jsonpost["email"] = null;
		}
		$taggers = get_the_tags();
		$tags = null;
		if ( !empty( $taggers ) ) {
			foreach ( $taggers as $tag ) {
				$tags .= ', ' . $tag->name;
			}
			$jsonpost["tags"] = substr($tags, 2);
		} else {
			$jsonpost["tags"] = null;
		}
		$jsonpost["featured"] = '';
		
		$jsonpost["url"] = get_permalink( get_the_ID() );

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
		$venue['latitude'] = null;
		$venue['longitude'] = null;
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
		$venue['name'] = str_replace( '&amp;', '&', $term->name );
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

		$jsonpost["id"] = $id;
		$jsonpost["name"] = htmlspecialchars_decode( get_the_title( $id ) );
		$jsonpost["original_id"] = $id;
		$jsonpost["time_start"] = date( DATE_ATOM, strtotime( $date . $start ) );
		$jsonpost["time_stop"] = date( DATE_ATOM, strtotime( $date . $stop ) );
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
	
} elseif ($type == 'maker') {

	// Set the query args.
	$args = array(
		'no_found_rows' => true,
		'post_type' =>'mf_form',
		'post_status' => 'accepted',
		'posts_per_page' => 1000,
		// 'offset'		=> 400

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
		$jsonpost = array();
		$exhibit = json_decode( str_replace( "\'", "'", $post->post_content ));
		$jsonpost["id"] = get_the_ID();
		if ( !isset( $exhibit->form_type ) ) {
			continue;
		}
		$form_type = $exhibit->form_type;
		// Start of with Exhibits
		if ( $exhibit->form_type == 'exhibit' ) {
			// Let's tackle groups first
			if ($exhibit->maker == 'A group or association' ) {
				$jsonpost['name'] = ($exhibit->group_name ? $exhibit->group_name : $exhibit->name);
				$url = $exhibit->group_photo;
				if (!empty($url)) {
					$url = add_query_arg( 'w', 80, $url );
					$url = add_query_arg( 'h', 80, $url );
					$url = add_query_arg( 'crop', 1, $url );
					$jsonpost["thumb_img_url"] = $url;
					$jsonpost["large_img_url"] = $exhibit->group_photo;
				} else {
					$jsonpost["thumb_img_url"] = null;
					$jsonpost["large_img_url"] = null;
				}
				$jsonpost['description'] = ($exhibit->group_bio ? htmlspecialchars_decode( $exhibit->group_bio ) : null);
				$jsonpost['youtube_url'] = ($exhibit->project_video ? $exhibit->project_video  : null);
			} elseif ($exhibit->maker == 'One maker') {
				$jsonpost['name'] = ($exhibit->maker_name ? $exhibit->maker_name : $exhibit->name);
				$url = $exhibit->maker_photo;
				if (!empty($url)) {
					$url = add_query_arg( 'w', 80, $url );
					$url = add_query_arg( 'h', 80, $url );
					$url = add_query_arg( 'crop', 1, $url );
					$jsonpost["thumb_img_url"] = $url;
					$jsonpost["large_img_url"] = $exhibit->maker_photo;
				} else {
					$jsonpost["thumb_img_url"] = null;
					$jsonpost["large_img_url"] = null;
				}
				$jsonpost['description'] = ($exhibit->maker_bio ? htmlspecialchars_decode( $exhibit->maker_bio ) : null);
				$jsonpost['youtube_url'] = ($exhibit->project_video ? $exhibit->project_video  : null);
			} elseif ($exhibit->maker == 'A list of makers' || empty( $exhibit->maker ) ) {
				$jsonpost['name'] = ($exhibit->maker_name ? $exhibit->maker_name : $exhibit->name);
				$url = $exhibit->m_maker_photo_thumb;
				if (!empty($url)) {
					$url = add_query_arg( 'w', 80, $url );
					$url = add_query_arg( 'h', 80, $url );
					$url = add_query_arg( 'crop', 1, $url );
					$jsonpost["thumb_img_url"] = $url;
					$jsonpost["large_img_url"] = $exhibit->m_maker_photo_thumb;
				} else {
					$jsonpost["thumb_img_url"] = null;
					$jsonpost["large_img_url"] = null;
				}
				$jsonpost['description'] = ($exhibit->maker_bio ? htmlspecialchars_decode( $exhibit->maker_bio ) : null);
				$jsonpost['youtube_url'] = ($exhibit->project_video ? $exhibit->project_video  : null);
			}
		// Move into Presentations
		} elseif ( $exhibit->form_type == 'presenter' ) {
			$jsonpost['name'] = ($exhibit->presenter_name ? $exhibit->presenter_name : $exhibit->name);
			$url = $exhibit->presenter_photo_thumb;
			if (!empty($url)) {
				$url = add_query_arg( 'w', 80, $url );
				$url = add_query_arg( 'h', 80, $url );
				$url = add_query_arg( 'crop', 1, $url );
				$jsonpost["thumb_img_url"] = $url;
				$jsonpost["large_img_url"] = $exhibit->presenter_photo_thumb;
			} else {
				$jsonpost["thumb_img_url"] = null;
				$jsonpost["large_img_url"] = null;
			}
			$jsonpost['description'] = ($exhibit->presenter_bio ? htmlspecialchars_decode( $exhibit->presenter_bio[0] ) : null);
			$jsonpost['youtube_url'] = ($exhibit->video ? $exhibit->video  : null);
		} elseif ( $exhibit->form_type == 'performer' ) {
			$jsonpost['name'] = ($exhibit->performer_name ? $exhibit->performer_name : $exhibit->name);
			$url = $exhibit->performer_photo;
			if (!empty($url)) {
				$url = add_query_arg( 'w', 80, $url );
				$url = add_query_arg( 'h', 80, $url );
				$url = add_query_arg( 'crop', 1, $url );
				$jsonpost["thumb_img_url"] = $url;
				$jsonpost["large_img_url"] = $exhibit->performer_photo;
			} else {
				$jsonpost["thumb_img_url"] = null;
				$jsonpost["large_img_url"] = null;
			}
			$jsonpost['description'] = ($exhibit->public_description ? htmlspecialchars_decode( $exhibit->public_description ) : null);
			$jsonpost['youtube_url'] = ($exhibit->performer_video ? $exhibit->performer_video  : null);
		}		
		array_push($entities, $jsonpost);
	}

	// Merge the header and the entities
	$merged = array_merge($header,array('entity' => $entities, ) );

	// Output the JSON
	echo json_encode( $merged );

	// Reset the Query
	wp_reset_postdata();
	
}