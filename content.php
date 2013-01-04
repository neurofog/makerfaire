	<article <?php post_class(); ?>>

		<!--<p class="categories"><?php the_category(', '); ?></p>-->

		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

		<p class="meta top">By <?php the_author_posts_link(); ?>, <?php the_time('Y/m/d \@ g:i a') ?></p>

		<?php the_content(); ?>

		<div class="clear"></div>

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
