<?php

	/**
	 * Display our form
	 * @return void
	 *
	 * @author  Cole Geissinger <[cgeissinger@makermedia.com]>
	 * @version 0.1
	 * @since   0.1
	 */
	function mm_applications_display_form( $settings = array(), $form = array() ) {

		$mm_applications_form = new MM_Application( $settings, $form );

		$mm_applications_form->display_form();
	}


	/**
	 * Random little function that helps us iterate through a multidimensional array.
	 * Works just like in_array() by searching haystack for needle using loose comparison unless strict is set but with multidimensional arrays.
	 * @param  string|array  $needle   If needle is a string, the comparison is done in a case-sensitive manner.
	 * @param  array         $haystack The array
	 * @param  boolean       $strict   If the third parameter strict is set to TRUE then the in_array() function will also check the types of the needle in the haystack.
	 * @return boolean
	 *
	 * @version  0.1
	 * @since    0.1
	 */
	function mm_in_array_r( $needle, $haystack, $strict = false ) {
	    foreach ( $haystack as $item ) {
	        if ( ( $strict ? $item === $needle : $item == $needle ) || ( is_array( $item ) && mm_in_array_r( $needle, $item, $strict ) ) ) {
	            return true;
	        }
	    }

	    return false;
	}


	function mm_is_application_page_template( $page_temp = '' ) {
		if ( ! empty( $page_temp ) ) {
			$page_templates = sanitize_file_name( $page_temp );
		} else {
			$page_templates = array(
				'page-application-exhibit.php',
			);
		}

		if ( is_array( $page_template ) ) {
			
		}
	}