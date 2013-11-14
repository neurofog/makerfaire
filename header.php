<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#" lang="en">
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# object: http://ogp.me/ns/object#">
	<meta charset="utf-8">
	<meta name="apple-itunes-app" content="app-id=463248665"/>

	<title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
	<meta name="description" content="<?php if ( is_single() ) {
				echo wp_trim_words( strip_shortcodes( get_the_content('...') ), 20 );
			} else {
				bloginfo( 'name' );
				echo " - ";
				bloginfo('description');
			}
	?>" />

	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le styles -->

	<!-- TypeKit -->
	<link rel="stylesheet" href="http://use.typekit.com/c/4690c1/museo-slab:n8:n9:n1:n3,bebas-neue:n4,proxima-nova:n4:i4:n7:i7,museo-slab:n5.QL3:F:2,QL5:F:2,QL7:F:2,SKB:F:2,TGd:F:2,W0V:F:2,W0W:F:2,W0Y:F:2,W0Z:F:2,WH7:F:2/d?3bb2a6e53c9684ffdc9a98f6135b2a62e9fd3f37bbbb30d58844c72ca542eb12d9fc18cda0192bd960a04b65e2f2facc738d907514640137ac74942ecfe54dd35844bc349bb4c1279a7aaf8651616db7b59a075388454f5f4a07fb5c0b8f09dcccc3d70f9605ca7a1dbf9b12b3c351656254cd3fc59e92f2e542459e636860be01542f5c784cda4fe2fc310798ac7c1670eeda393aa990e8b58d73431e6bae280cf620ce09d0a49a9554ea7f25339dd274cf69ee61d55e93d9cb159fd2848203940e4eb67ad0455b5b574d1a27fec0ae65">
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	
	<?php get_template_part('dfp'); ?>

	<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-51157-7']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

	</script>

	<?php wp_head(); ?>

	</head>


<body id="bootstrap-js" <?php body_class('no-js'); ?>>

<script type="text/javascript">document.body.className = document.body.className.replace('no-js','js');</script> 
<!-- 
======
Topbar
======
-->

<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
		<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<span class="i-bar"></span>
			<span class="i-bar"></span>
			<span class="i-bar"></span>
		</a>
		<div class="nav-collapse">
			<ul class="nav">
				<li class="red"><a  class="red" href="http://makezine.com">MAKE</a></li>
				<li><a href="http://makezine.com/blog/">Blog</a></li>
				<li><a href="http://makezine.com/magazine/">Magazine</a></li>
				<li><a href="http://makerfaire.com">Maker Faire</a></li>
				<li><a href="http://makezine.com/projects/">Make: Projects</a></li>
				<li><a href="http://makershed.com">Maker Shed</a></li>
				<li><a href="http://kits.makezine.com">Kits</a></li>
				<li class="user-creds login"><a href="#login">Login</a></li>
				<li class="user-creds register"><a href="#register">Register</a></li>
			</ul>
			<ul class="nav pull-right">
				<li>
					<form action="http://makezine.com/search/" class="form-horizontal form-search"> 
						<input type="hidden" name="as_sitesearch" value="makerfaire.com" /> 
						<input type="text" name="q" class="span2" /> 
						<input type="submit" class="btn btn-primary" value="Search" /> 
					</form>
				</li>
			</ul>
		</div>
			
			
		</div>
	</div>
</div>

<header id="header">
	
	<div class="modal fade" id="login" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Login or Register</h4>
      </div>
      <div class="modal-body" id="modal-body">
      	<div class="gigya-screen-set" id="login-makerfaire" style="" data-on-existing-login-identifier-screen="gigya-link-account-screen"
