<?php
/**
 * Public Page Functions for Makers
 */

function mf_character_fixer( $str ) {
	$bad  = array( '&#039l', "\'", '&#8217;', '&#38;', '&amp;', '&quot;', '&#34;', '&#034;', '&#8211;', '&lt;', '&#8230;', 'u2018', 'u2019', 'u2014', 'u201d', 'u201c' );
	$good = array( "'",      "'",  "'",       "&",	   '&',		'\"',     '"',     '"',      '–',       '>',    '...',     "'",     "'",     "—",     '\"',    '\"'   );
	return str_replace( $bad, $good, $str );
}

function mf_convert_newlines( $str, $replace = '<br />' ) {
	$s = array('nn-', ' nn', '.nn', '<br />rn');
	return str_replace($s, $replace, $str);
}

/**
 * Loop through the locations, and build the breadcrumb navigation for locations.
 */
function mf_location( $id ) {
	$locs = get_the_terms( $id, 'location' );
	$booth = get_post_meta( $id, 'booth');
	if ( !empty($locs) ) {
		$output = '<ul class="breadcrumb">';
		foreach ($locs as $loc) {
			$output .= '<li><strong>Located in</strong>&nbsp;</li>';
			$parent = get_term($loc->parent, 'location');
			$output .= ( !is_wp_error( $parent ) ) ? '<li>' . $parent->name . '</li><span class="divider">/</span>' : '' ;
			$output .= '<li>' . $loc->name . '</li>';
			$output .= ( !empty( $booth[0] ) ) ? '<span class="divider">/</span><li>Booth: ' . esc_html( $booth[0] ) . '</li>' : '' ;

		}
		$output .= '</ul>';	
	}
	return $output;
}

/**
 * Change the name of the Faire to be a proper name.
 */
function mf_better_name( $str ) {
	if ( $str == '2013_bayarea' ) {
		return 'Maker Faire Bay Area 2013';
	} elseif ( $str == '2013_newyork' ) {
		return 'World Maker Faire New York 2013';
	}
}

add_filter('get_avatar','mf_change_avatar_css');

function mf_change_avatar_css( $class ) {
	$class = str_replace("class='avatar", "class='media-object thumbnail pull-left avatar", $class) ;
	return $class;
}

/**
 * Parse the type of Maker, and then build the page.
 */
