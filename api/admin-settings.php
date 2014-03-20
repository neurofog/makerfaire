<?php

/**
 * Creates a new settings field in the Settings > General area to allow us to pass in the API key allowed to use the Application API
 *
 * @since Optimus Prime
 */

/**
 * Adds a new section on to Settings > General screen
 * This section will allow us to add the fields needed for passing our Application API key and store them in the DB.
 * @return void
 *
 * @since  Optimus Prime
 */
function make_app_api_init_settings() {

	// Define our settings section
	add_settings_section( 'make_app_api_settings_section', 'Applications API Settings', 'make_app_api_settings_description', 'general' );

	// Define our actual settings and asign them to the settings section
	add_settings_field( 'make_app_api_key', 'API Key', 'make_app_api_text_field', 'general', 'make_app_api_settings_section', array(
		'name' => 'make_app_api_key',
		'id'   => 'make_app_api_key',
	) );

	// Now we need to register our settings
	register_setting( 'general', 'make_app_api_key', 'make_app_api_sanitize_input' );
}
add_action( 'admin_init', 'make_app_api_init_settings' );


/**
 * The callback function to the settings section set in make_app_api_init_settings()
 * @return string
 *
 * @since  Optimus Prime
 */
function make_app_api_settings_description() {
	echo '<p>Pass in the valid API key to be used when returning applications with the Maker Faire API</p>';
}


/**
 * A generic function that will output a text field
 * To customize, add a name and id to the add_settings_field array arguments
 * @param  array $args The arguments passed from add_settings_field()
 * @return string
 *
 * @since  Optimus Prime
 */
function make_app_api_text_field( $args ) {
	$value = get_option( esc_attr( $args['name'] ) );

	echo '<input type="text" name="' . esc_attr( $args['name'] ) . '" id="' . esc_attr( $args['id'] ) . '" class="regular-text" value="' . ( ! empty( $value ) ? esc_attr( $value ) : '' ) . '" />';
}


/**
 * Sanitizes user input in the application API
 * @param  string $input The value passed through the form
 * @return string
 *
 * @since  Optimus Prime
 */
function make_app_api_sanitize_input( $input ) {
	$input = sanitize_text_field( $input );

	return $input;
}