data-on-pending-registration-screen="gigya-complete-registiration-screen" data-on-pending-verification-screen="gigya-email-verification-screen"
data-width="760">
  <div class="gigya-screen" id="gigya-login-screen" data-caption="Login" style="width: 700px;"
  data-width="700">
    <form class="gigya-login-form">
      <div class="gigya-layout-row"></div>
      <div class="gigya-layout-row">
        <div class="gigya-layout-cell">
          <h2 class="gigya-composite-control gigya-composite-control-header">Login with your social network:</h2>
          <div class="gigya-composite-control gigya-spacer"
          data-units="2" style="height: 20px;"></div>
          <div class="gigya-composite-control gigya-composite-control-social-login">
            <div class="gigya-social-login">
              <param name="width" value="300">
              <param name="height" value="100">
              <param name="enabledProviders" value="facebook,Twitter,linkedin,google,yahoo,messenger">
              <param name="buttonsStyle" value="fullLogo">
              <param name="buttonSize" value="35">
              <param name="showWhatsThis" value="false">
              <param name="showTermsLink" value="false">
              <param name="hideGigyaLink" value="true">
            </div>
          </div>
        </div>
        <div class="gigya-layout-cell">
          <h2 class="gigya-composite-control gigya-composite-control-header">Or, login here:</h2>
          <div class="gigya-composite-control gigya-spacer" data-units="2"
          style="height: 20px;"></div>
          <div class="gigya-composite-control gigya-composite-control-textbox">
            <label class="gigya-label">
              <span class="gigya-label-text">Email:</span>
            </label>
            <input type="text" name="loginID" class="gigya-input-text">
            <span class="gigya-error-msg" data-bound-to="loginID"></span>
          </div>
          <div class="gigya-composite-control gigya-composite-control-password">
            <label class="gigya-label">
              <label for="password" class="gigya-label"> <a style="float: right; font-weight: normal;                                    margin-right: 5px;"
                data-switch-screen="gigya-forgot-password-screen">Forgot password                                </a> 
                <span
                class="gigya-label-text">Password:</span>
                  <div class="gigya-clear"></div>
              </label>
            </label>
            <input type="password" name="password" class="gigya-input-password" tabindex="0">
            <span class="gigya-error-msg" data-bound-to="password"></span>
          </div>
        </div>
        <div class="gigya-clear"></div>
      </div>
      <div class="gigya-layout-row ">
        <div class="gigya-layout-cell ">
          <div class="gigya-layout-row ">
            <div class="gigya-layout-cell"></div>
            <div class="gigya-layout-cell"></div>
            <div class="gigya-clear"></div>
          </div>
        </div>
        <div class="gigya-layout-cell ">
          <div class="gigya-layout-row ">
            <div class="gigya-layout-cell">
              <div class="gigya-error-display gigya-composite-control gigya-composite-control-form-error"
              data-bound-to="gigya-login-form">
                <div class="gigya-error-msg gigya-form-error-msg" data-bound-to="gigya-login-form"
                style=""></div>
              </div>
            </div>
            <div class="gigya-layout-cell">
              <div class="gigya-composite-control gigya-composite-control-submit">
                <input type="submit" class="gigya-input-submit" value="Submit">
              </div>
            </div>
            <div class="gigya-clear"></div>
          </div>
        </div>
        <div class="gigya-clear"></div>
      </div>
      <div class="gigya-layout-row">
        <label class="gigya-composite-control gigya-composite-control-label" style="text-align: center; display: block;">Don't have an account? <a data-switch-screen="gigya-register-screen">Register now!</a>
        </label>
      </div>
      <div class="gigya-layout-row ">
        <div class="gigya-layout-cell"></div>
        <div class="gigya-layout-cell"></div>
        <div class="gigya-clear"></div>
      </div>
      <div class="gigya-layout-row ">
        <div class="gigya-layout-cell ">
          <div class="gigya-layout-row ">
            <div class="gigya-layout-cell"></div>
            <div class="gigya-layout-cell"></div>
            <div class="gigya-clear"></div>
          </div>
        </div>
        <div class="gigya-layout-cell ">
          <div class="gigya-layout-row ">
            <div class="gigya-layout-cell"></div>
            <div class="gigya-layout-cell"></div>
            <div class="gigya-clear"></div>
          </div>
        </div>
        <div class="gigya-clear"></div>
      </div>
      <div class="gigya-layout-row"></div>
      <div class="gigya-clear"></div>
    </form>
  </div>
  <div data-caption="Registration" id="gigya-register-screen" class="gigya-screen"
  style="width: 700px;" data-width="700" data-on-pending-verification-screen="gigya-thank-you-screen">
    <form class="gigya-register-form">
      <div class="gigya-layout-row"></div>
      <div class="gigya-layout-row">
        <div class="gigya-layout-row">
          <div class="gigya-layout-cell">
            <div class="gigya-layout-row">
              <h2 class="gigya-composite-control gigya-composite-control-header" style="display: block;">Register with your social network</h2>
              <div class="gigya-composite-control gigya-spacer"
              data-units="2" style="height: 20px;"></div>
              <div class="gigya-composite-control gigya-composite-control-social-login"
              style="display: block;">
                <div class="gigya-social-login">
                  <param value="300" name="width">
                  <param value="100" name="height">
                  <param name="enabledProviders" value="facebook,Twitter,linkedin,google,yahoo,messenger">
                  <param name="buttonsStyle" value="fullLogo">
                  <param name="buttonSize" value="35">
                  <param name="showWhatsThis" value="false">
                  <param name="showTermsLink" value="false">
                  <param name="hideGigyaLink" value="true">
                </div>
              </div>
            </div>
            <div class="gigya-layout-row">
              <div class="gigya-layout-cell"></div>
              <div class="gigya-layout-cell"></div>
              <div class="gigya-clear"></div>
            </div>
            <div class="gigya-layout-row"></div>
          </div>
          <div class="gigya-layout-cell">
            <div class="gigya-layout-row">
              <h2 class="gigya-composite-control gigya-composite-control-header" style="display: block;">Or, create new account</h2>
              <div class="gigya-composite-control gigya-spacer" data-units="2"
              style="height: 20px;"></div>
              <div class="gigya-composite-control gigya-composite-control-textbox" style="display: block;">
                <label class="gigya-label">
                  <span class="gigya-label-text">Email:</span>
                  <label class="gigya-required-display" data-bound-to="email">*</label>
                </label>
                <input type="text" class="gigya-input-text" name="email" data-display-name=""
                tabindex="1">
                <span class="gigya-error-msg" data-bound-to="email"></span>
              </div>
            </div>
            <div class="gigya-layout-row">
              <div class="gigya-layout-cell">
                <div class="gigya-composite-control gigya-composite-control-textbox" style="display: block;">
                  <label class="gigya-label">
                    <span class="gigya-label-text">First name:</span>
                    <label class="gigya-required-display" data-bound-to="profile.firstName"
                    style="display: none;">*</label>
                  </label>
                  <input type="text" class="gigya-input-text" name="profile.firstName" data-display-name=""
                  tabindex="2">
                  <span class="gigya-error-msg" data-bound-to="profile.firstName"></span>
                </div>
                <div class="gigya-composite-control gigya-composite-control-password" style="display: block;">
                  <label class="gigya-label">
                    <span class="gigya-label-text">Password:</span>
                    <label class="gigya-required-display" data-bound-to="password">*</label>
                  </label>
                  <input type="password" name="password" class="gigya-input-password" data-display-name=""
                  tabindex="4">
                  <span class="gigya-error-msg" data-bound-to="password"></span>
                  <div class="gigya-password-strength" data-bound-to="password" data-on-focus-bubble="true"></div>
                </div>
              </div>
              <div class="gigya-layout-cell">
                <div class="gigya-composite-control gigya-composite-control-textbox" style="display: block;">
                  <label class="gigya-label">
                    <span class="gigya-label-text">Last name:</span>
                    <label class="gigya-required-display" data-bound-to="profile.lastName"
                    style="display: none;">*</label>
                  </label>
                  <input type="text" class="gigya-input-text" name="profile.lastName" data-display-name=""
                  tabindex="3">
                  <span class="gigya-error-msg" data-bound-to="profile.lastName"></span>
                </div>
                <div class="gigya-composite-control gigya-composite-control-password">
                  <label for="password" class="gigya-label">
                    <span class="gigya-label-text">Re-enter Password:</span>
                    <label class="gigya-required-display" data-bound-to="password">*</label>
                  </label>
                  <input type="password" class="gigya-input-password" name="passwordRetype" tabindex="5"
                  data-display-name="">
                  <span class="gigya-error-msg" data-bound-to="passwordRetype"></span>
                </div>
              </div>
              <div class="gigya-clear"></div>
              <div class="gigya-clear"></div>
            </div>
            <div class="gigya-layout-row">
              <div class="gigya-composite-control gigya-composite-control-checkbox" style="display: block;">
                <input type="checkbox" name="data.terms" class="gigya-input-checkbox" data-display-name=""
                tabindex="7">
                <label class="gigya-label">
                  <span class="gigya-label-text">I have read and understood the <a href="#">Terms of Use</a> 
                  </span>
                  <label class="gigya-required-display" data-bound-to="data.terms" style="display: inline;">*</label>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="gigya-layout-row ">
        <div class="gigya-layout-cell ">
          <div class="gigya-layout-row ">
            <div class="gigya-layout-cell"></div>
            <div class="gigya-layout-cell"></div>
            <div class="gigya-clear"></div>
          </div>
        </div>
        <div class="gigya-layout-cell ">
          <div class="gigya-layout-row ">
            <div class="gigya-layout-cell">
              <div class="gigya-error-display gigya-composite-control gigya-composite-control-form-error"
              data-bound-to="gigya-register-form" style="display: block;">
                <div class="gigya-error-msg gigya-form-error-msg" data-bound-to="gigya-register-form"
                style=""></div>
              </div>
            </div>
            <div class="gigya-layout-cell">
              <div class="gigya-composite-control gigya-composite-control-submit" style="display: block;">
                <input type="submit" class="gigya-input-submit" value="Submit" tabindex="8">
              </div>
            </div>
            <div class="gigya-clear"></div>
          </div>
        </div>
        <div class="gigya-clear"></div>
      </div>
      <div class="gigya-layout-row">
        <label class="gigya-composite-control gigya-composite-control-label" style="text-align: center;">Have an account already? <a data-switch-screen="gigya-login-screen">Click here</a> 
        </label>
      </div>
      <div class="gigya-clear"></div>
    </form>
  </div>
  <div class="gigya-screen" id="gigya-complete-registiration-screen" data-caption="Complete your registration"
  style="width: 350px;" data-width="350">
    <form class="gigya-profile-form">
      <div class="gigya-layout-row">
        <label class="gigya-composite-control gigya-composite-control-label" style="display: block;">We still need some details from you...</label>
        <div class="gigya-composite-control gigya-spacer"
        data-units="1" style="height: 10px;"></div>
        <div class="gigya-composite-control gigya-composite-control-textbox" style="display: block;">
          <label class="gigya-label">
            <span class="gigya-label-text">Email:</span>
            <label class="gigya-required-display" data-bound-to="profile.email"
            style="display: inline;">*</label>
          </label>
          <input value="" name="profile.email" class="gigya-input-text" tabindex="0">
          <span class="gigya-error-msg" data-bound-to="profile.email"></span>
        </div>
        <div class="gigya-composite-control gigya-composite-control-dropdown" style="display: block;">
          <label class="gigya-label">
            <span class="gigya-label-text">Year of birth:</span>
            <label class="gigya-required-display" data-bound-to="profile.birthYear"
            style="display: none;">*</label>
          </label> <select name="profile.birthYear" tabindex="0"><option value="1920">1920</option><option value="1921">1921</option><option value="1922">1922</option><option value="1923">1923</option><option value="1924">1924</option><option value="1925">1925</option><option value="1926">1926</option><option value="1927">1927</option><option value="1928">1928</option><option value="1929">1929</option><option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960 </option><option value="1961">1961 </option><option value="1962">1962 </option><option value="1963">1963 </option><option value="1964">1964 </option><option value="1965">1965 </option><option value="1966">1966 </option><option value="1967">1967 </option><option value="1968">1968 </option><option value="1969">1969 </option><option value="1970">1970 </option><option value="1971">1971 </option><option value="1972">1972 </option><option value="1973">1973 </option><option value="1974">1974 </option><option value="1975">1975 </option><option value="1976">1976 </option><option value="1977">1977 </option><option value="1978">1978 </option><option value="1979">1979 </option><option value="1980">1980 </option><option value="1981">1981 </option><option value="1982">1982 </option><option value="1983">1983 </option><option value="1984">1984 </option><option value="1985">1985 </option><option value="1986">1986 </option><option value="1987">1987 </option><option value="1988">1988 </option><option value="1989">1989 </option><option value="1990">1990 </option><option value="1991">1991 </option><option value="1992">1992 </option><option value="1993">1993 </option><option value="1994">1994 </option><option value="1995">1995 </option><option value="1996">1996 </option><option value="1997">1997 </option><option value="1998">1998 </option><option value="1999">1999 </option><option value="2000">2000 </option><option value="2001">2001 </option><option value="2002">2002 </option><option value="2003">2003 </option><option value="2004">2004 </option></select> 
          <span
          class="gigya-error-msg" data-bound-to="profile.birthYear"></span>
        </div>
        <div class="gigya-composite-control" name="">
          <label class="gigya-label">Photo</label>
          <div class="gigya-photo-upload gigya-composite-control-photo-upload-widget"></div>
        </div>
      </div>
      <div class="gigya-layout-row">
        <div class="gigya-layout-cell"></div>
        <div class="gigya-layout-cell">
          <div class="gigya-composite-control gigya-composite-control-submit" style="display: block;">
            <input type="submit" class="gigya-input-submit" value="Submit">
          </div>
        </div>
        <div class="gigya-clear"></div>
      </div>
      <div class="gigya-layout-row ">
        <div class="gigya-layout-cell ">
          <div class="gigya-layout-row ">
            <div class="gigya-layout-cell"></div>
            <div class="gigya-layout-cell"></div>
            <div class="gigya-clear"></div>
          </div>
        </div>
        <div class="gigya-layout-cell ">
          <div class="gigya-layout-row ">
            <div class="gigya-layout-cell"></div>
            <div class="gigya-layout-cell"></div>
            <div class="gigya-clear"></div>
          </div>
        </div>
        <div class="gigya-clear"></div>
      </div>
      <div class="gigya-layout-row"></div>
      <div class="gigya-layout-row ">
        <div class="gigya-layout-cell"></div>
        <div class="gigya-layout-cell"></div>
        <div class="gigya-clear"></div>
      </div>
      <div class="gigya-layout-row ">
        <div class="gigya-layout-cell ">
          <div class="gigya-layout-row ">
            <div class="gigya-layout-cell"></div>
            <div class="gigya-layout-cell"></div>
            <div class="gigya-clear"></div>
          </div>
        </div>
        <div class="gigya-layout-cell ">
          <div class="gigya-layout-row ">
            <div class="gigya-layout-cell"></div>
            <div class="gigya-layout-cell"></div>
            <div class="gigya-clear"></div>
          </div>
        </div>
        <div class="gigya-clear"></div>
      </div>
      <div class="gigya-layout-row"></div>
      <div class="gigya-clear"></div>
    </form>
  </div>
  <div class="gigya-screen" id="gigya-link-account-screen" data-caption="Already a member"
  style="width: 400px;" data-width="400">
    <form class="gigya-link-accounts-form">
      <div class="gigya-layout-row">
        <label class="gigya-composite-control gigya-composite-control-label" style="display: block;">We found your email in our system.
          <br>Please provide your site password to link to your existing account:</label>
        <div
        class="gigya-composite-control gigya-spacer" data-units="1" style="height: 10px;"></div>
      <div class="gigya-composite-control gigya-composite-control-textbox" style="display: block;">
        <label class="gigya-label">
          <span class="gigya-label-text">Email:</span>
        </label>
        <input type="text" name="loginID" class="gigya-input-text">
        <span class="gigya-error-msg" data-bound-to="loginID"></span>
      </div>
      <div class="gigya-composite-control gigya-composite-control-password" style="display: block;">
        <label class="gigya-label">
          <span class="gigya-label-text">Password: <a style="float: right; font-weight: normal;                            margin-right: 5px;"
            data-switch-screen="gigya-forgot-password-screen">Forgot password</a>
          </span>
        </label>
        <input type="password" name="password" class="gigya-input-password">
        <span class="gigya-error-msg" data-bound-to="password"></span>
      </div>
  </div>
  <div class="gigya-layout-row">
    <div class="gigya-layout-cell"></div>
    <div class="gigya-layout-cell">
      <div class="gigya-composite-control gigya-composite-control-submit" style="display: block;">
        <input type="submit" class="gigya-input-submit" value="Submit">
      </div>
    </div>
    <div class="gigya-clear"></div>
  </div>
  <div class="gigya-layout-row ">
    <div class="gigya-layout-cell ">
      <div class="gigya-layout-row ">
        <div class="gigya-layout-cell"></div>
        <div class="gigya-layout-cell"></div>
        <div class="gigya-clear"></div>
      </div>
    </div>
    <div class="gigya-layout-cell ">
      <div class="gigya-layout-row ">
        <div class="gigya-layout-cell"></div>
        <div class="gigya-layout-cell"></div>
        <div class="gigya-clear"></div>
      </div>
    </div>
    <div class="gigya-clear"></div>
  </div>
  <div class="gigya-layout-row"></div>
  <div class="gigya-layout-row ">
    <div class="gigya-layout-cell"></div>
    <div class="gigya-layout-cell"></div>
    <div class="gigya-clear"></div>
  </div>
  <div class="gigya-layout-row ">
    <div class="gigya-layout-cell ">
      <div class="gigya-layout-row ">
        <div class="gigya-layout-cell"></div>
        <div class="gigya-layout-cell"></div>
        <div class="gigya-clear"></div>
      </div>
    </div>
    <div class="gigya-layout-cell ">
      <div class="gigya-layout-row ">
        <div class="gigya-layout-cell"></div>
        <div class="gigya-layout-cell"></div>
        <div class="gigya-clear"></div>
      </div>
    </div>
    <div class="gigya-clear"></div>
  </div>
  <div class="gigya-layout-row"></div>
  <div class="gigya-clear"></div>
  </form>
