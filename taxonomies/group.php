<?php

function mf_group_init() {
	register_taxonomy( 'group', array( 'mf_form' ), array(
		'hierarchical'            => true,
		'public'                  => true,
		'show_in_nav_menus'       => true,
		'show_ui'                 => true,
		'query_var'               => 'group',
		'rewrite'                 => true,
		'capabilities'            => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'                  => array(
			'name'                       =>  __( 'Groups', 'makerfaire' ),
			'singular_name'              =>  __( 'Group', 'makerfaire' ),
			'search_items'               =>  __( 'Search groups', 'makerfaire' ),
			'popular_items'              =>  __( 'Popular groups', 'makerfaire' ),
			'all_items'                  =>  __( 'All groups', 'makerfaire' ),
			'parent_item'                =>  __( 'Parent group', 'makerfaire' ),
			'parent_item_colon'          =>  __( 'Parent group:', 'makerfaire' ),
			'edit_item'                  =>  __( 'Edit group', 'makerfaire' ),
			'update_item'                =>  __( 'Update group', 'makerfaire' ),
			'add_new_item'               =>  __( 'New group', 'makerfaire' ),
			'new_item_name'              =>  __( 'New group', 'makerfaire' ),
			'separate_items_with_commas' =>  __( 'Groups separated by comma', 'makerfaire' ),
			'add_or_remove_items'        =>  __( 'Add or remove groups', 'makerfaire' ),
			'choose_from_most_used'      =>  __( 'Choose from the most used groups', 'makerfaire' ),
			'menu_name'                  =>  __( 'Groups', 'makerfaire' ),
		),
	) );

}
add_action( 'init', 'mf_group_init' );