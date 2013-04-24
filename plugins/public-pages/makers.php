<?php
/**
 * Public Page Functions for Makers
 */

function mf_convert_newlines( $str, $replace = '<br />' ) {
	$s = array('nn-', ' nn', '.nn', '<br />rn');
	return str_replace($s, $replace, $str);
}

/**
 * Loop through the locations, and build the breadcrumb navigation for locations.
 */
function mf_location( $id ) {
	$locs = get_the_terms( $id, 'location' );
	$count = count($locs);
	if ( empty($locs) )  {
		return;
	}
	$output = '<ul class="breadcrumb">';
	$i = 0;
	foreach ( $locs as $loc ) {
		$i++;
		$output .= '<li>';
		$link = get_term_link( $loc );
		if ( !is_wp_error( $link ) ) {
			$output .= '<a href="' . esc_url( $link ) . '">';
			$output .= $loc->name;
			$output .= '</a>';
		} else {
			$output .= $loc->name;
		}
		if ( $i != $count ) {
			$output .= ' <span class="divider">/</span>';
		}
		$output .= '</li>';
	}
	$output .= '</ul>';
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
		
		echo ( $json->public_description ) ? Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->public_description, "\n" ) ) ) ) : null;
		
		if ( $json->project_website || $json->project_website ) {
			echo '<hr>';
			echo ( !empty( $json->project_website ) ) ? '<a class="btn btn-mini btn-info" href="'. esc_url( $json->project_website ) . '"><i class="icon-home icon-white"></i> Website</a>' : null ;
			echo ' ';
			echo ( !empty( $json->project_website ) ) ? '<a class="btn btn-mini btn-info" href="'. esc_url( $json->project_website ) . '"><i class="icon-facetime-video icon-white"></i> Website</a>' : null ;
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
			if (!empty($json->name)) {
				echo '<h3>About the Maker</h3>';
				echo '<div class="media">';
				if (!empty($json->maker_photo)) {
					echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->maker_photo, 130, 130, true ) . '" class="media-object thumbnail pull-left"/>';
				}
				echo '<div class="media-body">';
				echo '<h4>' . wp_kses_post( $json->name ) . '</h4>';
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
					echo '<a class="btn btn-mini btn-info" href="'.esc_url( $json->group_website ) . '"><i class="icon-home icon-white"></i> Website</a>';
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
					if ( isset( $json->m_maker_photo[ $i ] ) ) {
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
		
		echo ( $json->public_description ) ? Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->public_description, "\n" ) ) ) ) : null;
		
		if ( $json->presentation_website || $json->video) {
			echo '<hr>';
			echo ( !empty( $json->presentation_website ) ) ? '<a class="btn btn-mini btn-info" href="'. esc_url( $json->presentation_website ) . '"><i class="icon-home icon-white"></i> Website</a>' : null ;
			echo ' ';
			echo ( !empty( $json->video ) ) ? '<a class="btn btn-mini btn-info" href="'. esc_url( $json->video ) . '"><i class="icon-facetime-video icon-white"></i> Website</a>' : null ;
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

		if (!empty($json->name)) {
			echo '<h3>About the Speaker</h3>';
			echo '<div class="media">';
			if (!empty($json->presenter_photo_thumb)) {
				$url = $json->presenter_photo_thumb;
				$url = add_query_arg( 'w', 130, $url );
				echo '<img src="'. esc_url( $url ) . '" class="thumbnail pull-left media-object" />';
			}	
			echo '<div class="media-body">';
			echo '<h4>' . wp_kses_post( $json->name ) . '</h4>';
			echo ( $json->presenter_bio[0] ) ? Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->presenter_bio[0], "\n" ) ) ) ) : null;
			
			echo '</div></div>';
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
				echo '<a class="btn btn-mini btn-info" href="'.esc_url( $json->group_website ) . '"><i class="icon-home icon-white"></i> Website</a>';
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
		
		echo ( !empty($json->public_description) ) ? Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $json->public_description, "\n" ) ) ) ) : null;
		
		if ( $json->performer_website || $json->performer_video ) {
			echo '<hr>';
			echo ( !empty( $json->performer_website ) ) ? '<a class="btn btn-mini btn-info" href="'. esc_url( $json->performer_website ) . '"><i class="icon-home icon-white"></i> Website</a>' : null ;
			echo ' ';
			echo ( !empty( $json->performer_video ) ) ? '<a class="btn btn-mini btn-info" href="'. esc_url( $json->performer_video ) . '"><i class="icon-facetime-video icon-white"></i> Website</a>' : null ;
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
}