</div>
<div class="gigya-screen" id="gigya-forgot-password-screen" data-caption="Forgot password"
style="width: 350px;" data-width="350">
  <form class="gigya-reset-password-form" data-on-success-screen="gigya-forgot-password-success-screen">
    <div class="gigya-layout-row">
      <label class="gigya-composite-control gigya-composite-control-label" style="display: block;">Please enter your email address to reset your password</label>
      <div class="gigya-composite-control gigya-spacer"
      data-units="1" style="height: 10px;"></div>
      <div class="gigya-composite-control gigya-composite-control-textbox" style="display: block;">
        <label class="gigya-label">
          <span class="gigya-label-text">Email:</span>
        </label>
        <input type="text" name="loginID" class="gigya-input-text" tabindex="0">
        <span class="gigya-error-msg" data-bound-to="loginID"></span>
      </div>
    </div>
    <div class="gigya-layout-row">
      <div class="gigya-layout-cell">
        <div class="gigya-error-display gigya-composite-control gigya-composite-control-form-error"
        data-bound-to="gigya-reset-password-form" style="display: block;">
          <div class="gigya-error-msg gigya-form-error-msg" data-bound-to="gigya-reset-password-form"
          style=""></div>
        </div>
      </div>
      <div class="gigya-layout-cell">
        <div class="gigya-composite-control gigya-composite-control-submit" style="display: block;">
          <input type="submit" class="gigya-input-submit" value="Submit" tabindex="0">
        </div>
      </div>
      <div class="gigya-clear"></div>
    </div>
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell ">
        <div class="gigya-layout-row ">
          <div class="gigya-layout-cell"></div>
          <div class="gigya-layout-cell"></div>
          <div class="gigya-clear"></div>
        </div>
      </div>
      <div class="gigya-layout-cell ">
        <div class="gigya-layout-row ">
          <div class="gigya-layout-cell"></div>
          <div class="gigya-layout-cell"></div>
          <div class="gigya-clear"></div>
        </div>
      </div>
      <div class="gigya-clear"></div>
    </div>
    <div class="gigya-layout-row">
      <label class="gigya-composite-control gigya-composite-control-label" style="text-align: right; display: block;">To login with a different account <a data-switch-screen="gigya-login-screen">click here                    </a> 
      </label>
    </div>
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell"></div>
      <div class="gigya-layout-cell"></div>
      <div class="gigya-clear"></div>
    </div>
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell ">
        <div class="gigya-layout-row ">
          <div class="gigya-layout-cell"></div>
          <div class="gigya-layout-cell"></div>
          <div class="gigya-clear"></div>
        </div>
      </div>
      <div class="gigya-layout-cell ">
        <div class="gigya-layout-row ">
          <div class="gigya-layout-cell"></div>
          <div class="gigya-layout-cell"></div>
          <div class="gigya-clear"></div>
        </div>
      </div>
      <div class="gigya-clear"></div>
    </div>
    <div class="gigya-layout-row"></div>
    <div class="gigya-clear"></div>
  </form>
