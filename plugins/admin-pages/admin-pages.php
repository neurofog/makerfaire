<?php
/**
 * Admin Pages for Maker Faire
 * 
 * Create a few helper pages for Maker Faire management.
 * 
 * @package makerfaires
 * 
 */

/**
 * Declare the current faire, globally here...
 */
$GLOBALS['current_faire'] = 'world-maker-faire-new-york-2013';
// $GLOBALS['current_faire'] = 'maker-faire-bay-area-2013';

/**
 * Function to count the statuses of Maker Faire applications
 */
function mf_count_post_statuses() {
	$types = array( 
		'All' 				=> 'any', 
		'Accepted'			=> 'accepted', 
		'Draft'				=> 'draft', 
		'In Progress'		=> 'in-progress', 
		'Proposed'			=> 'proposed', 
		'Rejected'			=> 'rejected',
		'Waiting for Info'	=> 'waiting-for-info'
		);
	$output = '';
	foreach ($types as $k => $type) {
		$args = array( 
			'post_type'			=> 'mf_form',
			'post_status'		=> 'any',
			'posts_per_page' 	=> 1,
			'faire'				=> $GLOBALS['current_faire'],
			'post_status'		=> $type,
			'return_fields'		=> 'ids',
			);
		$query = new WP_Query( $args );
		$output .= '| <li><a href="edit.php?post_type=mf_form&page=current_faire&post_status=' . $type . '">' . $k . '</a> <span class="count">(' . $query->found_posts . ' )</span></li>';
	}
	return substr($output, 2);
}

/**
 * Function to generate the pagination links. Just a wrapper for paginate links
 */
function mf_get_pagination_links( $total, $paged ) {
	$links = paginate_links( array(
		'base' 		=> get_pagenum_link() . '%_%',
		'format' 	=> '&paged=%#%',
		'current' 	=> max( 1, $paged ),
		'total' 	=> $total
		) 
	);
	return $links;
}

/**
 * Post Status Drop Down
 */
function mf_post_status_dropdown() {
	// $stati = get_post_stati();
	// sort( $stati );
	$the_good = array( 'accepted', 'draft', 'in-progress', 'proposed', 'rejected', 'waiting-for-info' );
	$post_status = ( isset( $_GET['post_status'] ) ) ? sanitize_title( $_GET['post_status'] ) : '';
	$output = '<select name="post_status" id="post_Status">';
	if ($post_status) {
		$output .= '<option value="' . esc_attr( $post_status ) . '">' . esc_attr( ucwords( str_replace( '-', ' ', $post_status ) ) ) . '</option>';
	} else {
		$output .= '<option value="">Application Status</option>';
	}
	foreach ($the_good as $status) {
		$output .= '<option value="' . $status . '">' . ucwords( str_replace( '-', ' ', $status ) ) . '</option>';
	}
	$output .= '</select>';
	return $output;
}
/**
 * Check to see if it is a valid orderby statement
 */
function mf_is_valid_orderby( $orderby ) {
	$valid = array( 'title', 'name', 'date', 'modified' );
	// Check to make sure that it is a valid orderby term.
	if ( !in_array( $orderby, $valid ) ) {
		$orderby = 'title';
	}
	return $orderby;
}

/**
 * Check to see if it is a valid order statement
 */
function mf_is_valid_order( $order ) {
	$valid = array( 'ASC', 'DSC' );
	// Check to make sure that it is a valid orderby term.
	if ( !in_array( $order, $valid ) ) {
		$order = 'ASC';
	}
	return $order;
}

/**
 * Orderby Drop Down
 */
function mf_orderby_dropdown( $orderby ) {
	$orderby = mf_is_valid_orderby( $orderby );
	$output = '<select name="orderby" id="orderby">';
	if ($orderby) {
		$output .= '<option value="' . $orderby . '">Orderby: ' . ucwords( str_replace( '-', ' ', $orderby ) ) . '</option>';
	} else {
		$output .= '<option value="">Orderby</option>';
	}
	$orders = array( 'title', 'date', 'modified', 'name' );
	foreach ($orders as $order) {
		if ( $order == 'modified' ) {
			$output .= '<option value="' . $order . '">' . ucwords( str_replace( '-', ' ', $order ) ) . ' Date</option>';
		} elseif ( $order == 'date' ) {
			$output .= '<option value="' . $order . '">Submission ' . ucwords( str_replace( '-', ' ', $order ) ) . '</option>';
		} else {
			$output .= '<option value="' . $order . '">' . ucwords( str_replace( '-', ' ', $order ) ) . '</option>';
		}
		
	}
	$output .= '</select>';
	return $output;
}

/**
 * Order Dropdown
 */
