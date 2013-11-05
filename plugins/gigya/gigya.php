<?php

	/**
	 * Gigya!
	 *
	 * A class that will integrate all the social login fun stuff good times.
	 *
	 * @since  SPRINT_NAME
	 */
	
	/**
	 * Set up some Constants
	 */
	define( 'MAKE_GIGYA_URL', get_template_directory_uri() . '/plugins/gigya' );


	/**
	 * Load the Gigya Socialize SDK
	 *
	 * @since  SPRINT_NAME
	 */
	if ( ! class_exists( 'GSRequest' ) )
		include_once( 'includes/GSSDK.php' );


	/**
	 * The guts.
	 *
	 * This little guy controls and loads all that is Gigya.
	 *
	 * @since  SPRINT_NAME
	 */
	class Make_Gigya {

		public function __construct() {
			// Load our GSSDK
			add_action( 'wp_head', array( $this, 'socialize_api' ), 999 );

			// Load our resources
			add_action( 'wp_enqueue_scripts', array( $this, 'load_resources' ), 30 );

			// Process our ajax requests
			 add_action( 'wp_ajax_nopriv_ajaxlogin', array( $this, 'ajax_login' ) );
		}

		/**
		 * Spits out the Gigya API for the socialize plugin
		 * Sadly, we have to manually echo this to wp_head() because Gigya requires the socialize.js API key to be passed with options wrapped in the same script tag.
		 * 
		 * @return html
		 * @since  SPRINT_NAME
		 */
		public function socialize_api() { ?>
			<script src="http://cdn.gigya.com/JS/socialize.js?apikey=3_bjlVxC0gadZ6dN9q8K1ePCbDHtATT8OgJxZJcsr0ty8o5oKnvjI_G2DOZ1YasJHF">{ enabledProviders: '*' }</script>
		<?php }
		


		/**
		 * Let's add all of our resouces to make our magic happen.
		 * Any scripts, we should include in the footer or else things will conflict due to how we have to load the socialize API file... #facepalm
		 *
		 * @since  SPRINT_NAME
		 */
		public function load_resources() {
			wp_enqueue_script( 'make_socialize', MAKE_GIGYA_URL . '/js/socialize.js', array( 'jquery' ), '0.1', true );
			wp_localize_script( 'make_socialize', 'make_gigya', array(
				'ajax' => admin_url( 'admin-ajax.php' ),
				'loading' => 'Loading',
				'secure_it' => wp_create_nonce( 'ajax-login-nonce' ),
			) );
		}


		public function ajax_login() {
			var_dump($_POST);
			// // Check our nonce and make sure it's correct
			// check_ajax_referer( 'ajax-login-nonce', 'nonce' );

			// // Hold onto the submission data
			// $data = array();

			// if ( isset( $_POST['request'] ) && $_POST['request'] == 'login' ) {
			// 	var_dump($_POST);
			// }
		}

	}
	$make_gigya = new Make_Gigya();

