<?php
/**
 * v2 of the Maker Faire API - ENTITY
 *
 * Built specifically for the mobile app but we have interest in building it further
 * This page is the controller to grabbing the appropriate API version and files.
 *
 * This page specifically handles the Entity type for the mobile app. AKA the applications.
 *
 * @version 2.0
 */

// Stop any direct calls to this file
defined( 'ABSPATH' ) or die( 'This file cannot be called directly!' );

// We need to have access to the $mfform object so we can utilize the merge_fields() function
global $mfform;

// Double check again we have requested this file
if ( $type == 'entity' ) {

	// Set the query args.
	$args = array(
		'no_found_rows'	 => true,
		'post_type'		 => 'mf_form',
		'post_status'	 => 'accepted',
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
	$apps = array();

	// Loop through the posts
	foreach ( $query->posts as $post ) {
		// Store the app information
		$app_data = json_decode( mf_clean_content( $post->post_content ) );

		// REQUIRED: Application ID
		$app['id'] = absint( $post->ID );

		// REQUIRED: Application name
		$app['name'] = html_entity_decode( get_the_title(), ENT_COMPAT, 'utf-8' );

		// Application Thumbnail and Large Images
		$app_image = mf_get_the_maker_image( $app_data );
		$app['thumb_img_url'] = esc_url( wpcom_vip_get_resized_remote_image_url( $app_image, '80', '80' ) );
		$app['large_image_url'] = esc_url( $app_image );

		// Application Locations
		$locations = get_post_meta( absint( $post->ID ), 'faire_location', true );

		if ( empty ( $locations ) ) {
			$locations = null;
		}
		$app['venue_id_ref'] = $locations;

		// Application Makers
		$maker_args = array(
			'post_type' => 'maker',
			'posts_per_page' => 20,
			'faire' => sanitize_title( $faire ),
			'meta_key' => 'mfei_record',
			'meta_value' => absint( $post->ID ),
		);
		$makers = new WP_Query( $maker_args );

		foreach ( $makers->posts as $maker ) {
			$maker_ids[] = absint( $maker->ID );
		}

		$app['child_id_refs'] = $maker_ids;

		// Application Categories
		$cats = wp_get_post_terms( absint( $post->ID ), array( 'category', 'post_tag', 'group' ) );
		
		if ( $cats && ! is_wp_error( $cats ) ) {
			foreach( $cats as $cat ) {
				$category_ids[] = absint( $cat->term_id );
			}
		} else {
			$category_ids = null;
		}

		$app['category_id_refs'] = $category_ids;

		// Application Description
		$app_description_field = $mfform->merge_fields( 'project_description', $app_data->form_type );
		
		$app['description'] = $app_data->{$app_description_field};

	
		// if ( !empty($exhibit->public_description) ) {
		// 	$booth = get_post_meta( get_the_ID(), 'booth', true );
		// 	$jsonpost["description"] = ( !empty( $booth ) ) ? '<strong>Location: ' . $booth . '</strong><br />' . $exhibit->public_description : $exhibit->public_description ;
		// } elseif ( !empty( $exhibit->short_description)) {
		// 	$booth = get_post_meta( get_the_ID(), 'booth', true );
		// 	$jsonpost["description"] = ( !empty( $booth ) ) ? '<strong>Location: ' . $booth . '</strong><br />' . $exhibit->short_description : $exhibit->short_description;
		// } else {
		// 	$jsonpost["description"] = null;
		// }
		// if (isset($exhibit->project_video)) {
		// 	$jsonpost["youtube_url"] = ( $exhibit->project_video ) ? $exhibit->project_video : '';
		// }
		// if (isset($exhibit->project_website)) {
		// 	$jsonpost["website_url"] = $exhibit->project_website;
		// } elseif ( isset( $exhibit->group_website ) ) {
		// 	$jsonpost["website_url"] = $exhibit->group_website;
		// } elseif ( isset( $exhibit->presentation_website ) ) {
		// 	$jsonpost["website_url"] = $exhibit->presentation_website;
		// }
		// // if ( !empty( $exhibit->email ) ) {
		// // 	$jsonpost["email"] = $exhibit->email;
		// // } else {
		// 	$jsonpost["email"] = null;
		// // }
		// $taggers = get_the_tags();
		// $tags = null;
		// if ( !empty( $taggers ) ) {
		// 	foreach ( $taggers as $tag ) {
		// 		$tags .= ', ' . $tag->name;
		// 	}
		// 	$jsonpost["tags"] = substr($tags, 2);
		// } else {
		// 	$jsonpost["tags"] = null;
		// }
		// $jsonpost["featured"] = '';
		
		// $jsonpost["url"] = get_permalink( get_the_ID() );

		// Put the application into our list of apps
		array_push( $apps, $app );
	}

	// Merge the header and the entities
	$merged = array_merge( $header, array( 'entity' => $app ) );
var_dump($merged);
	// Output the JSON
	// echo json_encode( $merged );

	// Reset the Query
	wp_reset_postdata();
	
}