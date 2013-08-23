<?php 
/**
 * Tag/Category/Faire Archive Page
 * Template Name: Faire Tax Archive Page
 */

// Let's setup some variables, yo.
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$cat = get_query_var( 'category_name' ) ? sanitize_title_for_query( get_query_var( 'category_name' ) ) : '';
$tag = get_query_var( 'tag' ) ? sanitize_title_for_query( get_query_var( 'tag' ) ) : '';

get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">
			
			<div class="page-header">
				
				<h1><?php the_title(); ?> <small>World Maker Faire New York 2013</small></h1>	
				
			</div>
			
			<?php get_search_form(); ?>
			
			<?php
			
			$args = array(
				'post_type'		=> 'mf_form',
				'post_status'	=> 'accepted',
				'orderby' 		=> 'title',
				'order'			=> 'asc',
				'posts_per_page'=> 20,
				'paged'			=> $paged,
				'faire'			=> 'world-maker-faire-new-york-2013',
				'category_name'	=> $cat,
				'tag'			=> $tag,
			);
			$query = new WP_Query( $args );

			if( $query->have_posts() ):
				while($query->have_posts()):$query->the_post();
					the_mf_content();
					echo '<hr>';
				endwhile;
			?>
			<ul class="pager">
				<li class="previous"><?php previous_posts_link('&larr; Previous Page', $query->max_num_pages); ?></li>
				<li class="next"><?php next_posts_link('Next Page &rarr;', $query->max_num_pages); ?></li>
			</ul>
			<?php endif; ?>
			<?php wp_reset_query(); ?>

		
		</div><!--Content-->

		<?php get_sidebar(); ?>

	</div>
	
</div><!--Container-->

<?php get_footer(); ?>