</div>
<div data-width="300" style="width: 300px;" data-caption="Password reset" id="gigya-forgot-password-success-screen"
class="gigya-screen">
  <div class="gigya-layout-row">
    <div style="height: 40px;" data-units="4" class="gigya-composite-control gigya-spacer"></div>
    <label class="gigya-composite-control gigya-composite-control-label gigya-message">An email regarding your password change has been sent to your email address.</label>
    <div
    class="gigya-composite-control gigya-spacer" data-units="5" style="height: 50px;"></div>
</div>
<div class="gigya-layout-row">
  <div class="gigya-layout-cell"></div>
  <div class="gigya-layout-cell"></div>
  <div class="gigya-clear"></div>
</div>
<div class="gigya-layout-row ">
  <div class="gigya-layout-cell ">
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell"></div>
      <div class="gigya-layout-cell"></div>
      <div class="gigya-clear"></div>
    </div>
  </div>
  <div class="gigya-layout-cell ">
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell"></div>
      <div class="gigya-layout-cell"></div>
      <div class="gigya-clear"></div>
    </div>
  </div>
  <div class="gigya-clear"></div>
</div>
<div class="gigya-layout-row"></div>
<div class="gigya-layout-row ">
  <div class="gigya-layout-cell"></div>
  <div class="gigya-layout-cell"></div>
  <div class="gigya-clear"></div>
