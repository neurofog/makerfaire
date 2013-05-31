<?php

function type_init() {
	register_taxonomy( 'type', array( 'mf_form' ), array(
		'hierarchical'            => false,
		'public'                  => true,
		'show_in_nav_menus'       => true,
		'show_ui'                 => true,
		'query_var'               => 'type',
		'rewrite'                 => true,
		'capabilities'            => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'                  => array(
			'name'                       =>  __( 'Types of Applications', 'makerfaire' ),
			'singular_name'              =>  __( 'Type', 'makerfaire' ),
			'search_items'               =>  __( 'Search types', 'makerfaire' ),
			'popular_items'              =>  __( 'Popular types', 'makerfaire' ),
			'all_items'                  =>  __( 'All types', 'makerfaire' ),
			'parent_item'                =>  __( 'Parent type', 'makerfaire' ),
			'parent_item_colon'          =>  __( 'Parent type:', 'makerfaire' ),
			'edit_item'                  =>  __( 'Edit type', 'makerfaire' ),
			'update_item'                =>  __( 'Update type', 'makerfaire' ),
			'add_new_item'               =>  __( 'New type', 'makerfaire' ),
			'new_item_name'              =>  __( 'New type', 'makerfaire' ),
			'separate_items_with_commas' =>  __( 'Types separated by comma', 'makerfaire' ),
			'add_or_remove_items'        =>  __( 'Add or remove types', 'makerfaire' ),
			'choose_from_most_used'      =>  __( 'Choose from the most used types', 'makerfaire' ),
			'menu_name'                  =>  __( 'Types', 'makerfaire' ),
		),
	) );

}
add_action( 'init', 'type_init' );
