<?php

/**
 * A class that contains all the code that interfaces with JDB. Primarily syncing data over so we can track resources and other reporting tools
 * In the future this class will contain all the JDB code. For now, legacy code still lives in plugins/maker-faire-forms/maker-faire-forms.php
 *
 * @since P-body
 */

class MF_JDB {

	/**
	 * Holds onto the JDB hostname
	 *
	 * @since P-body
	 */
	private $jdb_host;


	/**
	 * Displays a generic message when using this in testing environments
	 *
	 * #since P-body
	 */
	public $dev_server_notification;


	/**
	 * Run some things on init
	 *
	 * @since P-body
	 */
	public function __construct() {

		// Add our JDB host name
		$this->jdb_host = 'http://db.makerfaire.com';

		// Add our generic dev message
		$this->dev_server_notification = 'Running on a testing server. JDB sync has been disabled.';
	}


	/**
	 * Runs the actual interfacing of syncing data to JDB
	 * @param  array $post The $_POST object being passed. Should at least contain the Request Method and Editorial Comments Nonce for this to run
	 * @return string
	 *
	 * @since P-body
	 */
	public function sync_editorial_comments() {
		// if ( mf_is_dev_server() )
		// 	return false;

		// Check that we are good to actually process any requests
		if ( ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) || ! isset( $_POST['mf_editorial_comments_sync'] ) && ! wp_verify_nonce( $_POST['mf_editorial_comments_sync'], 'mf_sync_editorial_comments_jdb' ) )
			return $this->sync_status_message( 'error', 'Request could not be validated or was called inappropriately.' );

		global $wpdb;

		// Setup our SQL for returning the editorial comments
		$sql = "SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_type = 'editorial-comment' AND post_type = 'mf_form' ORDER BY comment_date_gmt DESC LIMIT 1999";
		$comments = $wpdb->get_results( $sql );
		$comments_obj = array();
		$i = 0;

		foreach ( $comments as $comment ) {
			// Just double checking that the comment being synced is from an application and the current faire
			if ( $comment->post_type === 'mf_form' && has_term( MF_CURRENT_FAIRE, 'faire', absint( $comment->comment_post_ID ) ) ) {
				$comments_obj[ intval( $i ) ]['app_id'] = absint( $comment->comment_post_ID );
				$comments_obj[ intval( $i ) ]['id'] = absint( $comment->comment_ID );
				$comments_obj[ intval( $i ) ]['comment'] = wp_kses_post( $comment->comment_content );
				$comments_obj[ intval( $i ) ]['author'] = esc_html( $comment->comment_author );
				$comments_obj[ intval( $i ) ]['email'] = sanitize_email( $comment->comment_author_email );
				$comments_obj[ intval( $i ) ]['date_posted'] = strtotime( $comment->comment_date );

				$i++;
			}
		}

		// Send the data over to JDB
		$results = $this->sync_to_jdb( 'editorial-comments', $comments_obj );

		// Handle the results from the sync. This can be a boolean value or a string (which contains an error message)
		if ( $results === false ) {
			return $this->sync_status_message( 'error', $this->dev_server_notification );
		} elseif ( is_string( $results ) ) {
			return $results;
		} else {
			return $this->sync_status_message( 'success', null );
		}
	}


	/**
	 * Handles all the syncing of data to JDB
	 * @param  string $type   The type of data we wish to push. Different types require different endpoints on JDB
	 * @param  mixed  $object The object, array, string, or whatever that needs to be sent to JDB.
	 * @return bool|string
	 *
	 * @since P-body
	 */
	private function sync_to_jdb( $type, $object ) {

		// Don't sync from any of our testing locations.
		// if ( mf_is_dev_server() )
		// 	return false;

		// List out what type of JDB data we can sync
		$accepted_types = array(
			'editorial-comments',
		);

		// Test that the type passed is valid
		if ( ! in_array( $type, $accepted_types ) )
			return $this->sync_status_message( 'error', 'Could not validate the type of data to sync.' );

		// Handle our different requests
		switch( $type ) {
			case 'editorial-comments' :
				$date = date_create();
				$body = array(
					'app_id' => 13280,
					'id' => 1,
					'cs_id' => 20883,
					'comment' => 'THIS IS A MANUAL EDITORIAL COMMENT TEST',
					'author' => 'Cole Geissinger',
					'email' => 'cgeissinger@makermedia.com',
					'date_posted' => date_timestamp_get($date),
				);
				
				$result = wp_remote_post( esc_url( $this->jdb_host . '/addExhibitNote' ), json_encode( $body ) );
				break;
		}

		// Test that all was gooooood
		if ( wp_remote_retrieve_response_code( $result ) !== 200 ) {
			return $this->sync_status_message( 'error', 'Could not connect. Please try again.' );
		} else {
			return true;
		}
	}


	/**
	 * Helper function to process sync status messages into a consistent interface and easy way to handle the output
	 * @param  [type] $type    Can either be 'error' or 'success'
	 * @param  [type] $message The message you want to return
	 * @return string|wp_error
	 *
	 * @since P-body
	 */
	private function sync_status_message( $type, $message ) {
		switch ( $type ) {
			case 'error' :
				$error = new WP_Error( 'sync_fail', esc_html( $message ) );

				$output = '';
				foreach ( $error->errors as $error ) {
					$output .= '<p style="background-color:#f2dede;border-color:#ebccd1;color:#a94442;padding:15px;border-radius:4px;"><strong>Sync to JDB Failed</strong>: ' . esc_html( $error[0] ) . '<br />'; 
				}

				return $output . '</p>';
				break;
			case 'success' :
				$output = '<p style="background-color:#dff0d8;border-color:#d6e9c6;color:#3c763d;padding:15px;border-radius:4px;">Sync to JDB Successful';

				if ( ! empty( $message ) )
					$output .= ' ' . esc_html( $message );

				$output .= '</p>';
				break;
		}

		return $output;
	}
}
$mf_jdb = new MF_JDB();