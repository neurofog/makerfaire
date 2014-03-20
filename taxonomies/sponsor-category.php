<?php

function sponsor_category_init() {
	register_taxonomy( 'sponsor-category', array( 'sponsor' ), array(
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
			'name'                       => __( 'Sponsor Categories', 'makerfaire' ),
			'singular_name'              => _x( 'Sponsor Category', 'taxonomy general name', 'makerfaire' ),
			'search_items'               => __( 'Search Sponsor Categories', 'makerfaire' ),
			'popular_items'              => __( 'Popular Sponsor Categories', 'makerfaire' ),
			'all_items'                  => __( 'All Sponsor Categories', 'makerfaire' ),
			'parent_item'                => __( 'Parent Sponsor Category', 'makerfaire' ),
			'parent_item_colon'          => __( 'Parent Sponsor Category:', 'makerfaire' ),
			'edit_item'                  => __( 'Edit Sponsor Category', 'makerfaire' ),
			'update_item'                => __( 'Update Sponsor Category', 'makerfaire' ),
			'add_new_item'               => __( 'New Sponsor Category', 'makerfaire' ),
			'new_item_name'              => __( 'New Sponsor Category', 'makerfaire' ),
			'separate_items_with_commas' => __( 'Sponsor Categories separated by comma', 'makerfaire' ),
			'add_or_remove_items'        => __( 'Add or remove Sponsor Categories', 'makerfaire' ),
			'choose_from_most_used'      => __( 'Choose from the most used Sponsor Categories', 'makerfaire' ),
			'menu_name'                  => __( 'Sponsor Categories', 'makerfaire' ),
		),
	) );

}
add_action( 'init', 'sponsor_category_init' );

