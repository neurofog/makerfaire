<?php
WP_CLI::add_command( 'makerfaire', 'MAKE_CLI' );

class MAKE_CLI extends WP_CLI_Command {

	/**
	 * Add tags and cats to posts.
	 * Read the category and tag out of the JSON array, and then assign to the post.
	 *
	 * @subcommand cats
	 * 
	 */
	public function copy_category_to_tag( $args, $assoc_args ) {

		$args = array(
			'posts_per_page' => 1000,
			'post_type' => 'mf_form',

			// Prevent new posts from affecting the order
			'orderby' => 'ID',
			'order' => 'ASC',

			// Speed this up
			'no_found_rows' => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		);

		// Get the first set of posts
		$query = new WP_Query( $args );

		while ( $query->have_posts() ) : $query->the_post();
		global $post;
			WP_CLI::line( get_the_title() );
			$json_post = json_decode( get_the_content() );
			if (!empty($json_post->cats)) {
				WP_CLI::line('Categories:');
				$cats = explode( ',', $json_post->cats );
				foreach ($cats as $cat) {
					$result = wp_set_object_terms( get_the_ID(), $cat, 'category', true );
					if ( !empty( $result ) ) {
						WP_CLI::line( $cat );
					} else {
						WP_CLI::error( $cat );
					}
				}
			}
			if (!empty($json_post->tags)) {
				WP_CLI::line('Tags:');
				$tags = explode( ',', $json_post->tags );
				foreach ($tags as $tag) {
					WP_CLI::line( $tag );
					$result = wp_set_object_terms( get_the_ID(), $tag, 'post_tag', true );
					if ( !empty( $result ) ) {
						WP_CLI::line( $tag );
					} else {
						WP_CLI::error( $tag );
					}
				}
			}
		WP_CLI::line( '' );
		endwhile;
		WP_CLI::success( "Boom!" );

	}
}