</div>
<div class="gigya-layout-row ">
  <div class="gigya-layout-cell ">
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell"></div>
      <div class="gigya-layout-cell"></div>
      <div class="gigya-clear"></div>
    </div>
  </div>
  <div class="gigya-layout-cell ">
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell"></div>
      <div class="gigya-layout-cell"></div>
      <div class="gigya-clear"></div>
    </div>
  </div>
  <div class="gigya-clear"></div>
</div>
<div class="gigya-layout-row"></div>
<div class="gigya-clear"></div>
</div>
<div class="gigya-screen" id="gigya-email-verification-screen" data-caption="Your email was not verified"
style="width: 350px;" data-width="350">
  <form class="gigya-resend-verification-code-form" data-on-success-screen="gigya-thank-you-screen">
    <div class="gigya-layout-row">
      <label class="gigya-composite-control gigya-composite-control-label" style="display: block;">We have not verified that the email belongs to you. Please check your inbox for
        the verification email.
        <br>
        <br>To resend the verification email, please enter your email address and click Submit.</label>
      <div
      class="gigya-composite-control gigya-spacer" data-units="1" style="height: 10px;"></div>
    <div class="gigya-composite-control gigya-composite-control-textbox" style="display: block;">
      <label class="gigya-label">
        <span class="gigya-label-text">Email:</span>
        <span class="gigya-required"></span>
      </label>
      <input type="text" name="email" class="gigya-input-text" tabindex="0">
      <span class="gigya-error-msg" data-bound-to="email"></span>
    </div>
