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
					// Adding the Ohm for one Maker... Will probably pull this out at somepoint.
					$json = json_decode( mf_character_fixer( $content ) );
				?>
				
				<article <?php post_class(); ?>>

					
					<?php echo ( !empty( $json->maker_faire ) ) ? '<h5><small>' . mf_better_name( $json->maker_faire ) . '</small></h5>' : ''; ?>
					
					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

					<?php
						if ($json->form_type == 'exhibit') {
							// echo mf_location( get_the_ID() );
						}
					?>
					
					<?php echo mf_get_scheduled_item( get_the_ID() ); ?>
					
					<?php mf_public_blurb( $json ); ?>
					
					<hr>
					
					<?php if ( function_exists( 'sharing_display') ) echo sharing_display(); ?> 
				
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