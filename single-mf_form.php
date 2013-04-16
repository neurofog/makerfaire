<?php
/**
 * Template Name: Exhibits
 *
 */
get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<?php 
					$content = get_the_content();
					$json = json_decode( str_replace( "\'", "'", $content ) );
				?>
				
				<article <?php post_class(); ?>>

					<h5>
						<small>
							<?php 
								if ( !empty( $json->maker_faire ) ) {
									echo mf_better_name( $json->maker_faire );
								}
							?>
						</small>
					</h5>
					
					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

					<?php // echo mf_location( get_the_ID() ); ?>
					
					<?php mf_public_blurb( $json ); ?>
					

					<div class="row">

						<div class="postmeta">

							<div class="span-thumb thumbnail">
							
								<?php echo get_avatar( get_the_author_meta('user_email'), 72); ?>
							
							</div>
							
							<div class="span-well well">
							
								<p>Posted by <?php the_author_posts_link(); ?> | <a href="<?php the_permalink(); ?>"><?php the_time('l F jS, Y g:i A'); ?></a></p>
								<p>Categories: <?php the_category(', '); ?> | <?php comments_popup_link(); ?> <?php edit_post_link('Fix me...', ' | '); ?></p>

							</div>

						</div>

						<div class="clear"></div>
						
					</div>
				
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