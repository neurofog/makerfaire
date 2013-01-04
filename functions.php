<?php

require_once( WP_CONTENT_DIR . '/themes/vip/plugins/vip-init.php' );

if ( function_exists( 'wpcom_vip_enable_opengraph' ) ) {
	wpcom_vip_enable_opengraph();
}

if ( function_exists( 'vip_contrib_add_upload_cap' ) ) {
	vip_contrib_add_upload_cap();
}

if ( function_exists( 'wpcom_vip_sharing_twitter_via' ) ) {
	wpcom_vip_sharing_twitter_via( 'make' );
}


function make_enqueue_jquery() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'make', get_stylesheet_directory_uri() . '/style.css' );
	wp_enqueue_script( 'make-bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.js', array( 'jquery' ) );
	wp_enqueue_style( 'make-bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.css' );
	wp_enqueue_style( 'makerfaire', get_stylesheet_directory_uri() . '/css/new.css' );
}

add_action( 'wp_enqueue_scripts', 'make_enqueue_jquery' );


function makerfaire_get_news() {

	$url = 'http://blog.makezine.com/maker-faire-news/';
	$output = wpcom_vip_file_get_contents( $url, 3, 60*60,  array( 'obey_cache_control_header' => false ) );
	return $output;
}

add_shortcode('news', 'makerfaire_get_news');