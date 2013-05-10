	<div class="span4">

	<div class="home-sidebar">
	
		<div class="newsletter">
			<div class="robot pull-left">
				<img src="<?php echo get_template_directory_uri(); ?>/images/robot.png"/>
			</div>

			<div class="textform pull-right">
				
				<h3>Get News and Updates on all Faires and Calls for Makers</h3>
			
				<div class="row" style="">

					<form class="form-inline" action="http://makermedia.createsend.com/t/r/s/jjuruj/" method="post" id="subForm"> 

							<script type="text/javascript">

								jQuery(document).ready(function(){

									jQuery('#jjuruj-jjuruj').focus(function() {
										jQuery('.hide').slideDown('fast').css('margin-left', '20px');
									});

								});

							</script>

							<div class="hide" style="margin-left:20px;">
								<div class="control-group" style="margin-top: 5px;">
									<h3>
										<label class="control-label" for="inlineCheckboxes">Preferred Faire?</label>
									</h3>
									<div class="controls" style="margin-top: -10px;margin-left: 5px;">
										<h3>
											<label class="checkbox inline" for="cm188882" style="padding-top: 8px;padding-right: 10px;">
												<input type="checkbox" name="cm-fo-jdlthk" id="cm188882" value="188882"> Bay Area
											</label>
											<label class="checkbox inline">
												<input type="checkbox" name="cm-fo-jdlthk" id="cm188884" value="188884">New York
											</label>
										</h3>
									</div>
								</div>
								<div class="control-group">
									<div class="controls">
										<h3 style="margin-left:5px">\
											<label class="checkbox inline" for="cm188888">
												<input type="checkbox" name="cm-fo-jdliji" id="cm188888" value="188888"> Are you a Maker?
											</label>
										</h3>
									</div>
								</div>
							</div>
						</div>		
						<div>
							<input type="text" placeholder="Enter your email" class="span2 small" name="cm-jjuruj-jjuruj" id="jjuruj-jjuruj">
							<input type="submit" value="Go!" style="margin-bottom:9px;" class="btn btn-danger btn-small">
						</div>
					</form>
			</div>
		</div> 
		<div class="clear"></div>
				
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
		
		<h3 style="text-align:center;">Countdown until Bay Area!</h3>
		
		<div class="countdown">
			
			<script type="text/javascript">
				// var newYear = new Date(); 
				// newYear = new Date('2013-05-18 9:00 AM UTC -0800'); 
				// jQuery('.countdown').countdown({until: newYear });

				jQuery(document).ready(function() {
					var newYear = new Date();
					mfba = new Date(2013, 5-1, 18, 10, 00);
					jQuery('.countdown').countdown({
						until: mfba,
						timezone: -7,
						format: 'DHMS',
						layout:'<div class="countdown-numbers"><table><tr><th>{dnn}</th><th>{sep}</td><th>{hnn}</th><th>{sep}</td><th>{mnn}</th><th>{sep}</td><th>{snn}</th></tr><tr class="time"><td>Days</td><td></td><td>Hours</td><td></td><td>Minutes</td><td></td><td>Seconds</td></tr></table></div>',
						timeSeparator:'<span class="separator">:</span>',
					});

				});
			</script>
			
		</div>
		<div id="buy-ticket">
			<a href="http://makerfaire2013.eventbrite.com/">
				<img src="http://cdn.makezine.com/make/makerfaire/images/ticket.png" width="296" height="100" alt="Get your tickets today">
			</a>
		</div>
		
	</div>
	
	<div>
		
		<div class="count">
		
			<h3><a class="red" href="http://makerfaire.com/sponsors/">Maker Faire Sponsors</a></h3>
			<div id="myCarousel" class="carousel slide">
				<div class="carousel-inner">
					<?php 
						$sponsors = get_bookmarks( array( 'orderby' => 'rating' ) );
						foreach ($sponsors as $idx => $sponsor) {
							if ( $idx == 0 ) {
								echo '<div class="item active">';
							} else {
								echo '<div class="item">';
							}
							echo '<a href="' . esc_url( $sponsor->link_url ) . '"><img src="' . esc_url( $sponsor->link_image ) . '" alt="' . esc_attr( $sponsor->link_name ) . '"></a></div>';
						}
					?>
				</div>
			</div>
			
			<!-- Beginning Sync AdSlot 2 for Ad unit header ### size: [[300,250]]  -->
			<div id='div-gpt-ad-664089004995786621-2'>
				<script type='text/javascript'>
					googletag.cmd.push(function(){googletag.display('div-gpt-ad-664089004995786621-2')});
				</script>
			</div>
			<!-- End AdSlot 2 -->
		
			<div class="row" style="margin-top: 10px;">

				<div class="span4" style="text-align:center;">
					<a href="https://twitter.com/makerfaire" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @makerfaire</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
					<a class="twitter-timeline" href="https://twitter.com/search?q=%23makerfaire" data-widget-id="322225978648698880">Tweets about "#makerfaire"</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>

			</div>
			
			<?php if ( !is_front_page() ) { ?>
			
			<div class="featured">
			
				<h3>Upcoming Featured Faires</h3>
				<div class="row">
					<div class="span1">
						<img alt="Maker Faire Kansas City" src="http://makerfaire.files.wordpress.com/2013/01/kansascity-mf-sq-01_001.gif?w=75&amp;h=60" width="75" height="60">
					</div>
					<div class="span3">
						<h4 class="smaller"><a href="http://www.makerfairekc.com/">Maker Faire <small style="color:#0088cc;">Kansas City</small></a></h4>
						<ul class="unstyled">
							<li>June 29<sup>th</sup>and 30<sup>th</sup>, 2013</li>
							<li>Union Station</li>
						</ul>
					</div>
				</div>
				
				<div class="row">
					<div class="span1">
						<img alt="Maker Faire Detroit" src="http://makerfaire.files.wordpress.com/2013/01/detroit-mf-sq.gif?w=75" width="75">
					</div>
					<div class="span3">
						<h4 class="smaller"><a href="http://www.makerfairedetroit.com/">Maker Faire <small style="color:#0088cc;">Detroit</small></a></h4>
						<ul class="unstyled">
							<li>Date: July 27<sup>th</sup> and 28<sup>th</sup>, 2013</li>
							<li>The Henry Ford</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="span1">
						<img alt="Maker Faire Rome" src="http://makerfaire.files.wordpress.com/2013/01/rome-mf-sq_logowithtag_logowithtag.gif?w=75" width="75">
					</div>
					<div class="span3">
						<h4 class="smaller"><a href="http://www.makerfairerome.eu/">Maker Faire <small style="color:#0088cc;">Rome</small></a></h4>
						<ul class="unstyled">
							<li>Date: October 3<sup>rd</sup> through 6<sup>th</sup>, 2013</li>
							<li>Campo Boario</li>
						</ul>
					</div>
				</div>	
				<div class="row">
					<div class="span1">
						<img alt="Maker Faire Tokyo" src="http://makerfaire.files.wordpress.com/2013/05/tokyo-mf-sq_logo.gif?w=75" width="75">
					</div>
					<div class="span3">
						<h4 class="smaller"><a href="http://makezine.jp/">Maker Faire <small style="color:#0088cc;">Tokyo</small></a></h4>
						<ul class="unstyled">
							<li>Date: TBD 2013</li>
							<li>Location: TBD</li>
						</ul>
					</div>
				</div>	
			</div>
			
			<?php } ?>
			
		</div>
	
		<?php //echo makerfaire_sidebar_news(); ?>
		
		<!-- Beginning Sync AdSlot 3 for Ad unit header ### size: [[300,250]]  -->
		<div id='div-gpt-ad-664089004995786621-3'>
			<script type='text/javascript'>
				googletag.cmd.push(function(){googletag.display('div-gpt-ad-664089004995786621-3')});
			</script>
		</div>
		<!-- End AdSlot 3 -->

	</div>

	<div class="clear"></div>

</div>
		
</div>