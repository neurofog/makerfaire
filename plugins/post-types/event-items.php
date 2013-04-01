<?php 
function event_items_init() {
	register_post_type( 'event-items', array(
		'hierarchical'        => false,
		'public'              => true,
		'show_in_nav_menus'   => true,
		'show_ui'             => true,
		'supports'            => array( 'thumbnail' ),
		'has_archive'         => true,
		'query_var'           => true,
		'rewrite'             => true,
		'labels'              => array(
			'name'                => __( 'Event Items', 'makerfaire' ),
			'singular_name'       => __( 'Event Items', 'makerfaire' ),
			'add_new'             => __( 'Add a new event item', 'makerfaire' ),
			'all_items'           => __( 'Event items', 'makerfaire' ),
			'add_new_item'        => __( 'Add a new event item', 'makerfaire' ),
			'edit_item'           => __( 'Edit event items', 'makerfaire' ),
			'new_item'            => __( 'New event item', 'makerfaire' ),
			'view_item'           => __( 'View event items', 'makerfaire' ),
			'search_items'        => __( 'Search event items', 'makerfaire' ),
			'not_found'           => __( 'No event items found', 'makerfaire' ),
			'not_found_in_trash'  => __( 'No event items found in trash', 'makerfaire' ),
			'parent_item_colon'   => __( 'Parent event items', 'makerfaire' ),
			'menu_name'           => __( 'Event items', 'makerfaire' ),
		),
	) );

}
add_action( 'init', 'event_items_init' );

function event_items_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['event-items'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Event items updated. <a target="_blank" href="%s">View event items</a>', 'makerfaire'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'makerfaire'),
		3 => __('Custom field deleted.', 'makerfaire'),
		4 => __('Event items updated.', 'makerfaire'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Event items restored to revision from %s', 'makerfaire'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Event items published. <a href="%s">View event items</a>', 'makerfaire'), esc_url( $permalink ) ),
		7 => __('Event items saved.', 'makerfaire'),
		8 => sprintf( __('Event items submitted. <a target="_blank" href="%s">Preview event items</a>', 'makerfaire'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Event items scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event items</a>', 'makerfaire'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Event items draft updated. <a target="_blank" href="%s">Preview event items</a>', 'makerfaire'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'event_items_updated_messages' );



function makerfaire_setup_easy_cf() {
	global $easy_cf;

	$easy_cf = new Easy_CF( array(
		'advanced_testgroup' => array (
			'fields' => array(
				'Start_Time'	=> array(
					'label'				=> 'Start Time',
					'input_class'		=> 'start-time',
				),
				'End_Time'	=> array(
					'label'				=> 'End Time',
					'input_class'		=> 'end-time',
				),
				'Record_Number'	=> array(
					'label'				=> 'Record Number',
				),
			),
		'title'		=> 'Time Slot',
		'context'	=> 'advanced',
		'pages'		=> array( 'event-items' ),
		),
	) );
}
add_action( 'init', 'makerfaire_setup_easy_cf' );

add_filter('manage_event-items_posts_columns', 'makerfaire_add_column', 10);  
add_action('manage_event-items_posts_custom_column', 'makerfaire_add_name_to_column', 10, 2);  
  

function makerfaire_add_column($defaults) {  
	$defaults['Event Item'] = 'Event Item';
	$defaults['Start Time'] = 'Start Time';
	$defaults['End Time'] = 'End Time';
	$defaults['Location'] = 'Location';
	return $defaults;  
}  
function makerfaire_add_name_to_column($column_name, $post_ID) {  
	if ($column_name == 'Event Item') {  
		$id = get_post_meta( get_the_ID(), 'Record_Number' );
		edit_post_link( get_the_title( $id[0] ), '', '', $id[0] );
	}
	if ($column_name == 'Start Time') {  
		$id = get_post_meta( get_the_ID(), 'Start_Time' );
		echo $id[0];
	}
	if ($column_name == 'End Time') {  
		$id = get_post_meta( get_the_ID(), 'End_Time' );
		echo $id[0];
	}
	if ($column_name == 'Location') {  
		$locs = get_the_terms( $post_ID, 'location' );
		foreach ($locs as $loc) {
			echo $loc->name;
		}
	}
}