</div>
<div class="gigya-layout-row">
  <div class="gigya-layout-cell">
    <div class="gigya-error-display gigya-composite-control gigya-composite-control-form-error"
    data-bound-to="gigya-resend-verification-code-form" style="display: block;">
      <div class="gigya-error-msg gigya-form-error-msg" data-bound-to="gigya-resend-verification-code-form"
      style=""></div>
    </div>
  </div>
  <div class="gigya-layout-cell">
    <div class="gigya-composite-control gigya-composite-control-submit" style="display: block;">
      <input type="submit" class="gigya-input-submit" value="Submit">
    </div>
  </div>
  <div class="gigya-clear"></div>
</div>
<div class="gigya-layout-row ">
  <div class="gigya-layout-cell ">
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell"></div>
      <div class="gigya-layout-cell"></div>
      <div class="gigya-clear"></div>
    </div>
  </div>
  <div class="gigya-layout-cell ">
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell"></div>
      <div class="gigya-layout-cell"></div>
      <div class="gigya-clear"></div>
    </div>
  </div>
  <div class="gigya-clear"></div>
</div>
<div class="gigya-layout-row">
  <label class="gigya-composite-control gigya-composite-control-label" style="text-align: right; display: block;">To login with a different account <a data-switch-screen="gigya-login-screen">click here                    </a> 
  </label>
