<?php get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
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
                <div class="newsies">
                	<div class="news post">
                		<h3 style="color: #fc040c;"><a href="http://blog.makezine.com/category/events-3/maker-faire-events/">Latest Maker Faire News</a></h3>
						<?php 
                        $fs = makerfaire_index_feed();
                        
                        foreach($fs as $f) : print_r($f); ?>
                            <h4><a href="http://blog.makezine.com/2013/01/29/houston-mini-maker-faire-2013/">Houston Hosts its First Maker Faire</a></h4>
                            <div class="row">
                                <div class="span2">
                                    <a title="Houston Hosts its First Maker Faire" href="http://blog.makezine.com/2013/01/29/houston-mini-maker-faire-2013/"><img class="thumbnail faire-thumb " alt="Houston Hosts its First Maker Faire" src="http://makezineblog.files.wordpress.com/2013/01/img_4282.jpg?w=130&amp;h=130&amp;crop=1" /></a>
                                </div>
                                <div class="span6">
                                Robotics, 3D printing, fast electric cars, e-textiles, gourmet food trucks, and lots of hands-on making at Houston's first-ever Maker Faire.
                                <p class="read_more"><strong>
                                <a class="btn btn-primary btn-mini" href="http://blog.makezine.com/2013/01/29/houston-mini-maker-faire-2013/">Read full story &raquo;</a></strong></p>
                                
                                    <ul class="unstyled">
                                        <li>Posted by <a title="Posts by Sabrina Merlo" href="http://blog.makezine.com/author/makesabrinamerlo/" rel="author">Sabrina Merlo</a> | January 29th, 2013 8:51 PM</li>
                                        <li>Categories: <a title="View all posts in Makers" href="http://blog.makezine.com/category/makers/" rel="category tag">Makers</a>, <a title="View all posts in Education" href="http://blog.makezine.com/category/education/" rel="category tag">Education</a>, <a title="View all posts in Electronics" href="http://blog.makezine.com/category/electronics/" rel="category tag">Electronics</a> | <a title="Comment on Houston Hosts its First Maker Faire" href="http://blog.makezine.com/2013/01/29/houston-mini-maker-faire-2013/#comments">2 Comments</a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach; ?> 
                	</div>
                </div>
			 
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