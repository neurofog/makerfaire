/**
 * This script contains all the JavaScript that controls or interfaces with the socialize features of Gigya (AKA Facebook, Twitter, etc etc logins)
 *
 * @since  HAL 9000
 */

// Set debugging mode.
var gigya_debug = false;

jQuery(document).ready(function($) {

	// Listen for a click event to open the login screen
	$( '.user-creds.login' ).on( 'click', function( e ) {
		e.preventDefault();

		gigya.accounts.showScreenSet({
			screenSet: 'Login-web',
			mobileScreenSet: 'Login-mobile'
		});
	});

	// Listen for a click event to open the register screen
	$( '.user-creds.register' ).on( 'click', function( e ) {
		e.preventDefault();

		gigya.accounts.showScreenSet({
			screenSet: 'Login-web',
			mobileScreenSet: 'Login-mobile',
			startScreen: 'gigya-register-screen'
		});
	});

	// Listen for a click event to logout
	$( '.user-creds.logout' ).on( 'click', function( e ) {
		e.preventDefault();

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
 * @since  HAL 9000
 */
function on_login( eventObj ) {
	if ( gigya_debug )
		console.log( 'Logged in to ' + eventObj.provider + '!' );

    // Verify the signature ...
    verify_signature( eventObj.UID, eventObj.signatureTimestamp, eventObj.UIDSignature );

    // Send our data via Ajax to the server to verify if the user is a returning user or a new one
    jQuery.ajax({
		type: 'POST',
		dataType: 'json',
		url: make_gigya.ajax,
		data: {
			'action'   : 'ajax', // Calls our wp_ajax_nopriv_ajax
			'request'  : 'login',
			'object'   : eventObj,
			'nonce'    : make_gigya.secure_it
		},
		success: function( results ) {

			if ( gigya_debug )
				console.log( results.message );

			// Set the Maker ID into a cookie.
			var date_login = new Date();
			date_login.setTime( date_login.getTime() + ( 1 * 24 * 60 * 60 * 1000 ) );
			document.cookie = '_mfugl=true; expires=' + date_login.toGMTString() + '; path=/';

			// Check that everything went well
			if ( results.loggedin === true )
				document.location = make_gigya.root_path + 'makerprofile';

		},
		error: function( jqXHR, textStatus, errorThrown ) {
			if ( gigya_debug ) {
				console.log( textStatus );
				console.log( errorThrown );
			}
		},
		complete: function( jqXHR, textStatus ) {
			if ( gigya_debug )
				console.log( 'AJAX complete' );
		}
    });
}


/**
 * Verifies the signature of the login.
 * The actual signature calculation implementation should be on server side
 * 
 * @param  string  UID       The User ID that should be used for login verification
 * @param  integer timestamp The GMT time of the response in UNIX time format. The time stamp should be used for login verification
 * @param  string  signature The signature that should be used for login verification
 * @since  HAL 9000
 */
function verify_signature( UID, timestamp, signature ) {
	encodedUID = encodeURIComponent( UID ) ; // encode the UID parameter before sending it to the server. On server side use decodeURIComponent() function to decode an encoded UID

	if ( gigya_debug )
		console.log( 'UID: ' + UID + '\nTimestamp: ' + timestamp + '\nSignature: ' + signature + '\nYour UID encoded: ' + encodedUID );
}


/**
 * onLogout Event handler
 * 
 * @since HAL 9000
 */
function on_logout() {
	if ( gigya_debug )
		console.log( 'User logged out' );

	// Send our logout notification and pull our cookie
    jQuery.ajax({
		type: 'POST',
		dataType: 'json',
		url: make_gigya.ajax,
		data: {
			'action'   : 'ajax', // Calls our wp_ajax_nopriv_ajax
			'request'  : 'logout',
			'nonce'    : make_gigya.secure_it
		},
		success: function( results ) {

			if ( gigya_debug )
				console.log( results.message );

			// Remove our cookie
			var date = new Date();
			date.setTime( date.getTime() - ( 1 * 24 * 60 * 60 * 1000 ) );
			document.cookie = '_mfugl=true; expires=' + date.toGMTString() + '; path=/';

			// Check that everything went well
			if ( results.loggedin === false )
				document.location = make_gigya.root_path;

		},
		error: function( jqXHR, textStatus, errorThrown ) {
			if ( gigya_debug ) {
				console.log( 'AJAX ERROR' );
				console.log( textStatus );
				console.log( errorThrown );
			}
		},
		complete: function( jqXHR, textStatus ) {
			if ( gigya_debug )
				console.log( 'AJAX complete' );
		}
    });
}