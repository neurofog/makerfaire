<?php

/**
 * Blue Ribbons!
 *
 * A class that will make it easy to tag posts with blue ribbons.
 *
 */
class MF_Blue_Ribbons {

	/**
	 * THE CONSTRUCT.
	 *
	 * All Hooks and Filter here.
	 * Anything else that needs to run when the class is instantiated, place them here.
	 * Maybe you'll get a Dr. Pepper if you do.
	 *
	 * @return  void
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'load_resources' ), 30 );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
		add_shortcode( 'blue-ribbon', array( $this, 'blue_ribbon_list' ) );
	}

	/**
	 * Let's add all of our resouces to make our magic happen.
	 *
	 * @return  void
	 */
	public function load_resources() {

	}

	public function add_meta_box( $post_type ) {
		//limit meta box to certain post types
		$post_types = array( 'mf_form' );
		if ( in_array( $post_type, $post_types )) {
			add_meta_box( 'some_meta_box_name', __( 'Blue Ribbons', 'maker-faire' ), array( $this, 'render_meta_box_content' ), $post_type ,'advanced' ,'high' );
		}
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['mf_blue_ribbon_nonce'] ) )
			return $post_id;

		$nonce = $_POST['mf_blue_ribbon_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'mf_blue_ribbons_box' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
				//     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$faires = get_the_terms( intval( $_POST['post_ID'] ), 'faire' );

		foreach ( $faires as $faire ) {

			// Sanitize the user input.
			$blue = sanitize_text_field( $_POST[ $faire->term_id . '_faire_blue_ribbons_won' ] );
			$red  = sanitize_text_field( $_POST[ $faire->term_id . '_faire_red_ribbons_won' ] );

			// Update the meta field.
			update_post_meta( $post_id, $faire->term_id . '_faire_blue_ribbons_won', $blue );
			update_post_meta( $post_id, $faire->term_id . '_faire_red_ribbons_won', $red );

		}

		/* OK, its safe for us to save the data now. */


	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'mf_blue_ribbons_box', 'mf_blue_ribbon_nonce' );

		// $faires = get_terms( 'faire' );

		$faires = get_the_terms( $post, 'faire' );

		foreach ( $faires as $faire ) {
			echo '<h4>' . esc_html( $faire->name ) . '</h4>';
			// Use get_post_meta to retrieve an existing value from the database.
			$blue = get_post_meta( $post->ID, $faire->term_id . '_faire_blue_ribbons_won', true );
			$red  = get_post_meta( $post->ID, $faire->term_id . '_faire_red_ribbons_won', true );
			// Display the form, using the current value.
			echo '<div><label style="width:100px; display:inline-block;" for="' . esc_attr( $faire->term_id ) . '_faire_blue_ribbons_won">Blue Ribbons</label> <input type="text" id="' . esc_attr( $faire->term_id ) . '_faire_blue_ribbons_won" name="' . esc_attr( $faire->term_id ) . '_faire_blue_ribbons_won" value="' . esc_attr( $blue ) . '" size="25" /></div>';
			echo '<div><label style="width:100px; display:inline-block;" for="' . esc_attr( $faire->term_id ) . '_faire_red_ribbons_won">Red Ribbons</label> <input type="text" id="' . esc_attr( $faire->term_id ) . '_faire_red_ribbons_won" name="' . esc_attr( $faire->term_id ) . '_faire_red_ribbons_won" value="' . esc_attr( $red ) . '" size="25" /></div>';
		}
	}

	/**
	 * Shortcode for the blue ribbons page.
	 */
	public function blue_ribbon_list( $atts ) {
		$defaults = array(
			'faire'				=> 'maker-faire-bay-area-2014',
			'limit' 			=> 10,
			'posts_per_page'	=> 20,
			'color'				=> 'blue',
			);
		$atts = shortcode_atts( $defaults, $atts );

		$faire = get_term_by( 'slug', $atts['faire'], 'faire' );

		$limit = $atts['limit'];

		$output = '';

		for ( $i = $limit; $i > 0; $i-- ) {

			$ribbons = intval( $faire->term_id ) . '_faire_' . sanitize_title( $atts['color'] ) . '_ribbons_won';

			$the_query = wp_cache_get( $i . '_' . $ribbons . '_cache' );

			if ( false === $the_query ) {

				$args = array(
					'faire' 			=> sanitize_title( $atts['faire'] ),
					'meta_key'			=> $ribbons,
					'meta_value'		=> $i,
					'orderby' 			=> 'meta_value',
					'posts_per_page'	=> absint( $atts['posts_per_page'] ),
					);

				// The Query
				$the_query = new WP_Query( $args );

				wp_cache_set( $i . '_' . $ribbons . '_cache', $the_query );

			}

			// The Loop

			if ( $the_query->have_posts() ) {
				$output .= '<h3>' . intval( $i ) . ' ' . ucfirst( esc_html( $atts['color'] ) ) . ' Ribbons</h3>';
				$output .= '<ul>';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$ribbons = get_post_meta( get_the_id(), intval( $faire->term_id ) . '_faire_blue_ribbons_won', true );
					$output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
				}
				$output .= '</ul>';
			} else {
				// Nothing found here...
			}
			/* Restore original Post Data */
			wp_reset_postdata();
		}
		return $output;
	}

}

$ribbons = new MF_Blue_Ribbons();