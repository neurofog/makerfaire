<?php
/**
 * Public Page Functions for Makers
 */

function mf_location( $id ) {
	$locs = get_the_terms( $id, 'location' );
	$output = '<ul class="breadcrumb">';
	$i = 0;
	$count = count($locs);
	foreach ( $locs as $loc ) {
		$i++;
		$output .= '<li>';
		$output .= '<a href="' . get_term_link( $loc ) . '">';
		$output .= $loc->name;
		$output .= '</a>';
		if ( $i == $count - 1 ) {
			$output .= ' <span class="divider">/</span>';
		}
		$output .= '</li>';
	}
	$output .= '</ul>';
	return $output;
}

function mf_better_name( $str ) {
	if ( $str == '2013_bayarea' ) {
		return 'Maker Faire Bay Area 2013';
	} elseif ( $str == '2013_newyork' ) {
		return 'World Maker Faire New York 2013';
	}
}