function mf_order_dropdown( $order ) {
	$order = mf_is_valid_order( $order );
	$output = '<select name="order" id="order">';
	if ($order) {
		$output .= '<option value="' . $order . '">Sort Order: ' . ucwords( str_replace( '-', ' ', $order ) ) . '</option>';
	} else {
		$output .= '<option value="">Sort Order</option>';
	}
	$output .= '<option value="ASC">Ascending</option>';
	$output .= '<option value="DSC">Descending</option>';
	$output .= '</select>';
	return $output;
}

/**
 * Current Faire Page
 */
function makerfaire_current_faire_page() {

	//must check that the user has the required capability 
	if (!current_user_can('manage_options')) {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	
	$paged 			= ( isset( $_GET['paged'] ) ) ? absint( $_GET['paged'] ) : 1;
	$post_status 	= ( isset( $_GET['post_status'] ) ) ? sanitize_title( $_GET['post_status'] ) : '';
	$type 			= ( isset( $_GET['type'] ) ) ? sanitize_title( $_GET['type'] ) : '';
	$cat 			= ( isset( $_GET['cat'] ) ) ? absint( $_GET['cat'] ) : '';
	$s 				= ( isset( $_GET['s'] ) ) ? sanitize_text_field( $_GET['s'] ) : '';
	$p 				= ( isset( $_GET['p'] ) ) ? absint( $_GET['p'] ) : '';
	$orderby 		= ( isset( $_GET['orderby'] ) ) ? sanitize_sql_orderby( $_GET['orderby'] ) : '';
	$order 			= ( isset( $_GET['order'] ) ) ? sanitize_text_field( $_GET['order'] ) : '';
	$posts_per_page = ( isset( $_GET['posts_per_page'] ) ) ? absint( $_GET['posts_per_page'] ) : '';

	$args = array( 
		'post_type'			=> 'mf_form',
		'faire'				=> $GLOBALS['current_faire'],
		'paged'				=> $paged,
		'post_status'		=> $post_status,
		'type'				=> $type,
		'cat'				=> $cat,
		's'					=> $s,
		'p'					=> $p,
		'orderby'			=> $orderby,
		'order'				=> $order,
		'posts_per_page'	=> $posts_per_page,
		);
	$query = new WP_Query( $args );

	?>
	
	<div class="wrap">
	
		<h1>Current Faire - <?php echo esc_html( get_term_by( 'slug', $GLOBALS['current_faire'], 'faire')->name ); ?></h1>
		
		<ul class="subsubsub">
			<?php echo mf_count_post_statuses(); ?>
		</ul>
		
		<style>

			.tablenav {
				height: inherit;
			}

		</style>
		
		<div class="tablenav top">

			<div class="tablenav-pages one-page">
				<span class="displaying-num"><?php echo esc_html( $query->found_posts ); ?></span>
				<?php echo mf_get_pagination_links( $query->max_num_pages, $paged ); ?>
			</div>
			
			<form class="" type="get">
				<input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ); ?>" />
				<input type="hidden" name="post_type" value="mf_form" />
				<?php echo mf_restrict_listings_by_type( $type ); ?>
				<?php echo mf_generate_dropdown( 'category', $cat ); ?>
				<?php echo mf_post_status_dropdown(); ?>
				<?php echo mf_orderby_dropdown( $orderby ); ?>
				<?php echo mf_order_dropdown( $order ); ?>
				<label class="screen-reader-text" for="post-search-input">Search Applications:</label>
				<input type="number" id="post-search-input" name="posts_per_page" min="1" value="<?php echo !empty( $posts_per_page ) ? esc_attr( $posts_per_page ) : ''; ?>" value="">
				<input type="search" id="post-search-input" name="s" placeholder="Search" value="<?php echo !empty( $s ) ? esc_attr( $s ) : ''; ?>" value="">
				<input type="search" id="post-search-input" name="p" placeholder="Project ID" value="<?php echo !empty( $p ) ? esc_attr( $p ) : ''; ?>" value="">
				<input type="submit" name="" id="search-submit" class="button" value="Search Applications"></p>
			</form>
			
		</div>
		
		<table class="wp-list-table widefat fixed pages">
			<thead>
				<tr>
					<th scope="col" id="" class="manage-column" style="">Photo</th>
					<th scope="col" id="" class="manage-column" style="">ID</th>
					<th scope="col" id="" class="manage-column" style="">Post Status</th>
					<th scope="col" id="" class="manage-column" style="">Project Name</th>
					<th scope="col" id="" class="manage-column" style="">Maker Name</th>
					<th scope="col" id="" class="manage-column" style="">Type</th>
					<th scope="col" id="" class="manage-column" style="">Description</th>
					<th scope="col" id="" class="manage-column" style="">Categories</th>
					<th scope="col" id="" class="manage-column" style="">Tags</th>
					<th scope="col" id="" class="manage-column" style="">Location</th>
					<th scope="col" id="" class="manage-column" style="">Featured Maker</th>
					<th scope="col" id="" class="manage-column" style="">Modified Date</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th scope="col" id="" class="manage-column" style="">Photo</th>
					<th scope="col" id="" class="manage-column" style="">ID</th>
					<th scope="col" id="" class="manage-column" style="">Post Status</th>
					<th scope="col" id="" class="manage-column" style="">Project Name</th>
					<th scope="col" id="" class="manage-column" style="">Maker Name</th>
					<th scope="col" id="" class="manage-column" style="">Type</th>
					<th scope="col" id="" class="manage-column" style="">Description</th>
					<th scope="col" id="" class="manage-column" style="">Categories</th>
					<th scope="col" id="" class="manage-column" style="">Tags</th>
					<th scope="col" id="" class="manage-column" style="">Location</th>
					<th scope="col" id="" class="manage-column" style="">Featured Maker</th>
					<th scope="col" id="" class="manage-column" style="">Modified Date</th>
				</tr>
			</tfoot>
			<tbody id="the-list">
				<?php
					global $post;
					$posts = $query->posts;
					if( $query ) {
						foreach ( $posts as $post ) {
							setup_postdata( $post );
							$json = json_decode( html_entity_decode( mf_convert_newlines( str_replace( array("\'", "u03a9"), array("'", '&#8486;'), $post->post_content ), "\n"), ENT_COMPAT, 'utf-8' ) );
							$id = $post->ID;
							echo '<tr>';
								echo '<td><img src="' . wpcom_vip_get_resized_remote_image_url( mf_get_the_maker_image( $json ), 130, 130, true ) . '" class="media-object thumbnail pull-left"/></td>';
								echo '<td>' . $id . '</td>';
								echo '<td>' . $post->post_status .'</td>';
								echo '<td><strong><a href="' . get_edit_post_link( $id ) . '">' . get_the_title() . '</a></strong>
									<div class="row-actions">
										<span class="inline hide-if-no-js"><a href="' . get_permalink( $id ) . '">View</a></span>
										<span class="trash"><a class="submitdelete" href="' . get_delete_post_link( $id ) . '">Trash</a></span>
										<span class="edit"><a href="' . get_edit_post_link( $id ) . '">Edit</a></span>
									</div>
								</td>';
								echo (!empty($json->name)) ? '<td>' . esc_html( $json->name ) .'</td>' : '<td></td>';
								echo '<td>' . get_the_term_list( $id, 'type', '', ', ', '' ) . '</td>';
								echo  ( !empty( $json->public_description) ) ? '<td>' . wp_trim_words( Markdown( wp_kses_post( $json->public_description ) ), 15 ) . '</td>': '<td></td>';
								echo '<td>' . get_the_term_list( $id, 'post_tag', '', ', ', '' ) . '</td>';
								echo '<td>' . get_the_term_list( $id, 'category', '', ', ', '' ) . '</td>';
								echo '<td>' . get_the_term_list( $id, 'location', '', ', ', '' ) . '</td>';
								$featured = get_post_meta( $id, '_ef_editorial_meta_checkbox_featured', true );
								if ( $featured ) {
									echo '<td>Yes</td>';
								} else {
									echo '<td>No</td>';
								}
								// echo '<td>' . get_the_time( 'F jS, Y', $id ) . '</td>';
								echo '<td>' . get_the_modified_date( 'F jS, Y' ) . '</td>';
							echo '</tr>';
						}
					}?>
			</tbody>
			
		</table>
		
		<div class="tablenav top">

			<div class="tablenav-pages one-page">
				<span class="displaying-num"><?php echo esc_html( $query->found_posts ); ?></span>
				<?php echo mf_get_pagination_links( $query->max_num_pages, $paged ); ?>
			</div>
			
			<form class="" type="get">
				<input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ); ?>" />
				<input type="hidden" name="post_type" value="mf_form" />
				<?php echo mf_restrict_listings_by_type( $type ); ?>
				<?php echo mf_generate_dropdown( 'category', $cat ); ?>
				<?php echo mf_post_status_dropdown(); ?>
				<label class="screen-reader-text" for="post-search-input">Search Applications:</label>
				<input type="search" id="post-search-input" name="s" placeholder="<?php echo !empty( $s ) ? esc_attr( $s ) : ''; ?>" value="">
				<input type="submit" name="" id="search-submit" class="button" value="Search Applications"></p>
			</form>
			
		</div>
		
	</div>

<?php

}

/**
 * Hook the page in
 */
function mf_add_menu_page() {
	add_submenu_page( 'edit.php?post_type=mf_form', 'Current Maker Faire', 'Current Faire', 'edit_posts', 'current_faire', 'makerfaire_current_faire_page' );	
}

add_action( 'admin_menu', 'mf_add_menu_page' );
