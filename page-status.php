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

echo mf_application_stats( mf_get_post_count() );