function mf_public_blurb( $json ) {

	$type = $json->form_type;

	if ($type == 'exhibit') {
		
		if (!empty($json->project_photo)) {
			$url = $json->project_photo;
			$url = add_query_arg( 'w', 610, $url );
			echo '<img src="'. esc_url( $url ) . '" class="thumbnail" />';
		}
		echo '<hr>';
		
		echo '<div class="lead">';
		echo ( !empty( $json->public_description ) ) ? Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->public_description, "\n" ) ) ) ) : null;
		echo '</div>';
		
		if ( $json->project_website || $json->project_video ) {
			echo '<hr>';
			echo ( !empty( $json->project_website ) ) ? '<a class="btn btn-info" href="'. esc_url( $json->project_website ) . '"><i class="icon-home icon-white"></i> Website</a>' : null ;
			echo ' ';
			echo ( !empty( $json->project_video ) ) ? '<a class="btn btn-info" href="'. esc_url( $json->project_video ) . '"><i class="icon-facetime-video icon-white"></i> Video</a>' : null ;
			if (!empty( $json->project_video ) ) {
				echo '<hr />';
				echo wpcom_vip_wp_oembed_get( esc_url( $json->project_video ), array( 'width'=>620 ) );
			}
			echo '<hr>';
		}

		$terms = get_the_terms( get_the_ID(), array( 'category', 'post_tag' ) );
		if ($terms) {
			echo '<p>Explore Similar Projects in these Areas: ';
			foreach ( $terms as $idx => $term ) {
				echo ( $idx != 0 ) ? ', <a href="' . get_term_link( $term ) . '">' . $term->name . '</a>' : '<a href="' . get_term_link( $term ) . '">' . $term->name . '</a>';
			}
			echo '</p>';
		}
		
		if ( $json->maker == 'One maker') {
			if (!empty($json->maker_name)) {
				echo '<h3>About the Maker</h3>';
				echo '<div class="media">';
				if (!empty($json->maker_photo)) {
					echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->maker_photo, 130, 130, true ) . '" class="media-object thumbnail pull-left"/>';
				}
				echo '<div class="media-body">';
				echo '<h4>' . wp_kses_post( $json->maker_name ) . '</h4>';
				if (function_exists('Markdown')) {
					echo $json->maker_bio ? Markdown( wp_kses_post( $json->maker_bio ) ) : '';
				} else {
					echo '<p>' . wp_kses_post( $json->maker_bio ) . '</p>';
				}
				echo '</div></div>';
			}
		} elseif ($json->maker == 'A group or association') {
			if (!empty($json->group_name)) {
				echo '<h3>Group Association</h3>';
				echo '<div class="media">';
				if (!empty($json->group_photo)) {
					echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->group_photo, 130, 130, true ) . '" class="media-object thumbnail pull-left" />';
				}
				echo '<div class="media-body">';
				echo '<h4>' . wp_kses_post( $json->group_name ) . '</h4>';
				echo '<p>' . wp_kses_post( $json->group_bio ) . '</p>';
				if (!empty($json->group_website)) {
					echo '<a class="btn btn-info" href="'.esc_url( $json->group_website ) . '"><i class="icon-home icon-white"></i> Website</a>';
				}
				echo '</div></div>';	
			}
		} elseif ( $json->maker == 'A list of makers' ) {
			if (!empty($json->m_maker_name)) {
				$i = 0;
				echo '<h3>Makers:</h3>';
				$makers = $json->m_maker_name;
				foreach ($makers as $maker) {
					echo '<div class="media">';
					if ( !empty( $json->m_maker_photo[ $i ] ) && strlen( $json->m_maker_photo[ $i ] ) > 1 ) {
						echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->m_maker_photo[ $i ], 130, 130, true ) . '" class="media-object thumbnail pull-left" />';
					} elseif (isset( $json->m_maker_email[ $i ] ) ) {
						echo get_avatar( $json->m_maker_email[ $i ], 130 ); 
					}
					echo '<div class="media-body">';
					echo '<h4>' . $maker . '</h4>';
					echo (isset( $json->m_maker_bio[ $i ] ) ) ? Markdown( $json->m_maker_bio[ $i ] ) : null;
					echo '</div>';
					echo '<div class="clearfix"></div>';
					$i++;
				}
			}
		}
	} elseif ($type == 'presenter') {
		if (!empty($json->presentation_photo)) {
			$url = $json->presentation_photo;
			$url = add_query_arg( 'w', 610, $url );
			echo '<img src="'. esc_url( $url ) . '" class="thumbnail" />';
		}
		echo '<hr>';

		if ( isset( $json->long_description ) || isset( $json->public_description ) ) {
			echo '<div class="lead">';
			if ( isset( $json->long_description ) ) {
				echo Markdown( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->long_description, "\n" ) ) ) );
			} else {
				echo Markdown( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->public_description, "\n" ) ) ) );
			}
			echo '</div>';
		}
		
		if ( $json->presentation_website || $json->video ) {
			echo '<hr>';
			echo ( !empty( $json->presentation_website ) ) ? '<a class="btn btn-info" href="'. esc_url( $json->presentation_website ) . '"><i class="icon-home icon-white"></i> Website</a>' : null ;
			echo ' ';
			echo ( !empty( $json->video ) ) ? '<a class="btn btn-info" href="'. esc_url( $json->video ) . '"><i class="icon-facetime-video icon-white"></i> Video</a>' : null ;
			if (!empty( $json->video ) ) {
				echo '<hr />';
				echo wpcom_vip_wp_oembed_get( esc_url( $json->video ), array( 'width'=>620 ) );
			}
			echo '<hr>';
		}

		$terms = get_the_terms( get_the_ID(), array( 'category', 'post_tag' ) );
		if ($terms) {
			echo '<p>Explore Similar Projects in these Areas: ';
			foreach ( $terms as $idx => $term ) {
				echo ( $idx != 0 ) ? ', <a href="' . get_term_link( $term ) . '">' . $term->name . '</a>' : '<a href="' . get_term_link( $term ) . '">' . $term->name . '</a>';
			}
			echo '</p>';
		}

		if (!empty($json->presenter_name)) {
			$i = 0;
			echo '<h3>Presenters:</h3>';
			$makers = $json->presenter_name;
			foreach ($makers as $maker) {
				echo '<div class="media">';
				if ( is_array( $json->presenter_photo ) ) {
					if ( !empty( $json->presenter_photo[ $i ] ) && strlen( $json->presenter_photo[ $i ] ) > 1 ) {
						echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->presenter_photo[ $i ], 130, 130, true ) . '" class="media-object thumbnail pull-left" />';
					} elseif (isset( $json->presenter_email[ $i ] )) {
						echo get_avatar( $json->presenter_email[ $i ], 130 ); 
					}
				} else {
					if ( !empty( $json->presenter_photo ) && strlen( $json->presenter_photo ) > 1 ) {
						echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->presenter_photo, 130, 130, true ) . '" class="media-object thumbnail pull-left" />';
					} elseif (isset( $json->presenter_email[ $i ] )) {
						echo get_avatar( $json->presenter_email[ $i ], 130 ); 
					}
				}
				echo '<div class="media-body">';
				$title =  (!empty( $json->presenter_title[ $i ] ) ) ? ' &mdash; ' . $json->presenter_title[ $i ] : null;
				echo '<h4>' . $maker . $title . '</h4>';
				echo (isset( $json->presenter_org[ $i ] ) ) ? '<h5>' . $json->presenter_org[ $i ] . '</h5>' : null;
				echo (isset( $json->presenter_bio[ $i ] ) ) ? Markdown( $json->presenter_bio[ $i ] ) : null;
				echo '</div>';
				echo '<div class="clearfix"></div>';
				$i++;
			}
		}

		if (!empty($json->group_name)) {
			echo '<h3>Group Association</h3>';
			echo '<div class="media">';
			if (!empty($json->group_photo)) {
				echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->group_photo, 130, 130, true ) . '" class="media-object thumbnail pull-left" />';
			}
			echo '<div class="media-body">';
			echo '<h4>' . wp_kses_post( $json->group_name ) . '</h4>';
			echo '<p>' . wp_kses_post( $json->group_bio ) . '</p>';
			if (!empty($json->group_website)) {
				echo '<a class="btn btn-info" href="'.esc_url( $json->group_website ) . '"><i class="icon-home icon-white"></i> Website</a>';
			}
			echo '</div></div>';	
		}
	} elseif ($type == 'performer') {
		if (!empty($json->performer_photo)) {
			$url = $json->performer_photo;
			$url = add_query_arg( 'w', 610, $url );
			echo '<img src="'. esc_url( $url ) . '" class="thumbnail" />';
		}
		echo '<hr>';
		
		echo '<div class="lead">';
		echo ( $json->public_description ) ? Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->public_description, "\n" ) ) ) ) : null;
		echo '</div>';
		
		if ( $json->performer_website || $json->performer_video ) {
			echo '<hr>';
			echo ( !empty( $json->performer_website ) ) ? '<a class="btn btn-info" href="'. esc_url( $json->performer_website ) . '"><i class="icon-home icon-white"></i> Website</a>' : null ;
			echo ' ';
			echo ( !empty( $json->performer_video ) ) ? '<a class="btn btn-info" href="'. esc_url( $json->performer_video ) . '"><i class="icon-facetime-video icon-white"></i> Video</a>' : null ;
			if (!empty( $json->performer_video ) ) {
				echo '<hr />';
				echo wpcom_vip_wp_oembed_get( esc_url( $json->performer_video ), array( 'width'=>620 ) );
			}
			echo '<hr>';
		}

		$terms = get_the_terms( get_the_ID(), array( 'category', 'post_tag' ) );
		if ($terms) {
			echo '<p>Explore Similar Projects in these Areas: ';
			foreach ( $terms as $idx => $term ) {
				echo ( $idx != 0 ) ? ', <a href="' . get_term_link( $term ) . '">' . $term->name . '</a>' : '<a href="' . get_term_link( $term ) . '">' . $term->name . '</a>';
			}
			echo '</p>';
		}
	}

	// Let's get the grouped projects
	$terms = get_the_terms( get_the_ID(), 'group' );
	if ( $terms ) {
		echo '<h3>Other exhibits in this group:</h3>';
		foreach ( $terms as $term ) {
			$args = array( 
				'tax_query' => array(
					array(
						'taxonomy' => 'group',
						'field' => 'id',
						'terms' => $term->term_id
					),
				),
				'post_type'		=> 'mf_form',
				'post_status'	=> 'accepted',
				'posts_per_page' => 100
				);
			$query = new WP_Query( $args );
			$posts = $query->posts;
			if( $query ) {
				foreach ( $posts as $the_post ) {
					$json = json_decode( html_entity_decode( mf_convert_newlines( str_replace( array("\'", "u03a9"), array("'", '&#8486;'), $the_post->post_content ), "\n"), ENT_COMPAT, 'utf-8' ) );
					echo  '<div class="media">';
					if ( !empty( $json->maker_photo ) ) {
						echo  '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->project_photo, 130, 130, true ) . '" class="media-object thumbnail pull-left"/>';
					}
					echo  '<div class="media-body">';
					echo  ( !empty( $json->project_name ) ) ? '<h4><a href="' . get_permalink( $the_post->ID ) . '">' . wp_kses_post( $json->project_name ) . '</a></h4>' : '' ;
					echo  ( !empty( $json->public_description) ) ? Markdown( wp_kses_post( $json->public_description ) ) : '';
					echo  '</div></div><div class="clearfix"></div>';
				}
			}
		}
	}
}

