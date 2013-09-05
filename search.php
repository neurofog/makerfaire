<?php get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">
			
			<div class="page-header">
				
				<h1 class="search-title">Search Results</h1>	
				<?php if ( isset( $_GET['faire'] ) && ! empty( $_GET['faire'] ) ) : 
					$faire_obj = wpcom_vip_get_term_by( 'slug', sanitize_text_field( $_GET['faire'] ), 'faire' ); ?>
					<h3>Results for '<?php echo esc_html( $faire_obj->name ); ?>'</h3>
					<p><a href="<?php echo esc_url( '/?s=' . esc_attr( $_GET['s'] ) . '&post_type=mf_form' ); ?>">Search all Maker Faire events</a></p>
				<?php endif; ?>
			</div>

			<form action="<?php echo home_url( '/' ); ?>">
				<input type="text" value="<?php echo get_search_query( true ); ?>" name="s" id="s" class="input-medium search-query" />
				<?php if ( ! isset( $_GET['faire'] ) || empty( $_GET['faire'] ) ) : ?>
					<?php $all_terms = get_terms( 'faire', array( 'hide_empty' => false ) ); ?>
					<select name="faire" id="faire-dropdown-search">';
						<option value="">All Faires</option>';
						
						<?php foreach ( $all_terms as $term ) : ?>
							<option value="<?php echo sanitize_text_field( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach; ?>

					</select>
				<?php endif; ?>
				<input type="hidden" name="post_type" value="mf_form" />
				<?php if ( isset( $_GET['faire'] ) ) : ?>
					<input type="hidden" name="faire" value="<?php echo esc_attr( $_GET['faire'] ); ?>" />
				<?php endif; ?>
				<input type="submit" id="searchsubmit" class="btn btn-primary" value="Search" />
			</form>
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<article <?php post_class(); ?>>
					
					<?php the_mf_content(); ?>
				
				</article>
				<hr>
				
			<?php endwhile; ?>

				<ul class="pager">
			
					<li class="previous"><?php previous_posts_link('&larr; Previous Page'); ?></li>
					<li class="next"><?php next_posts_link('Next Page &rarr;'); ?></li>
				
				</ul>
			
			<?php else: ?>
			
				<p><?php _e( 'Sorry, no makers matched your criteria.' ); ?></p>
			
			<?php endif; ?>

		</div><!--Content-->

		<?php get_sidebar(); ?>

	</div>
	
</div><!--Container-->

<?php get_footer(); ?>