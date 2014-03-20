<?php

function sponsor_init() {
	register_post_type( 'sponsor', array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
		'has_archive'       => false,
		'query_var'         => true,
		'rewrite'           => true,
		'labels'            => array(
			'name'                => __( 'Sponsors', 'makerfaire' ),
			'singular_name'       => __( 'Sponsors', 'makerfaire' ),
			'all_items'           => __( 'Sponsors', 'makerfaire' ),
			'new_item'            => __( 'New Sponsors', 'makerfaire' ),
			'add_new'             => __( 'Add New', 'makerfaire' ),
			'add_new_item'        => __( 'Add New Sponsors', 'makerfaire' ),
			'edit_item'           => __( 'Edit Sponsors', 'makerfaire' ),
			'view_item'           => __( 'View Sponsors', 'makerfaire' ),
			'search_items'        => __( 'Search Sponsors', 'makerfaire' ),
			'not_found'           => __( 'No Sponsors found', 'makerfaire' ),
			'not_found_in_trash'  => __( 'No Sponsors found in trash', 'makerfaire' ),
			'parent_item_colon'   => __( 'Parent Sponsors', 'makerfaire' ),
			'menu_name'           => __( 'Sponsors', 'makerfaire' ),
		),
	) );

}
add_action( 'init', 'sponsor_init' );

function sponsor_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['sponsor'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Sponsors updated. <a target="_blank" href="%s">View Sponsors</a>', 'makerfaire'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'makerfaire'),
		3 => __('Custom field deleted.', 'makerfaire'),
		4 => __('Sponsors updated.', 'makerfaire'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Sponsors restored to revision from %s', 'makerfaire'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Sponsors published. <a href="%s">View Sponsors</a>', 'makerfaire'), esc_url( $permalink ) ),
		7 => __('Sponsors saved.', 'makerfaire'),
		8 => sprintf( __('Sponsors submitted. <a target="_blank" href="%s">Preview Sponsors</a>', 'makerfaire'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Sponsors scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Sponsors</a>', 'makerfaire'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Sponsors draft updated. <a target="_blank" href="%s">Preview Sponsors</a>', 'makerfaire'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'sponsor_updated_messages' );


/**
 * Add meta boxes to the sponsor edit screen
 * @return void
 */
function mf_sponsor_add_meta_boxes() {
	add_meta_box( 'mf-sponsor-details', __( 'Sponsor Details', 'makerfaire' ), 'mf_sponsor_details_mb', 'sponsor' );
}
add_action( 'add_meta_boxes', 'mf_sponsor_add_meta_boxes' );


/**
 * Adds the details meta box.
 * @param  object $post The post object
 * @return string
 */
function mf_sponsor_details_mb( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'mf-sponsor-details' );
	$details = get_post_meta( absint( $post->ID ), 'sponsor-details', true );

	$output  = '<p><label for="sponsor-details" style="width:100px;display:inline-block">URL</label>';
	$output .= '<input type="text" name="sponsor-details" id="sponsor-details" value="' . ( ! empty( $details ) ? esc_url( $details ) : '' ) . '" style="width:100%;" /></p>';

	echo $output;
}


/**
 * Saves our meta boxes
 * @param  int $post_id The post ID
 * @return void
 */
function mf_save_sponsor_meta( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	if ( ! isset( $_POST['mf-sponsor-details'] ) || ! wp_verify_nonce( $_POST['mf-sponsor-details'], basename( __FILE__ ) ) )
		return;

	if ( ! current_user_can( 'edit_post', absint( $post_id ) ) )
		return;

	if ( get_post_type() == 'sponsor' && isset( $_POST['sponsor-details'] ) )
		update_post_meta( absint( $post_id ), 'sponsor-details', esc_url( $_POST['sponsor-details'] ) );
}
add_action( 'save_post', 'mf_save_sponsor_meta' );
