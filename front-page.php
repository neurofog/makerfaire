<?php get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<article <?php post_class( 'home-page' ); ?>>

					<?php //the_content(); ?>


					<div class="row-fluid top-header">
						<div class="span4">
							<h2 class="big-title right-border">650+ Maker <span>Exhibits</span></h2>
						</div>
						<div class="span8 exhibit-types">
							<ul>
								<li>Technology</li>
								<li>Science</li>
								<li class="no-bull">Craft</li>
								<li>Fashion</li>
								<li>Art</li>
								<li class="no-bull">Food &amp; much more!</li>
							</ul>
						</div>
					</div>
					<div class="top-featured">
						<iframe src="http://player.vimeo.com/video/70982386" width="100%" height="337" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
					</div>
					<div class="row-fluid top-content">
						<div class="span4">
							<h2 class="big-title">Fantastical Attractions</h2>
							<ul>
								<li>Build a drone or join the Power Racing Series and let your imagination GO.</li>
								<li>Don't miss robots, DIY puppets and creativity around every corner.</li>
								<li>Catch the brilliantly timed fountains of the Coke Zero and Mentos Show.</li>
								<li>The Life Size Mousetrap will be up to their usual antics.</li>
							</ul>
						</div>
						<div class="span4">
							<h2 class="big-title">How-To Workshops</h2>
							<ul>
								<li>Learn to solder, pick locks, and program with Arduino, and Raspberry Pi.</li>
								<li>Make an AeroQuad, a flying open source multicopter!</li>
								<li>Learn to knit, crochet, cross-stitch, needlepoint or spin.</li>
								<li>Explore welding at Lincoln VRTEX 360 virtual simulator stations.</li>
							</ul>
						</div>
						<div class="span4">
							<h2 class="big-title">Inspiring Presentations</h2>
							<ul>
								<li>The latest news from maker tech leaders of Makerbot, Arduino, and Beaglebone.</li>
								<li>Maker Movement thinkers, educators, and writers will entertain and inspire you.</li>
								<li>Panel discussions about emerging tech, new practices, and building community.</li>
								<li>Popular maker platform demos all day long.</li>
							</ul>
						</div>
					</div>
					<div class="thumbnail">
						<div class="border-bottom">
							<h3>Upcoming Maker Faires</h3>
							<p class="pull-right"><a href="http://makerfaire.com/map/">See All</a></p>
						</div>
						<h4 class="text-center"><a href="#">Maker Faire Rome</a> &bull; October 3 - 6, 2013</p>
						<p class="text-center">Palazzo dei Congressi, Roma, Italy</p>
						<h4 class="text-center"><a href="#">Maker Faire Tokyo</a> &bull; November 3 - 4, 2013</p>
						<p class="text-center">National Museum of Emerging Science &amp; Innovation, Tokyo, Japan</p>
					</div>
					<?php echo do_shortcode( '[news]' ); ?>

					<div class="clear"></div>
				
				</article>
							
			<?php endwhile; ?>

				<ul class="pager">
			
					<li class="previous"><?php previous_posts_link('&larr; Previous Page'); ?></li>
					<li class="next"><?php next_posts_link('Next Page &rarr;'); ?></li>
				
				</ul>
			
			<?php else: ?>
			
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			
			<?php endif; ?>

		</div><!--Content-->

		<?php get_sidebar(); ?>

	</div>
	
</div><!--Container-->

<?php get_footer(); ?>