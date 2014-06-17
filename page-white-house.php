<?php
/**
 * Template name: White House Template
 */
get_header(); ?>

<style type="text/css" media="screen">
nav.wh {
	margin-bottom: 20px;
}
nav.wh ul {
  text-align: center;
  margin: 0 auto;
}
nav.wh ul li {
  text-transform: uppercase;
  font-size: 13px;
  font-weight: bold;
  border-right: 1px dashed #005d8f;
  padding-right: 10px !important;
  padding-left: 10px;
  display: inline-block;
  text-align: center;
}
nav.wh ul li.active a {
  transition: color 0.5s ease;
  color: #007ec2;
}
nav.wh ul li a {
  color: #005d8f;
}
nav.wh ul li:last-of-type {
  border-right: 0px;
}
</style>

<div class="clearfix"></div>

<div class="blue" style="text-align:center; height:60px; background-color:#D9F0FA; padding-top:20px; margin-bottom:80px; margin-top:20px;">
	<div class="container">
		<img src="https://makerfaire.files.wordpress.com/2014/06/white-house2.png" width="160" class="pull-left" style="margin-top:-60px; margin-bottom:40px;">
		<nav class="wh">
			<ul class="inline">
				<li data-show="activities" class="linker nav-map"><a href="http://makezine.com/day-of-making/#activities">Day of<br> Making</a></li>
				<li data-show="null" class="nav-white-house"><a href="http://makerfaire.com/white-house/">White House<br> Maker Faire</a></li>
				<li data-show="proclamation" class="linker nav-proclamation"><a href="http://makezine.com/day-of-making/#proclamation">Presidential<br> Proclamation</a></li>
				<li data-show="signup" class="linker nav-home"><a href="http://makezine.com/day-of-making/#signup">Support Your<br> Maker Community</a></li>
				<li data-show="map" class="linker nav-map-full"><a href="http://makezine.com/day-of-making/#map">#NationOfMakers<br> Map</a></li>
				<li data-show="pledge" class="linker nav-pledge"><a href="http://makezine.com/day-of-making/#pledge">Maker<br> Pledge</a></li>
			</ul>
		</nav>
		<div class="row">
			<div class="span12">

			</div>
		</div>
	</div>
</div>

<div class="container">

	<div class="row">

		<div class="content span12">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article <?php post_class(); ?>>

					<?php the_content(); ?>

				</article>

				<section class="posts"></section>

			<?php endwhile; ?>

				<ul class="pager">

					<li class="previous"><?php previous_posts_link('&larr; Previous Page'); ?></li>
					<li class="next"><?php next_posts_link('Next Page &rarr;'); ?></li>

				</ul>

			<?php else: ?>

				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

			<?php endif; ?>

		</div><!--Content-->

	</div>

</div><!--Container-->

<?php get_footer(); ?>