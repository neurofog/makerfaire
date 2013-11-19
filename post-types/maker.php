<?php

function maker_init() {
	register_post_type( 'maker', array(
		'hierarchical'        => false,
		'public'              => true,
		'show_in_nav_menus'   => true,
		'show_ui'             => true,
		'supports'            => array( 'title', 'editor' ),
		'has_archive'         => true,
		'query_var'           => true,
		'rewrite'             => true,
		'labels'              => array(
			'name'                => __( 'Makers', 'makerfaire' ),
			'singular_name'       => __( 'Maker', 'makerfaire' ),
			'add_new'             => __( 'Add new maker', 'makerfaire' ),
			'all_items'           => __( 'Makers', 'makerfaire' ),
			'add_new_item'        => __( 'Add new maker', 'makerfaire' ),
			'edit_item'           => __( 'Edit maker', 'makerfaire' ),
			'new_item'            => __( 'New maker', 'makerfaire' ),
			'view_item'           => __( 'View maker', 'makerfaire' ),
			'search_items'        => __( 'Search makers', 'makerfaire' ),
			'not_found'           => __( 'No makers found', 'makerfaire' ),
			'not_found_in_trash'  => __( 'No makers found in trash', 'makerfaire' ),
			'parent_item_colon'   => __( 'Parent maker', 'makerfaire' ),
			'menu_name'           => __( 'Makers', 'makerfaire' ),
		),
	) );

}
add_action( 'init', 'maker_init' );

function maker_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['maker'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Maker updated. <a target="_blank" href="%s">View maker</a>', 'makerfaire'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'makerfaire'),
		3 => __('Custom field deleted.', 'makerfaire'),
		4 => __('Maker updated.', 'makerfaire'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Maker restored to revision from %s', 'makerfaire'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Maker published. <a href="%s">View maker</a>', 'makerfaire'), esc_url( $permalink ) ),
		7 => __('Maker saved.', 'makerfaire'),
		8 => sprintf( __('Maker submitted. <a target="_blank" href="%s">Preview maker</a>', 'makerfaire'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Maker scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview maker</a>', 'makerfaire'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Maker draft updated. <a target="_blank" href="%s">Preview maker</a>', 'makerfaire'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'maker_updated_messages' );


/**
 * Add a custom meta box to display and handle custom user data
 * @return void
 *
 * @since  SPRINT NAME
 */
function maker_user_data() {
	add_meta_box( 'maker-user-data', __( 'User Data', 'makerfaire' ), 'maker_user_data_mb', 'maker' );
}
add_action( 'add_meta_boxes', 'maker_user_data' );


/**
 * Ourput our post meta
 * @param  [type] $post [description]
 * @return [type]       [description]
 */
function maker_user_data_mb( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'maker_user_data' );
	$user_data = get_post_custom( $post->ID );

	if ( ! empty( $user_data ) ) {
		foreach ( $user_data as $key => $value ) {
			$mfei = ( $key == 'mfei_record' ) ? ' disabled="disabled"' : '';

			// Hide the WP _edit_lock meta field
			if ( $key != '_edit_lock' ) {
				$output  = '<p><label for="' . esc_attr( $key ) . '" style="width:100px;display:inline-block">' . strtoupper( str_replace( '_', ' ', esc_html( $key ) ) ) . '</label>';
				$output .= '<input type="text" name="user_data[' . esc_attr( $key ) . ']" id="' . esc_attr( $key ) . '" value="' . ( ! empty( $value[0] ) ? sanitize_text_field( $value[0] ) : '' ) . '"' . $mfei . ' style="width:100%;" /></p>';

				echo $output;
			}
		}
	} else {
		echo '<p>No Data Set!</p>';
	}
}


function maker_save_user_data( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	if ( ! isset( $_POST['maker_user_data'] ) || ! wp_verify_nonce( $_POST['maker_user_data'], basename( __FILE__ ) ) )
		return;

	if ( ! current_user_can( 'edit_post', $post_id ) )
		return;

	if ( get_post_type() == 'maker' && isset( $_POST['user_data'] ) && ! empty( $_POST['user_data'] ) ) {
		foreach ( $_POST['user_data'] as $key => $value ) {
			update_post_meta( $post_id, sanitize_text_field( $key ), sanitize_text_field( $value ) );
		}
	}
}
add_action( 'save_post', 'maker_save_user_data' );