/**
 * Function to spit out Featured Makers
 */
add_shortcode( 'featured', 'mf_featured_makers' );
function mf_featured_makers( $atts ) {
	$args = array( 
		'meta_key'		=> '_ef_editorial_meta_checkbox_featured', 
		'meta_value'	=> true,
		'post_type'		=> 'mf_form',
		'post_status'	=> 'accepted',
		'faire'			=> 'maker-faire-bay-area-2013'
		);
	$args = wp_parse_args( $atts, $args );
	$query = new WP_Query( $args );
	$output = '<div id="featuredMakers" class="carousel slide"><div class="carousel-inner">';
	$i = 1;
	while ( $query->have_posts() ) :
	$query->the_post();
		$content = get_the_content();
		$json = json_decode( str_replace( "\'", "'", $content ) );
		if ($i == 1) {
			$output .= '<div class="item active ' . get_the_ID() . '">';
		} else {
			$output .= '<div class="item ' . get_the_ID() . '">';
		}
		$output .= '<a href="' . get_permalink( get_the_ID() ) . '">';
		if ( !empty( $json->presenter_photo[0] ) ) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->presenter_photo[0], 620, 400, true ) . '" class="Test"/>';
			$output .= '<!--Presenter Photo Array-->';
		} elseif (!empty( $json->project_photo ) ) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->project_photo, 620, 400, true ) . '" class="" />';
			$output .= '<!--Project Photo-->';
		} elseif ( !empty( $json->performer_photo ) ) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->performer_photo, 620, 400, true ) . '" class="" />';
			$output .= '<!--Performer Photo-->';
		} elseif ( !empty( $json->maker_photo ) ) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->maker_photo, 620, 400, true ) . '" class="" />';
			$output .= '<!--Maker Photo-->';
		} elseif ( !empty( $json->presentation_photo ) ) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->presentation_photo, 620, 400, true ) . '" class=""/>';
			$output .= '<!--Presentation Photo-->';
		} elseif ( isset( $json->presenter_photo) ) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->presenter_photo, 620, 400, true ) . '" class=""/>';
			$output .= '<!--Presenter Photo-->';
		}
		$output .= '<div class="carousel-caption">';
		$output .= '<h4>' . get_the_title();
		if (!empty( $json->name ) ) {
			$output .= ' &mdash; ' . wp_kses_post( $json->name );
		}
		$output .= '</h4>';
		if ( !empty( $json->public_description ) ) {
			$output .= $json->public_description ? Markdown( wp_kses_post( $json->public_description ) ) : '';
		}
		$output .= '</div></a></div>';
		$i++;
	endwhile;
	$output .= '</div>
		<a class="left carousel-control" href="#featuredMakers" data-slide="prev">‹</a>
		<a class="right carousel-control" href="#featuredMakers" data-slide="next">›</a>
	</div>';

	wp_reset_postdata();
	return $output;
}

