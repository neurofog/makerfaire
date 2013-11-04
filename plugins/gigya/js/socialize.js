/**
 * This script contains all the JavaScript that controls or interfaces with the socialize features of Gigya (AKA Facebook, Twitter, etc etc logins)
 *
 * @since  SPRINT_NAME
 */

gigya.socialize.addEventHandlers({ // http://developers.gigya.com/020_Client_API/010_Socialize/socialize.addEventHandlers
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
    console.log( 'Logged in to ' + eventObj.provider + '!\nUser ID: ' +  eventObj.user.identities[ eventObj.provider ].providerUID );

    // Verify the signature ...
    verify_signature( eventObj.UID, eventObj.signatureTimestamp, eventObj.UIDSignature );

    // Check whether the user is new by searching if eventObj.UID exists in your database (link this to maker profiles)
    var newUser = true; // Let's assume the user is new
    
    if ( newUser ) {
        // 1.  Register user
        // 2.  Store new user in DB
        // 3.  link site account to social network identity
        // 3.1 first construct the linkAccounts parameters
        var siteUID = 'uTtCGqDTEtcZMGL08w'; // The user ID that you have designated to the current user on your user management system. This site UID must be different than the Gigya ID.
        var dateStr = Math.round( new Date().getTime() / 1000.0 ); // Current time in Unix format
        var yourSig = encodeURIComponent( siteUID, dateStr );
        var params = {
            siteUID: siteUID, 
            timestamp: dateStr,
			cid: '',
            signature: yourSig
        };
        
        // 3.1 call linkAccounts method:
        // http://developers.gigya.com/020_Client_API/010_Socialize/socialize.notifyRegistration  
        gigya.socialize.notifyRegistration( params ); // Use the REST API http://developers.gigya.com/037_API_reference/010_Socialize/socialize.notifyRegistration
    }
	
	// Update our links and remove any of the modal stuffffffsssss.
	jQuery( '.user-creds' ).addClass( 'logged-in' ).find( 'a' ).removeAttr( 'data-toggle' ).text( 'Logout' );

	// Close the modal when we have logged in.
	jQuery( '#login' ).modal( 'hide' );

	$( '.user-creds.logged-in' ).click( function() {
		console.log('CLICKED');
		logout_gigya();
	});

}

/**
 * Creates an encoded URI to pass to notifyRegistration
 * @param  string   UID       [description]
 * @param  {[type]} timestamp [description]
 * @return {[type]}           [description]
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

    console.log( 'UID: ' + UID + '\nTimestamp: ' + timestamp + '\nSignature: ' + signature + '\nYour UID encoded: ' + encodedUID );
}

/**
 * Logout from Gigya platform. This method is activated when "Logout" button is clicked
 * @since SPRINT_NAME
 */
function logout_gigya() {
    gigya.services.socialize.logout(); // logout from Gigya platform
}

/**
 * onLogout Event handler
 * 
 * @param  {[type]} eventObj [description]
 * @since SPRINT_NAME
 */
function on_logout(eventObj) {
	alert( 'You have been successfully logged out!' );
}

/**
 * Displays the login plugin
 *
 * http://developers.gigya.com/020_Client_API/010_Socialize/Socialize.showLoginUI
 * 
 * @since SPRINT_NAME
 */
gigya.socialize.showLoginUI({
	height: 100,
	width: 330,
	showTermsLink: false,
	hideGigyaLink: true,
	buttonsStyle: 'fullLogo', // Change the default buttons design to "Full Logos" design
	showWhatsThis: true, // Pop-up a hint describing the Login Plugin, when the user rolls over the Gigya link.
	containerID: 'modal-body', // The component will embed itself inside the loginDiv Div
	cid: ''
});

jQuery( 'document' ).ready( function( $ ) {
	$( '.user-creds.logged-in' ).click( function() {
		console.log('CLICKED');
		logout_gigya();
	});
});