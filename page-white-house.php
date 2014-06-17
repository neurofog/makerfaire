<?php
/**
 * Template name: White House Template
 */
get_header(); ?>

<div class="blue" style="
	text-align:center;
	height:120px;
	background-color:#D9F0FA;
	padding-top:20px;
	margin-bottom:80px;
	margin-top:-40px;
	">
	<div class="container">
		<div class="row">
			<div class="span12">
				<img src="https://makerfaire.files.wordpress.com/2014/06/white-house2.png" width="160">
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