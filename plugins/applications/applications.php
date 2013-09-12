<?php
	
	/**
	 * Contains the new and improved Maker Faire Application Forms.
	 *
	 * These forms are built on and customized from Cole Geissinger's custom form builder class, FormFlow. https://github.com/colegeissinger/formflow
	 *
	 * @version  0.1
	 * @since    0.1
	 * @author Cole Geissinger <cgeissinger@makermedia.com>
	 */
	

	// Load our primary class
	if ( ! class_exists( 'MF_Applications' ) )
		require_once( 'classes/class.applications.php' );

	// Load our helper functions if everything is setup.
	if ( class_exists( 'MF_Applications' ) )
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
	function mf_applications_resources() {
		wp_enqueue_style( 'mf-applications-default', get_stylesheet_directory_uri() . '/plugins/applications/assets/css/application-forms.css' );
	}
	add_action( 'wp_enqueue_scripts', 'mf_applications_resources' );