function mf_add_custom_types( $query ) {
	if ( ! is_admin() && $query->is_main_query() && ( $query->is_category() || $query->is_tag() || $query->is_author() || $query-> is_tax() ) && empty( $query->query_vars['suppress_filters'] ) ) {
		$query->set( 'post_type', array( 'post', 'mf_form' ));
		return $query;
	}
}
add_filter( 'pre_get_posts', 'mf_add_custom_types' );

function mf_the_maker_image( $json ) {
	if (!empty($json->presentation_photo)) {
		echo '<img src="'. wpcom_vip_get_resized_remote_image_url( $json->presentation_photo, 140, 140 ) . '" class="" />';
	}
	if (!empty($json->project_photo)) {
		echo '<img src="'. wpcom_vip_get_resized_remote_image_url( $json->project_photo, 140, 140 ) . '" class="" />';
	}
	if (!empty($json->performer_photo)) {
		echo '<img src="'. wpcom_vip_get_resized_remote_image_url( $json->performer_photo, 140, 140 ) . '" class="" />';
	}
}


function mf_get_the_maker_image( $json ) {
	$output = null;
	if (!empty($json->presentation_photo)) {
		$output .= $json->presentation_photo;
	}
	if (!empty($json->project_photo)) {
		$output .= $json->project_photo;
	}
	if (!empty($json->performer_photo)) {
		$output .= $json->performer_photo;
	}
	return $output;
}


function the_mf_content() {
	if ( get_post_type() == 'mf_form' ) {
		$content = get_the_content();
		$json = json_decode( mf_convert_newlines( mf_character_fixer( str_replace( "\'", "'", $content ) ) ) );
		echo '<div class="row"><div class="span2">';
		mf_the_maker_image( $json );
		echo '</div><div class="span6">';
		the_title( '<h3><a href="' . get_permalink() . '">', '</a></h3>' );
		echo ( isset( $json->form_type ) ) ? '<span class="label label-info">' . wp_kses_post( ucfirst( $json->form_type ) ) . '</span>' : '';
		if (!empty($json->public_description)) {
			echo Markdown( wp_kses_post( $json->public_description ) );
		} elseif ( !empty( $json->long_description ) ) {
			echo Markdown( wp_kses_post( $json->long_description ) );
		}
		echo '<ul class="unstyled">';
		$tags = get_the_terms( get_the_ID(), 'post_tag' );
		$cats = get_the_terms( get_the_ID(), 'category' );
		$terms = null;
		if ( is_array( $tags ) && is_array( $cats ) ) {
			$terms = array_merge($cats, $tags);
		} elseif ( is_array( $tags ) ) {
			$terms = $tags;
		} elseif ( is_array( $cats ) ) {
			$terms = $cats;
		}
		if (!empty($terms)) {
			echo '<li>Topics: ';
			$output = null;
			foreach ($terms as $idx => $term) {
				$output .= ', <a href="' . get_term_link( $term ) . '">' . $term->name . '</a>';
			}
			echo substr( $output, 2 );
			echo '</li>';
		}
		echo '</ul>';
		echo '</div></div>';
	} else {
		the_title( '<h2><a href="' . get_permalink() . '">', '</a></h2>' );
		the_content();
	}
}

function mf_term_list() {
	$output = '<ul class="unstyled">';
	$output .= wp_list_categories('hide_empty=0&title_li=&echo=0');
	$output .= '</ul>';
	return $output;
}

add_shortcode( 'mf_terms', 'mf_term_list' );

function mf_switch_category_name( $str ) {
	return str_replace( array( 'category', 'post_tag' ), array( 'category_name', 'tag' ), $str );
}