/**
 * Function to spit out Featured Makers
 */
add_shortcode( 'featured', 'mf_featured_makers' );
function mf_featured_makers() {
	$args = array( 
		'meta_key'		=> '_ef_editorial_meta_checkbox_featured', 
		'meta_value'	=> true,
		'post_type'		=> 'mf_form',
		'post_status'	=> 'accepted',
		);
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
		if (!empty($json->presenter_photo)) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->presenter_photo, 620, 400, true ) . '" class=""/>';
		} elseif (!empty($json->project_photo)) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->project_photo, 620, 400, true ) . '" class="" />';
		} elseif (!empty($json->performer_photo)) {
			$output .= '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->performer_photo, 620, 400, true ) . '" class="" />';
		} else {
			
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
		$output .= '</div></div>';
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
		$json = json_decode( str_replace( "\'", "'", $content ) );
		echo '<div class="row"><div class="span2">';
		mf_the_maker_image( $json );
		echo '</div><div class="span6">';
		the_title( '<h3><a href="' . get_permalink() . '">', '</a></h3>' );
		if (!empty($json->public_description)) {
			echo Markdown( wp_kses_post( $json->public_description ) ) ;
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

function mf_merged_terms() {

	$args = array(
		'hide_empty'	=> false,
		'exclude'		=> array( '1' ),
		);
	$cats = get_terms( array('category', 'post_tag' ), $args );
	$output = '<ul class="columns">';
	foreach ($cats as $cat) {
		$output .= '<li><a href="' . get_term_link( $cat ) . '">' . $cat->name . '</a></li>';
	}
	$output .= '</ul>';
	return $output;
}

add_shortcode('mf_cat_list', 'mf_merged_terms');


function mf_schedule() {
	$loc = get_terms( 'location', array(
		'hide_empty' => true,
		) 
	);
	foreach ($loc as $location) {
		$args = array( 
			'location' 		=> $location->name,
			'post_type'		=> 'event-items',
			'orderby' 		=> 'meta_value', 
			'meta_key' 		=> strtotime('mfei_start')
			);
		$query = new WP_Query( $args );
		echo '<h2>' . $location->name . '</h2>';
		echo '<table class="table table-striped table-bordered">';
		while ( $query->have_posts() ) : $query->the_post();
		$meta = get_post_meta( get_the_ID());
		$sched_post = get_post( $meta['mfei_record'][0] );
		$json = json_decode( str_replace( "\'", "'", $sched_post->post_content ) );
		$day = ($meta['mfei_day'][0]) ? $meta['mfei_day'][0] : null ;
		$start = ($meta['mfei_start'][0]) ? $meta['mfei_start'][0] : null ;
		$stop = ($meta['mfei_stop'][0]) ? $meta['mfei_stop'][0] : null ;
		echo '<tr>';
		echo '<td width="150">';
		echo '<h5>' . $day . '</h5>';
		echo '<p>' . $start . ' &mdash; ' . $stop . '</p>';
		echo '<div class="pull-left thumbnail">';
		mf_the_maker_image( $json );
		echo '</div>';
		echo '</td>';
		echo '<td>';
		echo '<h3>' . get_the_title( $sched_post->ID ) . '</h3>';
		if (!empty($json->public_description)) {
			echo Markdown( wp_kses_post( $json->public_description ) ) ;
		}
		echo '<ul class="unstyled">';
		$tags = get_the_terms( $sched_post->ID, 'post_tag' );
		$cats = get_the_terms( $sched_post->ID, 'category' );
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
		echo '</td>';
		echo '</tr>';
		endwhile;
		echo '</table>';
	}

}

add_shortcode('schedule', 'mf_schedule');