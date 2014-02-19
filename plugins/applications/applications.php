<?php
	
	/**
	 * Contains the new and improved Maker Faire Application Forms.
	 *
	 * A programtic way to build comprehensive online forms.
	 *
	 * @author  Cole Geissinger <cgeissinger@makermedia.com>
	 * @version  0.1
	 * @since    0.1
	 */
	

	// Load our primary class
	if ( ! class_exists( 'MM_Application' ) )
		require_once( 'classes/class.application.php' );

	// Load our helper functions if everything is setup.
	if ( class_exists( 'MM_Application' ) )
		require_once( 'helpers/helpers.applications.php' );

	// Load our Exhibit form options and settings
	require_once( 'classes/class.exhibits.php' );

	/**
	 * Load some styles outside of the class. This is to be completly separate to allow devs to add their own styles
	 * @return void
	 *
	 * @version 0.1
	 * @since   0.1
	 */
	function mm_applications_resources() {
		// if ( is_application_page_template() ) {
			wp_enqueue_style( 'mm-applications-default', get_stylesheet_directory_uri() . '/plugins/applications/assets/css/application-forms.css' );
		// }
	}
	add_action( 'wp_enqueue_scripts', 'mm_applications_resources' );

