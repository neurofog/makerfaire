<?php

function location_init() {
	register_taxonomy( 'location', array( 'mf_form', 'event-items' ), array(
		'hierarchical'            => true,
		'public'                  => true,
		'show_in_nav_menus'       => true,
		'show_ui'                 => true,
		'query_var'               => 'location',
		'rewrite'                 => true,
		'capabilities'            => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'                  => array(
			'name'                       =>  __( 'Locations', 'makerfaire' ),
			'singular_name'              =>  __( 'Location', 'makerfaire' ),
			'search_items'               =>  __( 'Search locations', 'makerfaire' ),
			'popular_items'              =>  __( 'Popular locations', 'makerfaire' ),
			'all_items'                  =>  __( 'All locations', 'makerfaire' ),
			'parent_item'                =>  __( 'Parent location', 'makerfaire' ),
			'parent_item_colon'          =>  __( 'Parent location:', 'makerfaire' ),
			'edit_item'                  =>  __( 'Edit location', 'makerfaire' ),
			'update_item'                =>  __( 'Update location', 'makerfaire' ),
			'add_new_item'               =>  __( 'New location', 'makerfaire' ),
			'new_item_name'              =>  __( 'New location', 'makerfaire' ),
			'separate_items_with_commas' =>  __( 'Locations separated by comma', 'makerfaire' ),
			'add_or_remove_items'        =>  __( 'Add or remove locations', 'makerfaire' ),
			'choose_from_most_used'      =>  __( 'Choose from the most used locations', 'makerfaire' ),
			'menu_name'                  =>  __( 'Locations', 'makerfaire' ),
		),
	) );

}
add_action( 'init', 'location_init' );
