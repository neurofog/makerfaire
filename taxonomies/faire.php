<?php

function faire_init() {
	register_taxonomy( 'faire', array( 'mf_form', 'event-items', 'maker' ), array(
		'hierarchical'            => true,
		'public'                  => true,
		'show_in_nav_menus'       => true,
		'show_ui'                 => true,
		'query_var'               => 'faire',
		'rewrite'                 => true,
		'capabilities'            => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'                  => array(
			'name'                       =>  __( 'Faires', 'maker_faire' ),
			'singular_name'              =>  __( 'Faire', 'maker_faire' ),
			'search_items'               =>  __( 'Search faires', 'maker_faire' ),
			'popular_items'              =>  __( 'Popular faires', 'maker_faire' ),
			'all_items'                  =>  __( 'All faires', 'maker_faire' ),
			'parent_item'                =>  __( 'Parent faire', 'maker_faire' ),
			'parent_item_colon'          =>  __( 'Parent faire:', 'maker_faire' ),
			'edit_item'                  =>  __( 'Edit faire', 'maker_faire' ),
			'update_item'                =>  __( 'Update faire', 'maker_faire' ),
			'add_new_item'               =>  __( 'New faire', 'maker_faire' ),
			'new_item_name'              =>  __( 'New faire', 'maker_faire' ),
			'separate_items_with_commas' =>  __( 'Faires separated by comma', 'maker_faire' ),
			'add_or_remove_items'        =>  __( 'Add or remove faires', 'maker_faire' ),
			'choose_from_most_used'      =>  __( 'Choose from the most used faires', 'maker_faire' ),
			'menu_name'                  =>  __( 'Faires', 'maker_faire' ),
		),
	) );

}
add_action( 'init', 'faire_init' );