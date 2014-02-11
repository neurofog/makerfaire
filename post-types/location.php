<?php

function location_post_type_init() {
	register_post_type( 'location', array(
		'hierarchical'      => true,
		'public'	   => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'supports'          => array( 'title', 'editor', 'page-attributes', 'revisions', 'excerpt' ),
		'has_archive'       => true,
		'query_var'         => true,
		'rewrite'           => true,
		'taxonomies'		=> array( 'faire' ),
		'labels'            => array(
			'name'                => __( 'Locations', 'makerfaire' ),
			'singular_name'       => __( 'Locations', 'makerfaire' ),
			'all_items'           => __( 'Locations', 'makerfaire' ),
			'new_item'            => __( 'New Locations', 'makerfaire' ),
			'add_new'             => __( 'Add New', 'makerfaire' ),
			'add_new_item'        => __( 'Add New Locations', 'makerfaire' ),
			'edit_item'           => __( 'Edit Locations', 'makerfaire' ),
			'view_item'           => __( 'View Locations', 'makerfaire' ),
			'search_items'        => __( 'Search Locations', 'makerfaire' ),
			'not_found'           => __( 'No Locations found', 'makerfaire' ),
			'not_found_in_trash'  => __( 'No Locations found in trash', 'makerfaire' ),
			'parent_item_colon'   => __( 'Parent Locations', 'makerfaire' ),
			'menu_name'           => __( 'Locations', 'makerfaire' ),
		),
	) );
}

add_action( 'init', 'location_post_type_init' );

function location_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['location'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Locations updated. <a target="_blank" href="%s">View Locations</a>', 'makerfaire'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'makerfaire'),
		3 => __('Custom field deleted.', 'makerfaire'),
		4 => __('Locations updated.', 'makerfaire'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Locations restored to revision from %s', 'makerfaire'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Locations published. <a href="%s">View Locations</a>', 'makerfaire'), esc_url( $permalink ) ),
		7 => __('Locations saved.', 'makerfaire'),
		8 => sprintf( __('Locations submitted. <a target="_blank" href="%s">Preview Locations</a>', 'makerfaire'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Locations scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Locations</a>', 'makerfaire'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Locations draft updated. <a target="_blank" href="%s">Preview Locations</a>', 'makerfaire'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'location_updated_messages' );


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function mf_add_custom_box() {

    $screens = array( 'mf_form', 'event-items' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'mf_sectionid',
            __( 'Location', 'makerfaire' ),
            'mf_inner_location_box',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'mf_add_custom_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function mf_inner_location_box( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'mf_inner_location_box', 'mf_inner_location_box_nonce' );

	$faire_location = get_post_meta( $post->ID, 'faire_location', true );

	$faires = get_the_terms( $post, 'faire' );

	$faire = array();

	if ( $faires ) {

		foreach ($faires as $da_faire ) {
			$faire[] = $da_faire->slug;
		}

		// WP_Query arguments
		$args = array (
			'post_type'	=> 'location',
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'faire',
					'field' 	=> 'slug',
					'terms' 	=> $faire,
				)
			)
		);

		// The Query
		$query = new WP_Query( $args );

		echo '<ul>';
		foreach ( $query->posts as $location ) {
			echo '<li><label class="checkbox">';
			if ( in_array( $location->ID, $faire_location ) ) {
				echo '<input type="checkbox" name="location[]" value="' . esc_attr( $location->ID ) .'" checked>';	
			} else {
				echo '<input type="checkbox" name="location[]" value="' . esc_attr( $location->ID ) .'">';
			}
			echo wp_kses_post( $location->post_title );
			echo '</label"></li>';

		}
		echo '</ul>';


	}
	echo '<p><a class="button" target="_blank" href="' . admin_url( 'post-new.php?post_type=location' ) . '">Add a New Location</a><p>';

}

/**
 * When the post is saved, saves our location data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function mf_save_postdata( $post_id ) {

	/*
	* We need to verify this came from the our screen and with proper authorization,
	* because save_post can be triggered at other times.
	*/

	// Check if our nonce is set.
	if ( ! isset( $_POST['mf_inner_location_box_nonce'] ) )
		return $post_id;

	$nonce = $_POST['mf_inner_location_box_nonce'];

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'mf_inner_location_box' ) )
		return $post_id;

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return $post_id;

	// Check the user's permissions.
  	if ( 'page' == $_POST['post_type'] ) {

    	if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;
  
  	} else {

    	if ( ! current_user_can( 'edit_post', $post_id ) )
		return $post_id;
	}

	/* OK, its safe for us to save the data now. */

	// Sanitize user input, and save to post meta.

	if ( isset( $_POST['location'] ) ) {
  		$locations = array();
		foreach ( $_POST['location'] as $location ) {
			$locations[] = absint( $location );
		}
		update_post_meta( $post_id, 'faire_location', $locations );
	} else {
		delete_post_meta( $post_id, 'faire_location' );
	}

}
add_action( 'save_post', 'mf_save_postdata' );