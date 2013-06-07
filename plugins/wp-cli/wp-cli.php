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
			'post_status' => 'any',

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
			setup_postdata($post);
			WP_CLI::line( get_the_title() );
			$json_post = json_decode( str_replace( "\'", "'", get_the_content() ) );

			if ( isset( $json_post->cats ) ) {
				$catsobj = $json_post->cats;
			} else {
				$catsobj = null;
			}
			$cats = null;
			if ( is_array( $catsobj ) ) {
				$cats = $catsobj;
			} else {
				$cats = explode(',', $catsobj);
			}
			if ( !empty( $cats[0] ) ) {
				WP_CLI::line('Categories:');
				foreach ($cats as $cat) {
					$result = wp_set_object_terms( get_the_ID(), $cat, 'category', true );
					if ( !empty( $result ) ) {
						WP_CLI::success( $cat );
					} else {
						WP_CLI::error( $cat );
					}
				}
			}
			if ( isset( $json_post->tags ) ) {
				$tagsobj = $json_post->tags;
			} else {
				$tagsobj = null;
			}
			$tags = null;
			if ( is_array( $tagsobj ) ) {
				$tags = $tagsobj;
			} else {
				$tags = explode(',', $tagsobj);
			}
			if ( !empty( $tags[0] ) ) {
				WP_CLI::line('Tags:');
				foreach ($tags as $tag) {
					$result = wp_set_object_terms( get_the_ID(), $tag, 'post_tag', true );
					if ( !empty( $result ) ) {
						WP_CLI::success( $tag );
					} else {
						WP_CLI::error( $tag );
					}
				}
			}
			

		WP_CLI::line( '' );
		endwhile;
		WP_CLI::success( "Boom!" );

	}

	/**
	 * Inserts places from Make: Projects
	 *
	 * @subcommand places
	 * 
	 */
	public function mf_location_import() {
		include_once 'placement.php';
		foreach ($placement as $place) {
			WP_CLI::line();
			WP_CLI::line( get_the_title( $place['CS_ID'] ) );
			$del = delete_post_meta( $place['CS_ID'], 'booth' );
			$pid = add_post_meta( $place['CS_ID'], 'booth', $place['Location'] );
			if ( !$del ) {
				WP_CLI::warning( "Nothing to delete" );
			} else {
				WP_CLI::success( 'Deleted ' . $place['CS_ID'] );
			}
			if ( $pid == null ) {
				WP_CLI::warning( "Booth number isn't set, unfortunately..." );
			} else {
				WP_CLI::success( 'Inserted booth number: ' . $place['Location'] );
			}
			if ( !empty( $place['New Subarea'] ) ) {
				$result = wp_set_object_terms( $place['CS_ID'], $place['New Subarea'], 'location', false );
				if ( !empty( $result ) ) {
					WP_CLI::success( 'Subarea: ' . $place['New Subarea'] );
				} else {
					WP_CLI::warning( $place['New Subarea'] );
				}
			} else {
				$result = wp_set_object_terms( $place['CS_ID'], $place['Area'], 'location', false );
				if ( !empty( $result ) ) {
					WP_CLI::success( 'Area was used, instead of subarea: ' . $place['Area'] );
				} else {
					WP_CLI::warning( $place['Area'] );
				}
			}
		}
	}


	/**
	 * Add makers to the maker custom post type from mf_form
	 *
	 * @subcommand makers
	 * 
	 */
	public function mf_create_makers( $args, $assoc_args ) {

		$faire_slug = 'maker-faire-bay-area-2013';
		$args = array(
			'posts_per_page' => 2000,
			'post_type' => 'mf_form',
			'post_status' => 'accepted',

			// Prevent new posts from affecting the order
			'orderby' => 'ID',
			'order' => 'ASC',

			// Get our latest applications in the "faire" taxonomy
			'tax_query' => array(
				array(
					'taxonomy' => 'faire',
					'field' => 'slug',
					'terms' => $faire_slug,
				)
			),

			// Speed this up
			'no_found_rows' => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		);

		// Get the first set of posts
		$query = new WP_Query( $args );

		if ( isset( $query ) && ! empty( $query ) )
			WP_CLI::line( 'Fetching Latest Maker Faire Appliactions...' );


		// Do this.
		while ( $query->have_posts() ) : $query->the_post();
		
			global $post;
			
			setup_postdata( $post );
		
			// Get our applications
			$app   = json_decode( html_entity_decode( $post->post_content ) );
			$type  = ( isset( $app->form_type ) ) ? $app->form_type : 'null';

			// Use a switch to easily check for all the different application types
			switch ( $type ) {

				// If the application is an "exhibit", get the info we need.
				case 'exhibit' :

					// Check what kind of maker we have; a single, a list, or a group. Return their email.
					switch ( $app->maker ) {

						// A single maker
						case 'One maker' :

							$maker_type  = 'One Maker';
							$maker_email = ( isset( $app->maker_email ) ) ? $app->maker_email : $app->email;
							$maker_name  = ( isset( $app->maker_name ) ) ? $app->maker_name : $app->name;
							$maker_photo = ( isset( $app->maker_photo ) ) ? $app->maker_photo: $app->project_photo;

							break;

						// A list of makers
						case 'A list of makers' :

							$maker_type  = 'A List of Makers';
							$num_makers  = count( $app->m_maker_name );
							$maker_email = array();
							$maker_name  = array();
							$maker_photo = array();
							
							// Let's loop through all of our makers in one shot shall we?
							for ( $i = 0; $i < $num_makers; $i++ ) {
								
								// Get our maker email. Some applicants have empty fields, default to the main contact
								if ( $app->m_maker_email[ $i ] != '' ) {
									$maker_email[] = $app->m_maker_email[ $i ];
								} else {
									$maker_email = $app->email;
								}

								// Get our maker name. Some applicants have empty fields, default to the main contact
								if ( $app->m_maker_name[ $i ] != '' ) {
									$maker_name[] = $app->m_maker_name[ $i ];
								} else {
									$maker_name = $app->name;
								}

								// Get our maker photo. Again, Some applicants have empty fields, default to the main contact
								if ( $app->m_maker_photo[ $i ] != '' ) {
									$maker_photo = $app->m_maker_photo[ $i ];
								} else {
									$maker_photo = $app->project_photo;
								}

							}

							break;

						// A group of makers
						case 'A group or association' :

							$maker_type  = 'A Group or Association';
							$maker_email = $app->email; // Since the group option doens't have a "Group Email" field, we'll just grab the main applicants emails
							$maker_name  = $app->group_name;

							break;
					}

					// Get our makers website URL
					if ( isset( $app->project_website ) && ! empty( $app->project_website ) )
						$maker_website = $app->project_website;

					// Get our makers video URL
					if ( isset( $app->project_video ) && ! empty( $app->project_video ) )
						$maker_video = $app->project_video; 

					break;

			}


			// Now that we have all of our delicious Maker info. Let's add them to our Maker Custom Post Type...
			// First, we need to deal with the application with multiple makers. If an array exists, loop through them and add each as an individual post.
			// Use email as our main key to pair and loop.
			if ( is_array( $maker_email ) ) {

				$num_makers = count( $maker_email );

				// Loop through each maker
				for ( $i = 0; $i < $num_makers; $i++ ) {

					// Check if the maker already exists.
					$maker = get_page_by_title( $maker_name[ $i ], OBJECT, 'maker' );

					if ( ! $maker ) {
						WP_CLI::success( 'User created' );
					} else {
						WP_CLI::success( 'User updated!' );
					}

					// Show the output of what we just did.
					WP_CLI::line( ' | Exhibit' );
					WP_CLI::line( ' | ID: ' . $post->ID );
					WP_CLI::line( ' | TYPE: ' . $maker_type );
					WP_CLI::line( ' | NAME: ' . $maker_name[ $i ] );
					WP_CLI::line( ' | EMAIL: ' . $maker_email[ $i ] );
					WP_CLI::line( ' | PHOTO: ' . $maker_photo[ $i ] );
					WP_CLI::line( ' | WEBSITE: ' . $maker_website );
					WP_CLI::line( ' | VIDEO: ' . $maker_video );
					WP_CLI::line( ' | FAIRE: ' . $faire_slug );

					// Leave some evidence we are done with this application.
					WP_CLI::line( ' ----------------------------------------' );
				}

			} else {

				// Check if the maker already exists.
				$maker = get_page_by_title( $maker_name, OBJECT, 'maker' );

				if ( ! $maker ) {
					WP_CLI::success( 'User created' );
				} else {
					WP_CLI::success( 'User updated!' );
				}

				// Show the output of what we just did.
				WP_CLI::line( ' | Exhibit' );
				WP_CLI::line( ' | ID: ' . $post->ID );
				WP_CLI::line( ' | TYPE: ' . $maker_type );
				WP_CLI::line( ' | NAME: ' . $maker_name );
				WP_CLI::line( ' | EMAIL: ' . $email );
				WP_CLI::line( ' | PHOTO: ' . $maker_photo );
				WP_CLI::line( ' | WEBSITE: ' . $maker_website );
				WP_CLI::line( ' | VIDEO: ' . $maker_video );
				WP_CLI::line( ' | FAIRE: ' . $faire_slug );

				// Leave some evidence we are done with this application.
				WP_CLI::line( ' ----------------------------------------' );
			}
		endwhile;

		WP_CLI::success( 'SHAZAM! Job is DONE. Get a beer! You deserve it big guy! ;)' );
	}

	/**
	 * Delete all of the Makers in the makers custom post type
	 *
	 * @subcommand mjolnir
	 * 
	 */
	public function mf_delete_makers( $args, $assoc_args ) {

		$args = array(
			'posts_per_page' => 2000,
			'post_type' => 'maker',
			'post_status' => 'any',

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
		
		$title = get_the_title( get_the_ID() );

		$del = wp_delete_post( get_the_ID() );

		if ( $del ) {
			WP_CLI::success( 'Deleted ' . $title );
		} else {
			WP_CLI::warning( 'Failed to delete ' . $title );
		}
		endwhile;
	}

	/**
	 * Assign all of the Maker Faire Applications to the Bay Area 2013 Faire
	 *
	 * @subcommand faires
	 * 
	 */
	public function mf_assign_faire( $args, $assoc_args ) {

		$args = array(
			'posts_per_page' => 2000,
			'post_type' => 'mf_form',
			'post_status' => 'any',

			// Speed this up
			'no_found_rows' => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		);

		// Get the first set of posts
		$query = new WP_Query( $args );

		while ( $query->have_posts() ) : $query->the_post();
		
		$title = get_the_title( get_the_ID() );

		$faire = wp_set_object_terms( get_the_ID(), 'Maker Faire Bay Area 2013', 'faire' );

		if ( is_array( $faire ) ) {
			WP_CLI::success( 'Updated ' . $title );
		} elseif (is_wp_error( $faire )) {
			WP_CLI::warning( 'Wasn\'t able to update ' . $title );
		}
		endwhile;
	}

	/**
	 * Assign the type of form to a taxonomy
	 *
	 * @subcommand types
	 * 
	 */
	public function mf_application_type() {

		$args = array(
			'posts_per_page' => 2000,
			'post_type' => 'mf_form',
			'post_status' => 'any',

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
			setup_postdata($post);
			//WP_CLI::line( get_the_title() );
			$json = json_decode( str_replace( array("\'", "u03a9", "u2019"), array("'", '&#8486;', '&rsquo;'), get_the_content() ) );
			//WP_CLI::line( $json->form_type );
			$type = wp_set_object_terms( get_the_ID(), $json->form_type, 'type' );
			if ( is_array( $type ) ) {
				WP_CLI::success( 'Updated ' . get_the_title() );
			} elseif (is_wp_error( $type )) {
				WP_CLI::warning( 'Wasn\'t able to update ' . get_the_title() );
			}
		endwhile;
		WP_CLI::success( "Boom!" );
		
	}

}