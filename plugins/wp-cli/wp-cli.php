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
	 * 
	 */
	public function mf_create_makers( $args, $assoc_args ) {

		$args = array(
			'posts_per_page' => 2000,
			'post_type' => 'mf_form',
			'post_status' => 'accepted',

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
			
		setup_postdata( $post );

		$application = json_decode( html_entity_decode( str_replace( array( "\'", "u03a9" ), array( "'", '&#8486;' ), $post->post_content ), ENT_COMPAT, 'utf-8' ) );
		$type = ( isset( $application->form_type ) ) ? $application->form_type : 'null';

		if ( $type == 'exhibit' ) {
			WP_CLI::line( 'Exhibit' );

			if ( $application->maker == 'A group or association' ) {
				WP_CLI::line( 'A group or association | ID: ' . get_the_ID() );

				$the_title = $application->group_name ? $application->group_name : $application->name;
				$title = htmlspecialchars( $the_title );
				$maker = get_page_by_title( $title, OBJECT, 'maker' );

				echo ( isset( $maker->post_title ) ) ? WP_CLI::success( 'Found: ' . $maker->post_title ) : WP_CLI::warning( 'no title...' ) ;

				if ( ! $maker ) {
					// Setup post object...
					$content = ( $application->group_bio ? htmlspecialchars_decode( $application->group_bio ) : null );
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

					$website = ( $application->project_website ) ? $application->project_website  : null;
					if ( ! empty( $website ) ) {
						$web = update_post_meta( $pid, 'website', $website );

						if ( ! empty( $web ) ) {
							WP_CLI::success( 'website = ' .  $website );
						} else {
							WP_CLI::warning( 'website = ' . $website );
						}
					}

					$video = ( $application->project_video ) ? $application->project_video  : null;
					if ( ! empty( $video ) ) {
						$vid = update_post_meta( $pid, 'video', $video );

						if ( ! empty( $vid ) ) {
							WP_CLI::success( 'Video = ' .  $video );
						} else {
							WP_CLI::warning( 'Video = ' . $video );
						}
					}

					$post_id = get_the_ID();
					if ( ! empty( $post_id ) ) {
						$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

						if ( ! empty( $mfei_record ) ) {
							WP_CLI::success( 'mfei_record = ' . $post_id );
						} else {
							WP_CLI::warning( 'mfei_record = ' . $post_id );
						}
					}

					$photo_url = ( $application->group_photo ) ? $application->group_photo : null;
					if ( ! empty( $photo_url ) ) {
						$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

						if ( ! empty( $photo ) ) {
							WP_CLI::success( 'Photo = ' . $photo_url );
						} else {
							WP_CLI::warning( 'Photo = ' . $photo_url );
						}
					}

					$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
					if ( ! empty( $mf ) ) {
						$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

						if ( ! empty( $photo ) ) {
							WP_CLI::success( 'Maker Faire = ' . $mf );
						} else {
							WP_CLI::warning( 'Maker Faire = ' . $mf );
						}
					}
				} else {
					$pid = $maker->ID;

					$website = ( $application->project_website ) ? $application->project_website  : null;
					if ( ! empty( $website ) ) {
						$web = update_post_meta( $pid, 'website', $website );

						if ( ! empty( $web ) ) {
							WP_CLI::success( 'Website = ' .  $website );
						} else {
							WP_CLI::warning( 'Website = ' . $website );
						}
					}

					$video = ( $application->project_video ) ? $application->project_video  : null;
					if ( ! empty( $video ) ) {
						$vid = update_post_meta( $pid, 'video', $video );

						if ( ! empty( $vid ) ) {
							WP_CLI::success( 'Video = ' .  $video );
						} else {
							WP_CLI::warning( 'Video = ' . $video );
						}
					}

					$post_id = get_the_ID();
					if ( ! empty( $post_id ) ) {
						$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

						if ( ! empty( $mfei_record ) ) {
							WP_CLI::success( 'mfei_record = ' . $post_id );
						} else {
							WP_CLI::warning( 'mfei_record = ' . $post_id );
						}
					}

					$photo_url = ( $application->group_photo ) ? $application->group_photo : null;
					if ( ! empty( $photo_url ) ) {
						$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

						if ( ! empty( $photo ) ) {
							WP_CLI::success( 'Photo = ' . $photo );
						} else {
							WP_CLI::warning( 'Photo = ' . $photo );
						}
					}

					$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
					if ( ! empty( $mf ) ) {
						$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

						if ( ! empty( $photo ) ) {
							WP_CLI::success( 'Maker Faire = ' . $mf );
						} else {
							WP_CLI::warning( 'Maker Faire = ' . $mf );
						}
					}
				}
			// Some users didn't select an maker type... so loop them here.
			} elseif ( $application->maker == 'One maker' || $application->maker == '' ) {
				WP_CLI::line( 'One Maker | ID: ' . get_the_ID() );

				$the_title = $application->maker_name ? $application->maker_name : $application->name;
				$title = htmlspecialchars( $the_title );
				$maker = get_page_by_title( $title, OBJECT, 'maker' );

				echo ( isset( $maker->post_title ) ) ? WP_CLI::success( 'Found: ' . $maker->post_title ) : WP_CLI::warning( 'no title...' );

				if ( ! $maker ) {
					// Setup post object...
					$content = ( $application->maker_bio ? htmlspecialchars_decode( $application->maker_bio ) : null );
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

					$website = ( $application->project_website ) ? $application->project_website  : null;
					if ( ! empty( $website ) ) {
						$web = update_post_meta( $pid, 'website', $website );

						if ( ! empty( $web ) ) {
							WP_CLI::success( 'Website = ' .  $website );
						} else {
							WP_CLI::warning( 'Website = ' . $website );
						}
					}

					$video = ( $application->project_video ) ? $application->project_video  : null;
					if ( ! empty( $video ) ) {
						$vid = update_post_meta( $pid, 'video', $video );

						if ( ! empty( $vid ) ) {
							WP_CLI::success( 'Video = ' .  $video );
						} else {
							WP_CLI::warning( 'Video = ' . $video );
						}
					}

					$post_id = get_the_ID();
					if ( ! empty( $post_id ) ) {
						$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

						if ( ! empty( $mfei_record ) ) {
							WP_CLI::success( 'mfei_record = ' . $post_id );
						} else {
							WP_CLI::warning( 'mfei_record = ' . $post_id );
						}
					}

					$photo_url = ( $application->m_maker_photo_thumb ) ? $application->m_maker_photo_thumb : null;
					if ( ! empty( $photo_url ) ) {
						$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

						if ( ! empty( $photo ) ) {
							WP_CLI::success( 'Photo = ' . $photo_url );
						} else {
							WP_CLI::warning( 'Photo = ' . $photo_url );
						}
					}

					$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
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

					$website = ( $application->project_website ) ? $application->project_website  : null;
					if ( ! empty( $website ) ) {
						$web = update_post_meta( $pid, 'website', $website );

						if ( ! empty( $web ) ) {
							WP_CLI::success( 'Website = ' .  $website );
						} else {
							WP_CLI::warning( 'Website = ' . $website );
						}
					}

					$video = ( $application->project_video ) ? $application->project_video  : null;
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
						$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

						if ( !empty( $mfei_record ) ) {
							WP_CLI::success( 'mfei_record = ' . $post_id );
						} else {
							WP_CLI::warning( 'mfei_record = ' . $post_id );
						}
					}
					$photo_url = ( $application->m_maker_photo_thumb ) ? $application->m_maker_photo_thumb : null;
					if ( !empty( $photo_url ) ) {
						$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

						if ( !empty( $photo ) ) {
							WP_CLI::success( 'Photo = ' . $photo );
						} else {
							WP_CLI::warning( 'Photo = ' . $photo );
						}
					}
					$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
					if ( !empty( $mf ) ) {
						$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

						if ( !empty( $photo ) ) {
							WP_CLI::success( 'Maker Faire = ' . $mf );
						} else {
							WP_CLI::warning( 'Maker Faire = ' . $mf );
						}
					}
				}
			}  elseif ( $application->maker == 'A list of makers' ) {
				WP_CLI::line('A List of Makers | ID: ' . get_the_ID() );
				
				$maker_list = ( isset( $application->m_maker_name ) ) ? $application->m_maker_name : $application->project_name;
				$i = 0;

				if ( is_array( $maker_list ) ) {
					foreach ( $maker_list as $maker_name ) {
						$the_title = $application->m_maker_name[ $i ] ? $application->m_maker_name[ $i ] : $application->project_name;
						$title = htmlspecialchars( $the_title );
						$maker = get_page_by_title( $title, OBJECT, 'maker' );

						echo ( isset( $maker->post_title ) ) ? WP_CLI::success( 'Found: ' . $maker->post_title ) : WP_CLI::warning( 'no title...' ) ;

						if ( ! $maker ) {
							// Setup post object...
							$content = ( isset( $application->m_maker_bio[ $i ] ) ? htmlspecialchars_decode( $application->m_maker_bio[ $i ] ) : null);
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

							$website = ( $application->project_website ) ? $application->project_website  : null;
							if ( ! empty( $website ) ) {
								$web = update_post_meta( $pid, 'website', $website );

								if ( ! empty( $web ) ) {
									WP_CLI::success( 'Website = ' .  $website );
								} else {
									WP_CLI::warning( 'Website = ' . $website );
								}
							}

							$video = ( $application->project_video ) ? $application->project_video  : null;
							if ( ! empty( $video ) ) {
								$vid = update_post_meta( $pid, 'video', $video );

								if ( ! empty( $vid ) ) {
									WP_CLI::success( 'Video = ' .  $video );
								} else {
									WP_CLI::warning( 'Video = ' . $video );
								}
							}

							$post_id = get_the_ID();
							if ( ! empty( $post_id ) ) {
								$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

								if ( ! empty( $mfei_record ) ) {
									WP_CLI::success( 'mfei_record = ' . $post_id );
								} else {
									WP_CLI::warning( 'mfei_record = ' . $post_id );
								}
							}

							$photo_url = ( $application->m_maker_photo[ $i ] ) ? $application->m_maker_photo[ $i ] : null;
							if ( ! empty( $photo_url ) ) {
								$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

								if ( ! empty( $photo ) ) {
									WP_CLI::success( 'Photo = ' . $photo_url );
								} else {
									WP_CLI::warning( 'Photo = ' . $photo_url );
								}
							}

							$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
							if ( ! empty( $mf ) ) {
								$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

								if ( ! empty( $photo ) ) {
									WP_CLI::success( 'Maker Faire = ' . $mf );
								} else {
									WP_CLI::warning( 'Maker Faire = ' . $mf );
								}
							}
						} else {
							WP_CLI::line( 'Updating Meta...' );
							$pid = $maker->ID;

							$website = ( $application->project_website ) ? $application->project_website  : null;
							if ( ! empty( $website ) ) {
								$web = update_post_meta( $pid, 'website', $website );

								if ( ! empty( $web ) ) {
									WP_CLI::success( 'Website = ' .  $website );
								} else {
									WP_CLI::warning( 'Website = ' . $website );
								}
							}

							$video = ( $application->project_video ) ? $application->project_video  : null;
							if ( ! empty( $video ) ) {
								$vid = update_post_meta( $pid, 'video', $video );

								if ( ! empty( $vid ) ) {
									WP_CLI::success( 'Video = ' .  $video );
								} else {
									WP_CLI::warning( 'Video = ' . $video );
								}
							}

							$post_id = get_the_ID();
							if ( ! empty( $post_id ) ) {
								$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

								if ( ! empty( $mfei_record ) ) {
									WP_CLI::success( 'mfei_record = ' . $post_id );
								} else {
									WP_CLI::warning( 'mfei_record = ' . $post_id );
								}
							}

							$photo_url = ( isset( $application->m_maker_photo[ $i ] ) ) ? $application->m_maker_photo[ $i ] : null;
							if ( ! empty( $photo_url ) ) {
								$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

								if ( ! empty( $photo ) ) {
									WP_CLI::success( 'Photo = ' . $photo );
								} else {
									WP_CLI::warning( 'Photo = ' . $photo );
								}
							}

							$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
							if ( ! empty( $mf ) ) {
								$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

								if ( ! empty( $photo ) ) {
									WP_CLI::success( 'Maker Faire = ' . $mf );
								} else {
									WP_CLI::warning( 'Maker Faire = ' . $mf );
								}
							}
						}
						$i++;
					}
				// Some users failed to fill in their name... so we need to provide something?
				} else {
					$the_title = $application->name ? $application->name : $application->project_name;
					$title = htmlspecialchars( $the_title );
					$maker = get_page_by_title( $title, OBJECT, 'maker' );

					echo ( isset( $maker->post_title ) ) ? WP_CLI::success( 'Found: ' . $maker->post_title ) : WP_CLI::warning( 'no title...' ) ;

					if ( ! $maker ) {
						// Setup post object...
						$content = ( isset( $application->m_maker_bio[0] ) ? htmlspecialchars_decode( $application->m_maker_bio[0] ) : null);
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

						$website = ( $application->project_website ) ? $application->project_website  : null;
						if ( ! empty( $website ) ) {
							$web = update_post_meta( $pid, 'website', $website );

							if ( ! empty( $web ) ) {
								WP_CLI::success( 'Website = ' .  $website );
							} else {
								WP_CLI::warning( 'Website = ' . $website );
							}
						}

						$video = ( $application->project_video ) ? $application->project_video  : null;
						if ( ! empty( $video ) ) {
							$vid = update_post_meta( $pid, 'video', $video );

							if ( ! empty( $vid ) ) {
								WP_CLI::success( 'Video = ' .  $video );
							} else {
								WP_CLI::warning( 'Video = ' . $video );
							}
						}

						$post_id = get_the_ID();
						if ( ! empty( $post_id ) ) {
							$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

							if ( ! empty( $mfei_record ) ) {
								WP_CLI::success( 'mfei_record = ' . $post_id );
							} else {
								WP_CLI::warning( 'mfei_record = ' . $post_id );
							}
						}

						$photo_url = ( $application->m_maker_photo[0] ) ? $application->m_maker_photo[0] : null;
						if ( ! empty( $photo_url ) ) {
							$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

							if ( ! empty( $photo ) ) {
								WP_CLI::success( 'Photo = ' . $photo_url );
							} else {
								WP_CLI::warning( 'Photo = ' . $photo_url );
							}
						}

						$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
						if ( ! empty( $mf ) ) {
							$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

							if ( ! empty( $photo ) ) {
								WP_CLI::success( 'Maker Faire = ' . $mf );
							} else {
								WP_CLI::warning( 'Maker Faire = ' . $mf );
							}
						}
					} else {
						WP_CLI::line( 'Updating Meta...' );
						$pid = $maker->ID;

						$website = ( $application->project_website ) ? $application->project_website  : null;
						if ( ! empty( $website ) ) {
							$web = update_post_meta( $pid, 'website', $website );

							if ( ! empty( $web ) ) {
								WP_CLI::success( 'Website = ' .  $website );
							} else {
								WP_CLI::warning( 'Website = ' . $website );
							}
						}

						$video = ( $application->project_video ) ? $application->project_video  : null;
						if ( ! empty( $video ) ) {
							$vid = update_post_meta( $pid, 'video', $video );

							if ( ! empty( $vid ) ) {
								WP_CLI::success( 'Video = ' .  $video );
							} else {
								WP_CLI::warning( 'Video = ' . $video );
							}
						}

						$post_id = get_the_ID();
						if ( ! empty( $post_id ) ) {
							$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

							if ( ! empty( $mfei_record ) ) {
								WP_CLI::success( 'mfei_record = ' . $post_id );
							} else {
								WP_CLI::warning( 'mfei_record = ' . $post_id );
							}
						}

						$photo_url = ( isset( $application->m_maker_photo[0] ) ) ? $application->m_maker_photo[0] : null;
						if ( ! empty( $photo_url ) ) {
							$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

							if ( ! empty( $photo ) ) {
								WP_CLI::success( 'Photo = ' . $photo );
							} else {
								WP_CLI::warning( 'Photo = ' . $photo );
							}
						}

						$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
						if ( ! empty( $mf ) ) {
							$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

							if ( ! empty( $photo ) ) {
								WP_CLI::success( 'Maker Faire = ' . $mf );
							} else {
								WP_CLI::warning( 'Maker Faire = ' . $mf );
							}
						}
					}
				}
			}
		} elseif ( $type == 'presenter' ) {
			WP_CLI::line( 'Presenter' );

			if ( $application->presentation_type == 'Presentation' ) {
				WP_CLI::line( 'Presentation | ID: ' . get_the_ID() );

				$the_title = $application->presenter_name[0] ? $application->presenter_name[0] : $application->name;
				$title = htmlspecialchars( $the_title );
				$presentation = get_page_by_title( $title, OBJECT, 'maker' );

				echo ( isset( $presentation->post_title ) ) ? WP_CLI::success( 'Found: ' . $presentation->post_title ) : WP_CLI::warning( 'no title...' );

				if ( ! $presentation ) {
					// Setup post object...
					$content = ( $application->presenter_bio[0] ? htmlspecialchars_decode( $application->presenter_bio[0] ) : null );
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

					$website = ( $application->presentation_website ) ? $application->presentation_website  : null;
					if ( ! empty( $website ) ) {
						$web = update_post_meta( $pid, 'presentation_website', $website );

						if ( !empty( $web ) ) {
							WP_CLI::success( 'Website = ' .  $website );
						} else {
							WP_CLI::warning( 'Website = ' . $website );
						}
					}

					$video = ( $application->video ) ? $application->video  : null;
					if ( ! empty( $video ) ) {
						$vid = update_post_meta( $pid, 'video', $video );

						if ( ! empty( $vid ) ) {
							WP_CLI::success( 'Video = ' .  $video );
						} else {
							WP_CLI::warning( 'Video = ' . $video );
						}
					}

					$post_id = get_the_ID();
					if ( ! empty( $post_id ) ) {
						$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

						if ( ! empty( $mfei_record ) ) {
							WP_CLI::success( 'mfei_record = ' . $post_id );
						} else {
							WP_CLI::warning( 'mfei_record = ' . $post_id );
						}
					}

					$photo_url = ( $application->presenter_photo[0] ) ? $application->presenter_photo[0] : null;
					if ( ! empty( $photo_url ) ) {
						$photo = add_post_meta( $pid, 'presenter_photo', $photo_url, true );

						if ( ! empty( $photo ) ) {
							WP_CLI::success( 'Photo = ' . $photo_url );
						} else {
							WP_CLI::warning( 'Photo = ' . $photo_url );
						}
					}

					// Get the Maker Faire year
					$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
					if ( ! empty( $mf ) ) {
						$faire = add_post_meta( $pid, 'maker_faire', $mf, true );
						if ( ! empty( $photo ) ) {
							WP_CLI::success( 'Maker Faire = ' . $mf );
						} else {
							WP_CLI::warning( 'Maker Faire = ' . $mf );
						}
					}
				} else {
					WP_CLI::line( 'Updating Meta...' );
					$pid = $presentation->ID;

					$website = ( $application->presentation_website ) ? $application->presentation_website  : null;
					if ( ! empty( $website ) ) {
						$web = update_post_meta( $pid, 'presentation_website', $website );

						if ( ! empty( $web ) ) {
							WP_CLI::success( 'Video = ' .  $website );
						} else {
							WP_CLI::warning( 'Video = ' . $website );
						}
					}

					$video = ( $application->video ) ? $application->video  : null;
					if ( ! empty( $video ) ) {
						$vid = update_post_meta( $pid, 'video', $video );

						if ( ! empty( $vid ) ) {
							WP_CLI::success( 'Video = ' .  $video );
						} else {
							WP_CLI::warning( 'Video = ' . $video );
						}
					}

					$post_id = get_the_ID();
					if ( ! empty( $post_id ) ) {
						$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

						if ( ! empty( $mfei_record ) ) {
							WP_CLI::success( 'mfei_record updated = ' . $post_id );
						} else {
							WP_CLI::warning( 'mfei_record updated = ' . $post_id );
						}
					}

					$photo_url = ( $application->presenter_photo[0] ) ? $application->presenter_photo[0] : null;
					if ( ! empty( $photo_url ) ) {
						$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

						if ( ! empty( $photo ) ) {
							WP_CLI::success( 'Photo = ' . $photo );
						} else {
							WP_CLI::warning( 'Photo = ' . $photo );
						}
					}

					$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
					if ( ! empty( $mf ) ) {
						$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

						if ( ! empty( $photo ) ) {
							WP_CLI::success( 'Maker Faire = ' . $mf );
						} else {
							WP_CLI::warning( 'Maker Faire = ' . $mf );
						}
					}
				}
			} elseif ( $application->presentation_type == 'Panel Presentation' ) {
				WP_CLI::line( 'Panel Presentation | ID: ' . get_the_ID() );

				$presentation_list = ( isset( $application->presenter_name ) ) ? $application->presenter_name : $application->name;
				$i = 0;

				if ( is_array( $presentation_list ) ) {
					foreach ( $presentation_list as $presenter_name ) {
						// We may need to revise this? If $application->m_maker_name[ $i ] return false, we may end up generating multiple
						// makers with the same title. If there are two empty maker name fields, that will generate dups.
						// Any other good idea around this? - CG
						$the_title = $application->presenter_name[ $i ] ? $application->presenter_name[ $i ] : $application->name;
						$title = htmlspecialchars( $the_title );
						$maker = get_page_by_title( $title, OBJECT, 'maker' );

						echo ( isset( $maker->post_title ) ) ? WP_CLI::success( 'Found: ' . $maker->post_title ) : WP_CLI::warning( 'no title...' ) ;

						if ( ! $maker ) {
							// Setup post object...
							$content = ( isset( $application->presenter_bio[ $i ] ) ? htmlspecialchars_decode( $application->presenter_bio[ $i ] ) : null);
							$my_post = array(
								'post_title'    => $title,
								'post_content'  => $content,
								'post_status'   => 'publish',
								'post_type'		=> 'maker'
							);

							$pid = wp_insert_post( $my_post );
							if ( is_wp_error( $pid ) ) {
								WP_CLI::warning( 'Presenter Name: ' . $title );
							} else {
								WP_CLI::success( 'Presenter Name: ' . $title );
							}

							$website = ( $application->presentation_website ) ? $application->presentation_website  : null;
							if ( ! empty( $website ) ) {
								$web = update_post_meta( $pid, 'website', $website );
								if ( ! empty( $web ) ) {
									WP_CLI::success( 'website = ' .  $website );
								} else {
									WP_CLI::warning( 'website = ' . $website );
								}
							}

							$video = ( $application->video ) ? $application->video  : null;
							if ( ! empty( $video ) ) {
								$vid = update_post_meta( $pid, 'video', $video );
								if ( ! empty( $vid ) ) {
									WP_CLI::success( 'Video = ' .  $video );
								} else {
									WP_CLI::warning( 'Video = ' . $video );
								}
							}

							$post_id = get_the_ID();
							if ( ! empty( $post_id ) ) {
								$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

								if ( ! empty( $mfei_record ) ) {
									WP_CLI::success( 'mfei_record = ' . $post_id );
								} else {
									WP_CLI::warning( 'mfei_record = ' . $post_id );
								}
							}

							$photo_url = ( $application->presenter_photo[ $i ] ) ? $application->presenter_photo[ $i ] : null;
							if ( ! empty( $photo_url ) ) {
								$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

								if ( ! empty( $photo ) ) {
									WP_CLI::success( 'Photo = ' . $photo_url );
								} else {
									WP_CLI::warning( 'Photo = ' . $photo_url );
								}
							}

							$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
							if ( ! empty( $mf ) ) {
								$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

								if ( ! empty( $photo ) ) {
									WP_CLI::success( 'Maker Faire = ' . $mf );
								} else {
									WP_CLI::warning( 'Maker Faire = ' . $mf );
								}
							}
						} else {
							WP_CLI::line( 'Updating Meta...' );
							$pid = $maker->ID;

							$website = ( $application->presentation_website ) ? $application->presentation_website  : null;
							if ( ! empty( $website ) ) {
								$web = update_post_meta( $pid, 'website', $website );

								if ( ! empty( $web ) ) {
									WP_CLI::success( 'website = ' .  $website );
								} else {
									WP_CLI::warning( 'website = ' . $website );
								}
							}

							$video = ( $application->video ) ? $application->video  : null;
							if ( ! empty( $video ) ) {
								$vid = update_post_meta( $pid, 'video', $video );

								if ( ! empty( $vid ) ) {
									WP_CLI::success( 'Video = ' .  $video );
								} else {
									WP_CLI::warning( 'Video = ' . $video );
								}
							}

							$post_id = get_the_ID();
							if ( ! empty( $post_id ) ) {
								$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

								if ( ! empty( $mfei_record ) ) {
									WP_CLI::success( 'mfei_record = ' . $post_id );
								} else {
									WP_CLI::warning( 'mfei_record = ' . $post_id );
								}
							}

							$photo_url = ( isset( $application->presenter_photo[ $i ] ) ) ? $application->presenter_photo[ $i ] : null;
							if ( ! empty( $photo_url ) ) {
								$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

								if ( ! empty( $photo ) ) {
									WP_CLI::success( 'Photo = ' . $photo );
								} else {
									WP_CLI::warning( 'Photo = ' . $photo );
								}
							}

							$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
							if ( ! empty( $mf ) ) {
								$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

								if ( ! empty( $photo ) ) {
									WP_CLI::success( 'Maker Faire = ' . $mf );
								} else {
									WP_CLI::warning( 'Maker Faire = ' . $mf );
								}
							}
						}
						$i++;
					}
				// There are inconsistencies with the form names... We need to handle an instance that is a panel but 
				// doesn't contain an array of panelists. That makes me a sad panda.
				} else {
					$the_title = $application->name ? $application->name : null;
					$title = htmlspecialchars( $the_title );
					$maker = get_page_by_title( $title, OBJECT, 'maker' );

					echo ( isset( $maker->post_title ) ) ? WP_CLI::success( 'Found: ' . $maker->post_title ) : WP_CLI::warning( 'no title...' ) ;

					if ( ! $maker ) {
						// Setup post object...
						$content = ( isset( $application->presenter_bio[0] ) ? htmlspecialchars_decode( $application->presenter_bio[0] ) : null);
						$my_post = array(
							'post_title'    => $title,
							'post_content'  => $content,
							'post_status'   => 'publish',
							'post_type'		=> 'maker'
						); 

						$pid = wp_insert_post( $my_post );
						if ( is_wp_error( $pid ) ) {
							WP_CLI::warning( 'Presenter Name: ' . $title );
						} else {
							WP_CLI::success( 'Presenter Name: ' . $title );
						}

						$website = ( $application->presentation_website ) ? $application->presentation_website  : null;
						if ( ! empty( $website ) ) {
							$web = update_post_meta( $pid, 'website', $website );

							if ( ! empty( $web ) ) {
								WP_CLI::success( 'website = ' .  $website );
							} else {
								WP_CLI::warning( 'website = ' . $website );
							}
						}

						$video = ( $application->video ) ? $application->video  : null;
						if ( ! empty( $video ) ) {
							$vid = update_post_meta( $pid, 'video', $video );

							if ( ! empty( $vid ) ) {
								WP_CLI::success( 'Video = ' .  $video );
							} else {
								WP_CLI::warning( 'Video = ' . $video );
							}
						}

						$post_id = get_the_ID();
						if ( ! empty( $post_id ) ) {
							$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

							if ( ! empty( $mfei_record ) ) {
								WP_CLI::success( 'mfei_record created = ' . $post_id );
							} else {
								WP_CLI::warning( 'mfei_record created = ' . $post_id );
							}
						}

						$photo_url = ( $application->presenter_photo[0] ) ? $application->presenter_photo[0] : null;
						if ( ! empty( $photo_url ) ) {
							$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

							if ( ! empty( $photo ) ) {
								WP_CLI::success( 'Photo = ' . $photo_url );
							} else {
								WP_CLI::warning( 'Photo = ' . $photo_url );
							}
						}

						$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
						if ( ! empty( $mf ) ) {
							$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

							if ( ! empty( $photo ) ) {
								WP_CLI::success( 'Maker Faire = ' . $mf );
							} else {
								WP_CLI::warning( 'Maker Faire = ' . $mf );
							}
						}
					} else {
						WP_CLI::line( 'Updating Meta...' );
						$pid = $maker->ID;

						$website = ( $application->presentation_website ) ? $application->presentation_website  : null;
						if ( ! empty( $website ) ) {
							$web = update_post_meta( $pid, 'website', $website );

							if ( ! empty( $web ) ) {
								WP_CLI::success( 'website = ' .  $website );
							} else {
								WP_CLI::warning( 'website = ' . $website );
							}
						}

						$video = ( $application->video ) ? $application->video  : null;
						if ( ! empty( $video ) ) {
							$vid = update_post_meta( $pid, 'video', $video );

							if ( ! empty( $vid ) ) {
								WP_CLI::success( 'Video = ' .  $video );
							} else {
								WP_CLI::warning( 'Video = ' . $video );
							}
						}

						$post_id = get_the_ID();
						if ( ! empty( $post_id ) ) {
							$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

							if ( ! empty( $mfei_record ) ) {
								WP_CLI::success( 'mfei_record updated = ' . $post_id );
							} else {
								WP_CLI::warning( 'mfei_record updated = ' . $post_id );
							}
						}

						$photo_url = ( isset( $application->presenter_photo[0] ) ) ? $application->presenter_photo[0] : null;
						if ( ! empty( $photo_url ) ) {
							$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

							if ( ! empty( $photo ) ) {
								WP_CLI::success( 'Photo = ' . $photo );
							} else {
								WP_CLI::warning( 'Photo = ' . $photo );
							}
						}

						$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
						if ( ! empty( $mf ) ) {
							$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

							if ( ! empty( $photo ) ) {
								WP_CLI::success( 'Maker Faire = ' . $mf );
							} else {
								WP_CLI::warning( 'Maker Faire = ' . $mf );
							}
						}
					}
				}
			}
		} elseif ( $type == 'performer' ) {
			WP_CLI::line( 'Performer | ID: ' . get_the_ID() );

			$the_title = $application->performer_name ? $application->performer_name : $application->name;
			$title = htmlspecialchars( $the_title );
			$performer = get_page_by_title( $title, OBJECT, 'maker' );

			echo ( isset( $performer->post_title ) ) ? WP_CLI::success( 'Found: ' . $performer->post_title ) : WP_CLI::warning( 'no title...' );

			if ( ! $performer ) {
				// Setup post object...
				$content = ($application->public_description ? htmlspecialchars_decode( $application->public_description ) : null);
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

				// Get Website URL
				$website = ( $application->performer_website ) ? $application->performer_website  : null;
				if ( ! empty( $website ) ) {
					$web = update_post_meta( $pid, 'performer_website', $website );

					if ( ! empty( $web ) ) {
						WP_CLI::success( 'Website = ' .  $website );
					} else {
						WP_CLI::warning( 'Website = ' . $website );
					}
				}

				// Get Video URL
				$video = ( $application->performer_video ) ? $application->performer_video  : null;
				if ( ! empty( $video ) ) {
					$vid = update_post_meta( $pid, 'video', $video );

					if ( ! empty( $vid ) ) {
						WP_CLI::success( 'Video = ' .  $video );
					} else {
						WP_CLI::warning( 'Video = ' . $video );
					}
				}

				// Get Post ID
				$post_id = get_the_ID();
				if ( ! empty( $post_id ) ) {
					$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

					if ( ! empty( $mfei_record ) ) {
						WP_CLI::success( 'mfei_record = ' . $post_id );
					} else {
						WP_CLI::warning( 'mfei_record = ' . $post_id );
					}
				}

				// Get Photo URL
				$photo_url = ( $application->performer_photo ) ? $application->performer_photo : null;
				if ( ! empty( $photo_url ) ) {
					$photo = add_post_meta( $pid, 'presenter_photo', $photo_url, true );

					if ( ! empty( $photo ) ) {
						WP_CLI::success( 'Photo = ' . $photo_url );
					} else {
						WP_CLI::warning( 'Photo = ' . $photo_url );
					}
				}

				// Get the Maker Faire year
				$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
				if ( ! empty( $mf ) ) {
					$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

					if ( ! empty( $photo ) ) {
						WP_CLI::success( 'Maker Faire = ' . $mf );
					} else {
						WP_CLI::warning( 'Maker Faire = ' . $mf );
					}
				}
			} else {
				WP_CLI::line( 'Updating Meta...' );
				$pid = $performer->ID;

				$website = ( $application->performer_website ) ? $application->performer_website  : null;
				if ( ! empty( $website ) ) {
					$web = update_post_meta( $pid, 'performer_website', $website );

					if ( ! empty( $web ) ) {
						WP_CLI::success( 'Website = ' .  $website );
					} else {
						WP_CLI::warning( 'Website = ' . $website );
					}
				}

				$video = ( $application->performer_video ) ? $application->performer_video  : null;
				if ( ! empty( $video ) ) {
					$vid = update_post_meta( $pid, 'video', $video );

					if ( ! empty( $vid ) ) {
						WP_CLI::success( 'Video = ' .  $video );
					} else {
						WP_CLI::warning( 'Video = ' . $video );
					}
				}

				$post_id = get_the_ID();
				if ( ! empty( $post_id ) ) {
					$mfei_record = add_post_meta( $pid, 'mfei_record', $post_id );

					if ( ! empty( $mfei_record ) ) {
						WP_CLI::success( 'mfei_record = ' . $post_id );
					} else {
						WP_CLI::warning( 'mfei_record = ' . $post_id );
					}
				}

				$photo_url = ( $application->performer_photo ) ? $application->performer_photo : null;
				if ( ! empty( $photo_url ) ) {
					$photo = add_post_meta( $pid, 'photo_url', $photo_url, true );

					if ( ! empty( $photo ) ) {
						WP_CLI::success( 'Photo = ' . $photo );
					} else {
						WP_CLI::warning( 'Photo = ' . $photo );
					}
				}

				$mf = ( $application->maker_faire ) ? $application->maker_faire : null;
				if ( ! empty( $mf ) ) {
					$faire = add_post_meta( $pid, 'maker_faire', $mf, true );

					if ( ! empty( $photo ) ) {
						WP_CLI::success( 'Maker Faire = ' . $mf );
					} else {
						WP_CLI::warning( 'Maker Faire = ' . $mf );
					}
				}
			}
		}

		WP_CLI::line( '' );
		endwhile;
		WP_CLI::success( "Boom!" );
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