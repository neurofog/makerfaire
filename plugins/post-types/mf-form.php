<?php

$labels = array( 
	'name'               => _x( 'Applications', 'post type general name' ),
	'singular_name'      => _x( 'Application', 'post type singular name' ),
	'add_new'            => _x( 'Add Application', 'mf_form' ),
	'add_new_item'       => __( 'Add New Application' ),
	'edit_item'          => __( 'Edit Application' ),
	'new_item'           => __( 'New Application' ),
	'all_items'          => __( 'All Applications' ),
	'view_item'          => __( 'View Application' ),
	'search_items'       => __( 'Search Applications' ),
	'not_found'          => __( 'No forms found' ),
	'not_found_in_trash' => __( 'No forms found in Trash' ),
	'parent_item_colon'  => '',
	'menu_name'          => __( 'Applications' )
);

$args = array(
	'labels'             => $labels,
	'public'             => true,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'show_in_menu'       => true,
	'query_var'          => true,
	'capability_type'    => 'post',
	'has_archive'        => false,
	'hierarchical'       => true,
	'menu_position'      => null,
	'supports'           => array( 'title', 'revisions', 'thumbnail' ),
	'taxonomies'		 => array( 'category', 'post_tag' ),
	'rewrite'            => array( 'slug' => 'makers', 'with_front' => false )
);

// Register the mf_form custom post type
register_post_type( 'mf_form', $args );


function mf_form_add_meta_boxes() {
	global $post;

	if ( empty( $post->post_content ) ) {
		if ( isset( $post->post_status ) && ( $post->post_status != 'auto-draft' ) ) {
			add_meta_box( 'mf_summary',   	  'Summary',   	  'mf_form_summary', 	   'mf_form', 'normal', 'default' );
			add_meta_box( 'mf_details',   	  'Details',   	  'mf_form_details', 	   'mf_form', 'normal', 'default' );
			add_meta_box( 'mf_logistics',     'Edit Form', 	  'mf_form_edit',    	   'mf_form', 'normal', 'default' );
			add_meta_box( 'mf_maker_contact', 'Contact Info', 'mf_form_maker_contact', 'mf_form', 'side', 	'default' );
			add_meta_box( 'mf_maker_info', 	  'Makers', 	  'mf_form_maker_info',    'mf_form', 'side', 	'default' );
		} else {
			add_meta_box( 'mf_form_type', 'Application Type',  'mf_form_type', 		'mf_form', 'normal', 'default' );
			add_meta_box( 'mf_exhibit',   'Exhibit Details',   'mf_form_exhibit', 	'mf_form', 'normal', 'default', array( 'type' => 'exhibit' ) );
			add_meta_box( 'mf_performer', 'Performer Details', 'mf_form_performer', 'mf_form', 'normal', 'default', array( 'type' => 'performer' ) );
			add_meta_box( 'mf_presenter', 'Presenter Details', 'mf_form_presenter', 'mf_form', 'normal', 'default', array( 'type' => 'presenter' ) );
		}

		add_meta_box( 'mf_save', 'Edit Application', 						'mf_form_save_app', 'mf_form', 'side', 	 'default' );
		add_meta_box( 'mf_logs', 'Status Changes &amp; Notifications Sent', 'mf_form_logs', 	'mf_form', 'normal', 'default' );
	}
}