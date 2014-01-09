<?php

/**
 * Makers!
 *
 * A fun little class that will handle fetching data on our makers custom post type.
 *
 * When a user logs in, a Maker is created in the Maker Custom Post Type and this over time will be their user account
 * for Maker Faire and will contain all the data on their Maker Faire profile.
 *
 * @since  SPRINT_NAME
 */

class Make_Makers {

	public function search_for_makers( $guid = '', $maker_id = '', $name = '', $echo = '' ) {

		$query_params = array();

		// If we pass a Gigya ID, let's form the data we'll need for the query
		if ( ! empty( $guid ) ) {
			$user_hash = md5( sanitize_text_field( $guid ) );

			$makers = wp_cache_get( 'mf_user_' . $user_hash );

			$query_params['meta_key'] = 'guid';
			$query_params['meta_value'] = sanitize_text_field( $guid );
		}

		// If we pass a Maker ID, let's form the data we'll need for the query
		if ( ! empty( $maker_id ) ) {
			$query_params['page_id'] = absint( $maker_id );
		}

		// If we pass a Maker name, let's form the data we'll need for the query
		if ( ! empty( $name ) ) {
			$query_params['name'] = sanitize_title_with_dashes( $name );
		}

		// Since we actually save a cache via guid, we need to search for the maker if only a name is passed
		if ( isset( $makers ) && ! empty( $makers ) ) {

			// Get the makers based on data passed through.
			$makers = new WP_Query( $query_params );
		}
	}
}

// Make_Makers::search_for_makers('asdfds', '234', 'Cole Geissinger');