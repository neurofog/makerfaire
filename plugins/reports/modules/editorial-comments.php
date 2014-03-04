<?php

/**
 * Contains all the fun stuff that handles the Editorial Comments syncing and reporting (in the future, for now check out the build_comments_export() method in maker-faire-forms/marker-faire-forms.php around line 3340)
 *
 * @since P-body
 */


function mf_sync_all_editorial_comments_with_jdb() { 
	global $mf_jdb;

	// Check if we have passed in the Editorial Comments 
	if ( ( $_SERVER['REQUEST_METHOD'] === 'POST' ) && isset( $_POST['mf_editorial_comments_sync'] ) && wp_verify_nonce( $_POST['mf_editorial_comments_sync'], 'mf_sync_editorial_comments_jdb' ) ) {
		$response = $mf_jdb->sync_editorial_comments();
	} ?>
	<h1>Sync All Editorial Comments with JDB</h1>
	<?php if ( mf_is_dev_server() ) : ?>
		<p>Sync all editorial comments with JDB.</p>
		<form action="" method="post">
			<input type="submit" value="Sync All Editorial Comments with JDB" class="button button-primary button-large" />
			<?php wp_nonce_field( 'mf_sync_editorial_comments_jdb', 'mf_editorial_comments_sync' ); ?>
		</form>
		<?php echo ( isset( $response ) ) ? wp_kses_post( $response ) : ''; ?>
	<?php else : ?>
		Running on a testing server. JDB sync has been disabled.
	<?php endif; ?>
<?php }




function build_comments_export( $options ) {
		
		// Check our nonce
		if ( isset( $_GET['export_nonce'] ) && ! wp_verify_nonce( $_GET['export_nonce'], 'mf_export_check' ) )
			return false;
			
		// Make sure the user requesting this has the privileges...
		if ( ! current_user_can( 'edit_others_posts' ) ) 
			return false;
		
		global $wpdb;
 
		$sql = "SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_type = 'editorial-comment' AND post_type = 'mf_form' ORDER BY comment_date_gmt DESC LIMIT 1999";
 
		$comments        = $wpdb->get_results( $sql );
		$output          = "Project ID\tProject Name\tUsers & Groups Flagged\tDate Timestamp\tUser Name\tComment Text\r\n";
		$following_users = array();
		
		foreach( $comments as $comment ) {
			
			// Check that the post has our latest faire term.
			if ( ! has_term( $options['filters']['faire'], 'faire', $comment->ID ) )
				continue;

			if ( isset( $following_users[ $comment->ID ] ) ) {
				$users = $following_users[ $comment->ID ];
			} else {
				$users = get_the_terms( $comment->ID, 'following_users' );
				$following_users[ $comment->ID ] = $users;
			}

			$user_list = '';
			foreach ( $users as $user ) {
				$user_name = get_user_by( 'login', $user->name );
				$user_list .= ", " . $user_name->display_name;
			}
			
			$txt = strip_tags( str_replace( '"', "\'", iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $comment->comment_content ) ) );

			$row  = absint( $comment->ID ) . "\t";
			$row .= $comment->post_title . "\t";
			$row .= substr( $user_list, 2 ) . "\t";
			$row .= $comment->comment_date . "\t";
			$row .= $comment->comment_author . "\t";
			$row .= '"' . $txt . "\"\t";
			
			$output .= $row . "\r\n";
		}

		// Get the time this export was ran. This is used in the file name of the CSV
		$time_offset = time() - ( 3600 * 7 );

		$this->output_csv( 'EDITORIAL_COMMENTS_' . strtoupper( $options['filters']['faire'] ) . '_' . date( 'M-d-Y', $time_offset ), $output );
	}
