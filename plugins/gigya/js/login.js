/**
 * This script contains all the JavaScript that controls or interfaces with the socialize features of Gigya (AKA Facebook, Twitter, etc etc logins)
 * To hit our deadline for Maker Faire Bay Area, we need to rely on the JavaScript SDK from Gigya.
 * A server-side SDK is preferred, but a new spec and time is needed to be done to do so.
 *
 * @since  HAL 9000
 */

// Set debugging mode.
var gigya_debug = false;

jQuery( document ).ready(function() {

	// Return our makers information. If a session is not found, Gigya will report back with an error and handled in the callback.
	gigya.accounts.getAccountInfo({ callback: make_is_logged_in });

	// Listen for a click event to open the login screen
	jQuery( document ).on( 'click', '.user-creds.login', function( e ) {
		e.preventDefault();

		gigya.accounts.showScreenSet({
			screenSet: 'Login-web',
			mobileScreenSet: 'Login-mobile'
		});
	});

	// Listen for a click event to open the register screen
	jQuery( document ).on( 'click', '.user-creds.register', function( e ) {
		e.preventDefault();

		gigya.accounts.showScreenSet({
			screenSet: 'Login-web',
			mobileScreenSet: 'Login-mobile',
			startScreen: 'gigya-register-screen'
		});
	});

	// Listen for a click event to logout
	jQuery( document ).on( 'click', '.user-creds.logout', function( e ) {
		e.preventDefault();

		if ( gigya_debug )
			console.log( 'Logout Started' );

		gigya.accounts.logout();
	});

});


/**
 * The Gigya service generates several global application events for various situations that are driven by user interactions.
 * Global application events are fired whenever the event to which they refer occurs, regardless of what was the action that triggered the event.
 * This method allows setting event handlers for each of the supported global events.
 * @url http://developers.gigya.com/020_Client_API/020_Accounts/accounts.addEventHandlers
 *
 * @since  HAL 9000
 */
gigya.accounts.addEventHandlers({ // 
	onLogin: make_on_login,
	onLogout: make_on_logout
});


/**
 * Event handler of socialize.
 * http://developers.gigya.com/020_Client_API/010_Socialize/socialize.addEventHandlers#section_1
 *
 * NOTE: It is important to use the REST API for logging in or registering users http://developers.gigya.com/037_API_reference/010_Socialize
 * 
 * @param  object eventObj The event object?
 * @since  HAL 9000
 */
function make_on_login( eventObj ) {
	if ( gigya_debug )
		console.log( 'Logged in to Gigya!' );

	// Send our data via Ajax to the server to verify if the user is a returning user or a new one and create their profile.
	jQuery.ajax({
		type: 'POST',
		dataType: 'json',
		url: make_gigya.ajax,
		xhrFields: {
			withCredentials: true
		},
		data: {
			'action'   : 'make_login_user', // Calls our wp_ajax_nopriv_make_ajax_login or wp_ajax_make_ajax_login actions
			'request'  : 'login',
			'object'   : eventObj,
			'nonce'    : make_gigya.secure_it
		},
		success: function( results ) {
			if ( gigya_debug )
				console.log( results.message );

			// Check that everything went well
			if ( results.loggedin === true ) {
				document.location = make_gigya.root_path + 'makerprofile';
			} else {
				// We may have logged into Gigya, but something happened on our end. Let's correct Gigya.
				gigya.accounts.logout();

				alert( 'Something went wrong and we couldn\'t log you in. Please try again.' );
			}

		},
		error: function( jqXHR, textStatus, errorThrown ) {
			if ( gigya_debug ) {
				console.log( 'ERROR' );
				console.log( textStatus );
				console.log( errorThrown );
			}
		},
		complete: function( jqXHR, textStatus ) {
			if ( gigya_debug )
				console.log( 'Login Complete.' );
		}
	});
}


/**
 * onLogout Event handler
 * After we have successfully logged out, we'll redirect to the homepage.
 * 
 * @since HAL 9000
 */
function make_on_logout() {
	if ( gigya_debug )
		console.log( 'User logged out' );

	// Redirect back to the homepage
	document.location = make_gigya.root_path;
}


/**
 * Checks if gigya returned a user account and verifies the signature for additional security
 * @param  object maker The object returned by gigya.accounts.getAccountInfo()
 * @return mixed
 *
 * @since  HAL 9000
 */
function make_is_logged_in( maker ) {
	if ( gigya_debug )
		console.log( maker );
	
	if ( maker.errorCode === 0 ) {
		if ( gigya_debug )
			console.log( 'User Logged In.' );

		jQuery( '.main-nav' ).append( '<li class="user-creds logout"><a href="#logout">Logout</a></li><li class="user-creds profile"><a href="' + make_gigya.root_path + 'makerprofile">Your Account</a></li>' );

		// Initialize our maker profile code
		makerfaire_profile( maker );
	} else {
		if ( gigya_debug )
			console.log( 'User Not Logged In.' );

		// Add our login/register links
		jQuery( '.main-nav' ).append( '<li class="user-creds login"><a href="#login">Login</a></li><li class="user-creds register"><a href="#register">Register</a></li>' );

		if ( path.indexOf( 'exhibit' ) >= 0 || path.indexOf( 'presenter' ) >= 0 || path.indexOf( 'performer' ) >= 0 || path.indexOf( 'makerprofile' ) >= 0 )
			jQuery( '.content' ).html( '<h2>You must be logged in to access this area.<br />Please <a href="#login" class="user-creds login">Login</a> or <a href="#register" class="user-creds register">Register</a>.</h2>' );
	}
}
