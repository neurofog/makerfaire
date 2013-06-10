<?php
/**
 * Get the amount of new posts over the last five days for pending and accepted Maker Faire Applications
 */
function mf_get_post_count( $post_types = array( 'mf_form', 'post' ), $status = array( 'pending', 'accepted' ) ) {
	$output = array();
	foreach ($post_types as $post_type ) {
		$accepted = array();
		for ( $count = 0; $count <= 10; $count++ ) {
			$query = wp_cache_get( 'today_posts_' . $count );
			if ( $query == false ) {
				$time = date( 'F jS, Y', strtotime( '-' . $count . ' days' ) );
				$date = new DateTime( $time );
				$args = array(
					'year'			=> $date->format('Y'),
					'monthnum' 		=> $date->format('m'),
					'day'			=> $date->format('d'),
					'post_type'		=> $post_type,
					'post_status'	=> 'accepted'
					);
				$query = new WP_Query( $args );
				// var_dump( $query->query );
				wp_cache_set( 'today_posts_' . $count, $query, '', 300 );
				$the = array( 'title' => $time, 'value' => $query->post_count );
				array_push( $accepted, $the );
				$output[ $post_type ] = $accepted;
			}
		}
	}
	var_dump( $output );
	$datasequences = array( 
		array( 
			'title' => 'Accepted',
			'datapoints' => $accepted
		), array (
			'title' => 'Pending', 
			// 'datapoints' => $pending
		)
	);
	$output = $datasequences;
	return $output;
}
/**
 * Generate the array of data for Status Board.
 */
function mf_application_stats( $output ) {

	$graph = array( 
		'graph' => array( 
			'title' => 'Maker Faire Applications',
			'datasequences' => $output
			)
		);
	$json = json_encode( $graph );
	return $json;
}