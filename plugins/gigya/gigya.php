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
	// The main URL to the plugin directory
	define( 'MAKE_GIGYA_URL', get_template_directory_uri() . '/plugins/gigya' );

	// Plugin version
	define( 'MAKE_GIGYA_VERSION', '0.1' );

	// Gigya Public Key
	define( 'MAKE_GIGYA_PUBLIC_KEY', get_option( 'make_gigya_public_key' ) );

	// Gigya Private Key
	define( 'MAKE_GIGYA_PRIVATE_KEY', get_option( 'make_gigya_private_key' ) );


	/**
	 * Load the Gigya Socialize SDK
	 *
	 * @since  SPRINT_NAME
	 */
	if ( ! class_exists( 'GSRequest' ) )
		include_once( 'includes/GSSDK.php' );

	/**
	 * Load our admin settings found in Settings > General
	 *
	 * @since  SPRINT_NAME
	 */
	include_once( 'includes/settings.php' );


	/**
	 * Load our helper functions
	 *
	 * @since  SPRINT_NAME
	 */
	if ( ! defined( 'MAKE_HELPERS_SET' ) )
		include_once( 'helpers/helpers.php' );


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
			add_action( 'wp_ajax_nopriv_ajax', array( $this, 'process_ajax' ) );
			add_action( 'wp_ajax_ajax', array( $this, 'process_ajax' ) );

		}


		/**
		 * Spits out the Gigya API for the socialize plugin
		 * Sadly, we have to manually echo this to wp_head() because Gigya requires the socialize.js API key to be passed with options wrapped in the same script tag.
		 * 
		 * @return html
		 * @since  SPRINT_NAME
		 */
		public function socialize_api() { ?>
			<script src="http://cdn.gigya.com/JS/socialize.js?apikey=<?php echo MAKE_GIGYA_PUBLIC_KEY; ?>">{ enabledProviders: 'facebook,twitter,googleplus' }</script>
		<?php }
		

		/**
		 * Let's add all of our resouces to make our magic happen.
		 * Any scripts, we should include in the footer or else things will conflict due to how we have to load the socialize API file... #facepalm
		 *
		 * @since  SPRINT_NAME
		 */
		public function load_resources() {
			wp_enqueue_style( 'make-login', MAKE_GIGYA_URL . '/css/login.css', null, MAKE_GIGYA_VERSION );
			wp_enqueue_script( 'make-socialize', MAKE_GIGYA_URL . '/js/login.js', array( 'jquery' ), MAKE_GIGYA_VERSION, true );
			wp_enqueue_script( 'make-isc-users', MAKE_GIGYA_URL . '/js/users.js', array( 'jquery' ), MAKE_GIGYA_VERSION, true );
			wp_localize_script( 'make-socialize', 'make_gigya', array(
				'ajax' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'loading' => 'Loading',
				'secure_it' => wp_create_nonce( 'ajax-nonce' ),
				'root_path' => esc_url( home_url( '/' ) ),
			) );
		}


		/**
		 * Process' our login to Gigya. This method will take the info from the socialize plugin and pass it through to either login or create a new user
		 * @return json
		 *
		 * @since  SPRINT_NAME
		 */
		public function process_ajax() {
			
			// Check our nonce and make sure it's correct
			check_ajax_referer( 'ajax-nonce', 'nonce' );

			
			// Login das user!
			if ( isset( $_POST['request'] ) && $_POST['request'] == 'login'  ) {

				// Hold onto the submission data
				$data = array();

				// Pass our User Info
				$user = $_POST['object']['profile'];

				$query_params = array(
					'post_type' => 'maker',
					'meta_key' => 'guid',
					'meta_value' => sanitize_text_field( $_POST['object']['UID'] ),
				);

				$users = new WP_Query( $query_params );

				// Check if a user already exists, if not we'll create one.
				if ( $users->posts ) {
					update_post_meta( absint( $users->posts[0]->ID ), 'logged_in', true );
					update_post_meta( absint( $users->posts[0]->ID ), 'last_login', time() );

					$results = array(
						'loggedin' => true,
						'message' => 'Login Successful!',
						'maker' => $users->posts[0]->ID,
					);

				// User didn't exist, let's make one.
				} else {

					// Handle our user name
					if ( ! empty( $user['firstName'] ) && ! empty( $user['lastName'] ) ) {
						$user_name = esc_html( $user['firstName'] ) . ' ' . esc_html( $user['lastName'] );
					} elseif ( ! empty( $user['firstName'] ) && empty( $user['lastName'] ) ) {
						$user_name = esc_html( $user['firstName'] );
					} elseif ( empty( $user['firstName'] ) && empty( $user['lastName'] ) && ! empty( $user['nickname'] ) ) {
						$user_name = esc_html( $user['nickname'] );
					} else {
						$user_name = 'Undefined Username';
					}

					// Our user doesn't exist, that means we need to sync them up, create a maker account and log them in.
					$maker = array(
						'post_title' => sanitize_text_field( $user_name ),
						'post_content' => ( ! empty( $user['bio'] ) ) ? wp_filter_post_kses( $user['bio'] ) : '',
						'post_status' => 'publish',
						'post_type' => 'maker',
					);
					$maker_id = wp_insert_post( $maker );

					// We'll want to add some custom fields. Let's do that.
					// ****************************************************
					// Add the maker email
					$user_email = ( isset( $user['email'] ) && ! empty( $user['email'] ) ) ? sanitize_email( $user['email'] ) : '';
					update_post_meta( absint( $maker_id ), 'email', sanitize_email( $user_email ) );

					// Add the maker photo
					$user_photo = ( isset( $user['photoURL'] ) && ! empty( $user['photoURL'] ) ) ? esc_url ( $user['photoURL'] ) : '';
					update_post_meta( absint( $maker_id ), 'photo_url', esc_url( $user_photo ) );

					// Add the maker website field
					update_post_meta( absint( $maker_id ), 'website', '' );

					// Add the maker video field
					update_post_meta( absint( $maker_id ), 'video', '' );

					// Add the Maker Gigya ID
					update_post_meta( absint( $maker_id ), 'guid', sanitize_text_field( $_POST['object']['UID'] ) );

					// Report our status to pass back to the modal window
					if ( is_wp_error( $maker_id ) ) {
						$results = array(
							'loggedin' => false,
							'message'  => 'A user account could not be created. Please try again.',
							'user' => absint( $maker_id ),
						);
					} else {
						$results = array(
							'loggedin' => true,
							'message'  => 'User account created and logged in!',
							'maker'    => absint( $maker_id ),
						);
					}
				}
			} elseif ( isset( $_POST['request'] ) && $_POST['request'] == 'logout'  ) {

				// Set the user as logged out.
				update_post_meta( absint( $_COOKIE['_mfuid'] ), 'logged_in', false );

				if ( $this->is_logged_in() ) {
					$results = array(
						'loggedin' => false,
						'message' => 'Successfully logged out!',
					);
				} else {
					$results = array(
						'loggedin' => true,
						'message' => 'Something went wrong. Please try logging out again.',
					);
				}
			} else {
				$results = array();
			}

			echo json_encode( $results );

			die();
		}


		/**
		 * Checks if a user is currently logged in.
		 * @return boolean
		 *
		 * @since  SPRINT_NAME
		 */
		public function is_logged_in() {
			if ( isset( $_COOKIE['_mfugl'] ) && $_COOKIE['_mfugl'] === 'true' ) {
				return true;
			} else {
				return false;
			}
		}
	}
	$make_gigya = new Make_Gigya();


	function maker_faire_user_profile_login( $content ) {
		global $make_gigya;

		if ( ! $make_gigya->is_logged_in() && has_shortcode( $content, 'mfform' ) ) {
			$output = '<h2>Oops! You must be logged in to access this page!</h2>';

			return $output;
		} else {
			return $content;
		}
	}
	add_filter( 'the_content', 'maker_faire_user_profile_login' );
