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

	// Gigya Public Key
	define( 'MAKE_GIGYA_PUBLIC_KEY', '3_bjlVxC0gadZ6dN9q8K1ePCbDHtATT8OgJxZJcsr0ty8o5oKnvjI_G2DOZ1YasJHF' );

	// Gigya Private Key
	define( 'MAKE_GIGYA_PRIVATE_KEY', 'GlvZcbxIY6Oy7lnWJheh56DXj3wKAiG3yVqhv++VLZM=' );


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
			add_action( 'wp_ajax_ajaxlogin', array( $this, 'ajax_login' ) );
		}

		/**
		 * Spits out the Gigya API for the socialize plugin
		 * Sadly, we have to manually echo this to wp_head() because Gigya requires the socialize.js API key to be passed with options wrapped in the same script tag.
		 * 
		 * @return html
		 * @since  SPRINT_NAME
		 */
		public function socialize_api() { ?>
			<script src="http://cdn.gigya.com/JS/socialize.js?apikey=<?php echo MAKE_GIGYA_PUBLIC_KEY; ?>">{ enabledProviders: '*' }</script>
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

		/**
		 * Process' our login to Gigya. This method will take the info from the socialize plugin and pass it through to either login or create a new user
		 * @return json
		 *
		 * @since  SPRINT_NAME
		 */
		public function ajax_login() {
			
			// Check our nonce and make sure it's correct
			check_ajax_referer( 'ajax-login-nonce', 'nonce' );

			// Move our user info to a new variable
			$user = $_POST['user'];

			// Hold onto the submission data
			$data = array();

			if ( isset( $_POST['request'] ) && $_POST['request'] == 'login' ) {
				$query_params = array(
					'post_type' => 'maker',
					'meta_key' => 'guid',
					'meta_value' => $user['UID']
				);

				$users = new WP_Query( $query_params );

				// Check if a user already exists, if not we'll create one.
				if ( $users->posts ) {

					// Notify Gigya about our returning user
					$request = new GSRequest( MAKE_GIGYA_PUBLIC_KEY, MAKE_GIGYA_PRIVATE_KEY, 'socialize.notifyLogin' );
					$request->setParam( 'siteUID', $users->posts[0]->ID );

					// Let's send this login data to Gigya
					$response = $request->send();

					// Handle the response from Gigya
					if ( $response->getErrorCode() == 0 ) {
						// Everything was good!
						$gigya_notified = true;
					} else {
						$gigya_notified = false;
						$gigya_error = array( 'gigya_response' => $response->getErrorMessage() );
					}


					// Now let's check Gigya responded positivly. If not, we need to report back
					if ( $gigya_notified ) {
						$results = array(
							'loggedin' => true,
							'message' => 'Login Successful!',
						);
					} else {
						$results = array(
							'loggedin' => false,
							'message' => $response->getErrorMessage(),
						);
					}
				} else {

					// Handle our user name
					if ( ! empty( $user['firstName'] ) && ! empty( $user['lastName'] ) ) {
						$user_name = $user['firstName'] . ' ' . $user['lastName'];
					} elseif ( ! empty( $user['firstName'] ) && empty( $user['lastName'] ) ) {
						$user_name = $user['firstName'];
					} elseif ( empty( $user['firstName'] ) && empty( $user['lastName'] ) && ! empty( $user['nickname'] ) ) {
						$user_name = $user['nickname'];
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
					update_post_meta( $maker_id, 'email', $user_email );

					// Add the maker photo
					$user_photo = ( isset( $user['photoURL'] ) && ! empty( $user['photoURL'] ) ) ? esc_url ( $user['photoURL'] ) : '';
					update_post_meta( $maker_id, 'photo_url', $user_photo );

					// Add the maker website field
					update_post_meta( $maker_id, 'website', '' );

					// Add the maker video field
					update_post_meta( $maker_id, 'video', '' );

					// Add the Maker Gigya ID
					update_post_meta( $maker_id, 'guid', sanitize_text_field( $user['UID'] ) );

					// Report our status to pass back to the modal window
					if ( is_wp_error( $maker_id ) ) {
						$results = array(
							'loggedin' => false,
							'gigya_loggedin' => false,
							'message'  => 'A user account could not be created. Please try again.',
						);
					} else {

						// Let's Set things up to notify Gigya about our user login
						$request = new GSRequest( MAKE_GIGYA_PUBLIC_KEY, MAKE_GIGYA_PRIVATE_KEY, 'socialize.notifyRegistraion' );
						$request->setParam( 'UID', $user['UID'] );
						$request->setParam( 'siteUID', $maker_id );

						// Now send the notification to Gigya
						$response = $request->send();

						// Handle the response from Gigya
						if ( $response->getErrorCode() == 0 ) {
							// Everything was good!
							$gigya_notified = true;
						} else {
							$gigya_notified = false;
							$gigya_error = array( 'gigya_response' => $response->getErrorMessage() );
						}

						// Now let's check Gigya responded positivly. If not, we need to report back
						if ( $gigya_notified ) {
							$results = array(
								'loggedin' => true,
								'message' => 'User account created!',
							);
						} else {
							$results = array(
								'loggedin' => false,
								'message' => $response->getErrorMessage(),
							);
						}
					}
				}

				echo json_encode( $results );
			}

			die();
		}

	}
	$make_gigya = new Make_Gigya();

