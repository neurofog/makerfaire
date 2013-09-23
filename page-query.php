<?php
/**
 * Template Name: Query
 */

require_once 'plugins/public-pages/locations.php';

// Simple API Keys. Basically, just XOMO needs this, and want to restrict access. Obviously not super secure, but doesn't need to be.
$keys = array(
		'make' => '4eqU!eT74!Exuca',
		'xomo' => 'V_2az7na7RacrAp',
		);

// Type Options: entity, venue, location, schedule, makers

// Init the $key variable
$key = (!empty($_REQUEST['key']) ? $_REQUEST['key'] : null);
$type = (!empty($_REQUEST['type']) ? $_REQUEST['type'] : null);
$faire = ( !empty($_REQUEST['faire']) ) ? sanitize_title( $_REQUEST['faire'] ) : null;

// If key doesn't exist, return nothing.
if (!in_array($key, $keys)) {
	header('HTTP/1.0 403 Forbidden');
	return;
}

function mf_clean_content( $content ) {
	$bad = array( '&#039;', "\'", '&#8217;', '&#38;', '&#038;', '&#34;', '&#034;', '&#8211;', '&lt;', '&#8230;' );
	$good = array( "'", "'", "'", "&", "&", '"', '"', '–', '>', '...' );

	$cleaned = str_replace( $bad, $good, htmlspecialchars_decode( mf_convert_newlines( $content ) ) );

	return $cleaned;
}

// Set the JSON header
header('Content-type: application/json');


// Entity Type


if ($type == 'entity') {

	// Set the query args.
	$args = array(
		'no_found_rows'		=> true,
		'post_type'			=> 'mf_form',
		'post_status'		=> 'accepted',
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
		$exhibit = json_decode( mf_clean_content( $post->post_content ) );

		if ( isset( $exhibit->form_type ) ) {
			$jsonpost["type"] = $exhibit->form_type;
		}
		
		$jsonpost["id"] = get_the_ID();

		// We need our Makers ID's so the exhibits can be linked to their maker profiles in the app.
		$maker_args = array(
			'post_type' 	 => 'maker',
			'posts_per_page' => 20,
			'faire'			 => $faire,
			'meta_key'		 => 'mfei_record',
			'meta_value'	 => get_the_ID()

		);
		$app_makers = new WP_Query( $maker_args );
		$maker_ids = $app_makers->posts;
		$maker_post_id = array();
		foreach( $maker_ids as $maker_id ) {
			array_push( $maker_post_id, absint( $maker_id->ID ) );
		}
		$jsonpost["child_id_refs"] = $maker_post_id;

		$jsonpost["name"] = html_entity_decode( get_the_title(), ENT_COMPAT, 'utf-8' );
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
		if ($locs) {
			$term = array_shift( array_values( $locs ) );
			$jsonpost["venue_id_ref"] = $term->term_id;
		} else {
			$jsonpost["venue_id_ref"] = null;
		}
		
		$cats = get_the_terms( get_the_ID(), array( 'category', 'post_tag', 'group' ) );
		$category_id_refs = array();
		if ($cats) {
			foreach ( $cats as $cat ) {
				array_push( $category_id_refs, $cat->term_id);
			}
		}
		$jsonpost["category_id_refs"] = $category_id_refs;
		if ( !empty($exhibit->public_description) ) {
			$booth = get_post_meta( get_the_ID(), 'booth', true );
			$jsonpost["description"] = ( !empty( $booth ) ) ? '<strong>Location: ' . $booth . '</strong><br />' . $exhibit->public_description : $exhibit->public_description ;
		} elseif ( !empty( $exhibit->short_description)) {
			$booth = get_post_meta( get_the_ID(), 'booth', true );
			$jsonpost["description"] = ( !empty( $booth ) ) ? '<strong>Location: ' . $booth . '</strong><br />' . $exhibit->short_description : $exhibit->short_description;
		} else {
			$jsonpost["description"] = null;
		}
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
		// if ( !empty( $exhibit->email ) ) {
		// 	$jsonpost["email"] = $exhibit->email;
		// } else {
			$jsonpost["email"] = null;
		// }
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
/**
 * Venue Feed
 */
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
	
} elseif( $type == 'category') {
	$terms = get_terms(array( 'category', 'post_tag', 'group' ), array( 'hide_empty' => 0 ) );
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
	
} elseif( $type == 'location_category') {
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
	
} elseif ($type == 'schedule') {
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
		if ( $faire == 'world-maker-faire-new-york-2013' ) {
			if ( $day == 'Saturday' ) {
				$date = '9/21/2013';
			} elseif ( $day = 'Sunday') {
				$date = '9/22/2013';
			}
		} else {
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
		if ( $faire == 'world-maker-faire-new-york-2013' ) {
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
	
} elseif ($type == 'maker') {

/**
 * Maker Feed
 */


	// Set the query args.
	$args = array(
		'no_found_rows' 	=> true,
		'post_type' 		=> 'mf_form',
		'post_status' 		=> 'accepted',
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
		$jsonpost = array();
		$exhibit = json_decode( html_entity_decode( str_replace( array("\'", "u03a9"), array("'", '&#8486;'), $post->post_content ), ENT_COMPAT, 'utf-8' ) );
		$jsonpost["id"] = get_the_ID();
		$jsonpost["child_id_refs"] = get_the_ID();
		if ( !isset( $exhibit->form_type ) ) {
			continue;
		}
		$form_type = $exhibit->form_type;
		// Start of with Exhibits
		if ( $exhibit->form_type == 'exhibit' ) {
			// Let's tackle groups first
			if ($exhibit->maker == 'A group or association' ) {
				$jsonpost['name'] = ucwords( ( $exhibit->group_name ) ? $exhibit->group_name : $exhibit->name );
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
				$jsonpost['name'] = ucwords( $exhibit->maker_name ? $exhibit->maker_name : $exhibit->name );
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
				$jsonpost['name'] = ucwords( $exhibit->maker_name ? $exhibit->maker_name : $exhibit->name );
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
			$jsonpost['name'] =  ucwords( $exhibit->presenter_name ? $exhibit->presenter_name : $exhibit->name );
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
			$jsonpost['name'] = ucwords( $exhibit->performer_name ? $exhibit->performer_name : $exhibit->name );
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
			if ( !empty($json->long_description ) ) {
				$jsonpost['description'] = htmlspecialchars_decode( $exhibit->long_description );
			} elseif ( !empty($json->public_description ) ) {
				$jsonpost['description'] = htmlspecialchars_decode( $exhibit->public_description );
			} else {
				$jsonpost['description'] = null;
			}
			$jsonpost['youtube_url'] = ($exhibit->performer_video ? $exhibit->performer_video  : null);
		}		
		$locs = get_the_terms( get_the_ID(), 'location' );
		if ($locs) {
			$term = array_shift( array_values( $locs ) );
			$jsonpost["venue_id_ref"] = $term->term_id;
		} else {
			$jsonpost["venue_id_ref"] = null;
		}
		array_push($entities, $jsonpost);
	}

	// Merge the header and the entities
	$merged = array_merge( $header, array( 'entity' => $entities ) );

	// Output the JSON
	echo json_encode( $merged );

	// Reset the Query
	wp_reset_postdata();
	
} elseif( $type == 'new_maker' ) {
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