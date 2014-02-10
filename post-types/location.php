<?php

function location_init() {
	register_post_type( 'location', array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'supports'          => array( 'title', 'editor' ),
		'has_archive'       => true,
		'query_var'         => true,
		'rewrite'           => true,
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
add_action( 'init', 'location_init' );

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
