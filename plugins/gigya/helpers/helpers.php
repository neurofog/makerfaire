<?php

/**
 * Help Functions
 *
 * We need something that can easily be used in our code. Instead of messing with classes, we'll create simple functions to simplify the process.
 *
 * @since  HAL 9000
 */


/**
 * Set a constant that will allow us to load this file when needed
 *
 * @since  HAL 9000
 */
define( 'MAKE_HELPERS_SET', true );


/**
 * Checks if the user is currently logged in.
 * @return boolean
 *
 * @since  HAL 9000
 */
function make_is_logged_in() {
	// Pass in our gigya object that contains the login checking method
	global $make_gigya;

	if ( $make_gigya->is_logged_in() ) {
		return true;
	} else {
		return false;
	}
}