function mf_merged_terms( $atts ) {
	$args = array(
		'hide_empty'	=> false,
		'exclude'		=> array( '1' ),
		);
	$args = wp_parse_args( $atts, $args );
	$cats = get_terms( array( 'category', 'post_tag' ), $args );
	$output = '<ul class="columns">';
	foreach ($cats as $cat) {
		// $atts['faire'] has been deprecated and will be removed once the production server has been updated.
		if ( isset( $atts['faire'] ) && $atts['faire'] == 'world-maker-faire-new-york-2013' ) {
			$output .= '<li><a href="' . esc_url( home_url( '/new-york-2013/topics/?' . mf_switch_category_name( $cat->taxonomy ) .'=' . $cat->slug ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
		} elseif ( isset( $atts['faire_url'] ) ) { // $atts['faire_url'] replaces $atts['faire']
			$output .= '<li><a href="' . esc_url( home_url( esc_attr( $atts['faire_url'] ) . '?' . mf_switch_category_name( $cat->taxonomy ) . '=' . $cat->slug ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
		} else {
			$output .= '<li><a href="' . esc_url( get_term_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
		}
		
	}
	$output .= '</ul>';
	return $output;
}

add_shortcode('mf_cat_list', 'mf_merged_terms');

add_filter('the_title', function($title) { 
	return str_replace('u03a9', '&#8486;', $title);
	}
);

add_filter('the_content', function($content) { 
	return str_replace('u03a9', '&#8486;', $content);
}
);


/**
 * Function to spit out Smaller Featured Slider for home page
 */
add_shortcode( 'featured_home', 'mf_featured_makers_home' );
function mf_featured_makers_home() {
	$args = array( 
		'meta_key'		=> '_ef_editorial_meta_checkbox_featured', 
		'meta_value'	=> true,
		'post_type'		=> 'mf_form',
		'post_status'	=> 'accepted',
		);
	$query = new WP_Query( $args );
	$output = '<div id="featuredMakers" class="carousel slide">';
	$output .= '<div class="meetthemakers"><h3><a href="http://makerfaire.com/bayarea-2013/maker-info/">Meet the Makers</a></h3></div>';
	$output .= '<div class="banner">';
	$output .= '<h3 class="red">May 18<sup>th</sup> - 19<sup>th</sup> 2013</h3>';
	$output .= '<div class="bordered">';
	$output .= '<h3>San Mateo County Events Center, CA</h3>';
	$output .= '<h4>Saturday 10am - 8pm</h4>';
	$output .= '<h4>Sunday 10am - 6pm</h4>';
	$output .= '</div>';
	$output .= '<h4 class="blue"><a href="http://makerfaire2013.eventbrite.com/">Get Tickets</a></h4>';
	$output .= '<h4 class="blue"><a href="http://makerfaire.com/alt">How to Get There</a></h4>';
	$output .= '<h4 class="blue"><a href="http://makerfaire.com/bayarea-2013/schedule/">Program &amp; Schedule</a></h4>';
	$output .= '<h4 class="blue"><a href="http://app.net/makerfaire">Download the App</a></h4>';
	$output .= '</div>';
	$output .= '<div class="carousel-inner">';
	$i = 1;
	while ( $query->have_posts() ) :
	$query->the_post();
		$content = get_the_content();
		$json = json_decode( str_replace( "\'", "'", $content ) );
		if ($i == 1) {
			$output .= '<div class="item active ' . get_the_ID() . '">';
		} else {
			$output .= '<div class="item ' . get_the_ID() . '">';
		}
		$output .= '<a href="' . get_permalink( get_the_ID() ) . '">';
		if ( !empty( $json->presenter_photo[0] ) ) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->presenter_photo[0], 620, 230, true ) . '" class="Test"/>';
			$output .= '<!--Presenter Photo Array-->';
		} elseif (!empty( $json->project_photo ) ) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->project_photo, 620, 230, true ) . '" class="" />';
			$output .= '<!--Project Photo-->';
		} elseif ( !empty( $json->performer_photo ) ) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->performer_photo, 620, 230, true ) . '" class="" />';
			$output .= '<!--Performer Photo-->';
		} elseif ( !empty( $json->maker_photo ) ) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->maker_photo, 620, 230, true ) . '" class="" />';
			$output .= '<!--Maker Photo-->';
		} elseif ( !empty( $json->presentation_photo ) ) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->presentation_photo, 620, 230, true ) . '" class=""/>';
			$output .= '<!--Presentation Photo-->';
		} elseif ( isset( $json->presenter_photo) ) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->presenter_photo, 620, 230, true ) . '" class=""/>';
			$output .= '<!--Presenter Photo-->';
		}
		$output .= '</a></div>';
		$i++;
	endwhile;
	$output .= '</div></div>';

	wp_reset_postdata();
	return $output;
}

/**
 * Add the description to stages the hard way.
 */
function mf_stage_description( $term ) {
	$output = '';
	if ( $term->term_id == 192277117 ) {
		$output .= '<div class="alert alert-info">' . Markdown( 'Conversations about emerging tech, new practices &amp; community' ) . '</div>';
	} elseif ( $term->term_id == 192277675 ) {
		$output .= '<div class="alert alert-info">' . Markdown( 'How-to on microcontrollers, robotics, and circuit boards' ) . '</div>';
	} elseif ( $term->term_id == 192277685 ) {
		$output .= '<div class="alert alert-info">' . Markdown( '3DP machines, materials, makers and applications' ) . '</div>';
	} elseif ( $term->term_id == 192277716 ) {
		$output .= '<div class="alert alert-info">' . Markdown( 'Product demos and tech how-tos' ) . '</div>';
	} elseif ( $term->term_id == 192277788 ) {
		$output .= '<div class="alert alert-info">' . Markdown( 'Design, craft, sustainability and domestic arts' ) . '</div>';
	} elseif ( $term->term_id == 192277738 ) {
		$output .= '<div class="alert alert-info">' . Markdown( 'Teachers and makers on making in education' ) . '</div>';
	} elseif ( !empty( $term->description ) ) {
		$output .= '<div class="alert alert-info">' . Markdown( $term->description ) . '</div>';
	}
	return $output;
}

/**
 * Generate the schedule for the schedule page. Based on a shortcode. Pass in the ID, and get the schedule for both days.
 */
