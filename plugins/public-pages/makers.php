<?php
/**
 * Public Page Functions for Makers
 */

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

/**
 * Parse the type of Maker, and then build the page.
 */
function mf_public_blurb( $json ) {

	$type = $json->form_type;

	if ($type == 'exhibit') {
		
		if (!empty($json->project_photo)) {
			echo '<img src="'. wpcom_vip_get_resized_remote_image_url( $json->project_photo, 610, 400 ) . '" class="thumbnail" />';
		}
		echo '<hr>';
		if (!empty($json->public_description)) {
			if (function_exists('Markdown')) {
				echo Markdown( wp_kses_post( $json->public_description ) ) ;
			} else {
				echo '<p>' . wp_kses_post( $json->public_description ) . '</p>';
			}
			
		}
		
		if (!empty($json->project_website)) {
			echo '<a class="btn btn-mini btn-info" href="'. esc_url( $json->project_website ) . '"><i class="icon-home icon-white"></i> Website</a>';
		}
		if (!empty($json->project_video)) {
			echo '<a class="btn btn-mini btn-info" href="'. esc_url( $json->project_video ) . '"><i class="icon-facetime-video icon-white"></i> Video</a>';
		}

		if (!empty($json->name)) {
			echo '<h3>About the Makers</h3>';
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
	} elseif ($type == 'presenter') {
		if (!empty($json->presentation_photo)) {
			echo '<img src="'. wpcom_vip_get_resized_remote_image_url( $json->presentation_photo, 610, 400 ) . '" class="thumbnail" />';
		}
		echo '<hr>';
		if (!empty($json->public_description)) {
			if (function_exists('Markdown')) {
				echo Markdown( wp_kses_post( $json->public_description ) ) ;
			} else {
				echo '<p>' . wp_kses_post( $json->public_description ) . '</p>';
			}
			
		}
		
		if (!empty($json->project_website)) {
			echo '<a class="btn btn-mini btn-info" href="'. esc_url( $json->presentation_website ) . '"><i class="icon-home icon-white"></i> Website</a>';
		}
		if (!empty($json->project_video)) {
			echo '<a class="btn btn-mini btn-info" href="'. esc_url( $json->presentation_website ) . '"><i class="icon-facetime-video icon-white"></i> Video</a>';
		}
		if (!empty($json->name)) {
			echo '<h3>About the Speaker</h3>';
			echo '<div class="media">';
			if (!empty($json->presenter_photo)) {
				echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->presenter_photo, 130, 130, true ) . '" class="media-object thumbnail pull-left"/>';
			}	
			echo '<div class="media-body">';
			echo '<h4>' . wp_kses_post( $json->name ) . '</h4>';
			if (function_exists('Markdown')) {
				echo $json->public_description ? Markdown( wp_kses_post( $json->public_description ) ) : '';
			} else {
				echo '<p>' . wp_kses_post( $json->public_description ) . '</p>';
			}
			
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
			echo '<img src="'. wpcom_vip_get_resized_remote_image_url( $json->performer_photo, 610, 400 ) . '" class="thumbnail" />';
		}
		echo '<hr>';
		if (!empty($json->public_description)) {
			if (function_exists('Markdown')) {
				echo Markdown( wp_kses_post( $json->public_description ) ) ;
			} else {
				echo '<p>' . wp_kses_post( $json->public_description ) . '</p>';
			}
			
		}
		
		if (!empty($json->project_website)) {
			echo '<a class="btn btn-mini btn-info" href="'. esc_url( $json->performer_website ) . '"><i class="icon-home icon-white"></i> Website</a>';
		}
		if (!empty($json->project_video)) {
			echo '<a class="btn btn-mini btn-info" href="'. esc_url( $json->performer_video ) . '"><i class="icon-facetime-video icon-white"></i> Video</a>';
		}
		if (!empty($json->name)) {
			echo '<h3>About the Speaker</h3>';
			echo '<div class="media">';
			if (!empty($json->presenter_photo)) {
				echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->performer_photo, 130, 130, true ) . '" class="media-object thumbnail pull-left"/>';
			}	
			echo '<div class="media-body">';
			echo '<h4>' . wp_kses_post( $json->name ) . '</h4>';
			if (function_exists('Markdown')) {
				echo $json->public_description ? Markdown( wp_kses_post( $json->public_description ) ) : '';
			} else {
				echo '<p>' . wp_kses_post( $json->public_description ) . '</p>';
			}
			
			echo '</div></div>';
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
	echo '<div id="featuredMakers" class="carousel slide"><div class="carousel-inner">';
	$i = 1;
	while ( $query->have_posts() ) :
	$query->the_post();
		$content = get_the_content();
		$json = json_decode( str_replace( "\'", "'", $content ) );
		if ($i == 1) {
			echo '<div class="item active ' . get_the_ID() . '">';
		} else {
			echo '<div class="item ' . get_the_ID() . '">';
		}
		if (!empty($json->presenter_photo)) {
			echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->presenter_photo, 620, 400, true ) . '" class=""/>';
		} elseif (!empty($json->project_photo)) {
			echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->project_photo, 620, 400, true ) . '" class="" />';
		} elseif (!empty($json->performer_photo)) {
			echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->performer_photo, 620, 400, true ) . '" class="" />';
		} else {
			
		}
		echo '<div class="carousel-caption">';
		echo '<h4>' . get_the_title() . '</h4>';
		if ( !empty( $json->public_description ) ) {
			echo $json->public_description ? Markdown( wp_kses_post( $json->public_description ) ) : '';
		}
		echo '</div></div>';
		$i++;
	endwhile;
	echo '</div>
		<a class="left carousel-control" href="#featuredMakers" data-slide="prev">‹</a>
		<a class="right carousel-control" href="#featuredMakers" data-slide="next">›</a>
	</div>';

	wp_reset_postdata();
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