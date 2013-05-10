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
	 * Add tags and cats to posts.
	 * Read the category and tag out of the JSON array, and then assign to the post.
	 *
	 * @subcommand makers
	 * 
	 */
	public function mf_create_makers( $args, $assoc_args ) {

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
			$exhibit = json_decode( html_entity_decode( str_replace( array("\'", "u03a9"), array("'", '&#8486;'), $post->post_content ), ENT_COMPAT, 'utf-8' ) );
			
			$type = (isset($exhibit->form_type)) ? $exhibit->form_type : 'null';

			// /$type = $exhibit->form_type;

			if ($type == 'exhibit') {

				if ( $exhibit->maker == 'A group or association' ) {

					$the_title = $exhibit->group_name ? $exhibit->group_name : $exhibit->name;

					$title = htmlspecialchars( $the_title );

					$maker = get_page_by_title( $title, OBJECT, 'maker' );

					echo ( isset( $maker->post_title ) ) ? WP_CLI::success( 'Found: ' . $maker->post_title ) : WP_CLI::warning( 'no title...' ) ;

					if ( !$maker ) {
						// Setup post object...
						$content = ($exhibit->group_bio ? htmlspecialchars_decode( $exhibit->group_bio ) : null);
						$my_post = array(
							'post_title'    => $title,
							'post_content'  => $content,
							'post_status'   => 'publish',
							'post_type'		=> 'maker'
						); 
						$pid = wp_insert_post( $my_post );
						if ( is_wp_error( $pid ) ) {
							WP_CLI::warning( $title );
						} else {
							WP_CLI::success( $title );
						}
						$video = ( $exhibit->project_video ) ? $exhibit->project_video  : null;
						if ( !empty( $video ) ) {
							$vid = update_post_meta( $pid, 'video', $video );
							if ( !empty( $vid ) ) {
								WP_CLI::success( 'Video = ' .  $video );
							} else {
								WP_CLI::warning( 'Video = ' . $video );
							}
						}
						$post_id = get_the_ID();
						if ( !empty( $post_id ) ) {
							$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id, true );
							if ( !empty( $mfei_record ) ) {
								WP_CLI::success( 'mfei_record = ' . $post_id );
							} else {
								WP_CLI::warning( 'mfei_record = ' . $post_id );
							}
						}
						$photo_url = ( $exhibit->group_photo ) ? $exhibit->group_photo : null;
						if ( !empty( $photo_url ) ) {
							$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );
							if ( !empty( $photo ) ) {
								WP_CLI::success( 'Photo = ' . $photo_url );
							} else {
								WP_CLI::warning( 'Photo = ' . $photo_url );
							}
						}
						$mf = ( $exhibit->maker_faire ) ? $exhibit->maker_faire : null;
						if ( !empty( $mf ) ) {
							$faire = add_post_meta( $pid, 'maker_faire', $mf, true );
							if ( !empty( $photo ) ) {
								WP_CLI::success( 'Maker Faire = ' . $mf );
							} else {
								WP_CLI::warning( 'Maker Faire = ' . $mf );
							}
						}
					} else {
						$pid = $maker->ID;
						$video = ( $exhibit->project_video ) ? $exhibit->project_video  : null;
						if ( !empty( $video ) ) {
							$vid = update_post_meta( $pid, 'video', $video );
							if ( !empty( $vid ) ) {
								WP_CLI::success( 'Video = ' .  $video );
							} else {
								WP_CLI::warning( 'Video = ' . $video );
							}
						}
						$post_id = get_the_ID();
						if ( !empty( $post_id ) ) {
							$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id, true );
							if ( !empty( $mfei_record ) ) {
								WP_CLI::success( 'mfei_record = ' . $post_id );
							} else {
								WP_CLI::warning( 'mfei_record = ' . $post_id );
							}
						}
						$photo_url = ( $exhibit->group_photo ) ? $exhibit->group_photo : null;
						if ( !empty( $photo_url ) ) {
							$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );
							if ( !empty( $photo ) ) {
								WP_CLI::success( 'Photo = ' . $photo );
							} else {
								WP_CLI::warning( 'Photo = ' . $photo );
							}
						}
						$mf = ( $exhibit->maker_faire ) ? $exhibit->maker_faire : null;
						if ( !empty( $mf ) ) {
							$faire = add_post_meta( $pid, 'maker_faire', $mf, true );
							if ( !empty( $photo ) ) {
								WP_CLI::success( 'Maker Faire = ' . $mf );
							} else {
								WP_CLI::warning( 'Maker Faire = ' . $mf );
							}
						}
					}
				} elseif ( $exhibit->maker == 'One maker' ) {

					$the_title = $exhibit->maker_name ? $exhibit->maker_name : $exhibit->name;

					$title = htmlspecialchars( $the_title );

					$maker = get_page_by_title( $title, OBJECT, 'maker' );

					echo ( isset( $maker->post_title ) ) ? WP_CLI::success( 'Found: ' . $maker->post_title ) : WP_CLI::warning( 'no title...' ) ;

					if ( !$maker ) {
						// Setup post object...
						$content = ($exhibit->maker_bio ? htmlspecialchars_decode( $exhibit->maker_bio ) : null);
						$my_post = array(
							'post_title'    => $title,
							'post_content'  => $content,
							'post_status'   => 'publish',
							'post_type'		=> 'maker'
						); 
						$pid = wp_insert_post( $my_post );
						if ( is_wp_error( $pid ) ) {
							WP_CLI::warning( $title );
						} else {
							WP_CLI::success( $title );
						}
						$video = ( $exhibit->project_video ) ? $exhibit->project_video  : null;
						if ( !empty( $video ) ) {
							$vid = update_post_meta( $pid, 'video', $video );
							if ( !empty( $vid ) ) {
								WP_CLI::success( 'Video = ' .  $video );
							} else {
								WP_CLI::warning( 'Video = ' . $video );
							}
						}
						$post_id = get_the_ID();
						if ( !empty( $post_id ) ) {
							$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id, true );
							if ( !empty( $mfei_record ) ) {
								WP_CLI::success( 'mfei_record = ' . $post_id );
							} else {
								WP_CLI::warning( 'mfei_record = ' . $post_id );
							}
						}
						$photo_url = ( $exhibit->m_maker_photo_thumb ) ? $exhibit->m_maker_photo_thumb : null;
						if ( !empty( $photo_url ) ) {
							$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );
							if ( !empty( $photo ) ) {
								WP_CLI::success( 'Photo = ' . $photo_url );
							} else {
								WP_CLI::warning( 'Photo = ' . $photo_url );
							}
						}
						$mf = ( $exhibit->maker_faire ) ? $exhibit->maker_faire : null;
						if ( !empty( $mf ) ) {
							$faire = add_post_meta( $pid, 'maker_faire', $mf, true );
							if ( !empty( $photo ) ) {
								WP_CLI::success( 'Maker Faire = ' . $mf );
							} else {
								WP_CLI::warning( 'Maker Faire = ' . $mf );
							}
						}
					} else {
						$pid = $maker->ID;
						$video = ( $exhibit->project_video ) ? $exhibit->project_video  : null;
						if ( !empty( $video ) ) {
							$vid = update_post_meta( $pid, 'video', $video );
							if ( !empty( $vid ) ) {
								WP_CLI::success( 'Video = ' .  $video );
							} else {
								WP_CLI::warning( 'Video = ' . $video );
							}
						}
						$post_id = get_the_ID();
						if ( !empty( $post_id ) ) {
							$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id, true );
							if ( !empty( $mfei_record ) ) {
								WP_CLI::success( 'mfei_record = ' . $post_id );
							} else {
								WP_CLI::warning( 'mfei_record = ' . $post_id );
							}
						}
						$photo_url = ( $exhibit->m_maker_photo_thumb ) ? $exhibit->m_maker_photo_thumb : null;
						if ( !empty( $photo_url ) ) {
							$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );
							if ( !empty( $photo ) ) {
								WP_CLI::success( 'Photo = ' . $photo );
							} else {
								WP_CLI::warning( 'Photo = ' . $photo );
							}
						}
						$mf = ( $exhibit->maker_faire ) ? $exhibit->maker_faire : null;
						if ( !empty( $mf ) ) {
							$faire = add_post_meta( $pid, 'maker_faire', $mf, true );
							if ( !empty( $photo ) ) {
								WP_CLI::success( 'Maker Faire = ' . $mf );
							} else {
								WP_CLI::warning( 'Maker Faire = ' . $mf );
							}
						}
					}
				}  elseif ( $exhibit->maker == 'A list of makers' ) {
					WP_CLI::line('A list! A list! ' . get_the_ID() );
					
					$maker_list = ( isset( $exhibit->m_maker_name ) ) ? $exhibit->m_maker_name : null;
					$i = 0;

					if ( is_array( $maker_list ) ) {
						foreach ( $maker_list as $maker_name ) {
							// We may need to revise this? If $exhibit->m_maker_name[ $i ] return false, we may end up generating multiple
							// makers with the same title. If there are two empty maker name fields, that will generate dups.
							// Any other good idea around this? - CG
							$the_title = $exhibit->m_maker_name[ $i ] ? $exhibit->m_maker_name[ $i ] : $exhibit->project_name;
							$title = htmlspecialchars( $the_title );
							$maker = get_page_by_title( $title, OBJECT, 'maker' );

							echo ( isset( $maker->post_title ) ) ? WP_CLI::success( 'Found: ' . $maker->post_title ) : WP_CLI::warning( 'no title...' ) ;

							if ( ! $maker ) {
								// Setup post object...
								$content = ( isset( $exhibit->m_maker_bio[ $i ] ) ? htmlspecialchars_decode( $exhibit->m_maker_bio[ $i ] ) : null);
								$my_post = array(
									'post_title'    => $title,
									'post_content'  => $content,
									'post_status'   => 'publish',
									'post_type'		=> 'maker'
								); 
								$pid = wp_insert_post( $my_post );
								if ( is_wp_error( $pid ) ) {
									WP_CLI::warning( 'Maker Name: ' . $title );
								} else {
									WP_CLI::success( 'Maker Name: ' . $title );
								}
								$video = ( $exhibit->project_video ) ? $exhibit->project_video  : null;
								if ( !empty( $video ) ) {
									$vid = update_post_meta( $pid, 'video', $video );
									if ( !empty( $vid ) ) {
										WP_CLI::success( 'Video = ' .  $video );
									} else {
										WP_CLI::warning( 'Video = ' . $video );
									}
								}
								$post_id = get_the_ID();
								if ( !empty( $post_id ) ) {
									$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id, true );
									if ( !empty( $mfei_record ) ) {
										WP_CLI::success( 'mfei_record = ' . $post_id );
									} else {
										WP_CLI::warning( 'mfei_record = ' . $post_id );
									}
								}
								$photo_url = ( $exhibit->m_maker_photo[ $i ] ) ? $exhibit->m_maker_photo[ $i ] : null;
								if ( !empty( $photo_url ) ) {
									$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );
									if ( !empty( $photo ) ) {
										WP_CLI::success( 'Photo = ' . $photo_url );
									} else {
										WP_CLI::warning( 'Photo = ' . $photo_url );
									}
								}
								$mf = ( $exhibit->maker_faire ) ? $exhibit->maker_faire : null;
								if ( !empty( $mf ) ) {
									$faire = add_post_meta( $pid, 'maker_faire', $mf, true );
									if ( !empty( $photo ) ) {
										WP_CLI::success( 'Maker Faire = ' . $mf );
									} else {
										WP_CLI::warning( 'Maker Faire = ' . $mf );
									}
								}
							} else {
								WP_CLI::line( 'Updating Meta...' );
								$pid = $maker->ID;
								$video = ( $exhibit->project_video ) ? $exhibit->project_video  : null;
								if ( !empty( $video ) ) {
									$vid = update_post_meta( $pid, 'video', $video );
									if ( !empty( $vid ) ) {
										WP_CLI::success( 'Video = ' .  $video );
									} else {
										WP_CLI::warning( 'Video = ' . $video );
									}
								}
								$post_id = get_the_ID();
								if ( !empty( $post_id ) ) {
									$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id, true );
									if ( !empty( $mfei_record ) ) {
										WP_CLI::success( 'mfei_record = ' . $post_id );
									} else {
										WP_CLI::warning( 'mfei_record = ' . $post_id );
									}
								}
								$photo_url = ( isset( $exhibit->m_maker_photo[ $i ] ) ) ? $exhibit->m_maker_photo[ $i ] : null;
								if ( !empty( $photo_url ) ) {
									$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );
									if ( !empty( $photo ) ) {
										WP_CLI::success( 'Photo = ' . $photo );
									} else {
										WP_CLI::warning( 'Photo = ' . $photo );
									}
								}
								$mf = ( $exhibit->maker_faire ) ? $exhibit->maker_faire : null;
								if ( !empty( $mf ) ) {
									$faire = add_post_meta( $pid, 'maker_faire', $mf, true );
									if ( !empty( $photo ) ) {
										WP_CLI::success( 'Maker Faire = ' . $mf );
									} else {
										WP_CLI::warning( 'Maker Faire = ' . $mf );
									}
								}
							}
							$i++;
						}
					}
				}
			}
		

		WP_CLI::line( '' );
		endwhile;
		WP_CLI::success( "Boom!" );

	}

}
