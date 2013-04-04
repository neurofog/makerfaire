<?php
/**
 * Public Page Functions for Makers
 */

/**
 * Loop through the locations, and build the breadcrumb navigation for locations.
 */
function mf_location( $id ) {
	$locs = get_the_terms( $id, 'location' );
	$output = '<ul class="breadcrumb">';
	$i = 0;
	$count = count($locs);
	foreach ( $locs as $loc ) {
		$i++;
		$output .= '<li>';
		$link = get_term_link( $loc );
		if ( is_wp_error( $link ) ) {
			$output .= '<a href="' . esc_url( $link ) . '">';
			$output .= $loc->name;
			$output .= '</a>';
		} else {
			$output .= $loc->name;
		}
		if ( $i == $count - 1 ) {
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