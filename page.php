<?php get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<article <?php post_class(); ?>>

					<!--<p class="categories"><?php the_category(', '); ?></p>-->

					<?php /*<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1> */ ?>

					<?php /*<p class="meta top">By <?php the_author_posts_link(); ?>, <?php the_time('Y/m/d \@ g:i a') ?></p> */ ?>

					<?php the_content(); ?>

					<div class="clear"></div>

					<?php /*
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
					*/ ?>
				
				</article>
                <?php if(is_front_page()) : ?>
                <div class="newsies">
                	<div class="news post">
                		<h3 style="color: #fc040c;"><a href="http://blog.makezine.com/tag/maker-faire/">Latest Maker Faire News</a></h3>
						<?php 
                        $fs = makerfaire_index_feed();

                        foreach($fs as $f) : $a = $f['i']->get_authors(); ?>
                            <h4><a href="<?php echo esc_url($f['i']->get_link()); ?>"><?php echo esc_html($f['i']->get_title()); ?></a></h4>
                            <div class="row">
                                <div class="span2">
                                    <a href="<?php echo esc_url($f['i']->get_link()); ?>" title="<?php echo esc_attr($f['i']->get_title()); ?>"><img class="thumbnail faire-thumb " alt="<?php echo esc_attr($f['i']->get_title()); ?>" src="<?php echo esc_url($f['src']); ?>" /></a>
                                </div>
                                <div class="span6">
                                <?php echo str_replace(array($f['img'], '<p><a href="'.$f['i']->get_link().'">Read the full article on MAKE</a></p>'), '', html_entity_decode(esc_html($f['i']->get_description()))); ?>
                                <p class="read_more" style="margin:10px 0"><strong>
                                <a class="btn btn-primary btn-mini" href="<?php echo esc_url($f['i']->get_link()); ?>">Read full story &raquo;</a></strong></p>
                                
                                    <ul class="unstyled">
                                        <li>Posted by <?php echo esc_html($a[0]->name); ?> | <?php echo esc_html($f['i']->get_date()); ?></li>
                                        <li>Categories: <?php foreach($f['i']->get_categories() as $cat) : echo esc_html($cat->term.', '); endforeach; ?></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach; ?> 
                	</div>
                </div>
                <h4><a href="http://blog.makezine.com/tag/maker-faire/">Read More &rarr;</a></h4>
				<?php endif; ?>
							
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