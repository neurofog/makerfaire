<?php
require_once( WP_CONTENT_DIR . '/themes/vip/plugins/vip-init.php' );

// include maker-faire-forms plugin
require_once( __DIR__ . '/plugins/maker-faire-forms/maker-faire-forms.php' );

// include maker-faire-forms plugin
require_once( __DIR__ . '/plugins/public-pages/makers.php' );

// include maker-faire-forms plugin
require_once( __DIR__ . '/post-types/maker.php' );

// Markdown
include_once dirname(__file__) . '/plugins/markdown/markdown.php';

require_once( 'taxonomies/location.php' );
require_once( 'taxonomies/location_category.php' );
require_once( 'taxonomies/group.php' );
require_once( 'plugins/post-types/event-items.php' );
if ( defined( 'WP_CLI' ) && WP_CLI )
	require_once( 'plugins/wp-cli/wp-cli.php' );

if ( function_exists( 'wpcom_vip_load_plugin' ) ) {
	wpcom_vip_load_plugin( 'easy-custom-fields' );
}

// load edit-flow plugin
if ( function_exists( 'wpcom_vip_load_plugin' ) ) {
	wpcom_vip_load_plugin( 'edit-flow' );
}

// add post-thumbnails support to theme
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
	wp_enqueue_script( 'make-countdown', get_stylesheet_directory_uri() . '/js/jquery.countdown.js', array( 'jquery' ) );
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

/**
 * Make the 'accepted' status public so that forms can be shown
 *
 * @see http://vip-support.automattic.com/tickets/16382
 */
add_action( 'init', function() {
	global $wp_post_statuses;

	if ( isset( $wp_post_statuses['accepted'] ) )
		$wp_post_statuses['accepted']->public = true;

}, 400 );

function makerfaire_index_feed($n = 4) {
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

function makerfaire_data_toggle() {
	return '<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#ny2012">New York 2012</a></li>
		<li><a data-toggle="tab" href="#d2012">Detroit 2012</a></li>
		<li><a data-toggle="tab" href="#ba2012">Bay Area 2012</a></li>
		<li><a data-toggle="tab" href="#ny2011">New York 2011</a></li>
		<li><a data-toggle="tab" href="#d2011">Detroit 2011</a></li>
		<li><a data-toggle="tab" href="#ba2011">Bay Area 2011</a></li>
		<li><a data-toggle="tab" href="#ny2010">New York 2010</a></li>
		<li><a data-toggle="tab" href="#d2010">Detroit 2010</a></li>
		<li><a data-toggle="tab" href="#ba2010">Bay Area 2010</a></li>
		<li><a data-toggle="tab" href="#ba2009">Bay Area 2009</a></li>
		<li><a data-toggle="tab" href="#a2008">Austin 2008</a></li>
		<li><a data-toggle="tab" href="#ba2008">Bay Area 2008</a></li>
		<li><a data-toggle="tab" href="#a2007">Austin 2007</a></li>
	</ul>';
}

add_shortcode( 'tabs', 'makerfaire_data_toggle' );

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

function makerfaire_news_rss() { ?>
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
<?php }

function makerfaire_widgets_init() {

	register_sidebar( array(
		'name' => 'Maker Faire Calendar',
		'id' => 'home_right_1',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h4 class="more-faires">',
		'after_title' => '</h4>',
	) );
}
add_action( 'widgets_init', 'makerfaire_widgets_init' );


if ( function_exists( 'vip_redirects' ) ) {
	vip_redirects( array(
		'/mini/toolkit/'	=> 'https://www.dropbox.com/sh/ykbi3al0j4hatd2/hSN6Z9nXTU',
		'/alt'         => 'http://makerfaire.com/bayarea-2013/getting-to-maker-faire/'
	) );
}

function mf_quick_links_box() {
	add_meta_box( 'quickly', 'Quick Links', 'mf_quick_links', 'mf_form' );
}
// This function echoes the content of our meta box
function mf_quick_links() {
	$output = '<ul class="subsubsub">
		<li class="all"><a href="edit.php?post_type=mf_form" class="current">All</a> |</li>
		<li class="trash"><a href="edit.php?post_status=trash&amp;post_type=mf_form">Trash</a> |</li>
		<li class="proposed"><a href="edit.php?post_status=proposed&amp;post_type=mf_form" title="Application proposed; waiting for acceptance.">Proposed</a> |</li>
		<li class="waiting-for-info"><a href="edit.php?post_status=waiting-for-info&amp;post_type=mf_form" title="Question has been emailed to Maker, waiting for response.">Waiting for Info</a> |</li>
		<li class="accepted"><a href="edit.php?post_status=accepted&amp;post_type=mf_form" title="Application is accepted to Maker Faire.">Accepted</a> |</li>
		<li class="cancelled"><a href="edit.php?post_status=cancelled&amp;post_type=mf_form" title="Accepted application is cancelled; This project will not attend Maker Faire after all.">Cancelled</a> |</li>
		<li class="in-progress"><a href="edit.php?post_status=in-progress&amp;post_type=mf_form" title="">In Progress</a></li>
	</ul><div class="clear"></div>';
	echo $output;
}

if (is_admin())
	add_action('admin_menu', 'mf_quick_links_box');
	
function mf_clean_title( $title ) {
    $title = str_replace('&nbsp;', ' ', $title);
    return $title;
}
add_filter('the_title', 'mf_clean_title', 10, 2);


function mf_release_shortcode() {
	$request_id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : null);
	$output = '<iframe src="' . esc_url( 'http://makedb.makezine.com/pa/' .  $request_id ) . '" width="620" height="2000" scrolling="auto" frameborder="0"> [Your user agent does not support frames or is currently configured not to display frames.] </iframe>';
	return $output;
}

add_shortcode( 'release', 'mf_release_shortcode' );


add_filter( 'wp_kses_allowed_html', 'mf_allow_data_atts', 10, 2 );
function mf_allow_data_atts( $allowedposttags, $context ) {
	$tags = array( 'div', 'a', 'li' );
	$new_attributes = array( 'data-toggle' => true );
 
	foreach ( $tags as $tag ) {
		if ( isset( $allowedposttags[ $tag ] ) && is_array( $allowedposttags[ $tag ] ) )
			$allowedposttags[ $tag ] = array_merge( $allowedposttags[ $tag ], $new_attributes );
	}
	
	return $allowedposttags;
}


add_filter('tiny_mce_before_init', 'mf_filter_tiny_mce_before_init'); 
function mf_filter_tiny_mce_before_init( $options ) { 

	if ( ! isset( $options['extended_valid_elements'] ) ) 
		$options['extended_valid_elements'] = ''; 

	$options['extended_valid_elements'] .= ',a[data*|class|id|style|href]';
	$options['extended_valid_elements'] .= ',li[data*|class|id|style]';
	$options['extended_valid_elements'] .= ',div[data*|class|id|style]';

	return $options; 
}


function mf_allow_my_post_types( $allowed_post_types ) {
	$allowed_post_types[] = 'mf_form';
	return $allowed_post_types;
}

add_filter( 'rest_api_allowed_post_types', 'mf_allow_my_post_types');
