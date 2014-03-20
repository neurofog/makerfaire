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


	/**
	 * Function is used to return post count table on the reports page.
	 * TODO: move this into the proper file.
	 */
	function mf_count_post_statuses( $display = 'list' ) {
		$types = array(
			'All' 				=> 'any',
			'Accepted'			=> 'accepted',
			'Draft'				=> 'draft',
			'In Progress'		=> 'in-progress',
			'Proposed'			=> 'proposed',
			'Rejected'			=> 'rejected',
			'More Info'	 		=> 'more-info',
			'wait-list'			=> 'wait-list',
			);
		$output = ( $display == 'table' ) ? '  <table width="300" border="0" cellspacing="0" cellpadding="3" style="border:1px solid #DFDFDF;">' : '';
		foreach ($types as $k => $type) {
			$args = array(
				'post_type'			=> 'mf_form',
				'post_status'		=> 'any',
				'posts_per_page' 	=> 1,
				'faire'				=> MF_CURRENT_FAIRE,
				'post_status'		=> $type,
				'return_fields'		=> 'ids',
				);
			$query = new WP_Query( $args );
			if ( $display == 'list' ) {
				$output .= '| <li><a href="edit.php?post_type=mf_form&page=current_faire&post_status=' . $type . '">' . $k . '</a> <span class="count">(' . $query->found_posts . ' )</span></li>';
			} elseif ( $display == 'table' ) {
				$output .= '<tr><td>' . $k . '</a></td><td><a href="edit.php?post_type=mf_form&page=current_faire&post_status=' . $type . '">' . $query->found_posts . '</a></td></tr>';
			}
		}
		$output .= ( $display == 'table' ) ? '</table>' : '';
		return substr($output, 2);
	}