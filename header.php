<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#" lang="en">
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# object: http://ogp.me/ns/object#">
	<meta charset="utf-8">
	<meta name="apple-itunes-app" content="app-id=463248665"/>

	<title><?php bloginfo('name'); ?> | <?php is_home() ? bloginfo('description') : wp_title(''); ?></title>
	<meta name="description" content="<?php if ( is_single() ) {
				echo wp_trim_words(strip_shortcodes(get_the_excerpt('...')), 20);
			} else {
				bloginfo('name'); echo " - "; bloginfo('description');
			}
			?>" />

	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le styles -->
	
	<script type="text/javascript" src="http://use.typekit.com/fzm8sgx.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

	<script type="text/javascript" charset="utf-8">
		$.embedly.defaults['key'] = '899d8ef024274909b3fabb22f2f8ee24';
	</script>
	

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


<body id="bootstrap-js" <?php body_class(); ?>>

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
							<li class=""><a href="http://blog.makezine.com">Blog</a></li>
							<li class=""><a href="http://makezine.com/magazine">Magazine</a></li>
							<li class=""><a href="http://makerfaire.com">Maker Faire</a></li>
							<li class=""><a href="http://makezine.com">Make: Projects</a></li>
							<li class=""><a href="http://makershed.com">Maker Shed</a></li>
							<li class=""><a href="http://kits.makezine.com">Kits</a></li>
			</ul>
			<ul class="nav pull-right">
				<li>
					<form action="http://blog.makezine.com/search/" class="form-horizontal form-search"> 
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

	<div class="container">

		<p class="tagline"><strong><em>A two-day, family-friendly festival of invention, creativity and resourcefulness, and a celebration of the Maker movement.</em></strong></p>
		
			<div class="row">
			
				<div class="span5">
			
					<h1><a href="http://makerfaire.com" title="Maker Faire"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/logo.jpg" width="380" alt="Maker Faire" title="Maker Faire"></a></h1>
			
				</div>
				
				<div class="span7">
					<!--<p class="blurb">
						Maker Faire is the premier event for grassroots American innovation.
						<img src="http://makerfaire.com/new/images/cross.png" alt="Cross" />
					</p>-->
			
					<div class="nav navi">
					
						<ul style="margin-left:10px;">
							
							<li class="dropdown inline">
								<a href="http://makerfaire.com/be-a-maker.html">
									<img src="http://makerfaire.com/new/images/be-a-maker.png" alt="Be a Maker" title="Be a Maker">
								</a>
								<!--<ul class="dropdown-menu">
									<li><h4>New York</h4></li>
									<li><a href="http://makerfairenyc.eventbrite.com/">Buy Tickets</a></li>
									<li><a href="http://makerfaire.com/newyork/2012/attend/index.html">Ticket Information</a></li>
									<li><a href="http://makezine.com/makerfaire/newyork/2012/directions.html">Directions</a></li>
									<li><a href="http://makerfaire.com/newyork/2012/hotel.html">Where to Stay</a></li>
									<li><a href="http://makerfaire.com/newyork/2012/faq/index.html">FAQ</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/tickets/outlets.html">Ticket Outlets</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/schedule/index.html">Program Guide &amp; Schedule</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/makerinfo">Meet the Makers</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/schedule/grid.html">Schedule</a></li>1
									<li><a href="http://makerfaire.com/bayarea/2012/press/register.html">Press Registration</a></li>-->
									<!--<li class="divider"></li>
									<li><h4>Bay Area</h4></li>
									<li><a href="http://makerfairebayarea.eventbrite.com/">Buy Tickets</a></li
									<li><a href="http://makerfaire.com/bayarea/2012/tickets/">Ticket Information</a></li>								
									<li><a href="http://makerfaire.com/bayarea/2012/tickets/outlets.html">Ticket Outlets</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/schedule/index.html">Program Guide &amp; Schedule</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/makerinfo">Meet the Makers</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/schedule/grid.html">Schedule</a></li>1
									<li><a href="http://makerfaire.com/bayarea/2012/car.html">Getting There by Car</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/alternative.html">Alternatives to Driving</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/hotel.html">Where to Stay</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/press/register.html">Press Registration</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/faq.html">FAQ</a></li>

								</ul>-->
								
							</li>
							
							<li class="dropdown inline">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="http://makerfaire.com/new/images/check-out-the-program.png" alt="Check out the Program" title="Check out the Program">
								</a>
								<ul class="dropdown-menu">
									<li><a style="font-size:14px; font-weight:bold;" href="http://makerfaire.com/live">2012 Video Highlights</a></li>
									<li class="divider"></li>
									<li><h4>New York</h4></li>
									<li><a href="http://makerfaire.com/newyork/2012/makerinfo/index.html">Meet the Makers</a></li>
									<li><a href="http://makerfaire.com/newyork/2012/schedule/index.html">Program &amp; Schedule</a></li>
									<li><a href="http://makerfaire.com/newyork/2012/beat-reports/index.html">MAKE Editorial Coverage</a></li>

									<li class="divider"></li>
									<li><h4>Bay Area</h4></li>
									<li><a href="http://makerfaire.com/bayarea/2012/schedule/index.html">Program &amp; Schedule</a></li>
									<li><a href="http://app.net/makerfaire">Download the App</a></li>

								</ul>
							</li>
							
							<li class="dropdown inline">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/how-to-participate1.png" alt="How to Participate" title="See all the Faires">
								</a>
								
								<ul class="dropdown-menu">
									<li><h4>New York</h4></li>
									<li><a href="http://makerfaire.com/newyork/2012/callformakers/">Call for Makers</a></li>
									<li><a href="http://makerfaire.com/newyork/2012/toolkit.html">Maker Toolkit</a></li>
									<li><a href="http://makerfaire.com/newyork/2012/makercorps/index.html">Volunteer / Maker Corps Training</a></li>
									<li><a href="http://makerfaire.com/newyork/2012/badges.html">Badges</a></li>
									<li><a href="http://makerfaire.com/newyork/2012/promote/index.html">Promote</a></li>
									<li class="divider"></li>
									<li><h4>Bay Area</h4></li>
									<li><a href="http://makerfaire.com/bayarea/2012/makerinfo">Meet the Makers</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/schedule/index.html">Program Guide &amp; Schedule</a></li>
									<!--li><a href="http://makerfaire.com/bayarea/2012/callformakers/">Call for Makers</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/toolkit.html">Maker Toolkit</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/maker-in-training/">Volunteer / Maker Corps Training</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/promote/">Promote</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/education-day/">Education Day</a></li-->
									<li class="divider"></li>
									<li><a href="http://makerfaire.com/sponsors/">Sponsors</a></li>
									<!--<li><a href="http://makerfaire.com/education/">Educators</a></li>-->
									<li><a href="http://makezine.com/makerfaire/be-a-maker.html">Be A Maker</a></li>
								</ul>
								
							</li>
							<li class="dropdown inline">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="http://makerfaire.com/new/images/nav_03.png" alt="In the Media" title="In the Media">
								</a>
								
								<ul class="dropdown-menu">
									<li><a href="http://makerfaire.com/press/highlights.html">Highlights</a></li>
									<li><a href="http://makerfaire.com/newyork/2012/beat-reports/index.html">MAKE Editorial Coverage</a></li>
									<li><a href="http://makerfaire.com/newyork/2012/press/register.html">Press Registration</a></li>
									<!--li><a href="http://makerfaire.com/bayarea/2012/press/">Press</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/press/releases.html">Press Releases</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/press/kits.html">Press Kits</a></li-->
								</ul>
								
								
								
							</li>
							<li class="dropdown inline"><a href="http://makerfaire.com/bayarea/2012/map.html">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="http://makerfaire.com/new/images/nav_04.png" alt="See all the Faires" title="See all the Faires">
								</a>
								
								<ul class="dropdown-menu">
									<li><a href="http://makerfaire.com/newyork/2012/">New York</a></li>
									<li><a href="http://makerfaire.com/bayarea/2012/index.html">Bay Area</a></li>
									<li class="divider"></li>
									<li><a href="http://makerfaire.com/map.html">Find a Faire Near You</a></li>
									<li><a href="http://makerfaire.com/mini/make-a-maker-faire.html">Make a Maker Faire</a></li>
									<li class="divider"></li>
									<li><a href="http://makerfaire.com/archive.html">See Faires From Years Past</a></li>
									<li><a href="http://makerfaire.com/blue-ribbon/">Blue Ribbon Winners</a></li>			

								</ul>
							
							</li>
						</ul>
					
					</div>
					
				</div>
			
			</div>
		
		</div>
		
	</div>


</header>