<?php
/*
 * Makers Post Type
 *
 */
class MF_White_House {

	/**
	 * Let's get this going...
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'load_resources' ), 30 );
	}

	public function load_resources() {
		if ( is_page_template( 'page-white-house.php' ) && ! is_admin() ) {
			wp_enqueue_script( 'white-house', get_stylesheet_directory_uri() . '/plugins/white-house/white-house.js', array( 'jquery' ) );
		}
	}
}

$white_house = new MF_White_House();
