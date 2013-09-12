<?php

	/**
	 * Display our form
	 * @return void
	 *
	 * @version 0.1
	 * @since   0.1
	 */
	function mf_applications_display_form( $settings = array(), $form = array() ) {

		$mf_applications_form = new MF_Applications( $settings, $form );

		$mf_applications_form->display_form();
	}