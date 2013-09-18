<div class="span4">

	<div class="sidebar-bordered">

		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mr-makey.png" alt="Mr. Makey" class="makey pull-left">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/countdown.png" alt="Mr. Makey" class="counter pull-left">
		<h5>Sept 21 &amp; 22, New York Hall of Science</h5>

		<div class="countdown">

			<script type="text/javascript">

				jQuery(document).ready(function() {
					mfba = new Date(2013, 9-1, 21, 9, 00);
					jQuery('.countdown').countdown({
						until: mfba,
						timezone: -5,
						format: 'DHMS',
						layout:'<div class="countdown-numbers"><table><tr><th>{dnn}</th><th>{sep}</td><th>{hnn}</th><th>{sep}</td><th>{mnn}</th><th>{sep}</td><th>{snn}</th></tr><tr class="time"><td>Days</td><td></td><td>Hours</td><td></td><td>Minutes</td><td></td><td>Seconds</td></tr></table></div>',
						timeSeparator:'<span class="separator">:</span>',
					});

				});
			</script>

		</div>

		<p class="buy-tickets"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/buy-tickets.png" alt="Buy tickets for Maker Faire" class=""></p>

		<hr>

		<h3>Get news and updates on all faires and calls for makers.</h3>

		<form class="form-inline" action="http://makermedia.createsend.com/t/r/s/jjuruj/" method="post" id="subForm"> 
			<input type="text" placeholder="Enter your email" class="" name="cm-jjuruj-jjuruj" id="jjuruj-jjuruj">
			<input type="image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/go.png" value="Go!" class="btn">
		</form>

		<div class="bm">
			<ul>
				<li><a href="http://twitter.com/makerfaire"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/twitter1.png" alt="Maker Faire on twitter" /></a></li>
				<li><a href="http://youtube.com/makerfaire"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/youtube.png" alt="Maker Faire on YouTube" /></a></li>
				<li><a href="http://www.flickr.com/photos/tags/makerfaire/"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/flickr.png" alt="Maker Faire on Flickr" /></a></li>
				<li><a href="http://facebook.com/makerfaire"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/facebook.png" alt="Maker Faire on facebook" /></a></li>
				<li><a href="http://instagram.com/makerfaire"><img src="http://cdn.makezine.com/make/social-icons/instagram-icon-32.png" alt="MAKE on Instagram" height="32" width="32"></a></li>
				<li><a href="https://google.com/+MAKE/"><img src="http://cdn.makezine.com/make/google-plus-icon.jpg" alt="MAKE on Google+" height="32" width="32"></a></li>
				<li><a href="http://blog.makezine.com/category/events-3/maker-faire-events/feed/"><img src="http://cdn.makezine.com/make/makerfaire/bayarea/2012/images/rss.png" alt="Maker Faire News Feed" /></a></li>
			</ul>
		</div>

	</div>

	<div class="sidebar-bordered sponsored">

		<h3>Presented By</h3>

		<div class="center">
			<a href="http://disney.com/">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sponsors/disney.png" alt="Disney" class="center"></a>
		</div>

		<h3>Goldsmith Sponsor</h3>

		<div id="myCarousel" class="carousel slide">
			<div class="carousel-inner">
				<?php mf_sponsor_carousel( 'Goldsmith Sponsor' ); ?>
			</div>
		</div>

		<h3>Silversmith Sponsor</h3>

		<div id="myCarousel" class="carousel slide">
			<div class="carousel-inner">
				<?php mf_sponsor_carousel( 'Silversmith Sponsor' ); ?>
			</div>
		</div>

		<h3>Coppersmith Sponsor</h3>

		<div id="myCarousel" class="carousel slide">
			<div class="carousel-inner">
				<?php mf_sponsor_carousel( 'Coppersmith Sponsor' ); ?>
			</div>
		
		</div>

	</div>

	<!-- Beginning Sync AdSlot 2 for Ad unit header ### size: [[300,250]]  -->
	<div id='div-gpt-ad-664089004995786621-2'>
		<script type='text/javascript'>
			googletag.cmd.push(function(){googletag.display('div-gpt-ad-664089004995786621-2')});
		</script>
	</div>
	<!-- End AdSlot 2 -->

	<div class="center">
		<a href="https://twitter.com/makerfaire" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @makerfaire</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		<a class="twitter-timeline" href="https://twitter.com/search?q=%23makerfaire" data-widget-id="322225978648698880">Tweets about "#makerfaire"</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>

	<!-- Beginning Sync AdSlot 3 for Ad unit header ### size: [[300,250]]  -->
	<div id='div-gpt-ad-664089004995786621-3'>
		<script type='text/javascript'>
			googletag.cmd.push(function(){googletag.display('div-gpt-ad-664089004995786621-3')});
		</script>
	</div>
	<!-- End AdSlot 2 -->

</div>