function mf_schedule( $atts ) {

	extract( shortcode_atts( array(), $atts ) );
	
	$output = '';
	$location = ( isset($atts['location'] ) ) ? sanitize_text_field( $atts['location'] ) : '';
	$faire = ( isset($atts['faire'] ) ) ? sanitize_text_field( $atts['faire'] ) : '';

	if (!empty($location)) {
		$term = wpcom_vip_get_term_by( 'id', $location, 'location');
		$url = get_term_link( $term );
		if ( !is_wp_error( $url ) ) {
			$output .= '<a href="' . esc_url( home_url( '/stage-schedule/?location=' . $term->slug ) ) . '" class="pull-right" style="position:relative; top:7px;"><img src="' . get_stylesheet_directory_uri() . '/images/print-ico.png" alt="Print this schedule" /></a>';
			$output .= '<h2><a href="'. esc_url( $url ) . '">' . esc_html( $term->name ) . '</a></h2>';
			$output .= mf_stage_description( $term );
		}
	}

	$query = wp_cache_get( $location . '_saturday_schedule' );
	if( !isset( $term->slug ) )
		return;
	if( $query == false ) {
		$args = array( 
			'location' 		=> sanitize_title( $term->slug ),
			'post_type'		=> 'event-items',
			'orderby' 		=> 'meta_value', 
			'meta_key'		=> 'mfei_start',
			'order'			=> 'asc',
			'posts_per_page'=> '30',
			'faire'			=> $faire,
			'meta_query' => array(
				array(
					'key' 	=> 'mfei_day',
					'value'	=> 'Saturday',
				),
			),
		);
		$query = new WP_Query( $args );
		wp_cache_set( $location . '_saturday_schedule', $query, '', 300 );
	}

	if ( $query->found_posts >= 1 ) :
	$output .= '<table class="table table-striped table-bordered table-schedule">';
	if ( $faire == 'world-maker-faire-new-york-2013' ) {
		$output .= '<thead><tr><th colspan="2">September 21st, 2013</th></tr></thead>';
	}
	while ( $query->have_posts() ) : $query->the_post();
		$meta = get_post_meta( get_the_ID() );
		$sched_post = get_post( $meta['mfei_record'][0] );
		$json = json_decode( mf_convert_newlines( str_replace( "\'", "'", $sched_post->post_content ) ) );
		$day = ($meta['mfei_day'][0]) ? $meta['mfei_day'][0] : '' ;
		$start = ($meta['mfei_start'][0]) ? $meta['mfei_start'][0] : '' ;
		$stop = ($meta['mfei_stop'][0]) ? $meta['mfei_stop'][0] : '' ;
		$output .= '<tr>';
		$output .= '<td width="150" style="max-width:150px;">';
		$output .= '<h5>' . esc_html( $day ) . '</h5>';
		$output .= '<p>' . esc_html( $start ) . ' &mdash; ' . esc_html( $stop ) . '</p>';
		if ( isset( $json->presenter_photo ) or isset($json->project_photo) or isset($json->presentation_photo) or isset($json->performer_photo) or has_post_thumbnail( get_the_ID() ) ) {
			if ( get_the_post_thumbnail() ) {
				$output .= '<div class="pull-left thumbnail"><a href="';
				$output .= get_permalink( $sched_post ) . '">';
				$output .= get_the_post_thumbnail( get_the_ID(), 'schedule-thumb' );
				$output .= '</a></div>';
			} elseif ( isset( $json->presenter_photo[0] ) && !is_array( $json->presenter_photo[0] ) && strlen( $json->presenter_photo[0] ) > 5 ) {
				$output .= '<div class="pull-left thumbnail"><a href="';
				$output .= get_permalink( $sched_post ) . '">';
				$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->presenter_photo[0], 140, 140 ) . '" alt="' . esc_attr( get_the_title( $sched_post->ID ) ) .'" />';
				$output .= '</a></div>';
			} else {
				$output .= '<div class="pull-left thumbnail"><a href="';
				$output .= get_permalink( $sched_post ) . '">';
				$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( mf_get_the_maker_image( $json ), 140, 140 ) . '" alt="' . esc_attr( get_the_title( $sched_post->ID ) ) .'" />';
				$output .= '</a></div>';
			}
		}
		$output .= '</td>';
		$output .= '<td>';
		$output .= '<h3><a href="' . get_permalink( $sched_post ) . '">' . get_the_title( $sched_post->ID ) . '</a></h3>';
		if ( !empty( $json->presenter_name ) ) {
			$names = $json->presenter_name;
			$names_output = '';
			foreach ( $names as $name ) {
				$names_output .= ', ' . $name;
			}
			$output .= '<h4>' . substr($names_output, 2) . '</h4>';
		}
		if ( !empty($json->short_description ) ) {
			$output .= Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->short_description, "\n" ) ) ) ) ;
		} elseif ( !empty($json->public_description ) ) {
			$output .= Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->public_description, "\n" ) ) ) ) ;
		}

		if ( ! empty( $meta['mfei_coverage'][0] ) )
			$output .= '<p><a href="' . esc_url( $meta['mfei_coverage'][0] ) . '" class="btn btn-mini btn-primary">Watch Video</a></p>';
		// $output .= '<ul class="unstyled">';
		// $terms = get_the_terms( $sched_post->ID, array( 'category', 'post_tag' ) );
		// if (!empty($terms)) {
		// 	$output .= '<li>Topics: ';
		// 	$the_terms = '';
		// 	foreach ($terms as $idx => $term) {
		// 		$the_terms .= ', <a href="' . esc_url( get_term_link( $term ) ) . '">' . $term->name . '</a>';
		// 	}
		// 	$output .= substr( $the_terms, 2 );
		// 	$output .= '</li>';
		// }
		// $output .= '</ul>';
		$output .= '</td>';
		$output .= '</tr>';
	endwhile;
	$output .= '</table>';
	endif;
	wp_reset_postdata();

	// Roll the schedule for Sunday.

	if ( $query->found_posts >= 1 ) :
	$query = wp_cache_get( $location . '_sunday_schedule' );
	if( $query == false ) {
		$args = array( 
			'location' 		=> sanitize_title( $term->slug ),
			'post_type'		=> 'event-items',
			'orderby' 		=> 'meta_value', 
			'meta_key'		=> 'mfei_start',
			'order'			=> 'asc',
			'posts_per_page'=> '30',
			'faire'			=> $faire,
			'meta_query' => array(
				array(
					'key' 	=> 'mfei_day',
					'value'	=> 'Sunday'
			   )
			)
			);
		$query = new WP_Query( $args );
		wp_cache_set( $location . '_sunday_schedule', $query, '', 300 );
	}
	$output .= '<table class="table table-striped table-bordered table-schedule">';
	if ( $faire == 'world-maker-faire-new-york-2013' ) {
		$output .= '<thead><tr><th colspan="2">September 22nd, 2013</th></tr></thead>';
	}
	while ( $query->have_posts() ) : $query->the_post();
		$meta = get_post_meta( get_the_ID());
		$sched_post = get_post( $meta['mfei_record'][0] );
		$json = json_decode( str_replace( "\'", "'", $sched_post->post_content ) );
		$day = ($meta['mfei_day'][0]) ? $meta['mfei_day'][0] : '' ;
		$start = ($meta['mfei_start'][0]) ? $meta['mfei_start'][0] : '' ;
		$stop = ($meta['mfei_stop'][0]) ? $meta['mfei_stop'][0] : '' ;
		$output .= '<tr>';
		$output .= '<td width="150">';
		$output .= '<h5>' . esc_html( $day ) . '</h5>';
		$output .= '<p>' . esc_html( $start ) . ' &mdash; ' . esc_html( $stop ) . '</p>';
		if ( isset( $json->presenter_photo ) or isset($json->project_photo) or isset($json->presentation_photo) or isset($json->performer_photo) or has_post_thumbnail( get_the_ID() ) ) {
			if ( get_the_post_thumbnail() ) {
				$output .= '<div class="pull-left thumbnail"><a href="';
				$output .= get_permalink( $sched_post ) . '">';
				$output .= get_the_post_thumbnail( get_the_ID(), 'schedule-thumb' );
				$output .= '</a></div>';
			} elseif ( isset( $json->presenter_photo[0] ) && !is_array( $json->presenter_photo[0] ) && strlen( $json->presenter_photo[0] ) > 5 ) {
				$output .= '<div class="pull-left thumbnail"><a href="';
				$output .= get_permalink( $sched_post ) . '">';
				$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->presenter_photo[0], 140, 140 ) . '" alt="' . esc_attr( get_the_title( $sched_post->ID ) ) .'" />';
				$output .= '</a></div>';
			} else {
				$output .= '<div class="pull-left thumbnail"><a href="';
				$output .= get_permalink( $sched_post ) . '">';
				$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( mf_get_the_maker_image( $json ), 140, 140 ) . '" alt="' . esc_attr( get_the_title( $sched_post->ID ) ) .'" />';
				$output .= '</a></div>';
			}
		}
		$output .= '</td>';
		$output .= '<td>';
		$output .= '<h3><a href="' . get_permalink( $sched_post ) . '">' . get_the_title( $sched_post->ID ) . '</a></h3>';
		if ( !empty( $json->presenter_name ) ) {
			$names = $json->presenter_name;
			$names_output = '';
			foreach ( $names as $name ) {
				$names_output .= ', ' . $name;
			}
			$output .= '<h4>' . substr($names_output, 2) . '</h4>';
		}
		if ( !empty($json->short_description ) ) {
			$output .= Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->short_description, "\n" ) ) ) ) ;
		} elseif ( !empty($json->public_description ) ) {
			$output .= Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->public_description, "\n" ) ) ) ) ;
		}
		
		if ( ! empty( $meta['mfei_coverage'][0] ) )
			$output .= '<p><a href="' . esc_url( $meta['mfei_coverage'][0] ) . '" class="btn btn-mini btn-primary">Watch Video</a></p>';
		// $output .= '<ul class="unstyled">';
		// $terms = get_the_terms( $sched_post->ID, array( 'category', 'post_tag' ) );
		// if (!empty($terms)) {
		// 	$output .= '<li>Topics: ';
		// 	$the_terms = '';
		// 	foreach ($terms as $idx => $term) {
		// 		$the_terms .= ', <a href="' . get_term_link( $term ) . '">' . $term->name . '</a>';
		// 	}
		// 	$output .= substr( $the_terms, 2 );
		// 	$output .= '</li>';
		// }
		// $output .= '</ul>';
		$output .= '</td>';
		$output .= '</tr>';
	endwhile;
	$output .= '</table>';
	endif;
	wp_reset_postdata();
	return $output;
}