</div>
<div class="gigya-layout-row ">
  <div class="gigya-layout-cell"></div>
  <div class="gigya-layout-cell"></div>
  <div class="gigya-clear"></div>
</div>
<div class="gigya-layout-row ">
  <div class="gigya-layout-cell ">
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell"></div>
      <div class="gigya-layout-cell"></div>
      <div class="gigya-clear"></div>
    </div>
  </div>
  <div class="gigya-layout-cell ">
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell"></div>
      <div class="gigya-layout-cell"></div>
      <div class="gigya-clear"></div>
    </div>
  </div>
  <div class="gigya-clear"></div>
</div>
<div class="gigya-layout-row"></div>
<div class="gigya-clear"></div>
</form>
</div>
<div class="gigya-screen" id="gigya-thank-you-screen" data-caption="Thank you for registering!"
style="width: 300px;" data-width="300">
  <div class="gigya-layout-row">
    <div class="gigya-composite-control gigya-spacer" data-units="4" style="height: 40px; display: block;"></div>
    <label class="gigya-composite-control gigya-composite-control-label gigya-message">A confirmation email has been sent to you with a link to activate the account.</label>
    <div
    class="gigya-composite-control gigya-spacer" data-units="5" style="height: 50px; display: block;"></div>
</div>
<div class="gigya-layout-row">
  <div class="gigya-layout-cell"></div>
  <div class="gigya-layout-cell"></div>
  <div class="gigya-clear"></div>
