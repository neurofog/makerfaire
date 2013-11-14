/**
 * This script contains all the JavaScript that controls or interfaces with the socialize features of Gigya (AKA Facebook, Twitter, etc etc logins)
 *
 * @since  SPRINT_NAME
 */

// Set debugging mode.
var gigya_debug = true;

jQuery(document).ready(function($) {

	// Listen for a click event to open the login screen
	$( '.user-creds.login' ).click( function() {
		gigya.accounts.showScreenSet({
			screenSet: 'login-makerfaire',
			mobileScreenSet: 'Login-mobile'
		});
	});

	// Listen for a click event to open the register screen
	$( '.user-creds.register' ).click( function() {
		gigya.accounts.showScreenSet({
			screenSet: 'login-makerfaire',
			mobileScreenSet: 'Login-mobile',
			startScreen: 'gigya-register-screen'
		});
	});

	// Listen for a click event to logout
	$( '.user-creds.logout' ).click( function() {
		gigya.accounts.logout({
			callback: onLogout
		});
	});
});


/**
 * The Gigya service generates several global application events for various situations that are driven by user interactions.
 * Global application events are fired whenever the event to which they refer occurs, regardless of what was the action that triggered the event.
 * This method allows setting event handlers for each of the supported global events.
 * @url http://developers.gigya.com/020_Client_API/020_Accounts/accounts.addEventHandlers
 *
 * @since  SPRINT_NAME
 */
gigya.accounts.addEventHandlers({ // 
	onLogin: on_login,
	onLogout: on_logout
});


/**
 * Event handler of socialize.
 * http://developers.gigya.com/020_Client_API/010_Socialize/socialize.addEventHandlers#section_1
 *
 * NOTE: It is important to use the REST API for logging in or registering users http://developers.gigya.com/037_API_reference/010_Socialize
 * 
 * @param  object eventObj The event object?
 * @since  SPRINT_NAME
 */
function on_login( eventObj ) {
	// Results: "congrats on your login to {PROVIDER}! {provider} user ID: {ProviderUID}"
	if ( gigya_debug )
		console.log( 'Logged in to ' + eventObj.provider + '!\nUser ID: ' +  eventObj.user.identities[ eventObj.provider ].providerUID );

    // Verify the signature ...
    verify_signature( eventObj.UID, eventObj.signatureTimestamp, eventObj.UIDSignature );

    // Send our data via Ajax to the server to verify if the user is a returning user or a new one
    jQuery.ajax({
		type: 'POST',
		dataType: 'json',
		url: make_gigya.ajax,
		data: {
			'action'  : 'ajaxlogin', // Calls our wp_ajax_nopriv_ajaxlogin
			'request' : 'login',
			'user'    : eventObj.user,
			'nonce'   : make_gigya.secure_it
		},
		success: function( results ) {
			if ( results.loggedin === true ) {
				if ( gigya_debug )
					console.log( 'WordPress logged in' );

				// Update the login window that everything went well
				jQuery( '.modal-body' ).prepend( '<div class="alert alert-success">Successfully Logged in!</div>' );

				// Update our links and remove any of the modal stuffffffsssss.
				jQuery( '.user-creds' ).addClass( 'logged-in' ).find( 'a' ).attr( 'href', '#logout' ).removeAttr( 'data-toggle' ).text( 'Logout' );

				if ( gigya_debug )
					console.log( 'LOGIN DONE' );

				// Let's hook into the new content update and allow users to sign out
				jQuery( '.user-creds.logged-in a[href="#logout"]' ).click( function(e) {
					if ( gigya_debug )
						console.log( 'CLICKED' );

					e.preventDefault();
					logout_gigya();
				});
			} else {
				if ( gigya_debug )
					console.log( 'Failed WordPress login' );
			}
		},
		complete: function( jqXHR, textStatus ) {
			if ( gigya_debug )
				console.log( 'AJAX complete' );

			// Remove the message window
			jQuery( '.modal-body .alert' ).delay( '5000' ).remove();
		}
    });
}

/**
 * Creates an encoded URI to pass to notifyRegistration
 * @param  string  UID       The User ID that should be used for login verification
 * @param  integer timestamp The GMT time of the response in UNIX time format. The time stamp should be used for login verification
 * 
 * @since  SPRINT_NAME
 */
function createSignature( UID, timestamp ) {
	encodedUID = encodeURIComponent( UID ); // Encode the UID parameter before sending it to the server. On server side use decodeURIComponent() function to decode an encoded UID

    return '';
}

/**
 * Verifies the signature of the login.
 * The actual signature calculation implementation should be on server side
 * 
 * @param  string  UID       The User ID that should be used for login verification
 * @param  integer timestamp The GMT time of the response in UNIX time format. The time stamp should be used for login verification
 * @param  string  signature The signature that should be used for login verification
 * @since  SPRINT_NAME
 */
function verify_signature( UID, timestamp, signature ) {
	encodedUID = encodeURIComponent( UID ) ; // encode the UID parameter before sending it to the server. On server side use decodeURIComponent() function to decode an encoded UID

	if ( gigya_debug )
		console.log( 'UID: ' + UID + '\nTimestamp: ' + timestamp + '\nSignature: ' + signature + '\nYour UID encoded: ' + encodedUID );
}

/**
 * Logout from Gigya platform. This method is activated when "Logout" button is clicked
 * NOTE: http://developers.gigya.com/020_Client_API/010_Socialize/socialize.logout
 * 
 * @since SPRINT_NAME
 */
function logout_gigya() {
    gigya.services.socialize.logout();
}

/**
 * onLogout Event handler
 * 
 * @param  {[type]} eventObj [description]
 * @since SPRINT_NAME
 */
function on_logout( eventObj ) {
	alert( 'You have been successfully logged out!' );

	jQuery( '.user-creds.logged-in' ).removeClass( 'logged-in' ).find( 'a' ).attr({
		'href' : '#login',
		'data-toggle': 'modal'
	}).text( 'Login/Register' );

	if ( gigya_debug )
		console.log( 'User logged out' );
}



