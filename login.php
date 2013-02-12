<?php
/*
* 
* Template Name: Social Login
*
*/
?>
<html>
<head>
	<SCRIPT type="text/javascript" lang="javascript" 
	   src="http://cdn.gigya.com/JS/socialize.js?apikey=3_vTDunCe4Ou6Ep04raVPTrgc-rBx0xxXx0qU0g_1tDw_9df286Erpi4s3S5FAQG3A">
	</SCRIPT>
	<script>
        // This method is activated when the page is loaded
        function onLoad() {
            // register for login event
            gigya.socialize.addEventHandlers({
					context: { str: 'congrats on your' }
					, onLogin: onLoginHandler 
					, onLogout: onLogoutHandler
					});

        }

        // onLogin Event handler
        function onLoginHandler(eventObj) {	
            //alert(eventObj.context.str + ' ' + eventObj.eventName + ' to ' + eventObj.provider 
			//	+ '!\n' + eventObj.provider + ' user ID: ' +  eventObj.user.identities[eventObj.provider].providerUID);
            // verify the signature ...
            verifyTheSignature(eventObj.UID, eventObj.signatureTimestamp, eventObj.UIDSignature);

            getUser(eventObj.user);
            
            // Check whether the user is new by searching if eventObj.UID exists in your database
            var newUser = true; // lets assume the user is new
            
            if (newUser) {
                // 1. Register user 
                // 2. Store new user in DB
                // 3. link site account to social network identity
                //   3.1 first construct the linkAccounts parameters
                var dateStr = Math.round(new Date().getTime()/1000.0); // Current time in Unix format
																	//(i.e. the number of seconds since Jan. 1st 1970)
				
                var siteUID = 'uTtCGqDTEtcZMGL08w'; // siteUID should be taken from the new user record
                                                   // you have stored in your DB in the previous step
                var yourSig = createSignature(siteUID, dateStr);

                var params = {
                    siteUID: siteUID, 
                    timestamp:dateStr,
					cid:'',
                    signature:yourSig
                };
                
                //   3.1 call linkAccounts method:
                gigya.socialize.notifyRegistration(params);
            }
			
			document.getElementById('status').style.color = "green";
			document.getElementById('status').innerHTML = "Status: You are now signed in";

        }
        //returns user object 
		function getUser(user){
			//alert(JSON.stringify(user));
            //alert('First name: ' + user['firstName'] + '\nLast name: ' + user['lastName'] + '\nEmail: ' + user['email']);

            document.getElementById('fname').style.color = "red";
            document.getElementById('fname').innerHTML = user['firstName'];

            document.getElementById('lname').style.color = "red";
            document.getElementById('lname').innerHTML = user['lastName'];

            document.getElementById('email').style.color = "red";
            document.getElementById('email').innerHTML = user['email'];
		}
		
        // Note: the actual signature calculation implementation should be on server side
        function createSignature(UID, timestamp) {
			encodedUID = encodeURIComponent(UID); // encode the UID parameter before sending it to the server.
												// On server side use decodeURIComponent() function to decode an encoded UID
            return '';
        }
		
        // Note: the actual signature calculation implementation should be on server side
        function verifyTheSignature(UID, timestamp, signature) {
			encodedUID = encodeURIComponent(UID); // encode the UID parameter before sending it to the server.
												// On server side use decodeURIComponent() function to decode an encoded UID
            alert('Your UID: ' + UID + '\n timestamp: ' + timestamp + '\n signature: ' + signature + '\n Your UID encoded: ' + encodedUID);
        }
        
        // Logout from Gigya platform. This method is activated when "Logout" button is clicked 
		function logoutFromGS() {
            gigya.services.socialize.logout(); // logout from Gigya platform
        }
       	
       	// onLogout Event handler
        function onLogoutHandler(eventObj) {
			document.getElementById('status').style.color = "red";
			document.getElementById('status').innerHTML = "Status: You are now signed out";
		}

    </script>
   
</head>
<body onload="onLoad()">
	<br />
	<h4>Please sign in using one of the following providers:</h4><br /><br />
	<div id="loginDiv"></div>
	<script type="text/javascript">
	    gigya.socialize.showLoginUI({ 
			height: 85
	        ,width: 360
			,showTermsLink:false // remove 'Terms' link
			,hideGigyaLink:true // remove 'Gigya' link
			,buttonsStyle: 'fullLogo' // Change the default buttons design to "Full Logos" design
			,showWhatsThis: true // Pop-up a hint describing the Login Plugin, when the user rolls over the Gigya link.
	        ,containerID: 'loginDiv' // The component will embed itself inside the loginDiv Div 
			,cid:''
			});
	</script>
    <br />
    <br /><br /><br />
	<h4>Click the button below to sign out from Gigya platform:</h4><br /><br />
    <input id="btnLogout" type="button" value="Sign Out" 
            onclick="logoutFromGS()"/>
    <br />
    <br />
    <div id="status"></div>
    <div id="gigya-signup">
        <form action="" method="">
            <label for="fname">First Name: </label>
            <div id="fname"></div>

            <label for="lname">Last Name: </label>
            <div id="lname"></div>

            <label for="email">Email: </label>
            <div id="email"></div>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" /><br />

        </form>    
    </div>  

</body>
</html>