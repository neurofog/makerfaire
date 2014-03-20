<?php

/**
 * Gigya!
 *
 * A class that will integrate all the social login fun stuff good times.
 *
 * Since Gigya is a third party system, we use their SDK to login users there and store information.
 * All we need to do is log them into Gigya, and when all is successful and logged in, we'll store some
 * info through cookies to give them access to their applications.
 *
 * This DOES NOT integrate into the WordPress Users database, nor can it due to VIP's global tables.
 * To get around that, we'll process users into a Custom Post Type called Makers which will store their Gigya ID and other info
 * and then these posts (aka "users" or "makers") will be associated to their application(s).
 *
 * @since  HAL 9000
 */

/**
 * Set up some Constants
 */
// The main URL to the plugin directory
define( 'MAKE_GIGYA_URL', get_template_directory_uri() . '/plugins/gigya' );

// Plugin version
define( 'MAKE_GIGYA_VERSION', '0.2' );

// Gigya Public Key
define( 'MAKE_GIGYA_PUBLIC_KEY', sanitize_text_field( get_option( 'make_gigya_public_key' ) ) );

// Gigya Private Key
define( 'MAKE_GIGYA_PRIVATE_KEY', sanitize_text_field( get_option( 'make_gigya_private_key' ) ) );


/**
 * Load the Gigya Socialize SDK
 *
 * @since  HAL 9000
 */
if ( ! class_exists( 'GSRequest' ) )
	include_once( 'includes/GSSDK.php' );

/**
 * Load our admin settings displayed in Settings > General
 *
 * @since  HAL 9000
 */
include_once( 'includes/settings.php' );


/**
 * The guts.
 *
 * This little guy controls and loads all that is Gigya.
 * The namespace for this class is Make because in the future this will be expanded to other make websites.
 *
 * @since  HAL 9000
 */
class Make_Gigya {

	/**
	 * THE CONSTRUCT.
	 *
	 * All Hooks and Filter here.
	 * Anything else that needs to run when the class is instantiated, place them here.
	 * Maybe you'll get a cake if you do.
	 *
	 * @return  void
	 * @since  HAL 9000
	 */
	public function __construct() {

		// Load our Gigya Social SDK and configurations
		add_action( 'wp_head', array( $this, 'socialize_api' ), 999 );

		// Load our resources
		add_action( 'wp_enqueue_scripts', array( $this, 'load_resources' ), 30 );

		// Process our ajax requests. We need ajax processing for both logged in and logged out users.
		// Since our login may be used by users logged into WordPress, we'll need the second option to run ajax requests.
		add_action( 'wp_ajax_nopriv_make_login_user', array( $this, 'user_login' ) );
		add_action( 'wp_ajax_make_login_user', array( $this, 'user_login' ) );
	}


	/**
	 * Spits out the Gigya API for the socialize features.
	 * Sadly, we have to manually echo this to wp_head() because Gigya requires the socialize.js API key to be passed with options wrapped in the same script tag... lame sauce.
	 *
	 * Well nly enable Facebook, Twitter and Google+ as social media providers, we'll also tell Gigya to end the users session with their service after 24 hours
	 *
	 * @return html
	 * @since  HAL 9000
	 */
	public function socialize_api() { ?>
		<script src="http://cdn.gigya.com/JS/socialize.js?apikey=<?php echo urlencode( MAKE_GIGYA_PUBLIC_KEY ); ?>">{ enabledProviders: 'facebook,twitter,googleplus', sessionExpiration: 86400 }</script>
	<?php }


	/**
	 * Let's add all of our resouces to make our magic happen.
	 * Any scripts we should include in the footer or else things will conflict due to how we have to load the socialize API file... #facepalm
	 *
	 * @return  void
	 * @since  HAL 9000
	 */
	public function load_resources() {
		// CSS
		wp_enqueue_style( 'make-login', MAKE_GIGYA_URL . '/css/login.css', null, MAKE_GIGYA_VERSION );

		// JavaScript
		wp_enqueue_script( 'make-login', MAKE_GIGYA_URL . '/js/login.js', array( 'jquery' ), MAKE_GIGYA_VERSION, true );
		wp_enqueue_script( 'make-isc-users', MAKE_GIGYA_URL . '/js/users.js', array( 'jquery' ), MAKE_GIGYA_VERSION, true );
		wp_localize_script( 'make-login', 'make_gigya', array(
			'ajax' => esc_url( admin_url( 'admin-ajax.php' ) ),
			'loading' => 'Loading',
			'secure_it' => wp_create_nonce( 'ajax-nonce' ),
			'root_path' => esc_url( home_url( '/' ) ),
		) );
	}