add_shortcode('mf_full_schedule', 'mf_schedule');


function mf_get_scheduled_item( $the_ID ) {
	$query = wp_cache_get( $the_ID . '_saturday_schedule' );
	if( $query == false ) {
		$args = array( 
			'post_type'		=> 'event-items',
			'orderby' 		=> 'meta_value', 
			'meta_key'		=> 'mfei_start',
			'order'			=> 'asc',
			'posts_per_page'=> '30',
			'meta_query' => array(
				array(
					'key' 	=> 'mfei_record',
					'value'	=> $the_ID
				),
				array(
					'key' 	=> 'mfei_day',
					'value'	=> 'Saturday'
				)
			)
			);
		$query = new WP_Query( $args );
		wp_cache_set( $the_ID . '_saturday_schedule', $query, '', 300 );
	}
	$output = '<table class="hide schedule table table-striped table-bordered">';
	if ($query->found_posts >= 1 ) {
		// Set a variable we can use to see if Saturday events were found for the Sunday query
		$has_saturday_events = true;
		$output .= '<thead><tr class="info"><td><strong>Day</strong></td><td><strong>Start Time</strong></td><td><strong>End Time</strong></td><td><strong>Locations</strong></td><td class="no-video"><strong>Video Coverage</strong></td></tr></thead><tbody>';
		while ( $query->have_posts() ) : $query->the_post();
			$meta = get_post_meta( get_the_ID());
			$sched_post = get_post( $meta['mfei_record'][0] );
			$json = json_decode( str_replace( "\'", "'", $sched_post->post_content ) );
			$day = ($meta['mfei_day'][0]) ? $meta['mfei_day'][0] : '' ;
			$start = ($meta['mfei_start'][0]) ? $meta['mfei_start'][0] : '' ;
			$stop = ($meta['mfei_stop'][0]) ? $meta['mfei_stop'][0] : '' ;
			$coverage = ( !empty( $meta['mfei_coverage'][0] ) ) ? $meta['mfei_coverage'][0] : '';
			$output .= '<tr>';
			$output .= '<td>' . esc_html( $day ) . '</td>';
			$output .= '<td>' . esc_html( $start ) . '</td>';
			$output .= '<td>' . esc_html( $stop ) . '</td>';
			$output .= '<td>' . get_the_term_list( get_the_ID(), 'location' ) . '</td>';
			if ( ! empty( $coverage ) ) {
				$output .= '<td class="has-video"><a href="' . esc_url( $coverage ) . '" class="btn btn-mini btn-primary">Watch Video</a></td>';
			} else {
				$output .= '<td class="no-video"></td>';
			}
			$output .= '</tr>';
		endwhile;
	}
	wp_reset_postdata();
	$query = wp_cache_get( $the_ID . '_sunday_schedule' );
	if( $query == false ) {
		$args = array( 
			'post_type'		=> 'event-items',
			'orderby' 		=> 'meta_value', 
			'meta_key'		=> 'mfei_start',
			'order'			=> 'asc',
			'posts_per_page'=> '30',
			'meta_query' => array(
				array(
					'key' 	=> 'mfei_record',
					'value'	=> $the_ID
				),
				array(
					'key' 	=> 'mfei_day',
					'value'	=> 'Sunday'
				)
			)
			);
		$query = new WP_Query( $args );
		wp_cache_set( $the_ID . '_sunday_schedule', $query, '', 300 );
	}
	if ($query->found_posts >= 1 ) {
		if ( ! isset( $has_saturday_events ) ) {
			$output .= '<thead><tr class="info"><td><strong>Day</strong></td><td><strong>Start Time</strong></td><td><strong>End Time</strong></td><td><strong>Locations</strong></td><td class="no-video"><strong>Video Coverage</strong></td></tr></thead><tbody>';
		}
		while ( $query->have_posts() ) : $query->the_post();
			$meta = get_post_meta( get_the_ID());
			$sched_post = get_post( $meta['mfei_record'][0] );
			$json = json_decode( str_replace( "\'", "'", $sched_post->post_content ) );
			$day = ($meta['mfei_day'][0]) ? $meta['mfei_day'][0] : '' ;
			$start = ($meta['mfei_start'][0]) ? $meta['mfei_start'][0] : '' ;
			$stop = ($meta['mfei_stop'][0]) ? $meta['mfei_stop'][0] : '' ;
			$coverage = ( isset( $meta['mfei_coverage'][0] ) ) ? $meta['mfei_coverage'][0] : '';
			$output .= '<tr>';
			$output .= '<td>' . esc_html( $day ) . '</td>';
			$output .= '<td>' . esc_html( $start ) . '</td>';
			$output .= '<td>' . esc_html( $stop ) . '</td>';
			$output .= '<td>' . get_the_term_list( get_the_ID(), 'location' ) . '</td>';
			if ( ! empty( $coverage ) ) {
				$output .= '<td class="has-video"><a href="' . esc_url( $coverage ) . '" class="btn btn-mini btn-primary">Watch Video</a></td>';
			} else {
				$output .= '<td class="no-video">No Video Available</td>';
			}
			$output .= '</tr>';
		endwhile;
	}
	$output .= '<tbody></table>';
	return $output;
	wp_reset_postdata();

}

