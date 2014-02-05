<?php

function bay_area_locations_init() {
	register_taxonomy( 'bay-area-locations', array( 'mf_form', 'event-items' ), array(
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
			'name'                       => __( 'Bay Area Locations', 'twentyfourteen' ),
			'singular_name'              => _x( 'Bay Area Locations', 'taxonomy general name', 'twentyfourteen' ),
			'search_items'               => __( 'Search Bay Area Locations', 'twentyfourteen' ),
			'popular_items'              => __( 'Popular Bay Area Locations', 'twentyfourteen' ),
			'all_items'                  => __( 'All Bay Area Locations', 'twentyfourteen' ),
			'parent_item'                => __( 'Parent Bay Area Locations', 'twentyfourteen' ),
			'parent_item_colon'          => __( 'Parent Bay Area Locations:', 'twentyfourteen' ),
			'edit_item'                  => __( 'Edit Bay Area Locations', 'twentyfourteen' ),
			'update_item'                => __( 'Update Bay Area Locations', 'twentyfourteen' ),
			'add_new_item'               => __( 'New Bay Area Locations', 'twentyfourteen' ),
			'new_item_name'              => __( 'New Bay Area Locations', 'twentyfourteen' ),
			'separate_items_with_commas' => __( 'Bay Area locations separated by comma', 'twentyfourteen' ),
			'add_or_remove_items'        => __( 'Add or remove Bay Area locations', 'twentyfourteen' ),
			'choose_from_most_used'      => __( 'Choose from the most used Bay Area locations', 'twentyfourteen' ),
			'menu_name'                  => __( 'Bay Area Locations', 'twentyfourteen' ),
		),
	) );

}
add_action( 'init', 'bay_area_locations_init' );
