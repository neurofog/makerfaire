<?php

function location_category_init() {
	register_taxonomy( 'location_category', array( 'mf_form' ), array(
		'hierarchical'            => false,
		'public'                  => true,
		'show_in_nav_menus'       => true,
		'show_ui'                 => false,
		'query_var'               => 'location_category',
		'rewrite'                 => true,
		'capabilities'            => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'                  => array(
			'name'                       =>  __( 'Location categories', 'makerfaire' ),
			'singular_name'              =>  __( 'Location category', 'makerfaire' ),
			'search_items'               =>  __( 'Search location categories', 'makerfaire' ),
			'popular_items'              =>  __( 'Popular location categories', 'makerfaire' ),
			'all_items'                  =>  __( 'All location categories', 'makerfaire' ),
			'parent_item'                =>  __( 'Parent location category', 'makerfaire' ),
			'parent_item_colon'          =>  __( 'Parent location category:', 'makerfaire' ),
			'edit_item'                  =>  __( 'Edit location category', 'makerfaire' ),
			'update_item'                =>  __( 'Update location category', 'makerfaire' ),
			'add_new_item'               =>  __( 'New location category', 'makerfaire' ),
			'new_item_name'              =>  __( 'New location category', 'makerfaire' ),
			'separate_items_with_commas' =>  __( 'Location categories separated by comma', 'makerfaire' ),
			'add_or_remove_items'        =>  __( 'Add or remove location categories', 'makerfaire' ),
			'choose_from_most_used'      =>  __( 'Choose from the most used location categories', 'makerfaire' ),
			'menu_name'                  =>  __( 'Location categories', 'makerfaire' ),
		),
	) );

}
add_action( 'init', 'location_category_init' );
