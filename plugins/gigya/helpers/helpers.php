<?php


// Set a constant that will allow us to load this file when needed
define( 'MAKE_HELPERS_SET', true );


/**
 * Checks if the user is currently logged in.
 * @return boolean
 *
 * @since  SPRINT_NAME
 */
function make_is_logged_in() {
	global $make_gigya;

	if ( $make_gigya->is_logged_in() ) {
		return true;
	} else {
		return false;
	}
}