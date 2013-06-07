<?php
/**
 * Template Name: Status
 */

header('Content-type: application/json');

// Simple API Keys. Basically, just XOMO needs this, and want to restrict access. Obviously not super secure, but doesn't need to be.
$keys = array(
		'make' => '4eqU!eT74!Exuca',
		'xomo' => 'V_2az7na7RacrAp',
		);
$key = (!empty($_REQUEST['key']) ? $_REQUEST['key'] : null);

// If key doesn't exist, return nothing.
if (!in_array($key, $keys)) {
	header('HTTP/1.0 403 Forbidden');
	return;
}

function mf_get_post_count() {
	$today = getdate();
	$accepted = array();
	$output = array();
	for ( $count = 0; $count <= 10; $count++ ) {
		$query = wp_cache_get( 'today_posts_' . $count );
		if ( $query == false ) {
			$args = array(
				'year'			=> $today["year"],
				'monthnum' 		=> $today["mon"],
				'day'			=> $today["mday"] - $count,
				'post_type'		=> 'mf_form',
				'post_status'	=> 'accepted'
				);
			$query = new WP_Query( $args );
			wp_cache_set( 'today_posts_' . $count, $query, '', 300 );
			$time = date( 'F jS, Y', strtotime( '-' . $count . ' day', strtotime( $today['month'] . '-' . $today['wday'] . '-' . $today['year'] ) ) );
			$the = array( 'title' => $time, 'value' => $query->post_count );
			array_push( $accepted, $the );
		}
	}
	$pending = array();
	for ( $count = 0; $count <= 10; $count++ ) {
		$query = wp_cache_get( 'pending_today_posts_' . $count );
		if ( $query == false ) {
			$args = array(
				'year'			=> $today["year"],
				'monthnum' 		=> $today["mon"],
				'day'			=> $today["mday"] - $count,
				'post_type'		=> 'mf_form',
				'post_status'	=> 'pending'
				);
			$query = new WP_Query( $args );
			wp_cache_set( 'pending_today_posts_' . $count, $query, '', 300 );
			$time = date( 'F jS, Y', strtotime( '-' . $count . ' day', strtotime( $today['month'] . '-' . $today['wday'] . '-' . $today['year'] ) ) );
			$the = array( 'title' => $time, 'value' => $query->post_count );
			array_push( $pending, $the );
		}
	}
	$datasequences = array( 
		array( 
			'title' => 'Pending', 
			'datapoints' => array( $accepted )
		), array (
			'title' => 'Accepted', 
			'datapoints' => array( $pending )
		)
	);
	$output = $datasequences;
	return $output;
}

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

echo mf_application_stats( mf_get_post_count() );