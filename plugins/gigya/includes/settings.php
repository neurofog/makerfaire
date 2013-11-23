<?php

/**
 * This file contains all the fun stuff that is added to the WordPress Settings screen
 * This will allow us to store and pass our Gigya public and private keys (which we don't we available publicly)
 *
 * @since  SPRINT_NAME
 */


/**
 * Adds a new section on to Settings > General
 * This section will allow us to add the fields needed for passing our Gigya public and private keys and store them in the DB.
 * @return void
 *
 * @since  SPRINT_NAME
 */
function make_gigya_init_settings() {

	// Define our settings section
	add_settings_section( 'make_gigya_settings_section', 'Gigya Settings', 'make_gigya_settings_description', 'general' );

	// Define our actual settings and asign them to the settings section
	add_settings_field( 'make_gigya_public_key', 'API Key', 'make_gigya_text_field', 'general', 'make_gigya_settings_section', array(
		'name' => 'make_gigya_public_key',
		'id'   => 'make_gigya_public_key',
	) );
	add_settings_field( 'make_gigya_private_key', 'Secret Key', 'make_gigya_text_field', 'general', 'make_gigya_settings_section', array(
		'name'  => 'make_gigya_private_key',
		'id'    => 'make_gigya_private_key',
	) );

	// Now we need to register our settings
	register_setting( 'general', 'make_gigya_public_key' );
	register_setting( 'general', 'make_gigya_private_key' );
}
add_action( 'admin_init', 'make_gigya_init_settings' );


/**
 * The callback function to the settings section set in make_gigya_init_settings()
 * @return string
 *
 * @since  SPRINT_NAME
 */
function make_gigya_settings_description() {
	echo '<p>The place where all the cool kids store their Gigya API keys :D</p>';
}


/**
 * A generic function that will output a text field
 * To customize, add a name and id to the add_settings_field array arguments
 * @param  array $args The arguments passed from add_settings_field()
 * @return string
 *
 * @since  SPRINT_NAME
 */
function make_gigya_text_field( $args ) {
	$value = get_option( esc_attr( $args['name'] ) );
	echo '<input type="text" name="' . $args['name'] . '" id="' . esc_attr( $args['id'] ) . '" class="regular-text" value="' . ( ! empty( $value ) ? esc_attr( $value ) : '' ) . '" />';
}


