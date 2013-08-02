<?php

	/**
	 * A nifty plugin for created for Makezine.com repurposed for Maker Faire
	 *
	 * This is a dynamic version of the old "Current Faire" script @whyisjake built. This is also originally based on that script.
	 *
	 * @package makerfaire
	 * @author Cole Geissinger <cgeissinger@makermedia.com>
	 *
	 * @version 0.1
	 * @since   0.1
	 */
	
	// Make sure we haven't already loaded our class.. 
	if ( ! class_exists( 'Make_List_Tables_Current_Faire' ) && is_admin() ) {
		require_once( 'includes/class.current-faire.php' );

		// Instantiate our listed tables of all blog content.
		$GLOBALS['make_list_table_current_faire'] = new Make_List_Tables_Current_Faire();

	}