</div>
<div class="gigya-layout-row ">
  <div class="gigya-layout-cell ">
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell"></div>
      <div class="gigya-layout-cell"></div>
      <div class="gigya-clear"></div>
    </div>
  </div>
  <div class="gigya-layout-cell ">
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell"></div>
      <div class="gigya-layout-cell"></div>
      <div class="gigya-clear"></div>
    </div>
  </div>
  <div class="gigya-clear"></div>
</div>
<div class="gigya-layout-row"></div>
<div class="gigya-layout-row ">
  <div class="gigya-layout-cell"></div>
  <div class="gigya-layout-cell"></div>
  <div class="gigya-clear"></div>
</div>
<div class="gigya-layout-row ">
  <div class="gigya-layout-cell ">
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell"></div>
      <div class="gigya-layout-cell"></div>
      <div class="gigya-clear"></div>
    </div>
  </div>
  <div class="gigya-layout-cell ">
    <div class="gigya-layout-row ">
      <div class="gigya-layout-cell"></div>
      <div class="gigya-layout-cell"></div>
      <div class="gigya-clear"></div>
    </div>
  </div>
  <div class="gigya-clear"></div>
</div>
<div class="gigya-layout-row"></div>
<div class="gigya-clear"></div>
</div>
</div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
	<div class="container">

		<div class="topad">
			<!-- Beginning Sync AdSlot 1 for Ad unit header ### size: [[728,90]]  -->
			<div id='div-gpt-ad-664089004995786621-1'>
				<script type='text/javascript'>
					googletag.cmd.push(function(){googletag.display('div-gpt-ad-664089004995786621-1')});
				</script>
			</div>
			<!-- End AdSlot 1 -->  
		</div>
		
			<div class="row">
			
				<div class="span5">
			
					<h1><a href="http://makerfaire.com" title="Maker Faire"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/logo.jpg" width="380" alt="Maker Faire" title="Maker Faire"></a></h1>
			
				</div>
				
				<div class="span7">
			
					<div class="nav navi">

						<?php

							$defaults = array(
								'theme_location'  => '',
								'menu'            => 'header-menu',
								'container'       => false,
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'menu',
								'menu_id'         => '',
								'echo'            => true,
								'fallback_cb'     => 'wp_page_menu',
								'before'          => '',
								'after'           => '',
								'link_before'     => '<div>',
								'link_after'      => '</div>',
								'items_wrap'      => '<ul id="%1$s" class="%2$s" style="margin-left:12px;">%3$s</ul>',
								'depth'           => 0,
								'walker'          => ''
							);

						wp_nav_menu( $defaults );	

						?>
					
					</div><!--end nav wrapper-->
					
				</div>
			
			</div>
		
		</div>
		
	</div>


</header>