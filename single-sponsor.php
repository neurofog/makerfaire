<?php
/**
 * Sponsor Single Page Template
 *
 * @package makerfaire
 *
 */
get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article <?php post_class(); ?>>

					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

					<?php the_post_thumbnail( array( 610, 9999 ), array( 'class' => 'thumbnail' ) ); ?>

					<hr>

					<div class="lead">
						<?php the_content(); ?>
					</div>

					<?php
					$meta = get_post_meta( get_the_id() );

					if ( $meta['sponsor-url'][0] || $meta['sponsor-video'][0] ) {
						echo '<hr>';
						echo ( !empty( $meta['sponsor-url'][0] ) ) ? '<a class="btn btn-info" href="'. esc_url( $meta['sponsor-url'][0] ) . '"><i class="icon-home icon-white"></i> Website</a>' : null ;
						echo ' ';
						echo ( !empty( $meta['sponsor-video'][0] ) ) ? '<a class="btn btn-info" href="'. esc_url( $meta['sponsor-video'][0] ) . '"><i class="icon-facetime-video icon-white"></i> Video</a>' : null ;
						if (!empty( $meta['sponsor-video'][0] ) ) {
							echo '<hr />';
							echo wpcom_vip_wp_oembed_get( esc_url( $meta['sponsor-video'][0] ), array( 'width'=>620 ) );
						}
						echo '<hr>';
					}

					$cats = get_the_terms( get_the_ID(), 'category' );
					$tags = get_the_terms( get_the_ID(), 'post_tag' );
					$terms = array_merge( $cats, $tags );
					if ( $terms ) {
						echo '<p>Explore Similar Projects in these Areas: ';
						foreach ( $terms as $idx => $term ) {
							echo ( $idx != 0 ) ? ', <a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>' : '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
						}
						echo '</p>';
					}
					?>

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