	/**
	 * Process' our Gigya interactions with the database. This method will take the info processed from the Gigya JS API and pass it through to either login or loggin out.
	 * These users are created and managed through the Makers CPT.
	 * @return json
	 *
	 * @since  HAL 9000
	 */
	public function user_login() {

		// Check our nonce and make sure it's correct
		check_ajax_referer( 'ajax-nonce', 'nonce' );

		// Make sure some required fields are being passed first
		if ( isset( $_POST['request'] ) && $_POST['request'] == 'login' && wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {

			// First we must verify this request is even a valid request from Gigya
			if ( $this->verify_user( $_POST['object']['UID'], $_POST['object']['signatureTimestamp'], $_POST['object']['UIDSignature'] ) ) {

				// Search for a maker and return them or false
				$users = $this->search_for_maker( $_POST['object']['UID'] );

				// Check if a user already exists, if not we'll create one.
				if ( $users ) {
					update_post_meta( absint( $users[0]->ID ), 'last_login', date( 'm/d/Y g:i:s a', time() ) );

					$results = array(
						'loggedin' => true,
						'message' => 'Login Successful!',
						'maker' => absint( $users[0]->ID ),
					);

				// User didn't exist, let's make one.
				} else {

					// Pass our User Info sent from Gigya
					$user = ( is_array( $_POST['object']['profile'] ) ) ? $_POST['object']['profile'] : '';

					// Create the maker and return their ID
					$maker_id = $this->create_maker( $user, $_POST['object']['UID'] );

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
			} else {
				$results = array(
					'loggedin' => false,
					'message' => 'Request could not be validated. Please try again.',
				);
			}
		} else {
			$results = array(
				'loggedin' => false,
				'message' => 'Missing required parameters',
			);
		}

		// Return our results and handle them in the Ajax callback
		die( json_encode( $results ) );
	}


	/**
	 * Searches the Makers lists and locates a usr based on their UID
	 * @param  string $uid The user ID from Gigya
	 * @return object
	 *
	 * @since  HAL 9000
	 */
	private function search_for_maker( $uid ) {
		// Stick a hashed version of our usr ID for wp cache
		$user_hash = md5( sanitize_text_field( $uid ) );

		// Check if our users are already cached
		$users = wp_cache_get( 'mf_user_' . $user_hash );

		// If there is no cache set, we'll run the query again and cache it.
		if ( $users == false ) {
			// Query our makers list and see if a maker exists
			$query_params = array(
				'post_type' => 'maker',
				'meta_key' => 'guid',
				'meta_value' => sanitize_text_field( $uid ),
			);
			$users = new WP_Query( $query_params );

			// Save the results to the cache
			wp_cache_set( 'mf_user_' . $user_hash, $users, '', 86400 ); // Since we are caching each user, might as well hold onto it for 24 hours.
		}

		return $users->posts;
	}


	/**
	 * Creates a new maker in the makers listings and returns the makers ID
	 * @param  array $user The data passed from Gigya for use in the maker creation
	 * @return integer
	 */
	private function create_maker( $user, $uid ) {
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

		// We need the term ID of the current faire taxonomy
		$current_faire = wpcom_vip_get_term_by( 'slug', MF_CURRENT_FAIRE, 'faire' );

		// Our user doesn't exist, that means we need to sync them up, create a maker account and log them in.
		$maker = array(
			'post_title' => sanitize_text_field( $user_name ),
			'post_content' => ( ! empty( $user['bio'] ) ) ? wp_filter_post_kses( $user['bio'] ) : '',
			'post_status' => 'publish',
			'post_type' => 'maker',
			'tax_input' => array( 'faire' => absint( $current_faire->term_id ) ),
		);
		$maker_id = wp_insert_post( $maker );

		// If an error happens, we want to report that back before running any post meta updates.
		if ( is_wp_error( $maker_id ) )
			return 0;

		// We'll want to add some custom fields. Let's do that.
		// ****************************************************
		// Add the maker email
		$user_email = ( isset( $user['email'] ) && ! empty( $user['email'] ) ) ? $user['email'] : '';
		update_post_meta( absint( $maker_id ), 'email', sanitize_email( $user_email ) );

		// Add the maker photo
		$user_photo = ( isset( $user['photoURL'] ) && ! empty( $user['photoURL'] ) ) ? $user['photoURL'] : '';
		update_post_meta( absint( $maker_id ), 'photo_url', esc_url( $user_photo ) );

		// Add the maker website field, even though this field will be blank on creation
		update_post_meta( absint( $maker_id ), 'website', '' );

		// Add the maker video field, even though this field will be blank on creation
		update_post_meta( absint( $maker_id ), 'video', '' );

		// Add the Maker Gigya ID
		update_post_meta( absint( $maker_id ), 'guid', sanitize_text_field( $uid ) );

		return $maker_id;
	}


	/**
	 * We want to verify our Gigya interactions are valid.
	 * Since all interactions are via the JavaScript API, we'll need to verify these via AJAX
	 * @return json
	 *
	 * @since  HAL 9000
	 */
	public function verify_user( $uid, $timestamp, $sig) {

		// Validate the signature is authentic
		$valid = SigUtils::validateUserSignature( sanitize_text_field( $uid ), absint( $timestamp ), MAKE_GIGYA_PRIVATE_KEY, sanitize_text_field( $sig ) );

		if ( $valid ) {
			return true;
		} else {
			return false;
		}
	}
}
$make_gigya = new Make_Gigya();
