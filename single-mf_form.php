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
					$json = json_decode($content);
					
				?>
				
				<article <?php post_class(); ?>>

					<h5><small><?php echo mf_better_name( $json->maker_faire ); ?></small></h5>
					
					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

					<?php echo mf_location( get_the_ID() ); ?>
					
					<?php 

						if (!empty($json->project_photo)) {
							echo '<img src="'. wpcom_vip_get_resized_remote_image_url( $json->project_photo, 610, 400 ) . '" class="thumbnail" />';
						}
						if (!empty($json->private_description)) {
							if (class_exists(Markdown)) {
								echo Markdown( wp_kses_post( $json->private_description ) ) ;
							} else {
								echo '<p>' . wp_kses_post( $json->private_description ) . '</p>';
							}
							
						}
						
						if (!empty($json->project_website)) {
							echo '<a class="btn btn-mini btn-info" href="'. esc_url( $json->project_website ) . '"><i class="icon-home icon-white"></i> Website</a>';
						}
						if (!empty($json->project_video)) {
							echo '<a class="btn btn-mini btn-info" href="'. esc_url( $json->project_video ) . '"><i class="icon-facetime-video icon-white"></i> Website</a>';
						}

						if (!empty($json->name)) {
							echo '<h3>About the Makers</h3>';
							echo '<div class="media">';
							if (!empty($json->maker_photo)) {
								echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->maker_photo, 64, 64, true ) . '" class="media-object thumbnail pull-left" />';
							}
							echo '<div class="media-body">';
							echo '<h4>' . wp_kses_post( $json->name ) . '</h4>';
							if (class_exists(Markdown)) {
								echo Markdown( wp_kses_post( $json->maker_bio ) );	
							} else {
								echo '<p>' . wp_kses_post( $json->maker_bio ) . '</p>';
							}
							
							echo '</div></div>';
						}
						if (!empty($json->group_name)) {
							echo '<h3>Group Association</h3>';
							echo '<div class="media">';
							if (!empty($json->group_photo)) {
								echo '<img src="' . wpcom_vip_get_resized_remote_image_url( $json->group_photo, 130, 130, true ) . '" class="media-object thumbnail pull-left" />';
							}
							echo '<div class="media-body">';
							echo '<h4>' . wp_kses_post( $json->group_name ) . '</h4>';
							echo '<p>' . wp_kses_post( $json->group_bio ) . '</p>';
							if (!empty($json->group_website)) {
								echo '<a class="btn btn-mini btn-info" href="'.esc_url( $json->group_website ) . '"><i class="icon-home icon-white"></i> Website</a>';
							}
							echo '</div></div>';	
						}

					?>
					

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