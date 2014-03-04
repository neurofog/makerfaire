<?php

/**
 * This is the new location that reports will be ported to. This file will act as the main controller to loading in multiple modules.
 * 
 * This is the first step in breaking up the speghetti code that is the maker-faire-forms directory.
 * To start, we'll create a new button that will sync editorial comments with JDB. Over time as we improve things, we'll be moving the reporting tools to this directory.
 */


/**
 * Builds out the interface for the syncing of editorial comments to JDB
 * @return [type] [description]
 */
function mf_sync_all_editorial_comments_with_jdb() { 
	global $mf_jdb;

	// Check if we have passed in the Editorial Comments 
	if ( ( $_SERVER['REQUEST_METHOD'] === 'POST' ) && isset( $_POST['mf_editorial_comments_sync'] ) && wp_verify_nonce( $_POST['mf_editorial_comments_sync'], 'mf_sync_editorial_comments_jdb' ) )
		$response = $mf_jdb->sync_editorial_comments(); ?>
	<h2>Sync All Editorial Comments with JDB</h2>
	<?php if ( ! mf_is_dev_server() ) : ?>
		<p>Sync all editorial comments with JDB.</p>
		<form action="" method="post">
			<input type="submit" value="Sync All Editorial Comments with JDB" class="button button-primary button-large" />
			<?php wp_nonce_field( 'mf_sync_editorial_comments_jdb', 'mf_editorial_comments_sync' ); ?>
		</form>
		<?php echo ( isset( $response ) ) ? wp_kses_post( $response ) : ''; ?>
	<?php else : ?>
		<p><?php echo esc_html( $mf_jdb->dev_server_notification ); ?></p>
	<?php endif; ?>
<?php }