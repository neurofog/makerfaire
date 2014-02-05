<?php

function new_york_locations_init() {
	register_taxonomy( 'new-york-locations', array( 'mf_form', 'event-items' ), array(
		'hierarchical'      => true,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'            => array(
			'name'                       => __( 'New York Locations', 'twentyfourteen' ),
			'singular_name'              => _x( 'New York Locations', 'taxonomy general name', 'twentyfourteen' ),
			'search_items'               => __( 'Search New York Locations', 'twentyfourteen' ),
			'popular_items'              => __( 'Popular New York Locations', 'twentyfourteen' ),
			'all_items'                  => __( 'All New York Locations', 'twentyfourteen' ),
			'parent_item'                => __( 'Parent New York Locations', 'twentyfourteen' ),
			'parent_item_colon'          => __( 'Parent New York Locations:', 'twentyfourteen' ),
			'edit_item'                  => __( 'Edit NewNYork Locations', 'twentyfourteen' ),
			'update_item'                => __( 'Update New York Locations', 'twentyfourteen' ),
			'add_new_item'               => __( 'New New York Locations', 'twentyfourteen' ),
			'new_item_name'              => __( 'New New York Locations', 'twentyfourteen' ),
			'separate_items_with_commas' => __( 'New York locations separated by comma', 'twentyfourteen' ),
			'add_or_remove_items'        => __( 'Add or remove New York locations', 'twentyfourteen' ),
			'choose_from_most_used'      => __( 'Choose from the most used New York locations', 'twentyfourteen' ),
			'menu_name'                  => __( 'New York Locations', 'twentyfourteen' ),
		),
	) );

}
add_action( 'init', 'new_york_locations_init' );
