<?php
/**
 * Template Name: Makers
 */
get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">
			
			<div class="page-header">
				
				<h1><?php the_title(); ?> <small>Maker Faire Bay Area 2013</small></h1>	
				
			</div>
			
			<?php
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$args = array(
				'post_type'		=> 'mf_form',
				'post_status'	=> 'accepted',
				'orderby' 		=> 'title',
				'order'			=> 'asc',
				'posts_per_page'=> 20,
				'paged'			=> $paged
			);
			$my_query = new WP_Query($args);

			if($my_query->have_posts()):
				while($my_query->have_posts()):$my_query->the_post();
					the_mf_content();
				endwhile;
			?>
			<div class="wp-navigation clearfix">
				<div class="pull-left"><?php echo get_next_posts_link('<i class="icon-chevron-left"></i> Next', $my_query->max_num_pages); ?></div>
				<div class="pull-right"><?php echo previous_posts_link('Previous <i class="icon-chevron-right"></i>', $my_query->max_num_pages); ?></div>
			</div>
			<?php endif; ?>
			

		
		</div><!--Content-->

		<?php get_sidebar(); ?>

	</div>
	
</div><!--Container-->

<?php get_footer(); ?>