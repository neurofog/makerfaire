<?php
/**
 * Sponsor Functions
 */
function mf_sponsor_carousel( $category_name ) {
	// Get all of the sponsor from the links
	$sponsors = get_bookmarks( array( 'orderby' => 'rating', 'category_name' => $category_name ) );

	// Split them into chucks of two
	$sponsors = array_chunk( $sponsors, 2, true );

	// Get the output started.
	$output = '';

	// Loop through each block of sponsors
	foreach ($sponsors as $idx => $sponsor) {
		if ( $idx == 0 ) {
			$output .= '<div class="item active">';
		} else {
			$output .= '<div class="item">';
		}
		$output .= '<div class="row-fluid">';

		// Loop through the individual sponsors
		foreach ($sponsor as $spon) {
			$output .= '<div class="span6"><div class="thumb"><a href="' . esc_url( $spon->link_url ) . '"><img src="' . wpcom_vip_get_resized_remote_image_url( $spon->link_image, 125, 105 ) . '" alt="' . esc_attr( $spon->link_name ) . '"></a></div></div>';	
		}
		$output .= '</div></div>';
	}

	return $output;
}