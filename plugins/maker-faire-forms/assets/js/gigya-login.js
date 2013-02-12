// JavaScript Document

var path = window.location.pathname.substring(1);
var user = {};

jQuery(function($) 
{	
	$('body').prepend('<div id="userScreensDiv"></div>');

	gigya.accounts.getAccountInfo({callback:mf_test}); 

	gigya.accounts.addEventHandlers({
		onLogin:  mf_onLoginHandler, 
		onLogout: mf_onLogoutHandler
	});

	mf_is_loggedin();

});

function mf_set_cookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value + "; path=/";
}

function mf_get_cookie(c_name)
{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
	  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	  x=x.replace(/^\s+|\s+$/g,"");
	  if (x==c_name)
		{
		return unescape(y);
		}
	  }
}
function mf_test(o)
{
	console.log(o);
}
function mf_is_loggedin()
{
	var c = mf_get_cookie('gigya_id');
	
	if(c != null && c != 0)
	{
		jQuery('.nav-collapse ul:first-of-type').append('<li><a href="/makerprofile?uid='+c+'">Your Account</a></li><li><a href="#" onclick="javascript: gigya.accounts.logout();">Logout</a></li>');
		var u = jQuery.parseJSON(mf_get_cookie('gigya_info'));
		
		if(path.indexOf('exhibit') >= 0 || path.indexOf('presenter') >= 0 || path.indexOf('performer') >= 0)
		{	
			if(jQuery('input.default-name').val() == '')
			{
				jQuery('input.default-name').val(u.firstName+' '+u.lastName);
				jQuery('input.default-email').val(u.email);  
				jQuery('textarea.default-bio').val(u.bio); 
			}
			
			jQuery('h3.default-name').html(u.firstName+' '+u.lastName);
  			jQuery('h3.default-email').html(u.email);   
			
			jQuery('#uid').val(c);
			jQuery(window).bind('beforeunload', function(){ return 'Are you sure you want to leave?'; });
		}
		else if(path.indexOf('makerprofile') >= 0)
		{
			if(u.thumbnailURL != undefined && u.thumbnailURL != 'undefined')
				jQuery('.maker-image').attr('src', u.thumbnailURL);
				
			jQuery('.maker-name span:first-of-type').html(u.firstName);
			jQuery('.maker-name span:last-of-type').html(u.lastName);
			jQuery('.mf-editforms .bio').html(u.bio);
		}
	}
	else
	{		
		jQuery('.nav-collapse ul:first-of-type').append('<li><a href="#" onclick="gigya.accounts.showScreenSet({screenSet:\'MakerFaire\'});">Login</a></li><li><a href="#" onclick="gigya.accounts.showScreenSet({screenSet:\'MakerFaire\', startScreen:\'gigya-register-screen\'});">Register</a></li>');
		
		if(document.URL.indexOf('login') > -1)
			gigya.accounts.showScreenSet({screenSet:'MakerFaire'});
			
		if(path.indexOf('exhibit') >= 0 || path.indexOf('presenter') >= 0 || path.indexOf('performer') >= 0 || path.indexOf('makerprofile') >= 0)
		{
			jQuery('article').html('<h1 class="mf-not-loggedin-header">You Must Be Logged In to Complete This Application.</h1><h2><a href="#" onclick="gigya.accounts.showScreenSet({screenSet:\'MakerFaire\'});">Login</a> &nbsp; | &nbsp;<a href="#" onclick="gigya.accounts.showScreenSet({screenSet:\'MakerFaire\', startScreen:\'gigya-register-screen\'});">Register</a></h2>');
		}
	}
}

// onLogin Event handler
function mf_onLoginHandler(o) 
{	
	mf_set_cookie("gigya_id",   o.UID, 1);
	mf_set_cookie("gigya_info", '{"firstName":"'+o.profile.firstName+'", "lastName":"'+o.profile.lastName+'", "email":"'+o.profile.email+'", "thumbnailURL":"'+o.profile.thumbnailURL+'", "bio":"'+o.data.bio+'"}', 1);

	document.location = '/makerprofile?uid='+o.UID;
}

// onLogout Event handler
function mf_onLogoutHandler(o) 
{
	mf_set_cookie("gigya_id",   0, -1);
	mf_set_cookie("gigya_info", '{}', -1);
	
	document.location = '/';
}

function mf_update_profile(o)
{
	mf_set_cookie("gigya_info", '{"firstName":"'+o.profile.firstName+'", "lastName":"'+o.profile.lastName+'", "email":"'+o.profile.email+'", "thumbnailURL":"'+o.profile.thumbnailURL+'", "bio":"'+o.data.bio+'"}', 1);
	window.location.reload();	
}