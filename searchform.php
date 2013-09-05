<?php 
	global $wp_query
?>
<form role="search" method="get" class="form-search" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<input type="text" value="<?php echo get_search_query( true ); ?>" name="s" id="s" class="input-medium search-query" />
	<input type="hidden" name="post_type" value="mf_form" />
	<?php if ( isset( $_GET['faire'] ) ) : ?>
		<input type="hidden" name="faire" value="<?php echo esc_attr( $_GET['faire'] ); ?>" />
	<?php endif; ?>
	<input type="submit" id="searchsubmit" class="btn btn-primary" value="Search" />
</form>
