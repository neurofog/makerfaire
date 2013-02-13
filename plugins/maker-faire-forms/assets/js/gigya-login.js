// JavaScript Document

var path = window.location.pathname.substring(1);
var user = {};

jQuery(function($) 
{	
	$('body').prepend('<div id="userScreensDiv"></div>');

	gigya.accounts.addEventHandlers({
		onLogin:  mf_onLoginHandler, 
		onLogout: mf_onLogoutHandler
	});
	
	gigya.accounts.getAccountInfo({ callback: mf_is_loggedin })

	var r = mf_get_query_value('register');
	if(r == 1)
		gigya.accounts.showScreenSet({screenSet:'MakerFaire', startScreen:'gigya-register-screen'});
});

function mf_get_query_value(name)
{
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.search);
  if(results == null)
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}
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

function mf_is_loggedin(o)
{
	console.log(o);

	if(o.errorCode == 0)
	{
		jQuery('.nav-collapse ul:first-of-type').append('<li><a href="/makerprofile">Your Account</a></li><li><a href="#" onclick="javascript: gigya.accounts.logout();">Logout</a></li>');		
		
		if(path.indexOf('exhibit') >= 0 || path.indexOf('presenter') >= 0 || path.indexOf('performer') >= 0)
		{	
			if(jQuery('.mf-form #id').val() != 0 && jQuery('.mf-form #uid').val() != o.UID)
				document.location = '/'+jQuery('.mf-form  #form_type').val()+'form';
		
			if(jQuery('input.default-name').val() == '')
			{
				jQuery('input.default-name').val(o.profile.firstName+' '+o.profile.lastName);
				jQuery('input.default-email').val(o.profile.email);  
				jQuery('textarea.default-bio').val(o.data.bio); 
			}
			
			jQuery('h3.default-name').html(o.profile.firstName+' '+o.profile.lastName);
  			jQuery('h3.default-email').html(o.profile.email);   
			
			jQuery('#uid').val(o.UID );
			jQuery(window).bind('beforeunload', function(){ return 'Are you sure you want to leave?'; });
		}
		else if(path.indexOf('makerprofile') >= 0)
		{
			if(o.profile.thumbnailURL != undefined && o.profile.thumbnailURL != 'undefined')
				jQuery('.maker-image').attr('src', o.profile.thumbnailURL);
				
			jQuery('.maker-name span:first-of-type').html(o.profile.firstName);
			jQuery('.maker-name span:last-of-type').html(o.profile.lastName);
			jQuery('.mf-editforms .bio').html(o.data.bio);
			
			jQuery.post('/wp-admin/admin-ajax.php', {action: 'mfform_getforms', uid:o.UID, e:o.profile.email}, function(r){
				
				for(i in r.forms)
				{
					for(j in r.forms[i])
					{
						jQuery('#'+i+' ul').append('<li><a href="/'+i+'form/?id='+j+'">'+j+' - '+r.forms[i][j]['post_title']+' ('+(r.forms[i][j]['post_status'] == 'mf_pending' ? 'pending' : 'submitted')+')</a></li>');
					}
				}
			}, 
			'json'); 
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
	document.location = '/makerprofile';
}

// onLogout Event handler
function mf_onLogoutHandler(o) 
{
	document.location = '/';
}

function mf_update_profile(o)
{
	window.location.reload();	
}