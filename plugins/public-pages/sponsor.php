<?php
/**
 * Sponsor Functions
 */
function mf_sponsor_carousel( $category_name ) {
	// Get all of the sponsor from the links
	$sponsors = get_bookmarks( array( 'orderby' => 'rating', 'category_name' => $category_name ) );

	// Split them into chucks of two
	$sponsors = array_chunk( $sponsors, 2, true );
	foreach ($sponsors as $idx => $sponsor) {
		if ( $idx == 0 ) {
			echo '<div class="item active">';
		} else {
			echo '<div class="item">';
		}
		echo '<div class="row-fluid">';
		foreach ($sponsor as $spon) {
			echo '<div class="span6"><a href="' . esc_url( $spon->link_url ) . '"><img src="' . wpcom_vip_get_resized_remote_image_url( $spon->link_image, 146, 121 ) . '" alt="' . esc_attr( $spon->link_name ) . '"></a></div>';	
		}
		echo '</div></div>';
	}
}