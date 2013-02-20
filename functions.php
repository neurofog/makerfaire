<?php
require_once( WP_CONTENT_DIR . '/themes/vip/plugins/vip-init.php' );

require_once( __DIR__ . '/plugins/maker-faire-forms/maker-faire-forms.php' );

add_theme_support( 'post-thumbnails' );

if ( function_exists( 'wpcom_vip_enable_opengraph' ) ) {
	wpcom_vip_enable_opengraph();
}

if ( function_exists( 'vip_contrib_add_upload_cap' ) ) {
	vip_contrib_add_upload_cap();
}

if ( function_exists( 'wpcom_vip_sharing_twitter_via' ) ) {
	wpcom_vip_sharing_twitter_via( 'make' );
}

function make_enqueue_jquery() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'make-bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.js', array( 'jquery' ) );
	wp_enqueue_style( 'make-bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.css' );
	wp_enqueue_style( 'make', get_stylesheet_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'make_enqueue_jquery' );


function makerfaire_get_news() {

	$url = 'http://blog.makezine.com/maker-faire-news/';
	$output = wpcom_vip_file_get_contents( $url, 3, 60*60,  array( 'obey_cache_control_header' => false ) );
	return $output;
}

add_shortcode('news', 'makerfaire_get_news');

function makerfaire_sidebar_news() {

	$url = 'http://blog.makezine.com/maker-faire-news-sidebar/';
	$output = wpcom_vip_file_get_contents( $url, 3, 60*60,  array( 'obey_cache_control_header' => false ) );
	return $output;

}

function makerfaire_index_feed($n = 4)
{
	$f = fetch_feed('http://blog.makezine.com/tag/maker-faire/feed/'); 

	if(is_wp_error($f))
		return false;

	$max = $f->get_item_quantity($n); 	
	$fs  = $f->get_items(0, $max);
	
	$res = array();
	foreach($fs as $i)
	{
		$img = preg_match('/<img(.*?)src="(.*?)"(.*?)>/i', html_entity_decode($i->get_description()), $m);
		$res[] = array('i'=>$i, 'img'=>$m[0], 'src'=>$m[2]);
	}

	return $res;
}

function isc_register_menus() {
  register_nav_menus(
	array( 'header-menu' => __( 'Header Menu' ) )
  );
}
add_action( 'init', 'isc_register_menus' );


function makerfaire_carousel_shortcode( $atts ) {
	extract( shortcode_atts( array( 'id' => 'biggins'), $atts ) );
	
	return 	'<a class="carousel-control left" href="#' . esc_attr( $id ) . '" data-slide="prev">&lsaquo;</a>
			<a class="carousel-control right" href="#' . esc_attr( $id ) . '" data-slide="next">&rsaquo;</a>';
}
add_shortcode( 'arrows', 'makerfaire_carousel_shortcode' );


function makerfaire_newsletter_shortcode() {

		$output = '<form action="http://makermedia.createsend.com/t/r/s/jjuruj/" method="post" class="form-horizontal" id="subForm">
			<fieldset>
			
			<legend>Sign up for the Maker Faire Newsletter</legend>
			
			<div class="control-group">
				<label for="name" class="control-label">Your Name:</label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="cm-name" id="name" size="35" />
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="jjuruj-jjuruj">Your Email:</label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="cm-jjuruj-jjuruj" id="jjuruj-jjuruj" size="35" />
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="cm621683"></label>
				<div class="controls">
					<label class="checkbox">
						<input type="checkbox" name="cm-fo-dduult" id="cm621683" value="621683" />
						Please let me know when the Call for Makers goes out!
					</label>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="optionsCheckbox">Any chance we could interest you in...</label>
				<div class="controls">
					<label for="CRAFTNewsletter" class="checkbox">
						<input type="checkbox" name="cm-ol-jjurhj" id="CRAFTNewsletter" />
						The CRAFT Newsletter?
					</label>
				</div>
				<div class="controls">
					<label for="MAKENewsletter" class="checkbox">
						<input type="checkbox" name="cm-ol-jjuylk" id="MAKENewsletter" />
						The MAKE Newsletter?
					</label>
				</div>
			</div>
			
			<div class="form-actions">
				<input type="submit" value="Subscribe" class="btn btn-primary" />
			</div>
			
			</fieldset>
		</form>';

	return $output;
}

add_shortcode( 'newsletter', 'makerfaire_newsletter_shortcode' );

function makerfaire_news_rss() {

	if(is_front_page()) : ?>
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
	<?php endif;

}