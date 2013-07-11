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
// $GLOBALS['current_faire'] = 'world-maker-faire-new-york-2013';
$GLOBALS['current_faire'] = 'maker-faire-bay-area-2013';

/**
 * Function to count the statuses of Maker Faire applications
 */
function mf_count_post_statuses() {
	$types = array( 
		'Any' 				=> 'any', 
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
			'posts_per_page' 	=> 1500,
			'faire'				=> $GLOBALS['current_faire'],
			'post_status'		=> $type,
			'return_fields'		=> 'ids',
			);
		$query = new WP_Query( $args );
		$output .= '| <li><a href="edit.php?post_type=mf_form&page=current_faire&post_status=' . $type . '">' . $k . '</a> <span class="count">(' . $query->post_count . ' )</span></li>';
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
 * Current Faire Page
 */
function makerfaire_current_faire_page() {

	//must check that the user has the required capability 
	if (!current_user_can('manage_options')) {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	// Start the WordPress Page

	$paged = ( isset( $_GET['paged'] ) ) ? $_GET['paged'] : 1;
	$post_status = ( isset( $_GET['post_status'] ) ) ? $_GET['post_status'] : '';

	$args = array( 
		'post_type'			=> 'mf_form',
		'post_status'		=> 'any',
		'posts_per_page' 	=> 100,
		'faire'				=> $GLOBALS['current_faire'],
		'paged'				=> $paged,
		'post_status'		=> $post_status

		);
	$query = new WP_Query( $args );

	?>
	
	<div class="wrap">
	
		<h1>Current Faire</h1>
		
		<ul class="subsubsub">
			<?php echo mf_count_post_statuses(); ?>
		</ul>
		
		<div class="tablenav top">

			<div class="tablenav-pages one-page">
				<span class="displaying-num"><?php echo $query->post_count; ?></span>
				<?php echo mf_get_pagination_links( $query->max_num_pages, $paged ); ?>
			</div>
		
		</div>
		
		<table class="wp-list-table widefat fixed pages">
			<thead>
				<tr>
					<th scope="col" id="" class="manage-column" style="">ID</th>
					<th scope="col" id="" class="manage-column" style="">Post Status</th>
					<th scope="col" id="" class="manage-column" style="">Name</th>
					<th scope="col" id="" class="manage-column" style="">Maker Name</th>
					<th scope="col" id="" class="manage-column" style="">Type</th>
					<th scope="col" id="" class="manage-column" style="">Description</th>
					<th scope="col" id="" class="manage-column" style="">Photo</th>
					<th scope="col" id="" class="manage-column" style="">Categories</th>
					<th scope="col" id="" class="manage-column" style="">Tags</th>
					<th scope="col" id="" class="manage-column" style="">Featured Maker</th>
					<th scope="col" id="" class="manage-column" style="">Submitted</th>
			</thead>
			<tbody id="the-list">
				<?php
					$posts = $query->posts;
					if( $query ) {
						foreach ( $posts as $the_post ) {
							$json = json_decode( html_entity_decode( mf_convert_newlines( str_replace( array("\'", "u03a9"), array("'", '&#8486;'), $the_post->post_content ), "\n"), ENT_COMPAT, 'utf-8' ) );
							$id = $the_post->ID;
							echo '<tr>';
								echo '<td>' . $id . '</td>';
								echo '<td>' . $the_post->post_status .'</td>';
								echo '<td><strong><a href="' . get_edit_post_link( $id ) . '">' . get_the_title( $id ) . '</a></strong>
									<div class="row-actions">
										<span class="inline hide-if-no-js"><a href="' . get_permalink( $id ) . '">View</a></span>
										<span class="trash"><a class="submitdelete" href="' . get_delete_post_link( $id ) . '">Trash</a></span>
									</div>
								</td>';
								echo (!empty($json->name)) ? '<td>' . $json->name .'</td>' : '<td></td>';
								echo get_the_term_list( $id, 'type', '<td>', ', ', '</td>' );
								echo  ( !empty( $json->public_description) ) ? '<td>' . Markdown( wp_kses_post( $json->public_description ) ) . '</td>': '<td></td>';
								echo '<td><img src="' . wpcom_vip_get_resized_remote_image_url( mf_get_the_maker_image( $json ), 130, 130, true ) . '" class="media-object thumbnail pull-left"/></td>';
								echo '<td>' . get_the_term_list( $id, 'post_tag', '', ', ', '' ) . '</td>';
								echo '<td>' . get_the_term_list( $id, 'category', '', ', ', '' ) . '</td>';
								$featured = get_post_meta( $id, '_ef_editorial_meta_checkbox_featured', true );
								if ( $featured ) {
									echo '<td>Yes</td>';
								} else {
									echo '<td>No</td>';
								}
								echo '<td>' . get_the_time( 'F jS, Y', $id ) . '</td>';
							echo '</tr>';
						}
					}?>
			</tbody>
			
		</table>
		
	</div>

<?php

}

/**
 * Hook the page in
 */
function mf_add_menu_page() {
	add_submenu_page( 'edit.php?post_type=mf_form', 'Current Maker Faire', 'Current Faire', 'edit_posts', 'current_faire', 'makerfaire_current_faire_page' );	
}

add_action('admin_menu', 'mf_add_menu_page');