/**
 * The Video/Image Gallery
 *
 * Wanted to extend our Bootstrap Slideshow so that you could put in Post IDs and get back a slideshow.
 * Basically the same thing that the default slideshow does, so why not use that!
 *
 * @since 1.0
 *
 * @param array $attr Attributes of the shortcode.
 * @return string HTML content to display gallery.
 */
function make_video_photo_gallery( $attr ) {

	$posts = explode( ',', $attr['ids'] );

	$rand = mt_rand( 0, get_the_ID() );

	global $post;

	$output = '<div id="myCarousel-' . $rand . '" class="carousel slide" data-interval=""><div class="carousel-inner">';
	$i = 0;

	foreach( $posts as $post ) {
		if ( strpos( $post, 'youtu' ) ) {
			$youtube = true;
		} else {
			$post = get_post( $post );
			setup_postdata( $post );
			$youtube = false;
		}
		$i++;

		if ($i == 1) {
			$output .= '<div class="item active">';	
		} else {
			$output .= '<div class="item">';
		}
		if ( $youtube == false ) {
			if ( get_post_type() == 'video' ) {
				$url = get_post_meta( get_the_ID(), 'Link', true );
				$output .= do_shortcode('[youtube='. esc_url( $url ) .'&w=620]');
			} else {
				$output .= wp_get_attachment_image( get_the_ID(), 'medium' );
			}
			if (isset($post->post_title)) {
				$output .= '<div class="carousel-caption" style="position:relative;">';
				$output .= '<h4>' . get_the_title() . '</h4>';
				$output .= ( isset( $post->post_excerpt ) ) ? Markdown( wp_kses_post( $post->post_excerpt ) ) : '';
				$output .= '</div>';
			}
		} else {
			$output .= do_shortcode('[youtube='. esc_url( $post ) .'&w=620]');
		}
		$output .= '</div>';
		
	} //foreach
	wp_reset_postdata();
	$output .= '</div>
		<a class="topper left carousel-control" href="#myCarousel-' . $rand . '" data-slide="prev">‹</a>
		<a class="topper right carousel-control" href="#myCarousel-' . $rand . '" data-slide="next">›</a>
	</div>';
	$output .= '<div class="clearfix"></div>';
	return $output;
}

add_shortcode( 'video_gallery', 'make_video_photo_gallery' );
