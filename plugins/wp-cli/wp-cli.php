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
			'posts_per_page'			=> 2000,
			'post_type'					=> 'mf_form',
			'post_status'				=> 'any',
			'faire'						=> $GLOBALS['current_faire'],

			// Prevent new posts from affecting the order
			'orderby' 					=> 'ID',
			'order' 					=> 'ASC',

			// Speed this up
			'no_found_rows' => true,
			'update_post_meta_cache'	=> false,
			'update_post_term_cache'	=> false,
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
						WP_CLI::warning( $cat );
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
						WP_CLI::warning( $tag );
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
	 * @synopsis [--faire=<faire>]
	 * 
	 */
	public function mf_create_makers( $args, $assoc_args ) {
		global $mfform;

		WP_CLI::line( 'Fetching Maker Faire Appliactions...' );

		$applications = $mfform->get_all_forms( NULL, 'all' );

		foreach( $applications as $app ) {
			$content = (array) json_decode( str_replace( "\'", "'", $app->post_content ) );

			// print_r($content[ $mfform->merge_fields( 'user_bio', $content['form_type'] ) ][0]);
			// Setup a new array based on our application ID.
			$app_type = $content['form_type'];
			$title = $content['name'];
			$content = ( is_array( $content[ $mfform->merge_fields( 'user_bio', $content['form_type'] ) ] ) ) ? $content[ $mfform->merge_fields( 'user_bio', $content['form_type'] ) ][0] : $content[ $mfform->merge_fields( 'user_bio', $content['form_type'] ) ];
			$email = $content['email'];
			$photo = $content[ $mfform->merge_fields( 'form_photo', $content['form_type'] ) ];
			$website = $content[ $mfform->merge_fields( 'project_website', $content['form_type'] ) ];
			$video = $content[ $mfform->merge_fields( 'project_video', $content['form_type'] ) ];

			foreach ( array( 'exhibit' => 'm_maker_', 'presenter' => 'presenter' ) as $type => $prefix ) {
				
				// Check if the form field contains more than one maker name and email.
				if ( $content['form_type'] == $type && is_array( $content[ $prefix . 'name' ] ) && is_array( $content[ $prefix . 'email' ] ) ) {

					// Loop through each maker and count them
					for ( $i = 1; $i < count( $content[ $prefix . 'name' ] ); $i++ ) {

						// Process their first and last name.
						$add_name = $content[ $prefix . 'name' ][ $i ];

						// Lets add their credentials to a new row
						$add_maker = str_replace( $title, $add_name, $title );
						$add_maker = str_replace( $email, $content[ $prefix . 'email'][ $i ], $add_maker );
					}
				}
			}


			WP_CLI::line( ' | APP TYPE: ' . $app_type );
			WP_CLI::line( ' | APP ID: ' . $app->ID );
			WP_CLI::line( ' | NAME: ' . $title );
			WP_CLI::line( ' | EMAIL: ' . $email );
			WP_CLI::line( ' | PHOTO: ' . $photo );
			WP_CLI::line( ' | WEBSITE: ' . $website );
			WP_CLI::line( ' | VIDEO: ' . $video );

			// Leave some evidence we are done with this application.
			WP_CLI::line( ' ----------------------------------------' );
			WP_CLI::line( '' );
		}

		// var_dump($makers);

		// $faire_slug = 'maker-faire-bay-area-2013';
		// $args = array(
		// 	'posts_per_page' => 2000,
		// 	'post_type' => 'mf_form',
		// 	'post_status' => 'accepted',

		// 	// Prevent new posts from affecting the order
		// 	'orderby' => 'ID',
		// 	'order' => 'ASC',

		// 	// Get our latest applications in the "faire" taxonomy
		// 	'tax_query' => array(
		// 		array(
		// 			'taxonomy' => 'faire',
		// 			'field' => 'slug',
		// 			'terms' => $faire_slug,
		// 		)
		// 	),

		// 	// Speed this up
		// 	'no_found_rows' => true,
		// 	'update_post_meta_cache' => false,
		// 	'update_post_term_cache' => false,
		// );

		// // Get the first set of posts
		// $query = new WP_Query( $args );

		// if ( isset( $query ) && ! empty( $query ) )
		// 	WP_CLI::line( 'Fetching Latest Maker Faire Appliactions...' );


		// // Do this.
		// while ( $query->have_posts() ) : $query->the_post();
		
		// 	global $post;
			
		// 	setup_postdata( $post );
		// 	$bad   = array( '&amp;', '&#8211;', '&#8230;', );
		// 	$good  = array( '&',	 '–',       '…',       );

		// 	// Get our applications
		// 	$app   = json_decode( $post->post_content );
		// 	$type  = ( isset( $app->form_type ) ) ? $app->form_type : 'null';

		// 	// Setup a array of messages
		// 	$messages = array(
		// 		'errors'  => array(),
		// 		'success' => array(),
		// 	);

		// 	// Use a switch to easily check for all the different application types
		// 	switch ( $type ) {

		// 		// If the application is an "exhibit", get the info we need.
		// 		case 'exhibit' :
		// 			$app_type = 'Exhibit';

		// 			// Check what kind of maker we have; a single, a list, or a group. Return their email.
		// 			switch ( $app->maker ) {

		// 				// A single maker
		// 				case 'One maker' :

		// 					$maker_type  = 'One Maker';
		// 					$maker_email = ( isset( $app->maker_email ) ) ? $app->maker_email : $app->email;
		// 					$maker_name  = ( isset( $app->maker_name ) )  ? $app->maker_name  : $app->name;
		// 					$maker_photo = ( isset( $app->maker_photo ) ) ? $app->maker_photo : $app->project_photo;
		// 					$maker_bio   = ( isset( $app->maker_bio ) )   ? $app->maker_bio   : $app->public_description;

		// 					break;

		// 				// A list of makers
		// 				case 'A list of makers' :

		// 					$maker_type  = 'A List of Makers';
		// 					$num_makers  = count( $app->m_maker_name );
		// 					$maker_email = array();
		// 					$maker_name  = array();
		// 					$maker_photo = array();
		// 					$maker_bio   = array();
							
		// 					// Let's loop through all of our makers in one shot shall we?
		// 					for ( $i = 0; $i < $num_makers; $i++ ) {
								
		// 						// Get our maker email. Some applicants have empty fields, default to the main contact
		// 						if ( $app->m_maker_email[ $i ] != '' ) {
		// 							$maker_email[] = $app->m_maker_email[ $i ];
		// 						} else {
		// 							$maker_email   = $app->email;
		// 						}

		// 						// Get our maker name. Some applicants have empty fields, default to the main contact
		// 						if ( $app->m_maker_name[ $i ] != '' ) {
		// 							$maker_name[] = $app->m_maker_name[ $i ];
		// 						} else {
		// 							$maker_name   = $app->name;
		// 						}

		// 						// Get our maker photo. Again, Some applicants have empty fields, default to the main contact
		// 						if ( $app->m_maker_photo[ $i ] != '' ) {
		// 							$maker_photo = $app->m_maker_photo[ $i ];
		// 						} else {
		// 							$maker_photo = $app->project_photo;
		// 						}

		// 						// Get our maker bio.
		// 						if ( $app->m_maker_bio[ $i ] != '' ) {
		// 							$maker_bio = $app->m_maker_bio[ $i ];
		// 						} else {
		// 							$maker_bio = $app->public_description;
		// 						}

		// 					}

		// 					break;

		// 				// A group of makers
		// 				case 'A group or association' :

		// 					$maker_type  = 'A Group or Association';
		// 					$maker_email = $app->email; // Since the group option doens't have a "Group Email" field, we'll just grab the main applicants emails
		// 					$maker_name  = $app->group_name;
		// 					$maker_bio   = $app->group_bio;

		// 					break;
		// 			}

		// 			// Get our makers website URL
		// 			if ( isset( $app->project_website ) && ! empty( $app->project_website ) )
		// 				$maker_website = $app->project_website;

		// 			// Get our makers video URL
		// 			if ( isset( $app->project_video ) && ! empty( $app->project_video ) )
		// 				$maker_video = $app->project_video; 

		// 			break;

		// 		// If the application is an "presenter", get the info we need.
		// 		case 'presenter' :
		// 			$app_type = 'Presenter';
					
		// 			// Check our presentation type; Presentation or Panel Presentation. Really, either presentation type holds the same data...
		// 			// We'll just create unique values for the $maker_type variable and process the rest as the same.
		// 			switch ( $app->presentation_type ) {

		// 				// Presentation 
		// 				case 'Presentation' :
		// 					$maker_type = 'Presentation';

		// 					break;
							
		// 				// Panel Presentation
		// 				case 'Panel Presentation' :
		// 					$maker_type = 'Panel Presentation';

		// 					break;

		// 			}

		// 			$num_makers  = count( $app->presenter_email );
		// 			$maker_email = array();
		// 			$maker_name  = array();
		// 			$maker_photo = array();
		// 			$maker_bio   = array();
					
		// 			// Let's loop through all of our makers in one shot shall we?
		// 			for ( $i = 0; $i < $num_makers; $i++ ) {
		// 				WP_CLI::line( $i );
						
		// 				// Get our maker email. Some applicants have empty fields, default to the main contact
		// 				if ( $app->presenter_email[ $i ] != '' ) {
		// 					$maker_email[] = $app->presenter_email[ $i ];
		// 				} else {
		// 					$maker_email   = $app->email;
		// 				}

		// 				// Get our maker name. Some applicants have empty fields, default to the main contact
		// 				if ( $app->presenter_name[ $i ] != '' ) {
		// 					$maker_name[] = $app->presenter_name[ $i ];
		// 				} else {
		// 					$maker_name   = $app->name;
		// 				}

		// 				// Get our maker photo. Again, Some applicants have empty fields, default to the main contact
		// 				if ( $app->presenter_photo[ $i ] != '' ) {
		// 					$maker_photo = $app->presenter_photo[ $i ];
		// 				} else {
		// 					$maker_photo = $app->presentation_photo;
		// 				}

		// 				// Get our maker bio.
		// 				if ( $app->presenter_bio[ $i ] != '' ) {
		// 					$maker_bio = $app->presenter_bio[ $i ];
		// 				} else {
		// 					$maker_bio = $app->public_description;
		// 				}

		// 			}

		// 			break;

		// 		// Lastly, we'll process the performer applications
		// 		case 'performer' :
		// 			$app_type = 'Performer';

		// 			$maker_type  = 'Performer';
		// 			$maker_email = ( isset( $app->performer_name ) ) 	 ? $app->performer_name 	: $app->name;
		// 			$maker_name  = ( isset( $app->name ) )				 ? $app->name  				: '';
		// 			$maker_photo = ( isset( $app->performer_photo ) )    ? $app->performer_photo 	: '';
		// 			$maker_bio   = ( isset( $app->public_description ) ) ? $app->public_description : '';

		// 			// Get our makers website URL
		// 			if ( isset( $app->performer_website ) && ! empty( $app->performer_website ) )
		// 				$maker_website = $app->performer_website;

		// 			// Get our makers video URL
		// 			if ( isset( $app->performer_video ) && ! empty( $app->performer_video ) )
		// 				$maker_video = $app->performer_video; 


		// 			break;


		// 	}

		// 	// str_replace( $bad, $good, $nothing );
		// 	// 
		// 	// Now that we have all of our delicious Maker info. Let's add them to our Maker Custom Post Type...
		// 	// First, we need to deal with the application with multiple makers. If an array exists, loop through them and add each as an individual post.
		// 	// Use email as our main key to pair and loop.
		// 	if ( is_array( $maker_email ) ) {

		// 		$num_makers = count( $maker_email );

		// 		// Loop through each maker
		// 		for ( $i = 0; $i < $num_makers; $i++ ) {

		// 			// Check if the maker already exists. Use wpcom_vip_get_page_by_title() as this is more performant and the non wpcom_vip_* function
		// 			$maker = wpcom_vip_get_page_by_title( $maker_name[ $i ], OBJECT, 'maker' );

		// 			if ( ! $maker ) {

		// 				// Create our post
		// 				$maker_post = array(
		// 					'post_title'    => esc_attr( $maker_name[ $i ] ),
		// 					'post_content'  => wp_kses_post( $maker_bio[ $i ] ),
		// 					'post_status'   => 'publish',
		// 					'post_type'		=> 'maker',
		// 					'tax_input'     => array(
		// 						'faire' => array(
		// 							$faire_slug
		// 						)
		// 					),
		// 				);

		// 				// Create our post and save it's info to a variable for use in adding post meta and error checking
		// 				$maker_id = wp_insert_post( $maker_post );

		// 				// Cheack if everything went well when creating our post
		// 				( is_wp_error( $maker_id ) ) ? $messages['errors'][] .= 'MAKER CREATION FAILED' : $messages['success'][] .= 'MAKER CREATED';

		// 				// Add the maker email
		// 				( update_post_meta( $maker_id, 'email', $maker_email[ $i ] ) )   ? $messages['success'][] .= 'Email Saved'    : $messages['errors'][] .= 'Email Not Saved';

		// 				// Add the maker photo
		// 				( update_post_meta( $maker_id, 'photo', $maker_photo[ $i ] ) )   ? $messages['success'][] .= 'Photo Saved'    : $messages['errors'][] .= 'Photo Not Saved';

		// 				// Add the maker website
		// 				( update_post_meta( $maker_id, 'website', $maker_website ) )     ? $messages['success'][] .= 'Website Saved'  : $messages['errors'][] .= 'Website Not Saved';

		// 				// Add the maker video
		// 				( update_post_meta( $maker_id, 'video', $maker_video ) )         ? $messages['success'][] .= 'Video Saved'    : $messages['errors'][] .= 'Video Not Saved';

		// 				// Add the MF Event ID
		// 				( add_post_meta( $maker_id, 'mfei_record', $post->ID ) )         ? $messages['success'][] .= 'Event ID Saved' : $messages['errors'][] .= 'Event ID Not Saved';

		// 				// Add the Faire Slug
		// 				( add_post_meta( $maker_id, 'maker_faire', $faire_slug, true ) ) ? $messages['success'][] .= 'MF Saved'       : $messages['errors'][] .= 'MF Not Saved';
		// 			} else {

		// 				// Since our post already exists, we should return it's ID so we can update
		// 				$maker_id = $maker->ID;

		// 				// Cheack if everything went well when creating our post
		// 				( is_wp_error( $maker_id ) ) ? $messages['errors'][] .= 'MAKER UPDATE FAILED' : $messages['success'][] .= 'MAKER UPDATED';

		// 				// Add the maker email
		// 				( update_post_meta( $maker_id, 'email', $maker_email[ $i ] ) )   ? $messages['success'][] .= 'Email Updated'    : $messages['errors'][] .= 'Email Not Updated';

		// 				// Add the maker photo
		// 				( update_post_meta( $maker_id, 'photo', $maker_photo[ $i ] ) )   ? $messages['success'][] .= 'Photo Updated'    : $messages['errors'][] .= 'Photo Not Updated';

		// 				// Add the maker website
		// 				( update_post_meta( $maker_id, 'website', $maker_website ) )     ? $messages['success'][] .= 'Website Updated'  : $messages['errors'][] .= 'Website Not Updated';

		// 				// Add the maker video
		// 				( update_post_meta( $maker_id, 'video', $maker_video ) )         ? $messages['success'][] .= 'Video Updated'    : $messages['errors'][] .= 'Video Not Updated';

		// 				// Add the MF Event ID
		// 				( add_post_meta( $maker_id, 'mfei_record', $post->ID ) )         ? $messages['success'][] .= 'Event ID Updated' : $messages['errors'][] .= 'Event ID Not Updated';

		// 				// Add the Faire Slug
		// 				( add_post_meta( $maker_id, 'maker_faire', $faire_slug, true ) ) ? $messages['success'][] .= 'MF Updated'       : $messages['errors'][] .= 'MF Not Updated';
		// 			}

		// 			// Show the output of what we just did.
		// 			if ( isset( $messages ) && is_array( $messages ) ) {
		// 				foreach ( $messages['errors'] as $errors ) {
		// 					WP_CLI::warning( $errors );
		// 				}

		// 				foreach ( $messages['success'] as $success ) {
		// 					WP_CLI::success( $success );
		// 				}
		// 			}
		// 			WP_CLI::line( ' | APP TYPE: ' . $app_type );
		// 			WP_CLI::line( ' | APP ID: ' . $post->ID );
		// 			WP_CLI::line( ' | MAKER ID: ' . $maker_id );
		// 			WP_CLI::line( ' | TYPE: ' . $maker_type );
		// 			WP_CLI::line( ' | NAME: ' . $maker_name[ $i ] );
		// 			WP_CLI::line( ' | EMAIL: ' . $maker_email[ $i ] );
		// 			WP_CLI::line( ' | PHOTO: ' . $maker_photo[ $i ] );
		// 			WP_CLI::line( ' | WEBSITE: ' . $maker_website );
		// 			WP_CLI::line( ' | VIDEO: ' . $maker_video );
		// 			WP_CLI::line( ' | FAIRE: ' . $faire_slug );

		// 			// Leave some evidence we are done with this application.
		// 			WP_CLI::line( ' ----------------------------------------' );
		// 			WP_CLI::line( '' );
		// 		}
		// 	} 

		// 	// Process applications that are NOT a group of makers.
		// 	else {

		// 		// Check if the maker already exists. Use wpcom_vip_get_page_by_title() as this is more performant and the non wpcom_vip_* function
		// 		$maker = wpcom_vip_get_page_by_title( $maker_name, OBJECT, 'maker' );

		// 		// Check if the maker post exists in the maker Custom Post Type, if not, create it.
		// 		if ( ! $maker ) {

		// 			// Create our post
		// 			$maker_post = array(
		// 				'post_title'    => $maker_name,
		// 				'post_content'  => $maker_bio,
		// 				'post_status'   => 'publish',
		// 				'post_type'		=> 'maker',
		// 				'tax_input'     => array(
		// 					'faire' => array(
		// 						$faire_slug
		// 					)
		// 				),
		// 			);

		// 			// Create our post and save it's info to a variable for use in adding post meta and error checking
		// 			$maker_id = wp_insert_post( $maker_post );

		// 			// Cheack if everything went well when creating our post
		// 			( is_wp_error( $maker_id ) ) ? $messages['errors'][] .= 'MAKER CREATION FAILED' : $messages['success'][] .= 'MAKER CREATED';

		// 			// Add the maker email
		// 			( update_post_meta( $maker_id, 'email', $maker_email ) )         ? $messages['success'][] .= 'Email Saved'    : $messages['errors'][] .= 'Email Not Saved';

		// 			// Add the maker photo
		// 			( update_post_meta( $maker_id, 'photo', $maker_photo ) )         ? $messages['success'][] .= 'Photo Saved'    : $messages['errors'][] .= 'Photo Not Saved';

		// 			// Add the maker website
		// 			( update_post_meta( $maker_id, 'website', $maker_website ) )     ? $messages['success'][] .= 'Website Saved'  : $messages['errors'][] .= 'Website Not Saved';

		// 			// Add the maker video
		// 			( update_post_meta( $maker_id, 'video', $maker_video ) )         ? $messages['success'][] .= 'Video Saved'    : $messages['errors'][] .= 'Video Not Saved';

		// 			// Add the MF Event ID
		// 			( add_post_meta( $maker_id, 'mfei_record', $post->ID ) )         ? $messages['success'][] .= 'Event ID Saved' : $messages['errors'][] .= 'Event ID Not Saved';

		// 			// Add the Faire Slug
		// 			( add_post_meta( $maker_id, 'maker_faire', $faire_slug, true ) ) ? $messages['success'][] .= 'MF Saved'       : $messages['errors'][] .= 'MF Not Saved';

		// 		} else {

		// 			// Since our post already exists, we should return it's ID so we can update
		// 			$maker_id = $maker->ID;

		// 			// Cheack if everything went well when creating our post
		// 			( is_wp_error( $maker_id ) ) ? $messages['errors'][] .= 'MAKER UPDATE FAILED' : $messages['success'][] .= 'MAKER UPDATED';

		// 			// Add the maker email
		// 			( update_post_meta( $maker_id, 'email', $maker_email ) )         ? $messages['success'][] .= 'Email Updated'    : $messages['errors'][] .= 'Email Not Updated';

		// 			// Add the maker photo
		// 			( update_post_meta( $maker_id, 'photo', $maker_photo ) )         ? $messages['success'][] .= 'Photo Updated'    : $messages['errors'][] .= 'Photo Not Updated';

		// 			// Add the maker website
		// 			( update_post_meta( $maker_id, 'website', $maker_website ) )     ? $messages['success'][] .= 'Website Updated'  : $messages['errors'][] .= 'Website Not Updated';

		// 			// Add the maker video
		// 			( update_post_meta( $maker_id, 'video', $maker_video ) )         ? $messages['success'][] .= 'Video Updated'    : $messages['errors'][] .= 'Video Not Updated';

		// 			// Add the MF Event ID
		// 			( add_post_meta( $maker_id, 'mfei_record', $post->ID ) )         ? $messages['success'][] .= 'Event ID Updated' : $messages['errors'][] .= 'Event ID Not Updated';

		// 			// Add the Faire Slug
		// 			( add_post_meta( $maker_id, 'maker_faire', $faire_slug, true ) ) ? $messages['success'][] .= 'MF Updated'       : $messages['errors'][] .= 'MF Not Updated';
					
		// 		}


		// 		// Now that we have either updated or created our maker posts, lets show the output of what we just did so we know what just happened.
		// 		if ( isset( $messages ) && is_array( $messages ) ) {
		// 			foreach ( $messages['errors'] as $errors ) {
		// 				WP_CLI::warning( $errors );
		// 			}

		// 			foreach ( $messages['success'] as $success ) {
		// 				WP_CLI::success( $success );
		// 			}
		// 		}
		// 		WP_CLI::line( ' | APP TYPE: ' . $app_type );
		// 		WP_CLI::line( ' | APP ID: ' . $post->ID );
		// 		WP_CLI::line( ' | MAKER ID: ' . $maker_id );
		// 		WP_CLI::line( ' | TYPE: ' . $maker_type );
		// 		WP_CLI::line( ' | NAME: ' . $maker_name );
		// 		WP_CLI::line( ' | EMAIL: ' . $maker_email );
		// 		WP_CLI::line( ' | PHOTO: ' . $maker_photo );
		// 		WP_CLI::line( ' | WEBSITE: ' . $maker_website );
		// 		WP_CLI::line( ' | VIDEO: ' . $maker_video );
		// 		WP_CLI::line( ' | FAIRE: ' . $faire_slug );

		// 		// Leave some evidence we are done with this application.
		// 		WP_CLI::line( ' ----------------------------------------' );
		// 		WP_CLI::line( '' );
		// 	}
		// endwhile;

		// WP_CLI::success( 'SHAZAM! Job is DONE. Get a beer! You deserve it big guy! ;)' );
	}


	/**
	 * Delete all of the Makers in the makers custom post type
	 *
	 * @subcommand mjolnir
	 * 
	 */
	public function mf_delete_makers( $args, $assoc_args ) {

		WP_CLI::line( ' 
                                                  zee.                      
        z**=.                                  .P"  $                       
         %   ^c                               z"   $                        
          b    %                             d    4"                        
          4     $            ....           4"    $                         
           F     L       .P"       "%.      $     $                         
           $     4     e"             "c    "     $                         
           $      F  z"                 *  4      $                         
           P      $ d                    3.$      $                         
           %      $d       ..eeeec..      *$      \'b                        
          d       $%   .e$*c d" ".z**$%.   $       $                        
          F       $  e" $   *F   $   ^F.db.$        b                       
         J        $d\" ^$   4b   $    $  3/$        *                       
         $        $*$   $c  P *P" * ."F  .$$         b                      
        4F        $ $c .EeP""      ^C$$..*F F        $                      
        J         $ $.*"-"*.      ."    "b$ F        \'r                     
        $         *"$   zc. ..  -"..-""\  $$%         $                     
        $          $      ..  L P  ebe    4$          $                     
        $          ^F   d%*$J%3 $ *$* "   4F          $                     
        *          4b       @   3 ^r      4$          $                     
        4          d$.          4         $3.        4F                     
         L         $$*.                  %$ $        J                      
         $        d $ $      -   ^.     P $c $       $                      
          r      z".$L L    .$%..*$    J  $P. *.    d                       
          "     z" P$$ ^%  z"      ".  L d$$"c "e  z%                       
           *  .P .*$$$  "*"   .$c        $$$$.b  ^$"                        
            *$  dL$$$$r ^4. ./" ""%..r"  $$$$$$J$e"                         
             *$b$$$$$$F        ""        $$$$$$$P                           
              ^$$$$$$$$                  $$$$$"                             
                 "*$$$$                  $"                                 
                      \'                 4                                   
                       *  $         .$  F                                   
                        % 4F       .$  "                                    
                          *$%     .$dr                                      
                            *.    .*                                        
                              ".." ' );

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