<?php

/**
 * Contains code and deserts for the mf_form post type (right now a bunch of stuff lives in plugins/maker-faire-forms/maker-faire-forms.php, until we can trash that directory)
 */


/**
 * Add meta boxes to the mf_form post type
 * @return void
 *
 * @since Makey
 */
function maker_faire_mf_form_add_meta_boxes() {

	// Ensure that users with a role of Editor or higher can review applications
	if ( current_user_can( 'delete_others_pages' ) )
		add_meta_box( 'mf-review-application', 'Review Application', 'maker_faire_mf_form_review_appliaction', 'mf_form', 'side', 'core' );
}
add_action( 'add_meta_boxes', 'maker_faire_mf_form_add_meta_boxes' );


function maker_faire_mf_form_review_appliaction( $post ) {
	// Get the current user
	$current_user = wp_get_current_user();

	// Return the saved review data from post meta
	$reviews = unserialize( get_post_meta( absint( $post->ID ), 'reviews', true ) ); ?>
	<div class="ratings my-rating">
		<div class="author-avatar"><?php echo get_avatar( absint( $current_user->ID ), '40', null, esc_attr( $current_user->display_name ) ); ?></div>
		<input type="radio" name="rating" id="star5" value="5" class="star"><label for="star5" title="5 Stars" class="label">5 Stars</label>
		<input type="radio" name="rating" id="star4" value="4" class="star"><label for="star4" title="4 Stars" class="label">4 Stars</label>
		<input type="radio" name="rating" id="star3" value="3" class="star"><label for="star3" title="3 Stars" class="label">3 Stars</label>
		<input type="radio" name="rating" id="star2" value="2" class="star"><label for="star2" title="2 Stars" class="label">2 Stars</label>
		<input type="radio" name="rating" id="star1" value="1" class="star"><label for="star1" title="1 Stars" class="label">1 Star</label>
		<input type="hidden" name="author-id" value="<?php echo absint( $current_user->ID ); ?>">
		<input type="hidden" name="post-id" value="<?php echo absint( get_the_ID() ); ?>">
		<?php wp_nonce_field( 'save_mf_form_rating', 'mf_form_rating' ); ?>
	</div>
	<hr>
	<?php if ( ! empty( $reviews ) && is_array( $reviews ) ) :
		foreach ( $reviews as $review ) : 
			$user_name = get_user_meta( absint( $review['user_id'] ), 'display_name', true ); ?>
			<div class="ratings rating-entree">
				<div class="author-name"><strong><?php echo esc_html( $user_name ); ?></strong> <?php echo date( 'M d, Y h:i A', $review['timestamp'] ); ?></div>
				<div class="author-avatar"><?php echo get_avatar( absint( $review['user_id'] ), '40', esc_attr( $user_name ) ); ?></div>
				<div class="ratings-wrapper">
					<?php for ( $i = 5; $i >= 1; $i-- ) : ?>
						<input type="radio" id="star<?php echo intval( $i ); ?>" value="<?php echo intval( $i ); ?>" class="star<?php echo ( $i === $review['rating'] ) ? ' selected': ''; ?>" disabled="disabled"><label for="star<?php echo intval( $i ); ?>" title="<?php echo intval( $i ); ?> Stars" class="label"><?php echo intval( $i ); ?> Stars</label>
					<?php endfor; ?>
				</div>
			</div>
		<?php endforeach;
	endif;
}


function maker_faire_mf_form_save_review() {
	// Verify our security checks
	if ( wp_verify_nonce( $_POST['nonce'], 'mf_form_rating' ) ) {
		echo json_encode( array(
			'status' => 'error',
			'message' => 'ERROR: Could not save due to invalid security precautions.'
		) );
		die();
	}

	// // Make sure the user has permission to do this..
	if ( ! current_user_can( 'delete_others_pages' ) ) {
		echo json_encode( array(
			'stats' => 'error',
			'message' => 'ERROR: User does not have privilegs to save.'
		) );
		die();
	}

	$data = $_POST['data'];

	// Save the info to post meta
	// update_post_meta( $post_id, $meta_key, $meta_value, $prev_value );
	die();
}
add_action( 'wp_ajax_mf_form_save_review', 'maker_faire_mf_form_save_review' );