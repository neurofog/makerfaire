<?php
/*
Plugin Name: Maker Faire Form
Plugin URI: http://insourcecode.com
Description: Select the type of form and embed into post or page.
Version: 0.0.2
Author: inSourceCode
Author URI: http://insourcecode.com
License:  GPL2
*/

/* 
* MAKER_FAIRE_FORM CLASS
* =====================================================================*/
class MAKER_FAIRE_FORM {

	/* 
	* GIGYA API KEY
	* =====================================================================*/
	const GIGYA_API_KEY    = '3_nUMOBEBpLoLnfNUbwAo9FCwTqzd6vTjpVt3Ojd807EIT5IcF94eM9hoV8vcqjoe8';
	
	/* 
	* GIGYA API SECRET
	* =====================================================================*/
	const GIGYA_SECRET_KEY = 'GlvZcbxIY6Oy7lnWJheh56DXj3wKAiG3yVqhv++VLZM=';

	/* 
	* All Form Keys with 1/0 for Required Field
	* =====================================================================*/
	var $fields = array(
			'exhibit' => array(
				's1' => array(
					'project_name'          => 1,
					'private_description'   => 1,
					'public_description'    => 1,
					'project_photo'         => 1,
					'project_photo_thumb'   => 0,
					'project_website'       => 0,
					'project_video'         => 0,
					'food'                  => 1,
					'food_details'          => 0,

					'org_type'              => 1,
					'large_non_profit'      => 0,

					'sales'                 => 0,
					'sales_details'         => 0,
					'crowdsource_funding'	=> 0,
					'cf_details'			=> 0,
					'booth_size'            => 1,
					'booth_size_details'    => 0,
					'tables_chairs'         => 1,
					'tables_chairs_details' => 0,
					'layout'                => 0,
					'activity'              => 0,
					'placement'             => 0,
					'booth_location'        => 1,
					'booth_options'         => 0,
					'lighting'              => 1,
					'noise'                 => 1,
					'power'                 => 1,
					'what_are_you_powering' => 0,
					'amps'                  => 0,
					'amps_details'          => 0,
					'internet'              => 1,
					'radio'                 => 1,
					'radio_frequency'       => 0,
					'radio_details'         => 0,
					'fire'                  => 0,
					'hands_on'              => 0,
					'safety_details'        => 0,
					),
				's2' => array(
					'email'               => 1,
					'name'                => 1,
					'maker'               => 1,

					'maker_name'          => 0,
					'maker_email'         => 0,
					'maker_bio'           => 0,
					'maker_twitter'		  => 0,
					'maker_photo'         => 0,
					'maker_photo_thumb'   => 0,

					'm_maker_name'        => 0,
					'm_maker_email'       => 0,
					'm_maker_photo'       => 0,
					'm_maker_photo_thumb' => 0,
					'm_maker_twitter'     => 0,
					'm_maker_bio'         => 0,
					'm_maker_gigyaid'     => 0,

					'group_name'          => 0,
					'group_bio'           => 0,
					'group_twitter'		  => 0,
					'group_photo'         => 0,
					'group_photo_thumb'   => 0,
					'group_website'       => 0,

					'phone1'              => 1,
					'phone1_type'         => 1,
					'phone2'              => 0,
					'phone2_type'         => 0,

					'private_address'     => 1,
					'private_address2'    => 0,
					'private_city'        => 1,
					'private_state'       => 0,
					'private_zip'         => 0,
					'private_country'     => 1
					),
				's3' => array(
					'supporting_documents' => 0,
					'references'           => 0,
					'referrals'            => 0,
					'hear_about'           => 0,
					'first_time'           => 0,
					'anything_else'        => 0,
				)
			),
			'performer' => array(
				's1' => array(
					'performer_name'        => 1,
					'private_description'   => 1,
					'length'                => 0,
					'public_description'    => 1,
					'performer_website'     => 0,
					'performer_photo'       => 1,
					'performer_photo_thumb' => 0,
					'performer_video'       => 0,
					'performance_time'      => 1,
					'schedule_comments'     => 0,
					'equipment'             => 0,
					'performer_count'       => 1,
					'compensation_type'     => 0,
					'compensation'          => 0,
					'guest_tickets'         => 1,
				),
				's2' => array(
					'name'             => 1,
					'email'            => 1,

					'phone1'           => 1,
					'phone1_type'      => 1,
					'phone2'           => 0,
					'phone2_type'      => 0,
					'onsite_phone'     => 0,

					'private_address'  => 1,
					'private_address2' => 0,
					'private_city'     => 1,
					'private_state'    => 0,
					'private_zip'      => 0,
					'private_country'  => 1,
				),
				's3' => array(
					'first_makerfaire' => 0,
					'exhibit'          => 0,
					'promotion'        => 0,
					'additional_info'  => 0,
				)
			),
			'presenter' => array(
				's1' => array(
					'presentation_type'        => 1,
					'private_description'	   => 0,
					'length_presentation'	   => 0,
					'availablity'              => 0,
					'special_requests'         => 0,
					'presentation_name'        => 1,
					'short_description'        => 1,
					'long_description'		   => 1,
					'presentation_photo'       => 1,
					'presentation_photo_thumb' => 0,
					'presentation_website'     => 0,
					'video'                    => 0,
				),
				's2' => array(
					'name'                  => 1,
					'email'                 => 1,
					'phone1'                => 1,
					'phone1_type'           => 0,
					'phone2'                => 0,
					'phone2_type'           => 0,

					'private_address'       => 1,
					'private_address2'      => 0,
					'private_city'          => 1,
					'private_state'         => 0,
					'private_zip'           => 0,
					'private_country'       => 1,

					'presenter_name'         => 1,
					'presenter_email'        => 1,
					'presenter_bio'          => 1,
					'presenter_org'          => 0,
					'presenter_twitter'		 => 0,
					'presenter_previous'	 => 0,
					'presenter_title'        => 0,
					'presenter_onsite_phone' => 1,
					'presenter_photo'        => 1,
					'presenter_photo_thumb'  => 0,
					'presenter_gigyaid'      => 0,
				),
				's3' => array(
					'maker_ask'        => 0,
					'first_makerfaire' => 0,
					'exhibit'          => 0,
					'promotion'        => 0,
					'additional_info'  => 0,
				)
			),
			'makerprofile' => array()
		);
	/* 
	* Default MakerFaire - PHASE 2 - MAKE THIS A SETTINGS OPTION
	* =====================================================================*/
	var $maker_faire = '2013_newyork';
	/* 
	* Default Form Type
	* =====================================================================*/
	var $type        = 'exhibit';

	/* 
	* Default Form Values
	* =====================================================================*/
	var $form        = array(
		'id'          => 0,
		'uid'         => 0,
		'maker_faire' => '2013_newyork',
		'tags'        => array(),
		'cats'        => array()
	);

	/* 
	* GIGYA USER
	* =====================================================================*/
	var $user;

	/* 
	* Post Meta save for Columns View
	* =====================================================================*/
	var $post_meta;

	/* 
	* Init the MakerFaire Class
	*
	* @access public
	* =====================================================================*/
	public function __construct() {
		add_action( 'init',                           array( &$this, 'init' ) );
		add_action( 'admin_init', 		 			  array( &$this, 'admin_init' ) );
		add_action( 'admin_menu',					  array( &$this, 'add_menus' ) );
		add_action( 'add_meta_boxes', 	              array( &$this, 'add_meta_boxes' ) );
		add_action( 'save_post',			          array( &$this, 'update_post' ) );


		add_shortcode( 'mfform', 					  array( &$this, 'shortcode_handler' ) );

		add_action( 'wp_ajax_nopriv_mfform_step', 	  array( &$this, 'ajax_handler' ) );
		add_action( 'wp_ajax_mfform_step', 			  array( &$this, 'ajax_handler' ) );

		add_action( 'wp_ajax_nopriv_mfform_getforms', array( &$this, 'ajax_getforms' ) );
		add_action( 'wp_ajax_mfform_getforms', 		  array( &$this, 'ajax_getforms' ) );

		add_action( 'wp_enqueue_scripts',             array( &$this, 'enqueue' ) );
		add_action( 'admin_enqueue_scripts',          array( &$this, 'admin_enqueue' ) );
	}

	/* 
	* Callback for INIT - HOOK
	*
	* @access public
	* =====================================================================*/
	public function init() {

		$labels = array( 
			'name'               => _x( 'Applications', 'post type general name' ),
			'singular_name'      => _x( 'Application', 'post type singular name' ),
			'add_new'            => _x( 'Add Application', 'mf_form' ),
			'add_new_item'       => __( 'Add New Application' ),
			'edit_item'          => __( 'Edit Application' ),
			'new_item'           => __( 'New Application' ),
			'all_items'          => __( 'All Applications' ),
			'view_item'          => __( 'View Application' ),
			'search_items'       => __( 'Search Applications' ),
			'not_found'          => __( 'No forms found' ),
			'not_found_in_trash' => __( 'No forms found in Trash' ),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Applications' )
		);

		$args =   array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => true,
			'menu_position'      => null,
			'menu_icon'          => plugins_url( 'assets/i/admin-icon.png', __FILE__ ),
			'supports'           => array( 'title', 'revisions' ),
			'taxonomies'		 => array( 'category', 'post_tag' ),
			'rewrite'            => array( 'slug' => 'makers', 'with_front' => false )
		);

		//REGISTER MF FORM CUSTOM POST TYPE
		register_post_type( 'mf_form', $args );
	}


	/* 
	* Callback for ADMIN INIT - HOOK
	*
	* @access public
	* =====================================================================*/
	public function admin_init() {
		
		if ( isset( $_GET['form_csv'] ) )
			$this->build_form_export( esc_attr( $_GET['form_csv'] ), ( isset( $_GET['form_status'] ) ? esc_attr( $_GET['form_status'] ) : 'all' ) );

		if ( isset( $_GET['maker_csv'] ) )
			$this->build_maker_export( esc_attr( $_GET['maker_csv'] ) );
		
		if ( isset( $_GET['comments_csv'] ) )
			$this->build_comments_export();
			
		if ( isset( $_GET['presentation_csv'] ) )
			$this->build_presentation_exports( esc_attr( $_GET['presentation_csv'] ) );
			
		$this->upgrade();	
			
		//ADD COLUMNS TO MF FORM SUBMISSION LIST
		add_filter( 'manage_mf_form_posts_columns',         array( &$this, 'columns' ) );
		add_filter( 'manage_edit-mf_form_sortable_columns', array( &$this, 'columns_sortable' ) );
		add_action( 'manage_mf_form_posts_custom_column',   array( &$this, 'custom_columns' ), 10, 2 );


		add_filter( 'request', array( &$this, 'columns_orderby' ) );

		//REMOVE ABILITY TO EDIT FORM
		remove_meta_box( 'submitdiv', 'mf_form', 'side' );
	}


	/* 
	* Set Columns for the MakerFaire Custom Post Type
	*
	* @access public
	* @param array $cs Default columns
	* =====================================================================*/
	public function columns( $cs ) {
		unset(
			$cs['author'],
			$cs['title'],
			$cs['date'],
			$cs['editorial-metadata-featured'],
			$cs['editorial-metadata-temporary-location']
		);

		$ncs = array(
			'status'                                => 'Status',			
			'type'                                  => 'Application Type',
			'id'                                    => 'Project ID',
			'title'                                 => 'Project Name',
			'maker'                                 => 'Maker',
			'editorial-metadata-featured'           => 'Featured Maker',
			'editorial-metadata-temporary-location' => 'Temporary Location',
			'date'                                  => 'Date'
		);
		return array_merge( $cs, $ncs );
	}


	/* 
	* Set Sortable Columns
	*
	* @access public
	* @param array $cs Default sortable columns
	* =====================================================================*/
	public function columns_sortable( $cs ) {
		$cs['id']                                     = 'ID';
		$cs['type']                                   = 'type';
		$cs['maker']                                  = 'maker';
		$cs['editorial-metadata-featured']            = 'featured';
		$cs['editorial-metadata-temporary-location']  = 'temp-location';
		
		return $cs;
	}


	/* 
	* Allow for sorting of custom colulmns
	*
	* @access public
	* @param array $vars The variables for the orderby
	* =====================================================================*/
	public function columns_orderby( $vars ) {
		if ( isset( $vars['orderby'] ) && $vars['post_type'] == 'mf_form' ) {
			
			switch( $vars['orderby'] ) {
				case 'temp-location' :
					$vars = array_merge( $vars, array(
						'meta_key' => '_ef_editorial_meta_text_temporary-location',
						'orderby'  => 'meta_value'
					) );
				break;
				case 'featured' :
					$vars = array_merge( $vars, array(
						'meta_key' => '_ef_editorial_meta_checkbox_featured',
						'orderby'  => 'meta_value'
					) );
				break;	
				case 'type' :
					$vars = array_merge( $vars, array(
						'meta_key' => '_mf_form_type',
						'orderby'  => 'meta_value'
					) );
				break;
				case 'maker' :
					$vars = array_merge( $vars, array(
						'meta_key' => '_mf_maker_name',
						'orderby'  => 'meta_value'
					) );
				break;
			}		
		}	 
		return $vars;
	}


	/* 
	* Adds Custom Columns to the MakerFaire Custom Post Type
	*
	* @access public
	* @param string $c Column ID
	* @param integer $pid Post ID
	* =====================================================================*/
	public function custom_columns( $c, $pid ) {
		global $post;
		$data = json_decode( str_replace( "\'", "'", $post->post_content ) );

		if( is_null( $this->post_meta ) || !isset( $this->post_meta[$pid] ) )
			$this->post_meta = array( $pid => get_post_meta( $pid ) );

		switch ( $c ) {
			case 'editorial-metadata-featured':
				echo isset( $this->post_meta[$pid]['_ef_editorial_meta_checkbox_featured'] ) && $this->post_meta[$pid]['_ef_editorial_meta_checkbox_featured'][0] == 1 ? 'Yes' : 'No';
				break;
			case 'editorial-metadata-temporary-location':
				echo isset( $this->post_meta[$pid]['_ef_editorial_meta_text_temporary-location'] ) ? esc_html( $this->post_meta[$pid]['_ef_editorial_meta_text_temporary-location'][0] ) : '';
				break;
			case 'id':
				echo '<strong>'.intval( $pid ).'</strong>';
				break;
			case 'type':
				echo ( !empty( $data->form_type ) ) ? '<strong>' . esc_html( $data->form_type ) . '</strong>' : '';
				break;
			case 'maker':
				echo ( !empty( $data->name ) ) ? esc_html( $data->name ) : '';
				break;
		}
	}


	/* 
	* Adds submenu pages to the MakerFaire Custom Post Type
	*
	* @access public
	* =====================================================================*/
	public function add_menus() {
		add_submenu_page( 'edit.php?post_type=mf_form', 'Add Maker', 'Add Maker', 'edit_others_posts', 'isc_mm_add_maker', array( &$this, 'show_add_maker_page' ) );
		add_submenu_page( 'edit.php?post_type=mf_form', 'List Makers', 'List Makers', 'edit_others_posts', 'isc_mm_list_makers', array( &$this, 'show_list_makers_page' ) );
		add_submenu_page( 'edit.php?post_type=mf_form', 'Project Images', 'Project Images', 'edit_others_posts', 'mf_project_images', array( &$this, 'show_project_images' ) );
		add_submenu_page( 'edit.php?post_type=mf_form', 'Reports', 'Reports', 'edit_others_posts', 'mf_reports', array( &$this, 'show_reports_page' ) );
	}


	/* 
	* Inits all included meta boxes for the MakerFaire Custom Post Type
	*
	* @access public
	* =====================================================================*/
	public function add_meta_boxes() {
		global $post;

		if ( $post->post_status != 'auto-draft' ) {
			add_meta_box( 'mf_summary',   'Summary',   array( &$this, 'meta_box' ), 'mf_form', 'normal', 'default' );
			add_meta_box( 'mf_details',   'Details',   array( &$this, 'meta_box' ), 'mf_form', 'normal', 'default' );
			add_meta_box( 'mf_logistics', 'Edit Form', array( &$this, 'meta_box' ), 'mf_form', 'normal', 'default' );
		} else {
			$gigya_lookup = ' <a target="_blank" style="float:right" href="edit.php?post_type=mf_form&amp;page=isc_mm_list_makers">Lookup GIGYA ID</a>';
			
			add_meta_box( 'mf_form_type', 'Application Type',  array( &$this, 'meta_box' ), 'mf_form', 'normal', 'default' );
			add_meta_box( 'mf_exhibit',   'Exhibit Details'.$gigya_lookup,   array( &$this, 'meta_box' ), 'mf_form', 'normal', 'default', array( 'type'=>'exhibit' ) );
			add_meta_box( 'mf_performer', 'Performer Details'.$gigya_lookup, array( &$this, 'meta_box' ), 'mf_form', 'normal', 'default', array( 'type'=>'performer' ) );
			add_meta_box( 'mf_presenter', 'Presenter Details'.$gigya_lookup, array( &$this, 'meta_box' ), 'mf_form', 'normal', 'default', array( 'type'=>'presenter' ) );
		}

		add_meta_box( 'mf_save', 'Edit Application', array( &$this, 'meta_box' ), 'mf_form', 'side', 'default' );
		add_meta_box( 'mf_logs', 'Status Changes &amp; Notifications Sent', array( &$this, 'meta_box' ), 'mf_form', 'normal', 'default' );

		if ( $post->post_status != 'auto-draft' )
			add_meta_box( 'mf_maker', 'Maker Info', array( &$this, 'meta_box' ), 'mf_form', 'side', 'default' );
	}


	/* 
	* Controller for all backend Meta Boxes
	*
	* @access public
	* @param object $post Current Post to be edited
	* @param array $args Include arguments for the meta box.
	* =====================================================================*/
	public function meta_box( $post, $args ) {
		$bad  = array( '&#039;', "\'", '&#8217;', '&#38;', '&#038;', '&#34;', '&#034;', '&#8211;', '&lt;', '&#8230;', 'u2018', 'u2019' );
   		$good = array( "'",      "'",  "'",       "&",     "&",      '"',     '"',      '–',       '>',    '...',     "'",     "'",    );
		$data = json_decode( str_replace( $bad, $good, $post->post_content ) );

		if( $args['id'] == 'mf_save' ) { 
			$wf = get_post_meta( $post->ID, '_mf_waiting_for', true );
			$wf = $wf == '' ? 'Waiting on?' : $wf; ?>
				<div class="submitbox" id="submitpost">
					<?php wp_nonce_field( 'mf_nonce', 'mf_submit_nonce' ); ?>
					<?php $post_status_types    = array( 'in-progress', 'proposed', 'waiting-for-info', 'accepted', 'rejected', 'cancelled' ); ?>
					<input name="mf_form" type="hidden" value="1" />
					<input id="id" name="id" type="hidden" value="<?php echo $post->post_status != 'auto-draft' ? intval( $post->ID ) : 0; ?>" />
					<div id="misc-publishing-actions">
						<div class="misc-pub-section">
							<label for="post_status" style="display: inline;">Status:</label>
							<select id="post_status" name="post_status">
								<?php
									// Get an array of our select options for setting the post status
									global $edit_flow;

									if ( is_object( $edit_flow ) && is_a( $edit_flow, 'edit_flow') ) :
										foreach ( $edit_flow->custom_status->get_custom_statuses() as $cso ) { ?>
											<option value="<?php echo esc_attr( $cso->slug ); ?>" title="<?php echo esc_attr( $cso->description ); ?>" <?php selected( $cso->slug, $post->post_status ); ?>>
												<?php echo esc_attr( $cso->name ); ?>
											</option>
										<?php }
									endif;
								?>
							</select>
							<div id="mff-post-status-display" style="padding-top:5px;"></div>
						</div>
					</div><!--[END #misc-pub-section]-->
					<div id="major-publishing-actions">
						<div id="mfquestionwait"></div>
						<div id="delete-action">
							<a href="<?php echo get_delete_post_link( $post->ID ); ?>" class="submitdelete deletion">Move to Trash</a>
						</div>
						<div id="publishing-action">
							<input type="submit" value="Save Application" accesskey="p" id="publish" class="button button-primary button-large" name="save">
						</div>
					</div>
					<div class="clear"></div>
					<p class="misc-pub-section num-revisions">
					<?php
						$kids = wp_get_post_revisions( get_the_ID() );
						if ( count( $kids ) > 1 ) :
							printf( __( 'Revisions: %s' ), '<b>' . number_format_i18n( absint( count( $kids ) ) ) . '</b>' );
							$kid = array_splice( $kids, 0 );
					?>
						<a class="hide-if-no-js" href="<?php echo esc_url( get_edit_post_link( absint( $kid[0]->ID ) ) ); ?>"><?php _ex( 'Browse', 'revisions' ); ?></a>
					<?php endif; ?>
					</p>
					<script type="text/javascript">
						(function($){
							$(document).ready(function() {

								// Check if the post status is set, if not, go ahead and run this code.
								if ( ! $('#mff-post-status-display').length )
									return true;

								$('#post_status').change(function() {
									var postStatus = $('#post_status');
									var origPost = $('#original_post_status');
									var postStatusSelected = $('option:selected', postStatus);
									var postStatusDisplay = $('#mff-post-status-display');
									var origPostStatus =origPost.val();
									var postStatusSelectedTitle=postStatusSelected.attr('title');
									var newStatus=postStatus.val();

									console.log('change: %s -> %s (%s)', origPostStatus, newStatus, postStatusSelected.val() );

									postStatusDisplay.html(postStatusSelectedTitle);

									if ( newStatus == 'waiting-for-info' ) {
										$('#mfquestionwait').html('<textarea name="mf_waitingquestion" id="mf_waitingquestion" style="width:99%"><?php echo html_entity_decode( esc_textarea( $wf ) ); ?></textarea>');
									} else {
										$('#mfquestionwait').html('');
									}

								});

								setTimeout(function(){$('#post_status').change();}, 10);
							})
						})(jQuery.noConflict());
					</script>
				</div>
		<?php } elseif ( $args['id'] == 'mf_logs' ) {
			$post_status_log = get_post_meta( $post->ID, '_mf_log', true );

			if ( ! is_array( $post_status_log ) || $post_status_log == false || sizeof( $post_status_log ) == 0 ) {
				$post_status_log = array();
				$post_status_log[] = mysql2date('m/d/y h:i a', $post->post_date) .' - Proposed';
			}

			echo '<ul>';
			foreach ( array_reverse( $post_status_log ) as $log ) {
				echo '<li>'.esc_html( $log ).'</li>';
			}
			echo "</ul>";
		} elseif ( $args['id'] == 'mf_summary' ) { 
		
			$jdb_success = get_post_meta( $post->ID, 'mf_jdb_sync', true );

			if ( $jdb_success == '' ) {
				$jdb_fail = get_post_meta( $post->ID, 'mf_jdb_sync_fail', true );
				$jdb      = '[FAILED] : N/A';
				if ( $jdb_success == '' )
					$jdb  = '[FAILED] : ' . date( 'M jS, Y g:i A', $jdb_fail - ( 7 * 3600 ) );
			} else {
				$jdb = '[SUCCESS] : ' . date( 'M jS, Y g:i A', $jdb_success - ( 7 * 3600 ) );	
			}
			
			$photo = $data->{ $this->merge_fields( 'form_photo_thumb', $data->form_type ) };

			// Check if a photo exists
			if ( '' == $photo )
				$photo = $data->{ $this->merge_fields( 'form_photo', $data->form_type ) };

			// Check if we are loading the public description or a short description
			if ( isset( $data->public_description ) ) {
				$main_description = $data->public_description;
			} else if ( isset( $data->short_description ) ) {
				$main_description = $data->short_description;
			} else {
				$main_description = '';
			}
			?>
			<h1><?php echo esc_html( $data->{ $this->merge_fields( 'project_name', $data->form_type ) } ); ?></h1>
			<input name="form_type" type="hidden" value="<?php echo esc_attr( $data->form_type ); ?>" />
			<table style="width:100%">
				<tr>
					<td style="width:210px;" valign="top"><img src="<?php echo esc_url( $photo ); ?>" height="200" width="200" /></td>
					<td valign="top">
						<p><?php echo Markdown ( stripslashes( wp_filter_post_kses( mf_convert_newlines( $main_description, "\n" ) ) ) ); ?></p>
						<table style="width:100%">
							<tr>
								<td style="width:80px;" valign="top"><strong>Type:</strong></td>
								<td valign="top"><?php echo esc_attr( ucfirst( $data->form_type ) ); ?></td>
							</tr>
							<tr>
								<td style="width:80px;" valign="top"><strong>Status:</strong></td>
								<td valign="top"><?php echo esc_attr( $post->post_status ); ?></td>
							</tr>
							<?php

								// Jake's fancy cached events query found in 'plugins/public-pages/makers.php' in mf_get_scheduled_item()
								// The function output things for the front-end and all we want is the data.
								$get_events = wp_cache_get( $post->ID . '_schedule' );
								if ( $get_events == false ) {
									$args = array( 
										'post_type'		=> 'event-items',
										'orderby' 		=> 'meta_value', 
										'meta_key'		=> 'mfei_start',
										'order'			=> 'asc',
										'posts_per_page'=> '30',
										'meta_query' 	=> array(
											array(
												'key' 	=> 'mfei_record',
												'value'	=> $post->ID
										   ),
										)
									);
									$get_events = new WP_Query( $args );
									wp_cache_set( $post->ID . '_schedule', $get_events, '', 300 );
								}

								// Check that we have returned our query of events, if not, give the option to schedule the event
								if ( $get_events->found_posts >= 1 ) { ?>
									<tr>
										<td style="width:80px;"><strong>Scheduled:</strong></td>
										<td valign="top">Yes</a>
									</tr>
									<?php // Loop through theme
									while ( $get_events->have_posts() ) : $get_events->the_post();

										// Get an array of our event data
										$event_record = get_post_meta( get_the_ID() );

										// Setup the edit URL and add an edit link to the admin area
										$edit_event_url = get_edit_post_link();

										// Check that fields are set, and display them as needed.
										if ( ! empty( $event_record['mfei_day'][0] ) ) : ?>
											<tr>
												<td style="width:80px;" valign="top"><strong>Day:</strong></td>
												<td valign="top"><?php echo esc_html( $event_record['mfei_day'][0] ); ?> &nbsp; &nbsp; &nbsp; <a href="<?php echo esc_url( $edit_event_url ); ?>" target="_blank">Edit the Time and Date</a></td>
											</tr>
										<?php endif; if ( ! empty( $event_record['mfei_start'][0] ) ) : ?>
											<tr>
												<td style="width:80px;" valign="top"><strong>Start Time:</strong></td>
												<td valign="top"><?php echo esc_html( $event_record['mfei_start'][0] ); ?></td>
											</tr>
										<?php endif; if ( ! empty( $event_record['mfei_stop'][0] ) ) : ?>
											<tr>
												<td style="width:80px;" valign="top"><strong>Stop Time:</strong></td>
												<td valign="top"><?php echo esc_html( $event_record['mfei_stop'][0] ); ?></td>
											</tr>
										<?php endif; if ( ! empty( $event_record['mfei_schedule_completed'][0] ) ) : ?>
											<tr>
												<td style="width:80px;" valign="top"><strong>Schedule Completed:</strong></td>
												<td valign="top"><?php echo esc_html( $event_record['mfei_schedule_completed'][0] ); ?></td>
											</tr>
										<?php endif; ?>

									<?php endwhile; ?>
									
										<tr>
											<td style="width:80px;" valign="middle"><strong>Event Video:</strong></td>
											<td valign="top">
												<input type="text" id="video-coverage" name="video-coverage" style="width:25%;" value="<?php echo !empty( $event_record['mfei_coverage'][0] ) ? esc_url( $event_record['mfei_coverage'][0] ) : ''; ?>" />
												<input type="hidden" name="event-id" value="<?php echo get_the_ID(); ?>" />
											</td>
										</tr>

								<?php } else { ?>
									<tr>
										<td style="width:80px;" valign="top"><strong>Scheduled:</strong></a></td>
										<td valign="top"><a href="<?php echo admin_url(); ?>post-new.php?post_type=event-items&amp;refer_id=<?php echo get_the_ID(); ?>">Schedule This Event</a></td>
									</tr>
								<?php }

								$wkey = $this->merge_fields( 'project_website', $data->form_type );
								$vkey = $this->merge_fields( 'project_video', $data->form_type );
							?>
							<tr>
								<td style="width:80px;" valign="top"><strong>Website:</strong></td>
								<td valign="top"><a href="<?php echo esc_url( $data->{$wkey} ); ?>" target="_blank"><?php echo esc_url( $data->{$wkey} ); ?></a></td>
							</tr>
							<tr>
								<td valign="top"><strong>Video:</strong></td>
								<?php 
									echo ( isset( $data->project_video ) ) ? '<td valign="top"><a href="' . esc_url( $data->project_video ) . '" target="_blank">' . esc_url( $data->project_video ) . '</a></td>' : null ;
									echo ( isset( $data->performer_video ) ) ? '<td valign="top"><a href="' . esc_url( $data->performer_video ) . '" target="_blank">' . esc_url( $data->performer_video ) . '</a></td>' : null ;
									echo ( isset( $data->video ) ) ? '<td valign="top"><a href="' . esc_url( $data->video ) . '" target="_blank">' . esc_url( $data->video ) . '</a></td>' : '<td></td>' ;
								?>
							
							</tr>
							<tr>
								<td style="width:80px;" valign="top"><strong>Categories:</strong></td>
								<td valign="top">
									<?php 
										$cats = get_the_category();
										$count = count($cats);
										$i = 1;
										if ( !empty( $cats ) ) {
											foreach ( $cats as $cat ) {
												echo $cat->name;
												echo $i != $count ?  ', ': ' ';
												$i++;
											}
										}
									?>
								</td>
							</tr>
							<tr>
								<td style="width:80px;" valign="top"><strong>Tags:</strong></td>
								<td valign="top">
									<?php 
										$tags = get_the_tags();
										$count = count($tags);
										$i = 1;
										if ( !empty( $tags ) ) {
											foreach ( $tags as $tag ) {
												echo $tag->name;
												echo $i != $count ?  ', ': ' ';
												$i++;
											}	
										}
									?>
								</td>
							</tr>
							<?php if( $data->form_type == 'exhibit' ) : ?>
							<tr>
								<td valign="top"><strong>Commercial Maker:</strong></td>
								<td valign="top"><?php echo esc_attr( $data->sales == '' ? 'N/A' : $data->sales ); ?></td>
							</tr>
							<?php endif; ?>
							<tr>
								<td valign="top"><strong>JDB Sync:</strong></td>
								<td valign="top"><?php echo esc_html( $jdb ); ?></td>
							</tr>
						</table>
						</td>
					</tr>
					</table>
				<?php
		} elseif ( $args['id'] == 'mf_details' ) {

			// Check if we are loading the private description or a long description
			if ( isset( $data->private_description ) ) {
				$details_description = $data->private_description;
			} else if ( isset( $data->long_description ) ) {
				$details_description = $data->long_description;
			} else {
				$details_description = '';
			}
			
			echo stripslashes( wp_filter_post_kses( $this->convert_newlines( $details_description ) ) );
			
		} elseif ( $args['id'] == 'mf_maker' ) { 
			
			$photo_thumb_key = $this->merge_fields( 'user_photo_thumb', $data->form_type );
			$photo_key       = $this->merge_fields( 'user_photo', $data->form_type );
			$bio_key         = $this->merge_fields( 'user_bio', $data->form_type );
			
			$photo = isset( $data->{ $photo_thumb_key } ) ? $data->{ $photo_thumb_key } : '';
			
			if( '' == $photo )
				$photo = isset( $data->{ $photo_key } ) ? $data->{ $photo_key } : '';
			if( is_array( $photo ) )
				$photo = $photo[0];
				
			$bio = isset( $data->{ $bio_key } ) ? $data->{ $bio_key } : '';
			if( is_array( $bio ) )
				$bio = $bio[0]; ?>

			<img src="<?php echo esc_url( $photo ); ?>" style="float:left; margin-right:10px;" height="75" width="75" />
			<div style="float:left; width:150px;">
				<strong><?php echo esc_html( $data->name ); ?></strong><br />
				<?php echo esc_html( $data->phone1 ); ?><br />
				<?php echo esc_html( $data->email ); ?>
			</div>
			<div style="clear:both; height:15px;"></div>
			<strong>ADDRESS</strong><br />
			<?php echo esc_html( $data->private_address.' '.$data->private_address2 ); ?><br />
			<?php echo esc_html( $data->private_city.', '.$data->private_state.' '.$data->private_zip.' '.$data->private_country ); ?><br /><br />
			<strong>Bio</strong><br />
			<?php echo esc_html( $bio ); ?>

		<?php } elseif ( $args['id'] == 'mf_form_type' ) { ?>

			<input class="mf_form_type" name="form_type" type="radio" value="exhibit" /> &nbsp; Exhibit Application &nbsp;
			<input class="mf_form_type" name="form_type" type="radio" value="performer" /> &nbsp; Performer Application &nbsp;
			<input class="mf_form_type" name="form_type" type="radio" value="presenter" /> &nbsp; Presenter Application
			<script type="text/javascript">
				(function($){
					$(document).ready(function() {
						$('#mf_exhibit, #mf_performer, #mf_presenter').hide();
						$('.mf_form_type').click(function(){
							$('#mf_exhibit, #mf_performer, #mf_presenter').hide();
							form_type = $(this).val();
							
							if ( form_type == 'exhibit' )
								$( '#maker input[value="One maker"]' ).click();
							
							$('#mf_'+form_type).show();
						} );
					} );
				} )(jQuery.noConflict())
			</script>

		<?php } elseif ( in_array( $args['id'], array( 'mf_exhibit', 'mf_performer', 'mf_presenter', 'mf_logistics' ) ) ) {

			if ( $args['id'] != 'mf_logistics' ) {
				$data = array( 'form_type' => $args['args']['type'], 'maker_faire' => $this->maker_faire );
				foreach ( $this->fields[$args['args']['type']] as $sn => $s ) {
					foreach ( array_keys( $s ) as $k ) {
						$data[$k] = '';
					}
				}

				$data = (object) $data;
			}
				
			if( !isset( $data->cats ) )
				$data = (object) array_merge( array( 'cats' => '' ), (array) $data);
			if( !isset( $data->tags ) )
				$data = (object) array_merge( array( 'tags' => '' ), (array) $data);
			if( !isset( $data->uid ) )
				$data = (object) array_merge( array( 'uid' => '' ), (array) $data);
				
			$cont = array(
				'm_maker_email', 
				'm_maker_gigyaid', 
				'm_maker_photo', 
				'm_maker_bio',
				'presenter_email',
				'presenter_gigyaid', 
				'presenter_bio',
				'presenter_onsite_phone',
				'presenter_org',
				'presenter_title',
				'presenter_photo'
			); ?>

			<table style="width:100%">

				<?php foreach( (array) $data as $k => $v ) : if ( in_array( $k, $cont ) ) continue; ?>
					<tr class="mf-form-row" id="<?php echo esc_attr( $k ); ?>" <?php if ( strpos( $k, '_thumb' ) !== false ): ?>style="display:none"<?php endif; ?>>
					<td valign="top"><?php echo esc_html( ucwords( str_replace( '_', ' ', $k ) ) ); ?>:</td>
					<td>
						<?php $this->display_edit_field( $data->form_type, $k, $v, (array) $data ); ?>
					<?php if ( $k != 'm_maker_name' && $k != 'presenter_name' ) : ?>
					</td>
					</tr>
					<?php endif; ?>
				<?php endforeach; ?>
				<tr>
					<td></td>
				</tr>

			</table>
			
			<?php if( $args['id'] == 'mf_logistics' || $args['id'] == 'mf_presenter' ) :
				if ( isset( $data->m_maker_name ) && is_array( $data->m_maker_name ) ) {
					$number_of_makers = count( $data->m_maker_name );
				} elseif ( isset( $data->presenter_name ) && is_array( $data->presenter_name ) ) {
					$number_of_makers = count( $data->presenter_name );
				} else {
					$number_of_makers = 1;
				} ?>
				<script type="text/javascript">

					jQuery(function($) {
						
						form_type      = '<?php echo esc_html( $data->form_type ); ?>';
						num_makers     = <?php echo intval( $number_of_makers ); ?>;
						num_presenters = <?php echo intval( isset( $data->presenter_name ) && is_array( $data->presenter_name ) ? count( $data->presenter_name ) + 1 : 1 ); ?>;
						
						$('#maker input[type=radio]').click(function(){
							$('#maker_name, #maker_email, #maker_photo, #maker_bio, #m_maker_name, .m_maker_name, .add-maker, #group_name, #group_website, #group_photo, #group_bio, .remove-maker').hide();
							if ( $(this).val() == 'One maker' ) {
								$('#maker_name, #maker_email, #maker_photo, #maker_bio').show();
							} else if ( $(this).val() == 'A list of makers' ) {
								$('#m_maker_name, .m_maker_name, .add-maker, .remove-maker').show();
							} else {
								$('#group_name, #group_website, #group_photo, #group_bio').show();
							}
						} );
						
						mf_insert_add_maker_btn();
						
						if( form_type == 'exhibit' ) {							
							$( '#maker input[value="<?php echo esc_attr( isset( $data->maker ) ? $data->maker : 'One maker' ); ?>"]' ).click();
						}
						
						function mf_insert_add_maker_btn()
						{
							html = '<tr id="'+form_type+'-add-maker" class="mf-form-row add-maker add-maker-btn">'+
										'<td colspan="2">'+
											'<input type="button" value="+Add Maker" class="button button-primary button-large"> '+
											'<div style="float:right"><a href="edit.php?post_type=mf_form&page=isc_mm_list_makers" target="_blank">Lookup GIGYA ID</a></div>'+
										'</td>'+
									'</tr>';
							
							$(html).insertAfter( $('#m_maker_bio, #presenter_previous') );
							$('.add-maker-btn .button').unbind('click').click(mf_add_maker);
						}
						
						function mf_add_maker() {

							fields = {
								exhibit : {
									m_maker_name    : 'Add. Maker Name',
									m_maker_email   : 'Add. Maker Email', 
									m_maker_gigyaid : 'Add. Maker Gigyaid',
									m_maker_bio     : 'Add. Maker Bio',
									m_maker_twitter : 'Add. Maker Twitter',
									m_maker_photo   : 'Add. Maker Photo URL'
								},
								presenter : {
									presenter_name     : 'Add. Presenter Name',
									presenter_email    : 'Add. Presenter Email', 
									presenter_gigyaid  : 'Add. Presenter Gigyaid',
									presenter_bio      : 'Add. Presenter Bio',
									presenter_org      : 'Add. Presenter Organization',
									presenter_title    : 'Add. Presenter Title',
									presenter_photo    : 'Add. Presenter Photo URL',
									presenter_twitter  : 'Add. Presenter Twitter',
									presenter_previous : 'Add. Presenter Previous'
								}
							};
							
							html  = '';
							for(i in fields[form_type]) {
								if ( i === 'presenter_bio' || i === 'm_maker_bio' ) {
									html += console.log(i);
									html += '<tr class="mf-form-row add-maker"><td valign="top">'+fields[form_type][i]+':</td><td><textarea name="' + form_type + '[' + i + '][' + num_makers + ']" id="" cols="30" rows="10"></textarea></td></tr>';
								} else {
									html += '<tr class="mf-form-row add-maker"><td valign="top">'+fields[form_type][i]+':</td><td><input type="text" name="'+form_type+'['+i+']['+num_makers+']"></td></tr>';
								}
							}
							html += '<tr class="remove-maker">'+
										'<td colspan="2">'+
											'<input type="button" onclick="mf_remove_maker( this )" value="Remove Maker Above" class="button button-primary button-large"></td></tr>';
							
							$(html).insertAfter($('.add-maker-btn'));

							num_makers++;
						}
					} );
					
					function mf_remove_maker( el ) {
						p = jQuery( el ).parent().parent();	
						l = form_type == 'exhibit' ? 5 : 7;							
						for( i = 0; i < l; i++ ) {
							p.prev().remove();
						}
						p.remove();	
					}
						
				</script>
			<?php endif;

		}
	}


	/* 
	* Creates Backend MakerFaire Application Forms
	*
	* @access public
	* 
	* @param string $type     Form type
	* @param string $key      Key for this field
	* @param string $value    Value of this field
	* @param array  $all_data All the data from the form
	* =====================================================================*/
	public function display_edit_field( $type, $key, $value, $all_data ) {
		
		$checkboxes = array( 
			'booth_options' => array(
				'With other Makers under a large tent', 
				'Open air', 
				'I can bring a tent/canopy with weights', 
				'Asphalt', 
				'Grass',
			),
			'radio_frequency' => array(
				'Remote Control (enter frequency band below)',
				'Amateur radio or CB',
				'ZigBee on 900 MHz', 
				'ZigBee on 2.4 GHz', 
				'Telepathy', 
				'Bluetooth', 
				'WiFi Internet access', 
				'My own local WiFi cloud on 2.4 GHz', 
				'My own local WiFi cloud on 5 GHz', 
				'Something else on 900 MHz', 
				'Something else on 2.4 GHz', 
				'Something else on 5 GHz', 
				'Something with an antenna, but I have no idea what'),
			'length' => array(
				'10 minutes', 
				'20 minutes', 
				'45 minutes',
			),
			'length_presentation' => array(
				'12 minutes', 
				'20 minutes', 
				'45 minutes',
			),
		);
		$radios = array( 
			'food'              => array( 'Yes', 'No' ), 
			'sales'             => array( 'Yes', 'No' ), 
			'activity'          => array( 'Yes', 'No' ), 
			'power'             => array( 'Yes', 'No' ), 
			'radio'             => array( 'Yes', 'No' ), 
			'fire'              => array( 'Yes', 'No' ), 
			'hands_on'          => array( 'Yes', 'No' ), 
			'first_time'        => array( 'Yes', 'No' ), 
			'first_makerfaire'  => array( 'Yes', 'No' ), 
			'exhibit'           => array( 'Yes', 'No' ), 
			'tables_chairs'     => array(
				'None'     => 'No tables or chairs needed', 
				'Standard' => '1 table and 2 chairs', 
				'Special'  => 'More than 1 table and 2 chairs. Specify your request below',
			), 
			'booth_size' => array(
				'Mobile'   => 'My exhibit is mobile (no fixed exhibit space needed)',
				'Tabletop' => 'Tabletop',
				'10x10'    => '10\' x 10\'',
				'10x20'    => '10\' x 20\'',
				'Other'    => 'Other - Tell us your space size request below',
			),
			'booth_location' => array(
				'Inside', 
				'Outside', 
				'Either',
			), 
			'lighting' => array( 'Normal', 'Dark' ), 
			'noise' => array(
				'Normal - does not interfere with normal conversation', 
				'Amplified - adjustable level of amplification', 
				'Repetitive or potentially annoying sound', 'Loud!',
			), 
			'amps' => array(
				'5 amp circuit (0-500 watts, 110V)', 
				'10 amp circuit (501-1000 watts, 110V)', 
				'15 amp circuit (1001-1500 watts, 110V)', 
				'20 amp circuit (1501-2000 watts, 110V)', 
				'My exhibit requires power, but I need help determining my total power amperage', 
				'Special power requirements noted below',
			), 
			'internet'=> array(
				'No internet access needed', 
				'It would be nice to have WiFi internet access', 
				'My exhibit must have WiFi internet access to work',
			), 
			'maker' => array(
				'One maker', 
				'A list of makers',
				'A group or association',
			), 
			'org_type' => array(
				'Non-profit',
				'Cause or mission-based organization',
				'Established company or commercial entity',
				'None of the above',
			), 
			'performance_time' => array(
				'Saturday Only', 
				'Sunday Only', 
				'Either Saturday or Sunday; We\'re flexible but prefer to play only once.', 
				'Both Saturday and Sunday; We\'d love to play both days if there\'s space and time in the schedule.', 
				'All Weekend! We have our own separate setup and would like to play all weekend, if possible.',
			), 
			'compensation_type' => array(
				'Thanks for the opportunity to play! We are happy to play without financial compensation.', 
				'We will play for guest tickets only.', 
				'$ amount',
			), 
			'presentation_type' => array(
				'Presentation', 
				'Panel Presentation',
			), 
			'availability'      => array(
				'Either Saturday or Sunday', 
				'Saturday only', 
				'Sunday only',
			)			
		);
		
		$san_value = is_array( $value ) ? esc_attr( implode( ', ', $value ) ) : esc_attr( $value ); 
		
		if ( $this->is_textarea( $key ) ) : ?>
		
			<textarea name="<?php echo esc_attr( $type . '[' . $key . ']' ); ?>" /><?php echo htmlspecialchars_decode( esc_textarea( $this->convert_newlines( $value, "\n" ) ) ); ?></textarea>
			
		<?php elseif ( array_key_exists( $key, $checkboxes ) ) : ?>
		
			<?php foreach( $checkboxes[$key] as $dkey => $data ) : $dkey = ! is_int( $dkey ) ? $dkey : $data; ?>
				<div>
					<input name="<?php echo esc_attr( $type.'['.$key.']' ); ?>[]" type="checkbox" value="<?php echo esc_attr( $dkey ); ?>" <?php checked( in_array( $dkey, (array) $value ) ); ?> /> 
					<?php echo esc_html( $data ) ?>
				</div>
			<?php endforeach; ?>
			
		<?php elseif ( array_key_exists( $key, $radios ) ) : ?>
		
			<?php foreach( $radios[ $key ] as $dkey => $data ) : $dkey = ! is_int( $dkey ) ? $dkey : $data; ?>
				<div>
					<input name="<?php echo esc_attr( $type . '[' . $key . ']' ); ?>" type="radio" value="<?php echo esc_attr( $dkey ); ?>" <?php checked( $dkey == $value ); ?> /> 
					<?php echo esc_html( $data ); ?>
				</div>
			<?php endforeach; ?>
			
		<?php elseif ( $key == 'm_maker_name' || $key == 'presenter_name' ) : 
			
			$init_fields = array(
				'm_maker_name'   => array(
					'm_maker_email', 
					'm_maker_gigyaid', 
					'm_maker_photo',
					'm_maker_twitter', 
					'm_maker_bio',
				),
				'presenter_name' => array(
					'presenter_gigyaid',
					'presenter_bio',
					'presenter_photo',
					'presenter_email',					 
					'presenter_onsite_phone',
					'presenter_org',
					'presenter_title',
				)
			); ?>
		
			<input name="<?php echo esc_attr( $type . '[' . $key . '][0]' ); ?>" value="<?php echo esc_attr( isset( $all_data[ $key ][0] ) ? $all_data[ $key ][0] : '' ); ?>" type="text" />
			</td></tr>
			<?php foreach( $init_fields[ $key ] as $fn ) : 
				$data = is_array( $all_data[ $fn ] ) && isset( $all_data[ $fn ][0] ) ? $all_data[ $fn ][0] : ''; 
				$data = is_string( $all_data[ $fn ][0] ) ? $all_data[ $fn ][0] : '';

				if ( ( $fn == 'm_maker_gigyaid' || $fn == 'presenter_gigyaid' ) && $data == '' && isset( $all_data['uid'] ) )
					$data = $all_data['uid']; ?>

				<tr class="mf-form-row <?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $fn ); ?>">
					<td valign="top"><?php echo esc_html( ucwords( str_replace( '_', ' ', $fn ) ) ); ?>:</td>

					<?php if ( $fn == 'm_maker_bio' || $fn == 'presenter_bio' ) :?>
						<td><textarea name="<?php echo esc_attr( $type . '[' . $fn . '][0]' ); ?>" id="<?php echo esc_attr( $type . '[' . $fn . '][0]' ); ?>" cols="30" rows="10"><?php echo ( ! empty( $data ) ) ? esc_attr( $data ) : ''; ?></textarea></td>
					<?php else : ?>
						<td><input style="width:100%;" name="<?php echo esc_attr( $type . '[' . $fn . '][0]' ); ?>" value="<?php echo esc_attr( $data ); ?>" type="text" /></td>
					<?php endif; ?>
				</tr>
			<?php endforeach;
			

			// If the data passed is an 'additional' maker
			if ( is_array( $all_data[ $key ] ) ) :
			
				$add_fields = array(
					'm_maker_name'   => array(
						'm_maker_name'    => 'Add. Maker Name',
						'm_maker_email'   => 'Add. Maker Email', 
						'm_maker_gigyaid' => 'Add. Maker Gigyaid',
						'm_maker_bio'	  => 'Add. Maker Bio',
						'm_maker_twitter' => 'Add. Maker Twitter Handle',
						'm_maker_photo'   => 'Add. Maker Photo URL',
					),
					'presenter_name' => array(
						'presenter_name'     => 'Add. Presenter Name',
						'presenter_email'    => 'Add. Presenter Email', 
						'presenter_gigyaid'  => 'Add. Presenter Gigyaid',
						'presenter_bio'		 => 'Add. Presenter Bio',
						'presenter_org'		 => 'Add. Presenter Organization',
						'presenter_title'	 => 'Add. Presenter Title',
						'presenter_photo'	 => 'Add. Presenter Photo',
						'presenter_bio'		 => 'Add. Presenter Bio',
						'presenter_twitter'  => 'Add. Presenter Twitter',
						'presenter_previous' => 'Add. Presenter Previous',
					)
				);

				for ( $i = 1; $i < count( $all_data[ $key ] ); $i++ ) : 
					foreach( $add_fields[ $key ] as $fkey => $ftitle ) : ?>
						<tr class="mf-form-row add-maker">
							<td valign="top"><?php echo esc_html( $ftitle ); ?>:</td>

							<?php if ( $fkey == 'm_maker_bio' || $fkey == 'presenter_bio' ) : ?>
								<td>
									<textarea name="<?php echo esc_attr( $type . '[' . $fkey . '][' . $i . ']' ); ?>" id="<?php echo esc_attr( $type . '[' . $fkey . '][' . $i . ']' ); ?>" cols="30" rows="10"><?php echo esc_attr( isset( $all_data[ $fkey ][ $i ] ) ? $all_data[ $fkey ][ $i ] : '' ); ?></textarea>
								</td>
							<?php else : ?>
								<td>
									<input name="<?php echo esc_attr( $type . '[' . $fkey . '][' . $i . ']' ); ?>" value="<?php echo esc_attr( isset( $all_data[ $fkey ][ $i ] ) ? $all_data[ $fkey ][ $i ] : '' ); ?>" type="text" />
								</td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
					<tr class="remove-maker">
						<td colspan="2">
							<input onclick="mf_remove_maker(this)" type="button" value="Remove Maker Above" class="button button-primary button-large">
						</td>
					</tr>
				<?php endfor;
			endif; ?>
			
		<?php else : ?>
			<input name="<?php echo esc_attr( $type . '[' . $key . ']' ); ?>" value="<?php echo $san_value; ?>" type="text" />
		<?php endif;
	}


	/* 
	* Updates mf_form object content and post meta data
	*
	* @access public
	* @param integer $id Post id
	* =====================================================================*/
	public function update_post( $id ) {

		if ( empty( $_POST ) || ( ! isset( $_POST['mf_form'], $_POST['form_type'] ) && isset( $this->fields[ $_POST['form_type'] ] ) ) || isset( $_POST['mf_updated'] ) )
			return false;

		// Bail if post is auto-draft/revision/nav-menu item
		if ( get_post_type( $id ) != 'mf_form' )
			return false;

		// Set some variables yo.
		$form_type  = sanitize_text_field( $_POST['form_type'] );
		$is_trashed = $_POST['trash-post'];
		$r = array(
			'form_type'   => $form_type,
			'maker_faire' => sanitize_text_field( $_POST[ $form_type ]['maker_faire'] ),
			'uid'         => sanitize_text_field( $_POST[ $form_type ]['uid'] ),
			'tags'        => sanitize_text_field( $_POST[ $form_type ]['tags'] ),
			'cats'        => sanitize_text_field( $_POST[ $form_type ]['cats'] ),
		);


		// For starters, lets get all of our data into one bucket and clean things up.
		foreach ( $this->fields[ $form_type ] as $sn => $s ) {

			// Loop through each array in the $s variable
			foreach ( array_keys( $s ) as $k ) {

				// Check if our data being submitted is in an array first, sanitize and add to the $r array.
				// Then check if we are passing in a textarea or text field and sanitize those fields accordingly.
				if ( is_array( $_POST[ $form_type ][ $k ] ) ) {
					
					// Add new keys that are not there by default to the $r array (e.g. m_maker_name, m_maker_email, etc etc)
					$r[ $k ] = array();
					
					// Loop through each key passed and their value to the $r array
					foreach ( $_POST[ $form_type ][ $k ] as $v ) {
						$r[ $k ][] = sanitize_text_field( $v );	
					}
				} elseif( $this->is_textarea( $k ) ) {
					// Sanitize our textareas for allowed HTML tags and then insert HTML line breaks before newlines.
			 		$r[ $k ] = wp_kses_post( nl2br( $_POST[ $form_type ][ $k ] ) );
				} else {
					// Sanitize the string in our text fields
			 		$r[ $k ] = sanitize_text_field( $_POST[ $form_type ][ $k ] );
			 	}
			}

			// Create a fallback for the public description field and repurpose it to the short_description field.
			// This is in place because in the presenter we removed this field, this will ensure older applications will be updated.
			if ( isset( $_POST['presenter']['public_description'] ) ) {
				$r[ 'short_description' ] = sanitize_text_field( $_POST['presenter']['public_description'] );
			}

			// Save our coverage video link if its set and save it into the Event Post Type post
			if ( ! empty( $_POST['video-coverage'] ) && ! empty( $_POST['event-id'] ) ) {
				$video_url = ( ! empty( $_POST['video-coverage'] ) ) ? esc_url( $_POST['video-coverage'] ) : '';

				update_post_meta( intval( $_POST['event-id'] ), 'mfei_coverage', esc_url( $_POST['video-coverage'] ) );
			}
		}

		

		// Check if the $r array contains less than 3 fields. If so, we want to return false and stop the processing of the code below.
		if ( count( $r ) < 3 )
			return false;

		$this->update_mf_form( $r['form_type'], $id, $r, 0 );
		
		//MAKE SURE ALL GIGA IDS ARE ASSOCIATED WITH THIS FORM
		$connected_users = get_post_meta( $id, 'mf_gigya_id' );
		$new_gigya_ids   = array( $r['uid'] );
			
		if ( ( $form_type == 'exhibit' && $_POST['exhibit']['maker'] == 'A list of makers' ) || $form_type == 'presenter' ) 
			$new_gigya_ids = array_merge( $new_gigya_ids, $_POST[$form_type][ ( $form_type == 'presenter' ? 'presenter_gigyaid' : 'm_maker_gigyaid' ) ]);
		
		//ADD GIGYA IDS
		$add_ids = array_diff( $new_gigya_ids, $connected_users );
			
		foreach ( $add_ids as $gigya_id ) {
			add_post_meta( $id, 'mf_gigya_id',  $gigya_id );	
		}
		
		//REMOVE GIGYA IDS
		$remove_ids = array_diff(  $connected_users, $new_gigya_ids );
			
		foreach( $remove_ids as $gigya_id ) {
			delete_post_meta( $id, 'mf_gigya_id',  $gigya_id );	
		}
		
		//SYNC WITH JDB
		$this->sync_jdb( $id );

		if ( isset( $_POST['original_post_status'], $_POST['post_status'], $_POST['action'], $_POST['post_type'] ) )
			$this->handle_post_status_change();
	}

	/* 
	* Controller to deal with post status change
	*
	* @access public
	* =====================================================================*/
	public function handle_post_status_change() {

		// return if _POST fields not set
		if ( ! isset( $_POST['original_post_status'], $_POST['post_status'], $_POST['action'], $_POST['form_type'], $_POST['ID'] ) )
			return;

		// return if action is not editpost
		if ( $_POST['action'] != 'editpost' )
			return; 

		// return if post_type is not mf_form
		if ( $_POST['post_type'] != 'mf_form' )
			return; 

		// get post id
		$post_id = absint( $_POST['ID'] );

		// grab post as ref to get the content
		$post =& get_post( $post_id );
		$wf   =  get_post_meta( $post_id, '_mf_waiting_for', true );

		//SANITIZE POST STATUS | post status ( proposed, waiting-for-info, accepted, rejected, cancelled )
		$post_status = sanitize_key( $_POST['post_status'] );
		if( !in_array( $post_status, array( 'waiting-for-info', 'accepted', 'rejected', 'cancelled' ) ) )
			return;

		// decode the content into data
		if ( isset( $post->post_content ) )
			$data = json_decode( str_replace( "\'", "'", $post->post_content ) );

		// SANITIZE FORM TYPE
		$form_type = sanitize_key( $_POST['form_type'] );
		if( !in_array( $form_type, array( 'exhibit', 'performer', 'presenter' ) ) )
			return;
		
		$form_type_pretty = ucfirst( $form_type );

		$form = $_POST[ $form_type ];

		if ( $_POST['original_post_status'] != $post_status )
			$this->sync_status_jdb( $post_id, $post_status );

		// if new status write the log
		if ( $_POST['original_post_status'] != $post_status || ( $post_status == 'waiting-for-info' && isset( $_POST['mf_waitingquestion'] ) && $wf != $_POST['mf_waitingquestion'] ) ) {
			
			$current_user = wp_get_current_user();
			$user_name    = $current_user->user_login;

			$date = date('m/d/y h:i a', time() - ( 3600 * 7 ) );

			$extra = '';
			if ( $post_status == 'waiting-for-info' ) {
				$extra = esc_textarea( $_POST['mf_waitingquestion'] );
				update_post_meta( $post_id, '_mf_waiting_for', $extra );	
			}

			$post_status_pretty = '';
			if ( $post_status == 'accepted' ) {
				$post_status_pretty = ' Accepted';
			} elseif ( $post_status == 'waiting-for-info' ) {
				$post_status_pretty = ' Request for more info: '.$extra;
			} elseif ( $post_status == 'cancelled' ) {
				$post_status_pretty = ' Cancelled';
			} elseif ( $post_status == 'rejected' ) {
				$post_status_pretty = ' Rejected';
			} elseif ( $post_status == 'in-progress' ) {
				$post_status_pretty = ' In-Progress';
			}


			$post_status_log = get_post_meta( $post_id, '_mf_log', true );

			if ( ! is_array( $post_status_log ) || $post_status_log == false || sizeof( $post_status_log ) == 0 ) {
				$post_status_log = array();
				$post_status_log[] = mysql2date('m/d/y h:i a', $post->post_date) .' Proposed';
			}

			$post_status_log[] = "{$date}{$post_status_pretty} by {$user_name}";
			
			//LIMIT STATUS LOG TO 15 ENTRIES
			$post_status_log   = array_slice($post_status_log, -15);
			
			update_post_meta( $post_id, '_mf_log', $post_status_log);
		} else {
			return;	
		}

		//DON'T SEND EMAIL IF DISABLE AUTORESPONDER IS CHECKED.
		if( isset( $_POST['_ef_editorial_meta_checkbox_email-notifications'] ) )
			return;

		// Get Project Name
		$project_name = htmlspecialchars_decode( sanitize_text_field( $form[$this->merge_fields( 'project_name', $form_type )] ) );


		// set maker name
		$maker_name = $contact_first_name = 'Maker';
		if ( isset( $form['name'] ) ) {
			$maker_name = $form['name'];

			// get contact_first_name but only if a space exists in the maker_name
			if ( strpos( $maker_name, ' ' ) !== false )
				$contact_first_name = substr( $maker_name, 0, strpos( $maker_name, ' ' ) );
		}

		// set maker_email
		$maker_email = '';
		if ( isset( $form['email'] ) && ! empty( $form['email'] )  && is_string( $form['email'] ) && is_email( $form['email'] ) )
			$maker_email = strtolower( $form['email'] );



		// the email recipients (main recipient)
		$tos = array();
		foreach ( array( 'maker_email', 'email', 'presenter_email' ) as $k ) {
			// if any of these are set add to tos array
			if ( isset( $form[ $k ] ) && ! empty( $form[ $k ] ) && is_string( $form[ $k ] ) )
				$tos[] = $form[ $k ];
		}

		// grab additional emails to tos array
		$maker_emails = array();

		if ( isset( $form['presenter_email'] ) && ! empty( $form['presenter_email'] ) && is_array( $form['presenter_email'] ) )
			$maker_emails = $form['presenter_email'];

		if ( $form_type != 'presenter' ) {
			if ( isset( $form['m_maker_email'] ) && ! empty( $form['m_maker_email'] ) && is_array( $form['m_maker_email'] ) )
				$maker_emails = $form['m_maker_email'];
		}

		// add to tos array
		foreach ( $maker_emails as $k => $v ) {
			$tos[] = $v;
		}
	


		// strtolower and unique the emails
		$tos = array_map( 'strtolower', $tos );
		$tos = array_unique( $tos );
		$toss = array();

		// make sure only valid emails in list and not the maker_email
		foreach ( $tos as $email ) {
			if ( is_email( $email ) && ( $email != $maker_email ) )
				$toss[] = $email;
		}

		$tos = array_merge( array( $maker_email ), $toss );
		
		
		if( isset( $_SERVER['SERVER_ADDR_NAME'] ) && $_SERVER['SERVER_ADDR_NAME'] == 'iscrackweb1' ) {
			$tos = array( 'matt@insourcecode.com' );	
		}

		// if contacts first name length is less than 2 chars or if tos array contains any emails set the name to User
		if ( strlen( trim( $contact_first_name ) ) <= 2 || sizeof( $tos ) > 1 )
			$contact_first_name = 'Maker';

		// default bcc
		$bcc = 'makers@makerfaire.com';

		// default from
		$from = 'Maker Faire <makers@makerfaire.com>';
		if ( $form_type == 'presenter' )
			$from = 'Sabrina Merlo, Maker Faire <sabrina@makerfaire.com>';

		// default msg to append to subject
		$subject_text = '';

		// get the subject_text based on post_status
		switch ( $post_status ) {
			case 'waiting-for-info':
				$subject_text = '– Need More Info';
				break;
			case 'accepted':
				$subject_text = '- Acceptance for Maker Faire';
				break;
			case 'rejected':
				$subject_text = '- Application for Maker Faire';
				break;
			case 'cancelled':
				$subject_text = '- Cancellation of Application for Maker Faire';
				break;
			case 'proposed':
				$subject_text = '';
				break;
		}

		// set the subject
		$subject = "[{$form_type_pretty}] #{$post_id} - {$project_name} {$subject_text}";



		// set the email template by formtype and poststatus, default to default.html
		$email_path = __DIR__ . '/emails/' .sanitize_file_name( $post_status . '-' . $form_type . '.html' );

		// if post_status is one of these, use post_status.html as the email template
		if ( in_array( $post_status, array( 'cancelled', 'rejected', 'waiting-for-info' ) ) )
			$email_path = __DIR__ . '/emails/' .sanitize_file_name( $post_status . '.html' );
		
		//Prevent Path Traversal
		if (strpos($email_path, '../') !== false || strpos($email_path, "..\\") !== false || strpos($email_path, '/..') !== false || strpos($email_path, '\..') !== false)
			return;
			
		// if the email template doesnt exist, use the default
		if ( ! file_exists( $email_path ) )
			return;


		// get the contents of the email_template as the body
		$body = file_get_contents( $email_path );


		// extras for inserting into the message dynamically
		$extras = '';

		// if editor is waiting on something.. add to the email
		if ( $post_status == 'waiting-for-info' && isset( $_POST['mf_waitingquestion'] ) && $_POST['mf_waitingquestion'] != 'Waiting on?' )
			$extras .= esc_textarea( force_balance_tags( stripslashes( $_POST['mf_waitingquestion'] ) ) );


		if ( $form_type == 'exhibit' ) {
			if ( isset( $form['sales'] ) && strtolower( $form['sales'] ) == 'yes' ) {
				$extras .= '<p>In your application, you indicated that you are selling or marketing a product. ';
				$extras .= 'Pay your Commercial Maker Fee <a href="https://www.makerfairetickets.com/ProductDetails.asp?ProductCode=MFCMAKER">here</a>.';
				$extras .= ' Deadline September 6th. If you are not marketing or selling a product, let us know at <a href="mailto:makers@makerfaire.com">makers@makerfaire.com</a>.</p>';
			}

			// if ( isset( $form['food'] ) && strtolower( $form['food'] ) == 'yes' ) {
			//	$extras .= '<p>You indicated that food would be included in your exhibit. Fill out the <a href="http://makerfaire.files.wordpress.com/2013/02/mfba13-health-food-permit-form.pdf">';
			//	$extras .= 'Health Permit Form</a> and pay the Health Permit Fee <a href="https://www.makerfairetickets.com/ProductDetails.asp?ProductCode=MFHPF">here</a>.';
			//	$extras .= ' Deadline April 5th. If you decided not to include food in your exhibit, email <a href="mailto:makers@makerfaire.com">makers@makerfaire.com</a>.</p>';
			//}
		}



		// search and replace (s-a-r) for alternative to eval
		$sar = array(
			'$subject' => $subject,
			'$form_type' => $form_type,
			'$post_id' => $post_id,
			'$project_name' => $project_name,
			'$contact_first_name' => $contact_first_name,
			'$extras' => $extras,
		);

		$message = force_balance_tags( wpautop( str_replace( array_keys( $sar ), array_values( $sar ), $body ) ) );

		$r = wp_mail( $tos, $subject, $message, array( 'Content-Type: text/html', "From: {$from}", "Bcc: {$bcc}" ) );
	}
	/* 
	* MakerFaire Shortcode handler "mf_form"
	*
	* @access public
	* @param array $atts An array of atributes included in the shortcode
	* @return string The replacement text
	* =====================================================================*/
	public function shortcode_handler( $atts ) {
		foreach ( $atts as $k => $v ) {
			if ( isset( $this->fields[$v] ) ) //Check and Allow only White Labeled Attributes and Values
				$this->{$k} = $v;
		}

		//Only allow forms that exist in folder
		if ( ! file_exists( plugin_dir_path( __FILE__ ) . 'forms/' . $this->type.'.php' ) )
			return '';

		ob_start();

		if ( $this->type == 'makerprofile' ) {
			//$forms = $this->getforms();
			include( plugin_dir_path( __FILE__ ) . 'forms/makerprofile.php' );
		} else {
			//GET FORM BY ID
			if ( isset( $_GET['id'] ) ) {
				$p = get_post( $_GET['id'] );

				if ( $p->post_type = 'mf_form' ) {
					$uid = get_post_meta( $p->ID, 'mf_gigya_id', true );

					$frm = json_decode( str_replace("\'", "'", $p->post_content ) );
					if ( $frm->form_type != $this->type || $frm->maker_faire != $this->maker_faire || $uid == '' )
						unset( $frm );
				}
			}

			//SET DEFAULT VALUES
			foreach ( $this->fields[$this->type] as $sn => $s ) {
				foreach ( array_keys( $s ) as $k ) {
					$v = isset( $frm ) && isset( $frm->$k ) ? $frm->$k : '';

					if ( gettype( $v ) == 'object' ) {
						$v = (array) $v;
					} elseif ( gettype( $v ) == 'array' ) {
						$v = (array) $v;
					}

					if ( $v == '' && $k == 'private_country' ) {
						$v = 'US';
					} elseif ( $v == '' && in_array( $k, array( 'presenter_bio', 'presenter_org', 'presenter_title', 'm_maker_bio' ) ) ) {
						$v = array( '' );
					}

					$this->form['data['.$sn.']['.$k.']'] = $v;
				}
			}

			//SET SOME GENERIC VALUES
			if ( isset( $frm ) ) {
				$this->form['id']          = $p->ID;
				$this->form['uid']         = $uid;
				$this->form['maker_faire'] = $frm->maker_faire;

				foreach ( $frm->tags as $t ) {
					$this->form['tags'][] = $t;
				}

				foreach ( $frm->cats as $c ) {
					$this->form['cats'][] = $c;
				}
			}

			//Show Requested Form
			include( plugin_dir_path( __FILE__ ) . 'forms/' . $this->type.'.php' );
		}

		$c = ob_get_clean();

		return $c;
	}
	/* 
	* Get's all forms and echos back for AJAX Listener
	*
	* @access public
	* =====================================================================*/
	public function ajax_getforms() {
		$args = array(
			'post_type'  => 'mf_form',
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => 'mf_gigya_id',
					'value' => sanitize_text_field( $_POST['uid'] )
				),
				array(
					'key' => 'mf_additional_user',
					'value' => sanitize_text_field( $_POST['e'] )
				)
			)
		);

		$q = new WP_Query( $args );
		$f = array( 
			'exhibit'   => array(),
			'presenter' => array(),
			'performer' => array()
		);

		foreach ( $q->posts as $p ) {
			$d = json_decode( str_replace( "\'", "'", $p->post_content ) );
			$p->data = $d;
			$f[$d->form_type][$p->ID] = $p;
		}

		die( json_encode( array( 'status'=>'OK', 'forms' => $f ) ) );
	}
	/* 
	* Handles frontend form submission
	*
	* @access public
	* =====================================================================*/
	public function ajax_handler() {
		if ( ! isset( $_POST['mf_submit_nonce'] ) || ! wp_verify_nonce( $_POST['mf_submit_nonce'], 'mf_nonce' ) )
			die( json_encode( array( 'status' => 'ERROR', 'errors' => array( 'BAD USER' ) ) ) );

		//POTENTIAL FILES TO BE UPLOADED
		$files  = array(
			'exhibit' => array(
				's1' => array( 'project_photo', 'layout' ),
				's2' => array( 'maker_photo', 'm_maker_photo', 'group_photo' ),
				's3' => array( 'supporting_documents' )
			),
			'performer' => array(
				's1' => array( 'performer_photo' )
			),
			'presenter' => array(
				's1' => array( 'presentation_photo' ),
				's2' => array( 'presenter_photo' )
			)
		);

		//ALL FIELDS FOR ALL 3 FORMS - BINARY IF FIELD IS REQUIRED OR NOT
		$errors = array();
		$res    = array(
			'form_type'   => sanitize_text_field( $_POST['form'] ),
			'maker_faire' => sanitize_text_field( $_POST['maker_faire'] ),
			'uid'         => sanitize_text_field( $_POST['uid'] ),
			'tags'        => array(),
			'cats'        => array()
		);

		//BLOCK ATTEMPTS TO SUBMIT FORMS OF AN UNKNOWN TYPE
		if ( ! in_array( $res['form_type'], array( 'exhibit', 'performer', 'presenter' ) ) )
			die( json_encode( array( 'status' => 'ERROR', 'errors' => array( 'BAD FORM TYPE' ) ) ) );

		/****************************************/
		/*  ERROR CHECK FORM SPECIFIC SITUATIONS
		/****************************************/

		//EXHIBIT STEP 1
		if ( $_POST['form'] == 'exhibit' && $_POST['step'] == 1 ) {
			if ( isset( $_POST['data']['s1']['booth_size'] ) && $_POST['data']['s1']['booth_size'] == 'Other' )
				$this->fields['exhibit']['s1']['booth_size_details'] = 1;

			if ( isset( $_POST['data']['s1']['power'] ) && $_POST['data']['s1']['power'] == 'Yes' && isset( $_POST['data']['s1']['amps'] ) && $_POST['data']['s1']['amps'] == 'special' )
				$this->fields['exhibit']['s1']['amps_details'] = 1;

			if ( isset( $_POST['data']['s1']['hands_on'] ) && $_POST['data']['s1']['hands_on'] == 'Yes' )
				$this->fields['exhibit']['s1']['safety_details'] = 1;

		//EXHIBIT STEP 2
		} elseif ( $_POST['form'] == 'exhibit' && $_POST['step'] == 2 ) {
		
			if ( isset( $_POST['data']['s2']['maker'] ) && $_POST['data']['s2']['maker'] == 'One maker' )
				$this->fields['exhibit']['s2']['maker_name'] = $this->fields['exhibit']['s2']['maker_email'] = $this->fields['exhibit']['s2']['maker_photo'] = $this->fields['exhibit']['s2']['maker_bio'] = 1;

			if ( isset( $_POST['data']['s2']['maker'] ) && $_POST['data']['s2']['maker'] == 'A list of makers' )
				$this->fields['exhibit']['s2']['m_maker_name'] = $this->fields['exhibit']['s2']['m_maker_email'] = $this->fields['exhibit']['s2']['m_maker_photo'] = $this->fields['exhibit']['s2']['m_maker_bio'] = 1;

			if ( isset( $_POST['data']['s2']['maker'] ) && $_POST['data']['s2']['maker'] == 'A group or association' )
				$this->fields['exhibit']['s2']['group_name'] = $this->fields['exhibit']['s2']['group_photo'] = $this->fields['exhibit']['s2']['group_bio'] = 1;

		//PERFORMER STEP 1
		} elseif ( $_POST['form'] == 'performer' && $_POST['step'] == 1 ) {

			if ( isset( $_POST['data']['s1']['compensation_type'] ) && strpos( $_POST['data']['s1']['compensation_type'], '$' ) !== false )
				$this->fields['performer']['s1']['compensation'] = 1;
		}

		/****************************************/
		/*  ERROR CHECK GENERIC
		/****************************************/
		if ( isset( $_POST['form'], $_POST['step'], $files[$_POST['form']]['s'.$_POST['step']] ) ):
			foreach ( $files[$_POST['form']]['s'.$_POST['step']] as $n ) {
				if ( $this->fields[$_POST['form']]['s'.$_POST['step']][$n] && ! isset( $_FILES[$n] ) && ! isset( $_POST['data']['s'.$_POST['step']][$n] ) )
					$errors['s'.$_POST['step']][$n] = 'Photo Required.';
			}
		endif;


		foreach ( $this->fields[$_POST['form']] as $s => $f ) {

			foreach ( $f as $k => $r ) {
				$v = isset( $_POST['data'][$s][$k] ) ? $_POST['data'][$s][$k] : '';

				// if ( $s == 's2' && ! empty( $files[$_POST['form']][$s] ) )
				// 	echo '<pre>' . $s . ': '; print_r( $files[$_POST['form']][$s] ); echo '</pre>';

				if ( is_array( $v ) )
					$v = array_values( $v );

				//CHECK ERRORS ON THIS STEP ONLY
				if ( $s == 's'.$_POST['step'] ) {
					//FILE UPLOAD ERROR CHECK
					if ( is_array( $v ) ) {
						foreach ( $v as $i => $av ) {
							if ( $r && ! in_array( $k, $files[$_POST['form']][$s] ) && $av == '' ) { //Empty / Not Set / Blank
								$errors[$s][$k][$i] = 'Required.';
							} elseif ( $r && strpos( $k, 'email' ) !== false && ! is_email( $av ) )  { //Check Email
								$errors[$s][$k][$i] = 'Valid Email Required.';
							}
						}
					} elseif ( is_array( $files[$_POST['form']][$s] ) ) { // Check that our data is an array first before sending it or else the form breakes.
						if ( $r && ! in_array( $k, $files[$_POST['form']][$s] ) && $v == '' )  //Empty / Not Set / Blank
							$errors[$s][$k] = 'Required.';
					} elseif ( ( $k == 'public_description' && strlen( $v ) > 255 ) || ( ( $k == 'maker_bio' || $k == 'm_maker_bio' || $k == 'group_bio' ) && strlen( $v ) > 500 ) ) { //Input too many characters.
						$errors[$s][$k] = 'Too Long.';
					} elseif ( $r && $k == 'email' && ! is_email( $v ) ) { //Check Email
						$errors[$s][$k] = 'Valid Email Required.';
					} elseif ( $r && $k == 'compensation' && ! is_numeric( $v ) ) { //Check Value
						$errors[$s][$k] = 'Number Required.';
					}
				}

				//SPECIAL DATA FORMATS
				if ( $k == 'equipment' ) //Make Sure NewLines are Preserved on Equipment List
					$v = nl2br( $v );

				//SANATIZE ALL DATA
				if ( is_array( $v ) ) {
					foreach ( $v as $nn => $d ) {
						$v[$nn] = wp_filter_post_kses( $d );
					}
					$res[$k] = $v;
				} else {
					$res[$k] = wp_filter_post_kses( $v );
				}
			}
		}

		if ( isset( $_POST['radio_frequency'] ) ) {
			foreach ( $_POST['radio_frequency'] as $rf ) {
				$res['radio_radio_frequency'][] = $rf;
			}
		}

		if ( isset( $_POST['tag'] ) ) {
			foreach ( $_POST['tag'] as $t ) {
				$res['tags'][] = $t;
			}
		}

		if ( isset( $_POST['cat'] ) ) {
			foreach ( $_POST['cat'] as $c ) {
				$res['cats'][] = $c;
			}
		}

		//IF THERE ARE ERRORS DIE WITH ERRORS
		if ( ! empty( $errors ) )
			die( json_encode( array( 'status' => 'ERROR', 'errors' => $errors ) ) );

		$file_res = $thumbs_res = array();

		//ERROR CHECK AND UPLOAD FILES
		if ( isset( $_POST['form'], $_POST['step'], $files[$_POST['form']]['s'.$_POST['step']] ) ):
			foreach ( $files[$_POST['form']]['s'.$_POST['step']] as $n ) {
				if ( empty( $errors ) && ((isset( $_POST[$n] ) && $_POST[$n] != '' ) || isset( $_FILES[$n] ) ) ) {
					if ( isset( $_FILES[$n] ) && $_FILES[$n]['name'] != '' ) {
						if ( $r = $this->upload( $_FILES[$n], ! in_array( $n, array( 'layout', 'supporting_documents' ) ) ) ) {
							$file_res[$n]     = $r['url'];
							$thumbs_res[$n]   = $r['thumb'];
							$res[$n]          = $r['url'];
							$res[$n.'_thumb'] = $r['thumb'];
						// TODO: Fix error reporting for non-supported files. - CG
						// } elseif ( $_FILES[$n]['type'] != 'image/jpeg' || $_FILES[$n]['type'] != 'image/gif' || $_FILES[$n]['type'] != 'image/png') {
						// 	$error['s' . $_POST['step']][$n] = 'Not an accepted file type.';
						} else {
							$errors['s'.$_POST['step']][$n] = 'Valid 500px or Wider Image Required.';
						}
					}
				} elseif ( empty( $errors ) && $res[$n] == '' && $this->fields[$_POST['form']]['s'.$_POST['step']][$n] ) {
					$errors['s'.$_POST['step']][$n] = 'Photo Required.';
				}
			}
		endif; // isset( $_POST['form'], $_POST['step'], $files[$_POST['form']]['s'.$_POST['step']]

		//IF THERE ARE ERRORS DIE WITH ERRORS
		if ( ! empty( $errors ) )
			die( json_encode( array( 'status'=>'ERROR', 'errors' => $errors ) ) );

		//IF THERE ARE NO ERRORS SAVE AND DIE WITH ID
		if ( isset( $_POST['id'] ) && $_POST['id'] ) {
			$id = $this->update_mf_form( $_POST['form'], $_POST['id'], $res, $_POST['step'] );
		} else {
			$id = $this->create_mf_form( $res, $_POST['form'] );
		}

		die( json_encode( array( 'status'=>'OK', 'id' => $id, 'files' => $file_res, 'thumbs' => $thumbs_res ) ) );
	}

	/* 
	* Upload images / documents and save as WP attachments
	*
	* @access public
	* @param  array   $ufile         File object $t Form type
	* @param  boolean $require_size  Check if deminsions are valid
	* 
	* @return boolean|array False if error and upload array if valid
	* =====================================================================*/
	private function upload( $ufile, $require_size ) {
		if ( ! function_exists( 'wp_handle_upload' ) )
			require_once( ABSPATH . 'wp-admin/includes/file.php' );

		// Check our uploaded file types.
		$info = pathinfo( $ufile['name'] );
		if ( ! in_array( strtolower( $info["extension"] ), array( 'jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'ppt', 'pptx', 'pps', 'ppsx', 'odt', 'xls', 'xlsx' ) ) )
			return false;

		if ( $require_size ) {
			list( $w, $h ) = getimagesize( $ufile['tmp_name'] );
		}

		$overrides = array( 'test_form' => false );
		$file      = wp_handle_upload( $ufile, $overrides );

		if ( ! $file )
			return false;

		$wp_upload_dir = wp_upload_dir();

		$attachment = array(
			'guid'           => $file['url'],
			'post_mime_type' => $file['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $ufile['name'] ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		//CREATE THUMBNAIL
		$thumb = image_make_intermediate_size( $file['file'], 500, 500 );

		$attach_id = wp_insert_attachment( $attachment, $file['file'] );


		if ( ! function_exists( 'wp_crop_image' ) )
			require_once( ABSPATH . 'wp-admin/includes/image.php' );

		$attach_data = wp_generate_attachment_metadata( $attach_id, $ufile['name'] );

		wp_update_attachment_metadata( $attach_id, $attach_data );

		return array( 'id' => $attach_id, 'url' => $file['url'], 'thumb'=>( $thumb ? $wp_upload_dir['url'].'/'.$thumb['file'] : $file['url'] ) );
	}

	/* 
	* Create a MakerFAIRE Form
	*
	* @access public
	* @param array  $r Form data
	* @param string $t Form type
	* 
	* @return integer Form that's created's ID
	* =====================================================================*/
	private function create_mf_form( $r, $t ) {
		
		//Make Sure this is the first and only time through
		if ( isset( $_POST['mf_updated'] ) )
			return false;
		
		$n = $t == 'exhibit' ? $r['project_name'] : ( $t == 'performer' ? $r['performer_name'] : $r['presentation_name'] );

		$d = array(
			'post_author'  => 0,
			'post_content' => json_encode( $r ),
			'post_title'   => $n,
			'post_status'  => 'in-progress',
			'post_type'    => 'mf_form'
		);

		// if uid is 0, empty, or not set then just return and do not insert the post or update the post_meta
		if ( ! isset( $r['uid'] ) || $r['uid'] == '0' || $r['uid'] == '' )
			return;
			
		$_POST['mf_updated'] = 1;

		$pid = wp_insert_post( $d );

		add_post_meta( $pid, '_mf_form_type', $t );
		add_post_meta( $pid, 'mf_gigya_id',  $r['uid'] );
		wp_set_object_terms( $pid, $t, 'type' );
		wp_set_object_terms( $pid, 'World Maker Faire New York 2013', 'faire' );

		return $pid;
	}

	/* 
	* Update a MakerFAIRE Form
	*
	* @access public
	* @param string  $t  Form type
	* @param integer $id Form ID
	* @param array   $r  Form data
	* @param integer $s  From Step
	* 
	* @return integer Form that's updated ID
	* =====================================================================*/
	private function update_mf_form( $t, $id, $r, $s ) {
		
		//Make Sure this is the first and only time through
		if ( isset( $_POST['mf_updated'] ) )
			return false;
		
		$n = $t == 'exhibit' ? $r['project_name'] : ( $t == 'performer' ? $r['performer_name'] : $r['presentation_name'] );

		$d = array(
			'ID'           => $id,
			'post_content' => json_encode( $r ),
			'post_title'   => $n,
		);

		//SUBMIT FINAL FORM
		if ( $s == 4 ) {
			$d['post_status'] = 'proposed';
			$emails           = $t == 'exhibit' ? array_slice( $r['m_maker_email'], 1 ) : ( $t == 'presenter' ? array_slice( $r['presenter_email'], 1 ) : array() );

			foreach ( $r as $k => $v ) {
				if ( is_array( $v ) ) {
					$r[$k] = implode( ', ', $v );
				}
			}

			// if uid is 0, empty, or not set then just return and do not insert the post or update the post_meta
			if ( ! isset( $r['uid'] ) || $r['uid']=='0' || $r['uid']=='' )
				return;

			//SYNC WITH MAKE DB
			$this->sync_jdb( $id );

			//SEND CONFIRMATION EMAIL TO MAKER
			$this->send_maker_email( $r, $n, $id );

			//SEND EMAILS TO ADDITIONAL USERS
			if ( $t == 'exhibit' || $t == 'presenter' ) {
				if ( ! empty( $emails ) ) {
					foreach ( $emails as $e ) {
						add_post_meta( $id, 'mf_additional_user', $e );
					}
					$this->send_maker_invite_email( $id, $emails, $r, $n );
				}
			}
		}
		
		$_POST['mf_updated'] = 1;
		
		update_post_meta( $id, '_mf_form_type',  $t );
		update_post_meta( $id, '_mf_maker_name', $r['name'] );

		return wp_update_post( $d );
	}

	/* 
	* Sends a email to form submitter
	*
	* @access public
	* @param array $r Form data
	* @param string $n Name
	* @return boolean if wp_mail was successful.
	* =====================================================================*/
	private function send_maker_email( $r, $n, $id ) {
		$bad  = array( '&#039;', "\'", '&#8217;', '&#38;', '&#038;', '&amp;', '&quot;', '&#34;', '&#034;', '&#8211;', '&lt;', '&#8230;', );
		$good = array( "'",      "'",  "'",       "&",     "&",      '&',     '"',      "'",     '"',      '–',       '>',    '...',     );

		// Don't send if there's no email or no form type
		if ( empty( $r['form_type'] ) || empty( $r['email'] ) )
			return false;

		// Setup app info
		$app_name = esc_html( $n );
		$app_info = esc_html( '[' . ucfirst( $r['form_type'] ) . ' ' . intval( $id ) . ']' );

		// Subject
		$subject  = str_replace( $bad, $good, stripslashes( sprintf( 'Maker Faire Application Submitted: %s %s', $app_name , $app_info ) ) );

		// Email Body
		$m = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>';
		$m.='<p>' . esc_html( ucfirst( $r['name'] ) ) . ',</p>';
		$m.='<p>Thanks for your interest in participating in World Maker Faire New York 2013! We have received your application for: <strong>' . $app_name . '</strong> ' . $app_info . '.</p>';
		if (  $r['form_type'] == 'presenter' ) {
			$m .= '<p><strong>You can update your presentation application anytime until September 1st</strong>. <em>(Note that those submitting panel presentation proposals are responsible for collecting and entering all bio information from proposed panelists—so please come back and finish your application if those fields are not yet complete.)</em></p>';
			$m .= '<ol><li>Log into your maker account from makerfaire.com. The login link is in the blue header at the top of every page.</li>';
			$m .= '<li>After login, you\'ll see a link to edit any applications you\'ve started or submitted.</li></ol>';
			$m .= '<p>(Note that those submitting panel presentation proposals are responsible for collecting and entering all bio information from proposed panelists—so please come back and finish your application if those fields are not yet complete.)</p>';
			$m .= '<p>You will be notified as to the status of your application no later than August 16th.</p>';
			$m .= '<p>If your presentation is accepted, we will do our best to accomodate your requests.  Please understand that your requests are not guaranteed. What we can provide will be confirmed in a follow-up letter after acceptance.';
			$m .= '<p>Spread the word - Like us on <a href="https://www.facebook.com/worldmakerfaire">Facebook</a> and follow us on <a href="http://twitter.com/makerfaire">Twitter</a> and <a href="https://plus.google.com/+MAKE/posts">G+</a>.</p>';
			$m .= '<p>Sabrina Merlo<br />Program Director<br />Maker Faire';
		} else {
			$m .= '<p>You will be notified as to the status of your application no later than August 12th.</p>';
			$m .= '<p>If your application is accepted, we have agreed to the concept of your exhibit, however, we are not able to  guarantee all of your requests at this time. What we can provide will be outlined in a confirmation letter before the event.</p>';
			$m .= '<p>Spread the word - Like us on <a href="https://www.facebook.com/worldmakerfaire">Facebook</a> and follow us on <a href="http://twitter.com/makerfaire">Twitter</a> and <a href="https://plus.google.com/+MAKE/posts">G+</a>.</p>';
			$m .= '<p>Lastly, the Road to Maker Faire Challenge, presented by Esurance, will award one lucky maker $2,500 to bring their project to World Maker Faire. You may apply with the same project you are submitting to Maker Faire, and applications must be completed no later than 11:59pm PT on August 5th. <a href="http://makezine.com/road-to-maker-faire-challenge">Enter Now</a>!</p>';
			$m .= '<p>Sherry Huss<br />Vice President<br />Maker Media, Inc.</p>';
			$m .= '<p>Maker Faire (<a href="http://makerfaire.com">makerfaire.com</a>)<br />MAKE (<a href="http://makezine.com">makezine.com</a>)</p>';
		}
		$m.='<p>Maker Media, Inc.<br />1005 Gravenstein Hwy North<br />Sebastopol, CA 95472</p>';
		$m.='<br /><br /><br /><p>Maker Faire ' . $app_info . ' Application Received: ' . $app_name . '</p>';
		$m.='</body></html>';

		$body = htmlspecialchars_decode( stripslashes( $m ) );

		// Headers
		$headers = array(
			'Content-Type: text/html',
			'From: Maker Faire <makers@makerfaire.com>',
			'Bcc: Maker Faire <makers@makerfaire.com>'
		);

		// Send the email
		$r = wp_mail( $r['email'], $subject, $body, $headers );
		
		return $r;
	}
	/* 
	* Sends a email to addtional makers
	*
	* @access public
	* @param integer $id Form ID
	* @param array $emails Emails to send
	* @param array $r Form data
	* @param string $i Include body
	* @param string $n Name
	* @return boolean if wp_mail was successful.
	* =====================================================================*/
	private function send_maker_invite_email( $id, $emails, $r, $n ) {
		$m = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>';
		$m .= '<p>Thanks for your interest in participating in World Maker Faire New York 2013!</p><br />';
		$m .= '<p>'.esc_html( ucwords( $r['name'] ) ).' has submitted an application and indicated you were part of their exhibit or presentation. We need you to create a maker account at ';
		$m .= '<a href="'.home_url().'/?register=1" alt="Maker Faire">makerfaire.com</a> and provide some additional details that we can include about you.</p>';
		$m .= '<p>Create an account by selecting “Register” in the header.</p>';
		$m .= '<br /><p>Spread the word - Like us on <a href="http://facebook.com/makerfaire" alt="Like Maker Faire Facebook">Facebook</a> and follow us on ';
		$m .= '<a href="https://twitter.com/#%21/makerfaire" alt="Follow Maker Faire Twitter">Twitter</a> and <a href="https://plus.google.com/+MAKE/posts" alt="Maker Faire Google+">G+</a></p>';

		$app_name = str_replace( '&amp;', '&', esc_html( $n ) );

		$r = wp_mail( $emails, 'Maker Faire Application: '.intval( $id ).': ' . $app_name, $m, array( 'Content-Type: text/html', 'From: Maker Faire <makers@makerfaire.com>','Bcc: Maker Faire <makers@makerfaire.com>' ) );

		return $r;
	}
	/* 
	* Tests if a phone number is valid
	*
	* @access public
	* @param string $phone Phone to check
	* @return boolean if valid phone number
	* =====================================================================*/
	private function is_phone( $phone ) {
		$phone = preg_replace( '/[^0-9]/', '', $phone );

		return (bool) strlen( $phone ) == 10 || strlen( $phone ) == 11;
	}
	/* 
	* Tests if a zipcode is valid
	*
	* @access public
	* @param string $zip Zipcode to check
	* @return boolean if valid zipcode
	* =====================================================================*/
	private function is_zip( $zip ) {
		return (bool) preg_match( '/^[0-9]{5}(-[0-9]{4}){0,1}$/', $zip );
	}
	/* 
	* Outputs a text field
	*
	* @access public
	* @param string $n textbox name
	* @param array $attr An array of attributes to include
	* =====================================================================*/
	public function text( $n, $attr = array() ) {
		?>
		<input type="text" name="<?php echo esc_attr( $n ); ?>" value="<?php echo esc_attr( $this->form[$n] ); ?>" <?php
		foreach ( $attr as $a => $av ) {
			echo esc_html( $a ) . '="'.esc_attr( $av ).'" ';
		}
		?> />
		<?php
	}
	/* 
	* Outputs a radio button
	*
	* @access public
	* @param string $n radio name
	* @param array $set An array of values and labels 
	* =====================================================================*/
	public function radio( $n, $set ) {
		foreach ( $set as $k => $v ) :
			$k = is_numeric( $k ) ? $v : $k;
			?>
			<div><input name="<?php echo esc_attr( $n ); ?>" type="radio" value="<?php echo esc_attr( $k ); ?>" <?php checked( $k, $this->form[$n] ); ?> /> <?php echo esc_html( $v ); ?></div>
			<?php
		endforeach;
	}
	/* 
	* Outputs a checkbox
	*
	* @access public
	* @param string $n checkbox name
	* @param array $set An array of values and labels 
	* =====================================================================*/
	public function checkbox( $n, $set ) {
		foreach ( $set as $k => $v ) :
			$k = is_numeric( $k ) ? $v : $k;
			?>
			<div><input name="<?php echo esc_attr( $n ); ?>[]" type="checkbox" value="<?php echo esc_attr( $k ); ?>" <?php checked(in_array( $v, (array )$this->form[$n] ) ); ?> /> <?php echo esc_html( $v ) ?></div>
			<?php
		endforeach;
	}
	/* 
	* Outputs a textarea
	*
	* @access public
	* @param string $n textarea name
	* @param array $attr An array of attributes to include
	* =====================================================================*/
	public function textarea( $n, $attr = array() ) {
		?>
		<textarea name="<?php echo esc_attr( $n ); ?>" <?php
		foreach ( $attr as $a => $av ) {
			echo esc_html( $a ).'="'. esc_attr( $av ) .'" ';
		}
		?>><?php echo esc_textarea( $this->form[$n] ); ?></textarea>
		<?php
	}
	/* 
	* Outputs a select field
	*
	* @access public
	* @param string $n Select name
	* @param array $set An array of values and labels 
	* =====================================================================*/
	public function select( $n, $set ) {
		?>
		<select name="<?php echo esc_attr( $n ); ?>">
			<option value="">-- Select One</option>
			<?php foreach ( $set as $v => $lbl ) : ?>
				<option value="<?php echo esc_attr( $v ); ?>" <?php selected( $v, $this->form[$n] ); ?>> <?php echo esc_html( $lbl ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php
	}
	/* 
	* Outputs a file field
	*
	* @access public
	* @param string $n key of file path
	* @param string $rn real key of path
	* =====================================================================*/
	public function file( $n, $rn ) {
		if ( $this->form[$n] == '' ) {
			?><input name="<?php echo esc_attr( $rn ); ?>" type="file" /><?php 
		} else {
			$v = $this->form[$n];
			$thumb = $this->form[substr( $n, 0, -1 ).'_thumb]'];
			
			if ( $rn == 'supporting_documents' || $rn == 'layout' ) {
				?><a href"<?php echo esc_attr( $v ); ?>" /><?php echo esc_url( $v ); ?></a><?php
			} else {
				?><img src="<?php echo esc_attr( $this->form[substr( $n, 0, -1 ).'_thumb]'] ); ?>" style="max-width:600px" /><?php
			}
			
			?>
			<input type="hidden" name="<?php echo esc_attr( $n ); ?>" value="<?php echo esc_attr( $v ); ?>" />
			<input type="hidden" name="<?php echo esc_attr( substr( $n, 0, -1 ).'_thumb]' ); ?>" value="<?php echo esc_attr( $thumb ); ?>" />
			<div id="<?php echo esc_attr( $rn ); ?>" class="info overwrite">Overwrite File</div>
			<?php
		}
	}
	/* 
	* Queue up all JS and CSS
	*
	* @access public
	* =====================================================================*/
	public function enqueue() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'mff_js',             plugins_url( 'assets/js/mff.js', __FILE__ ) );
		wp_enqueue_script( 'mff_jquery_form_js', plugins_url( 'assets/js/jquery.form.js', __FILE__ ) );
		wp_enqueue_script( 'mff_gigya',          'http://cdn.gigya.com/JS/socialize.js?apikey='.self::GIGYA_API_KEY );
		wp_enqueue_script( 'mff_gigya_login',    plugins_url( 'assets/js/gigya-login.js', __FILE__ ) );

		wp_enqueue_style( 'mff_css', plugins_url( 'assets/css/style.css', __FILE__ ) );
	}

	/* 
	* Queue up all Admin JS and CSS
	*
	* @access public
	* =====================================================================*/
	public function admin_enqueue( $hook ) {
		global $post_type;
    	
    	// Load our custom search JS ONLY on the edit.php when viewing the mf_form CPT.
		if ( ( 'edit.php' == $hook && $post_type == 'mf_form' ) || ( 'post.php' == $hook && $post_type == 'mf_form' ) )
			wp_enqueue_script( 'mf-custom-search', plugins_url( 'assets/js/search-id.js', __FILE__ ), array( 'jquery' ), '1.0', true );

		wp_enqueue_style( 'mff_css', plugins_url( 'assets/css/style.css', __FILE__ ) );
	}

	/* 
	* Searches and retrieves data from Gigya's Accounts Storage using an SQL-like query.
	*
	* @access public
	* @param string $query An associative array of key/value to search
	* @return array An array users or empty array
	* =====================================================================*/
	public function gigya_search_users( $query = '' ) {
		// include the gigya php sdk
		require_once ( __DIR__ . '/inc/GSSDK.php' );
		require_once ( __DIR__ . '/inc/GSSDK-WP.php' );

		$request = new GSRequestWP( self::GIGYA_API_KEY, self::GIGYA_SECRET_KEY, 'accounts.search' );
		$request->setParam( 'query', "{$query}" );
		$response = $request->send();

		$response_array = array();
		$users = array();
		$user_count = 0;

		if ( $response->getErrorCode() == 0 ) {
			$response_array = json_decode( $response->getResponseText(), true );
			$user_count = isset( $response_array['totalCount'] ) ? $response_array['totalCount'] : 0;
			$users = isset( $response_array['results'] ) ? $response_array['results'] : array();
		} else {
			//error_log( $response->getLog() );
			return array();
		}

		return $users;
	}
	/* 
	* Provides a form to create new GIGYA users
	*
	* @access public
	* =====================================================================*/
	public function show_add_maker_page() {

		require_once ( __DIR__ . '/inc/GSSDK.php' );
		require_once ( __DIR__ . '/inc/GSSDK-WP.php' );

		$message = '';

		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {

			if ( ! isset( $_POST['isc_mm_addmaker_nonce'] ) || ! check_admin_referer( 'isc_mm_addmaker_action', 'isc_mm_addmaker_nonce' ) ) {
				return;
			} else {
				$maker_user = array();
				$defaults = array( 'firstname', 'lastname', 'email', 'bio', 'photourl', 'twitterhandle', 'websiteurl' );
				foreach ( $defaults as $k ) {
					if ( isset( $_POST["maker{$k}"] ) && ! empty( $_POST["maker{$k}"] ) ) {
						$maker_user[$k] = $_POST["maker{$k}"];
					}
				}

				// create nickname based on concatenating firstname and lastname per gigya specs
				$maker_user['nickname'] = $maker_user['firstname'].' '.$maker_user['lastname'];


				// if there isn't a valid email its hopelessly not gonna work
				if ( isset( $maker_user['email'] ) && is_email( $maker_user['email'] ) ) {


					// if there is no photourl set then use the gravatar generated image
					if ( ! isset( $maker_user['photourl'] ) )
						$maker_user['photourl'] = 'http://www.gravatar.com/avatar/' . md5( strtolower( $maker_user['email'] ) );


					$profileObject = array(
						'firstName'  => $maker_user['firstname'],
						'lastName'   => $maker_user['lastname'],
						'email'      => $maker_user['email'],
						//'photoURL'   => $maker_user['photourl'],
						//'profileURL' => $maker_user['websiteurl'],
					);

					$dataObject = array(
						'bio'           => stripslashes( $maker_user['bio'] ),
						//'twitterhandle' => $maker_user['twitterhandle'],
					);

					// get the regToken needed to make the actual registration request
					$request = new GSRequestWP( self::GIGYA_API_KEY, self::GIGYA_SECRET_KEY, 'accounts.initRegistration' );
					$response = $request->send();

					$response_array = array();
					$regToken = false;
					if ( $response->getErrorCode() == 0 ) {
						$response_array = json_decode( $response->getResponseText(), true );
						$regToken = isset( $response_array['regToken'] ) ? $response_array['regToken'] : false;
					}

					// got the regToken so lets register
					if ( $regToken !== false ) {
						$request = new GSRequestWP( self::GIGYA_API_KEY, self::GIGYA_SECRET_KEY, 'accounts.register', null, true );
						$request->setCAFile( __DIR__ . '/inc/cacert.pem' );
						$request->setParam( 'email', $maker_user['email'] );
						$request->setParam( 'finalizeRegistration', true );
						$request->setParam( 'password', 'M@ker'.'F@ire'.'2013' );
						$request->setParam( 'regToken', $regToken );
						$request->setParam( 'profile', json_encode( $profileObject ) );
						$request->setParam( 'data', json_encode( $dataObject ) );

						$response       = $request->send();
						$response_array = json_decode( $response->getResponseText(), true );
						
						if ( $response->getErrorCode() == 0 ) {
							$message = '<div class="updated below-h2" id="message"><p>Maker Added</p></div>';
						} elseif ( $response->getErrorCode() == 206002 ) {
							$message = '<div class="updated below-h2" id="message"><p>Account Pending Verification</p></div>';
						} else {
							$message = '<div class="error below-h2" id="message"><p>'.esc_html( $resposne->getErrorMessage() ).'</p></div>';
						}
					}
				} else {
					$message = '<div class="error below-h2" id="message"><p>Valid Email Only.</p></div>';
				}
			}
		}

		?>
		<div class="wrap" id="iscic"><?php screen_icon();?>
			<h2>Add Maker</h2>
			<?php echo $message; ?>
			<div id="poststuff">
				<div id="post-body" class="metabox-holder">
					<div class="postbox " id="mf_addamaker" style="display: block;">
						<h3 class="hndle"><span>Add a Maker</span></h3>
						<div class="inside">
							<form id="iscmmaddmaker" method="post" action="">
								<table style="width:100%">
									<tbody>
										<tr>
											<td valign="top" style="width:150px;"><label for="makerfirstname"><strong>First Name</strong></label></td>
											<td><input style="width:100%;" name="makerfirstname" id="makerfirstname" type="text" value="<?php echo esc_attr( isset( $maker_user['firstname'] ) ? $maker_user['firstname'] : '' ); ?>" /></td>
										</tr>
										<tr>
											<td valign="top" style="width:150px;"><label for="makerlastname"><strong>Last Name</strong></label></td>
											<td><input style="width:100%;" name="makerlastname" id="makerlastname" type="text" value="<?php echo esc_attr( isset( $maker_user['lastname'] ) ? $maker_user['lastname'] : '' ); ?>" /></td>
										</tr>
										<tr>
											<td valign="top" style="width:150px;"><label for="makeremail"><strong>Email</strong></label></td>
											<td><input style="width:100%;" name="makeremail" id="makeremail" type="text" value="<?php echo esc_attr( isset( $maker_user['email'] ) ? $maker_user['email'] : '' ); ?>" /></td>
										</tr>
										<tr>
											<td valign="top" style="width:150px;"><label for="makerbio"><strong>Bio</strong></label></td>
											<td><textarea style="width:100%;"  name="makerbio" id="makerbio" cols="50" rows="3"><?php echo esc_textarea( isset( $maker_user['bio'] ) ? stripslashes( $maker_user['bio']) : '' ); ?></textarea></td>
										</tr>
									</tbody>
								</table>
								<p class="submit"><input type="submit" id="isc_mm_addmaker_now" name="isc_mm_addmaker_now" value="Create Maker Now" class="button button-primary button-large" /></p>
								<?php wp_nonce_field( 'isc_mm_addmaker_action', 'isc_mm_addmaker_nonce' ); ?>
							</form>
						</div><!--inside-->
					</div><!--postbox-->
				</div><!--post-body-->
			</div><!--poststuff-->
		</div><!--wrap-->
		<?php
	}
	/* 
	* List all makers in a table
	*
	* @access public
	* =====================================================================*/
	public function show_list_makers_page() {
	
		$makers = $this->gigya_search_users( 'select UID, profile.firstName, profile.lastName, profile.email, created from accounts order by created limit 800' );

		$makers_list = array();
		foreach ( $makers as $maker ) {
			$makers_list[] = $maker;
		}

		?>
		<div class="wrap" id="iscic"><?php screen_icon();?>
		<h2>List Makers</h2>
		<table cellspacing="0" class="wp-list-table widefat fixed posts">
			<thead>
				<tr>
					<th class="manage-column ciscfirstname desc" id="iscfirstname" scope="col">First Name</th>
					<th class="manage-column cisclastname desc" id="isclastname" scope="col">Last Name</th>
					<th class="manage-column ciscemail desc" id="iscemail" scope="col">Email</th>
					<th class="manage-column ciscuid desc" id="iscuid" scope="col">UID</th>
					<th class="manage-column cisccreated desc" id="isccreated" scope="col">Created</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="manage-column ciscfirstname desc" scope="col">First Name</th>
					<th class="manage-column cisclastname desc" scope="col">Last Name</th>
					<th class="manage-column ciscemail desc" scope="col">Email</th>
					<th class="manage-column ciscuid desc" scope="col">UID</th>
					<th class="manage-column cisccreated desc" scope="col">Created</th>
				</tr>
			</tfoot>
			<tbody id="the-list">
				<?php
					foreach ( $makers_list as $x => $m ) {		
						$c = ( ( $x + 1 ) % 2) == 0 ? 'alternate' : '';
						?>
						<tr class="<?php echo esc_attr( $c ); ?>" id="<?php echo esc_attr( 'maker-'.$x ); ?>" valign="top">
							<td class="iscc ciscfirstname"><?php echo esc_html( $m['profile']['firstName'] ); ?></td>
							<td class="iscc cisclastname"><?php echo esc_html( $m['profile']['lastName'] ); ?></td>
							<td class="iscc ciscemail"><?php echo esc_html( $m['profile']['email'] ); ?></td>
							<td class="iscc ciscuid"><code><?php echo esc_html( $m['UID'] ); ?></code></td>
							<td class="iscc cisccreated date"><?php echo esc_html( $m['created'] ); ?><br /></td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>
		</div><!--wrap-->
		<?php
	}
	/*
	* Output list of project images
	*
	* @access public 
	* =====================================================================*/
	public function show_project_images() { 
		
		$projects = $this->get_all_forms( 'form_type' );
		?>
		<div class="wrap" id="iscic">
			<?php echo screen_icon(); ?>
			<h2><?php echo wpcom_vip_get_term_by( 'slug', $GLOBALS['current_faire'], 'faire')->name; ?>
				<div style="font-size:75%">Report: View Project Images</div>
			</h2>
			<h3>Total: <?php echo intval( count( $projects['exhibit'] ) + count( $projects['performer'] ) + count( $projects['presenter'] ) ); ?> Proposed, Waiting for Info and Accepted Projects</h3>
			<?php
			foreach( $projects as $type => $list ) :
				krsort( $list );
				?>
				<div class="clear"></div>
				<h1><?php echo esc_html( ucwords( $type ) ); ?> Applications</h1>
				
				<?php
				foreach( $list as $id => $form ) :
				?>
					<div style="float:left; width:400px; margin:20px; height:500px;">
						<a href="<?php echo esc_url( get_edit_post_link( $id ) ) ?>">
							<img src="<?php echo esc_url( $form['form_photo_thumb'] ); ?>" style="max-width:400px; max-height:400px; margin-bottom:10px;" />
						</a>
						<div style="font-size:12px;">
							<a href="<?php echo esc_url( get_edit_post_link( $id ) ) ?>">
								<?php echo esc_html( ucwords( $form['form_type'] ) ); ?> : <?php echo esc_html( $form[ 'project_name' ] ); ?> (<?php echo intval( $id ); ?>)<br />
							</a>
							Maker: <?php echo esc_html( $form['name'] ); ?>
						</div>
					</div>
				<?php
				endforeach; ?>
			<?php
			endforeach; ?>
		</div><!--wrap-->
		<?php
	}
	/*
	* Output Reports List
	*
	* @access public
	* =====================================================================*/
	public function show_reports_page() { 
	
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
			//NONCE CHECK
			if ( isset( $_POST['mf_syncjdb'] ) && wp_verify_nonce( $_POST['mf_syncjdb'], 'mf_syncjdb' ) )
				$this->sync_jdb();
			elseif ( isset( $_POST['mf_syncstatusjdb'] ) && wp_verify_nonce( $_POST['mf_syncstatusjdb'], 'mf_syncstatusjdb' ) ) {
				echo $this->sync_all_status_jdb( $_POST['offset'] );
			}
		}
	
		// $stats = $this->get_reports_stats();
		$fails = $this->get_failed_syncs();
		
		?>
		<div class="wrap" id="iscic">
			<?php echo screen_icon(); ?>
			<h2>Maker Faire Reports</h2>
			<div style="width:45%; float:left">
				<h3><?php echo wpcom_vip_get_term_by( 'slug', $GLOBALS['current_faire'], 'faire')->name; ?> Stats</h3>
				<?php //echo mf_count_post_statuses( 'table' ); ?>
			<h1 style="margin-top:20px;">Sync Status with JDB</h1>
			Syncs 100 applications at a time.<br />To do a full sync start at 0 and increase by 100 until you're done.
			<form action="" method="post">
				<p>
					<div style="float:left; width:50px">
						<strong>Start</strong><br />
						<select name="offset">
							<option value="0">0</option>
							<?php foreach( range( 100, 1000, 100 ) as $v ) : ?>
							<option value="<?php echo intval( $v ); ?>"><?php echo intval( $v ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</p>
				<div class="clear"></div>
				<p class="submit"><input type="submit" value="Sync Statuses With JDB Now" class="button button-primary button-large" /></p>
				<?php wp_nonce_field( 'mf_syncstatusjdb', 'mf_syncstatusjdb' ); ?>
			</form>
			<h1 style="margin-top:40px;">Sync with JDB</h1>
			<?php if( !isset( $_SERVER['SERVER_ADDR_NAME'] ) || $_SERVER['SERVER_ADDR_NAME'] != 'iscrackweb1' ) : ?>
				Last Sync : <?php echo esc_html( get_option( 'mf_full_jdb_sync', 'NEVER' ) ); ?><br />
				<form action="" method="post">
					<p class="submit"><input type="submit" value="Sync With JDB Now" class="button button-primary button-large" /></p>
					<?php wp_nonce_field( 'mf_syncjdb', 'mf_syncjdb' ); ?>
				</form>
			<?php endif; ?>
			<h2>Failed Syncs</h2>
			<ul>
			<?php foreach( $fails as $fail ) : ?>
				<li><a href="post.php?post=<?php echo intval( $fail->ID ); ?>&action=edit"><?php echo esc_html( $fail->post_title ); ?></a></li>
			<?php endforeach; ?>
			</ul>
			</div>
			<div style="width:45%; float:right; border:1px solid #DFDFDF; border-radius:3px; padding:10px; background:#F2F2F2">
				<h1>Project/Application Reports</h1>
				
				<h2>Accepted Projects/Applications</h2>
        		<h3><a href="<?php echo wp_nonce_url( 'edit.php?post_type=mf_form&page=mf_reports&form_csv=exhibit&form_status=accepted', 'mf_export_check' ); ?>">Export Accepted Exhibit Applications</a></h3>
        		<h3><a href="<?php echo wp_nonce_url( 'edit.php?post_type=mf_form&page=mf_reports&form_csv=performer&form_status=accepted', 'mf_export_check' ); ?>">Export Accepted Performer Applications</a></h3>
        		<h3><a href="<?php echo wp_nonce_url( 'edit.php?post_type=mf_form&page=mf_reports&form_csv=presenter&form_status=accepted', 'mf_export_check' ); ?>">Export Accepted Presenter Applications</a></h3>
        
				<h2>Project/Application Reports</h2>
				<h3><a href="<?php echo wp_nonce_url( 'edit.php?post_type=mf_form&page=mf_reports&form_csv=all', 'mf_export_check' ); ?>">Export All Applications</a></h3>
				<h3><a href="<?php echo wp_nonce_url( 'edit.php?post_type=mf_form&page=mf_reports&form_csv=exhibit', 'mf_export_check' ); ?>">Export All Exhibit Applications</a></h3>
				<h3><a href="<?php echo wp_nonce_url( 'edit.php?post_type=mf_form&page=mf_reports&form_csv=performer', 'mf_export_check' ); ?>">Export All Performer Applications</a></h3>
				<h3><a href="<?php echo wp_nonce_url( 'edit.php?post_type=mf_form&page=mf_reports&form_csv=presenter', 'mf_export_check' ); ?>">Export All Presenter Applications</a></h3>
				
				<h2 style="margin-top:40px;">Maker Reports</h2>
				<h3><a href="<?php echo wp_nonce_url( 'edit.php?post_type=mf_form&page=mf_reports&maker_csv=presenter', 'mf_export_check' ); ?>">Export All Makers</a></h3>
				
				<h2 style="margin-top:40px;">Editorial Comments Export</h2>
				<h3><a href="<?php echo wp_nonce_url( 'edit.php?post_type=mf_form&page=mf_reports&comments_csv', 'mf_export_check' ); ?>">Export Editorial Comments</a></h3>
				
				<h2 style="margin-top:40px;">Presentation Reports</h2>
				<h3><a href="<?php echo wp_nonce_url( 'edit.php?post_type=mf_form&page=mf_reports&presentation_csv=manager', 'mf_export_check' ); ?>">Stage Manager Report</a></h3>
				<h3><a href="<?php echo wp_nonce_url( 'edit.php?post_type=mf_form&page=mf_reports&presentation_csv=signage', 'mf_export_check' ); ?>">Stage Signage Report</a></h3>
				<h3><a href="<?php echo wp_nonce_url( 'edit.php?post_type=mf_form&page=mf_reports&presentation_csv=checkin', 'mf_export_check' ); ?>">Presenter CheckIn Report</a></h3>
			</div>
		</div>
		<?php
	}
	/* 
	* Gathers and outputs application data
	*
	* @access private
	* @return array Associative array of all reports stats
	* =====================================================================*/
	private function get_reports_stats() {
		
		$posts  = $this->get_all_forms();
		$types  = array(
			'exhibit'   => 0,
			'presenter' => 0,
			'performer' => 0
		);
		
		$res    = array(
			'in-progress'      => $types,
			'proposed'         => $types,
			'waiting-for-info' => $types,
			'accepted'         => $types,
			'rejected'         => $types,
			'cancelled'        => $types
		);		
		
		foreach( $posts as $post ) {
			$form = (array) json_decode( str_replace( "\'", "'", $post->post_content ) );
			
			if ( array_key_exists( $form['form_type'], $types ) )
				$res[$post->post_status][$form['form_type']]++;
		}

		return $res;
	}
	/* 
	* Gathers and outputs application data
	*
	* @access private
	* @param string $export_type The type of form to output
	* @param string $status The status of the form
	* @param boolean $return_array Whether to return an array or output CSV
	* =====================================================================*/
	private function build_form_export( $export_type = 'all', $status = 'all', $options = array(), $return_array = false ) {

		// Check our nonce
		if ( isset( $_GET['_wpnonce'] ) && ! wp_verify_nonce( $_GET['_wpnonce'], 'mf_export_check' ) )
			return false;
			
		// Make sure the user requesting this has the privileges...
		if ( ! current_user_can( 'edit_others_posts' ) ) 
			return false;

		// Set to true
		$return_array = false;

		// Setup some default options
		$defaults = array(
			'export_type' 	=> 'all',
			'sort'		  	=> null,
			'header_titles' => array(
				'hotdogs',
			),
		);

		// Parse our options with the defaults
		$options = wp_parse_args( $options, $defaults );

		$fields = array_merge( $this->fields, $options['header_titles'] );

		// Get our array of form fields so we can build the header of the csv export
		if ( $options['export_type'] == 'all' ) {
			$header_titles = array(
				's1' => array(),
			);

			foreach ( $fields as $type => $step_number ) {
				foreach ( $step_number as $key => $value ) {
					$header_titles['s1'] = array_merge( $header_titles['s1'], $value );
				}
			}
		} else {
			$header_titles = $this->fields[ $export_type ];
		}

		// Take the current header titles and merge them all into the $data variable.
		foreach ( $header_titles as $step_number => $value ) {
			foreach ( $value as $key => $value ) {
				$data[ $key ] = '';

				if ( $key == 'm_maker_gigyaid' ) {
					for ( $i = 2; $i < 5; $i++ ) {
						$data['m_maker_name_' . $i ] 	= '';
						$data['m_maker_email_' . $i ] 	= '';
						$data['m_maker_gigyaid_' . $i ] = '';
					}
				} elseif ( $key == 'presenter_gigyaid' ) {
					for ( $i = 2; $i < 5; $i++ ) {
						$data['presenter_name_' . $i ] 	  = '';
						$data['presenter_email_' . $i ]   = '';
						$data['presneter_gigyaid_' . $i ] = '';
					}
				}
			}
		}
		
		// Get our data setup
		$applications = $this->get_all_forms( $options['sort'], $status );
		$ef_terms 	  = $this->get_editflow_terms();
		$ef_data 	  = $this->get_editflow_data( $ef_terms );
		$ef_def   = array(
			'checkbox' => 'No',
			'data'     => 'N/A',
		);

		// Set the array keys for the header
		$data   = array_keys( $data );

		// Begin setting up the code for the header
		$header = implode( "\t", $data );

		// Any instance that has under scores, replace it with spaces and make the text uppercase
		$header = strtoupper( str_replace( '_', ' ', $header ) );

		// Process our Edit Flow terms also into the header
		foreach( $ef_terms as $ef_term ) {
			$header .= "\t" . $ef_term['name'];
		}

		// Add some more to the list..
		$header .= "\tLocation";
		$header .= "\tList of Makers";
		$header .= "\tTemp Location";
		$header .= "\tLocations";
		$header .= "\tList of Makers";
		$header .= "\r\n";

		foreach ( $options['header_titles'] as $header_title ) {
			$header .= "\t" . strtoupper( $header_title );
		}

		var_dump($header);
		
		// Setup the results array
		$results = array();

		// Process our rows.
		foreach ( $applications as $app ) {
			// Get the current applications content (which is json data)
			$form = (array) json_decode( str_replace( "\'", "'", $app->post_content ) );

			// Let's make sure we're actually getting what we expect..
			if ( $export_type != 'all' && $export_type != $form['form_type'] )
				continue;

			// Append some extra details to our data
			$form = array_merge( $form, array(
				'status'     => $app->post_status,
				'project_id' => $app->ID
			) );

			// Create an array key for this post in the results array
			$results[ $app->ID ] = array();

			// Create an empty string to append each CSV row to.
			$row = '';

			// Add our maker info
			$multi = array( 
				'm_maker_name', 
				'm_maker_email', 
				'm_maker_gigyaid', 
				'presenter_name', 
				'presenter_email', 
				'presenter_gigyaid' 
			);

			// define our CSV rows
			foreach ( $data as $key ) {

				// For each application type, we have different field keys. We'll pass it through this function to ensure we return the right type
				if ( $merged_key = $this->merge_fields( $key, $form['form_type'] ) )
					$key = $merged_key;

				// Separate each maker/presenter to a new row
				if ( in_array( $key, $multi ) ) {

					// If the current data is an array, then we'll point it to their 0 index. This will be the makers name, email and gigya ID's
					$maker_data = is_array( $form[ $key ] ) ? $form[ $key ][0] : $form[ $key ];

					// Add our maker data to the results array
					$results[ $app->ID][ $key ] = $maker_data;
					
					// Add our maker data to the row TODO: don't add if $maker_data is empty?? What happens to the results?
					$row .= "\t" . $maker_data;
					
					// Process a makers info
					if ( $key == 'm_maker_gigyaid' ) {
						for ( $i = 1; $i < 4; $i++ ) {
							foreach ( array( 'm_maker_name', 'm_maker_email', 'm_maker_gigyaid' ) as $n ) {
								$results[ $app->ID ][ $n . '_' . ( $i + 1 ) ] = $form[ $n ][ $i ];
								$row .= "\t" . $form[ $n ][ $i ];
							}
						}
					} elseif( $key == 'presenter_gigyaid' ) {
						for ( $i = 1; $i < 4; $i++ ) {
							foreach ( array( 'presenter_name', 'presenter_email', 'presenter_gigyaid' ) as $n ) {
								$results[ $app->ID ][ $n . '_' . ( $i + 1 ) ] = $form[ $n ][ $i ];
								$row .= "\t" . $form[ $n ][ $i ];
							}
						}
					}
				// Catch all
				} elseif ( $key == 'accepted' ) {
					
					// Return the logged data
					$meta_log = get_post_meta( $app->ID, '_mf_log', true );

					// If data was returned
					if ( $meta_log ) {
						foreach ( $meta_log as $entry ) {
							if ( strpos( $entry, 'Accepted' ) !== false ) {
								$entry_a = explode( ' ', $entry );
								$row .= "\t" . $entry_a[0] . ' ' . $entry_a[1] . ' ' . strtoupper( $entry_a[2] );
								break;
							}
						}
					} else {
						$row .= "\tN/A";
					}	
					
				} elseif ( isset( $form[ $key ] ) ) {
					$d = is_array( $form[ $key ] ) ? implode( ', ', $form[ $key ] ) : $form[ $key ];
					
					$results[ $app->ID ][ $key ] = $d;
					$row .= "\t" . $d;

				} else {
					
					// Check if we are dealing with a multi-listing maker of presenter.
					$is_multi = false;
					foreach ( $multi as $m ) {
						for ( $i = 2; $i < 5; $i++ ) {
							if ( $key == $m . '_' . $i ) {
								$is_multi = true;
								break;	
							}
						}
					}
					
					if ( ! $is_multi ) {
						$results[ $app->ID ][ $key ] = '';
						$row .= "\t" . '';

					}
				}
			}

			// Get all of the Edit Flow terms and process them into our CSV
			foreach( $ef_terms as $ef_id => $ef_term ) {
				$results_ef = $results[ $app->ID ][ $ef_term['slug'] ];

				if ( isset( $ef_data[ $app->ID ][ $ef_id ] ) ) {
					
					// Handle any text field
					if ( $ef_term['type'] == 'text' ) {

						$ef_text_results = get_post_meta( $app->ID, '_' . $ef_term['taxonomy'] . '_' . $ef_term['type'] . '_' . $ef_term['slug'], true );
						$results[ $app->ID ][ $ef_term['slug'] ] = $ef_text_results;
						$row .= "\t" . $ef_text_results;

					} else {

						$results[ $app->ID ][ $ef_term['slug'] ] = $ef_def[ $ef_term['type'] ];
						$row .= "\t" . $ef_data[ $app->ID ][ $ef_id ];
					}

				} else {
					
					$results[ $app->ID ][ $ef_term['slug'] ] = $ef_def[ $ef_term['type'] ];
					$row .= "\t" . $ef_def[ $ef_term['type'] ];

				}
			}

			// Get application locations and add to the CSV
			$locations = wp_get_object_terms( $app->ID, 'location' );
			if ( empty( $locations ) ) {
				$results[ $app->ID ]['locations'] = '';
				$row .= "\t";
			} else {
				$ls = '';
				// Locations are returned as an object, grab the name.
				foreach ( $locations as $l ) {
					$ls .= ', ' . htmlspecialchars_decode( $l->name );
				}

				$results[ $app->ID ]['locations'] = substr( $ls, 1 );
				$row .= "\t" . substr( $ls, 1 );
			}

			// Set List of Makers
			$makers = $form['m_maker_name'];

			// $makers can return an array, a single string or empty. Handle them as needed.
			if ( empty( $makers ) ) {
				$results[ $app->ID ]['list_of_makers'] = '';
				$row .= "\t";
			} else {
				$ls = '';
				// Process each maker into a string.
				foreach( $makers as $maker ) {
					$ls .= ', ' . htmlspecialchars_decode( $maker );
				}

				$results[ $app->ID ]['list_of_makers'] = substr( $ls, 2 );
				$row .= "\t" . substr( $ls, 2 );
			}
			
			// Take the $row variable we have been feeding each of our applications into in a variable called $body
			$body = substr( $row, 1) . "\r\n";
		}

		// Check if we are using this function to just return an array of our results.
		if ( $return_array )
			var_dump($results);
		
		// Get the time this export was ran. This is used in the file name of the CSV
		$time_offset = time() - ( 3600 * 7 );
		
		// var_dump($header);
		// var_dump($body);
		// Now that we have everything, return the data.
		// $this->output_csv( strtoupper( $export_type ) . '_APPLICATIONS_' . date( 'M-d-Y', $time_offset ) . '_' . date( 'G-i', $time_offset ), $header . $body );


		####### Original Export Tool from ISC #######
		// //EXPORT TYPE CHECK
		// if ( $export_type != 'all' && ! array_key_exists( $export_type, $this->fields ) )
		// 	return false;

		// $data  = array(
		// 	'status'              => '',
		// 	'form_type'           => '',
		// 	'project_id'          => '',
		// 	'project_name'        => '',
		// 	'public_description'  => '',
		// 	'private_description' => '',
		// 	'cats'                => '',
		// 	'tags'                => '',
		// 	'form_photo'          => '',
		// 	'uid'                 => '',
		// 	'user_photo'          => '',
		// 	'user_bio'            => ''
		// );

		// if ( $export_type == 'all' ) {	
		// 	$s = array( 's1' => array() );	
		// 	foreach( $this->fields as $type => $st ) { 
		// 		foreach( $st as $sn => $d ) {
		// 			$s['s1'] = array_merge( $s['s1'], $d );
		// 		}
		// 	}
		// } else {
		// 	$s = $this->fields[ $export_type ];
		// }
		
		// foreach( $s as $sn => $d ) {
		// 	foreach( $d as $key => $r ) {
		// 		$data[$key] = '';
				
		// 		if( 'm_maker_gigyaid' == $key ) {
		// 			for( $i=2; $i < 5; $i++ ) {
		// 				$data['m_maker_name_'.$i]    = '';
		// 				$data['m_maker_email_'.$i]   = '';
		// 				$data['m_maker_gigyaid_'.$i] = '';
		// 			}
		// 		} elseif( 'presenter_gigyaid' == $key ) {
		// 			for( $i=2; $i < 5; $i++ ) {
		// 				$data['presenter_name_'.$i]    = '';
		// 				$data['presenter_email_'.$i]   = '';	
		// 				$data['presenter_gigyaid_'.$i] = '';
		// 			}
		// 		}
		// 	}
		// }
		// 
		// $posts   = $this->get_all_forms( NULL, $status );
		// $efterms = $this->get_editflow_terms();
		// $efdata  = $this->get_editflow_data( $efterms );
		// $efdef   = array(
		// 	'checkbox' => 'No',
		// 	'data'     => 'N/A',
		// 	'text'     => ''
		// );

		// $res     = array();
		// $data    = array_keys( $data );

		// if( 'accepted' == $status ) {
		// 	array_splice( $data, 1, 0, 'accepted' );	
		// }

		// $header  = implode( "\t", $data );
		// $header  = strtoupper( str_replace( '_', ' ', $header ) );

		// foreach( $efterms as $efterm ) {
		// 	$header .= "\t".$efterm['name'];
		// }
		// $header .= "\tLocation";
		// $header .= "\tList of Makers";
		// $header .= "\r\n";

		// $body    = "";

		// foreach( $posts as $post ) {
		// 	$form = (array) json_decode( str_replace( "\'", "'", $post->post_content ) );

		// 	if ( $export_type != 'all' && $export_type != $form['form_type'] )
		// 		continue;

		// 	$form = array_merge( $form, array(
		// 		'status'     => $post->post_status,
		// 		'project_id' => $post->ID
		// 	) );
			
		// 	$line             = '';
		// 	$res[ $post->ID ] = array();
			
		// 	$multi = array( 
		// 		'm_maker_name', 
		// 		'm_maker_email', 
		// 		'm_maker_gigyaid', 
		// 		'presenter_name', 
		// 		'presenter_email', 
		// 		'presenter_gigyaid' 
		// 	);
			
		// 	//SET POST DATA
		// 	foreach( $data as $key ) {
		// 		$data_key = $key;
		// 		if( $mkey = $this->merge_fields( $key, $form['form_type'] ) )
		// 			$key = $mkey;

		// 		//BREAK UP MULTIPLE MAKERS/PRESENTERS
		// 		if( in_array( $data_key, $multi ) ) {
		// 			$d = is_array( $form[$key] ) ? $form[$key][0] : $form[$key]; 
					
		// 			$res[$post->ID][$data_key] = $d;
		// 			$line .= "\t".$d;
					
		// 			if( 'm_maker_gigyaid' == $data_key ) {
		// 				for( $i=1; $i < 4; $i++ ) {
		// 					foreach( array( 'm_maker_name', 'm_maker_email', 'm_maker_gigyaid' ) as $n ) {
		// 						$res[$post->ID][$n.'_'.( $i + 1 )] = $form[$n][$i];
		// 						$line .= "\t".$form[$n][$i];
		// 					}
		// 				}
		// 			} elseif( 'presenter_gigyaid' == $data_key ) {
		// 				for( $i=1; $i < 4; $i++ ) {
		// 					foreach( array( 'presenter_name', 'presenter_email', 'presenter_gigyaid' ) as $n ) {
		// 						$res[$post->ID][$n.'_'.( $i + 1 )] = $form[$n][$i];
		// 						$line .= "\t".$form[$n][$i];
		// 					}
		// 				}
		// 			}
		// 		//CATCH ALL
		// 		} elseif( 'accepted' == $key ) {
					
		// 			$log = get_post_meta( $post->ID, '_mf_log', true );

		// 			if( $log ) {
		// 				foreach( $log as $entry ) {
		// 					if( strpos( $entry, 'Accepted' ) !== false ) {
		// 						$entry_a = explode( ' ', $entry );
		// 						$line .= "\t".$entry_a[0]." ".$entry_a[1]." ". strtoupper( $entry_a[2] );
		// 						break;
		// 					}
		// 				}
		// 			} else {
		// 				$line .= "\tN/A";
		// 			}	
					
		// 		} elseif( isset( $form[$key] ) ) {
		// 			$d = is_array( $form[$key] ) ? implode( ',', $form[$key] ) : $form[$key];
					
		// 			$res[$post->ID][$data_key] = $d;
		// 			$line .= "\t".$d;
		// 		} else {
					
		// 			$is_multi = false;
		// 			foreach( $multi as $m ) {
		// 				for( $i=2; $i < 5; $i++ ) {
		// 					if( $data_key == $m.'_'.$i ) {
		// 						$is_multi = true;
		// 						break;	
		// 					}
		// 				}
		// 			}
					
		// 			if( !$is_multi ) {
		// 				$res[$post->ID][$data_key] = "";
		// 				$line .= "\t"."";
		// 			}
		// 		}
		// 	}

		// 	//SET EDITFLOW DATA	
		// 	foreach( $efterms as $efid => $efterm ) {
		// 		if ( isset( $efdata[ $post->ID ][ $efid ] ) ) {
		// 			$line .= "\t".$efdata[ $post->ID ][ $efid ];
		// 		} else {
		// 			$line .= "\t".$efdef[ $efterm['type'] ];
		// 		}
		// 	}
			
		// 	//SET LOCATIONS
		// 	$locations = wp_get_object_terms( $post->ID, 'location' );
		// 	if( empty( $locations ) ) {
		// 		$line .= "\t";
		// 	} else {
		// 		$ls = '';
		// 		foreach( $locations as $l ) {
		// 			$ls .= ','.htmlspecialchars_decode( $l->name );	
		// 		}
		// 		$line .= "\t".substr($ls, 1);
		// 	}


		// 	// Set List of Makers
		// 	$makers = $form['m_maker_name'];
		// 	if( empty( $makers ) ) {
		// 		$line .= "\t";
		// 	} else {
		// 		$ls = '';
		// 		foreach( $makers as $maker ) {
		// 			$ls .= ', '.htmlspecialchars_decode( $maker );
		// 		}
		// 		$line .= "\t".substr($ls, 2);
		// 	}
		// 	$body .= substr( $line, 1)."\r\n";
		// }

		// if ( $return_array )
		// 	return $res;
			
		// $time_offset = time() - ( 3600 * 7 );
		// $this->output_csv( strtoupper( $export_type ).'_APPLICATIONS_'.date('M-d-Y', $time_offset).'_'.date('G-i', $time_offset), $header.$body );
	}


	/* 
	* Associate all posts with EditFlow Data
	*
	* @access private
	* @param array $efterms An array of all EditFlow Terms/Types
	* @return array An Array of all posts associated with EditFlow Data
	* =====================================================================*/
	private function get_editflow_data( $efterms ) {

		global $wpdb;

		$term_list = '';
		foreach( $efterms as $meta_key => $term )
			$term_list .= ",'".sanitize_key( $meta_key )."'";

		$res = array();
		$pm  = $wpdb->get_results( $wpdb->prepare( "SELECT post_id, meta_key, meta_value FROM $wpdb->postmeta WHERE meta_key IN (".substr( $term_list, 1 ).") LIMIT 0,1999") );

		foreach( $pm as $data ) {
			if ( !isset( $res[ $data->post_id ] ) )
				$res[ $data->post_id ] = array();

			$value = $data->meta_value;

			switch( $efterms[ $data->meta_key ]['type'] ) {
				case 'checkbox' :
					$value = $value == 1 ? 'Yes' : 'No';
				break;
				case 'date' :
					$value = $value != 0 ? date('M d Y', $value) : 'N/A';
				break;
			}

			$res[ $data->post_id ][ $data->meta_key ] = $value;
		}

		return $res;
	}
	/*
	* Gets all EDITFLOW Terms and Types
	*
	* @access private
	* @return array An Array of all edit flow terms/types
	* =====================================================================*/
	private function get_editflow_terms() {

		$efterms = array();
		$terms   = get_terms( 'ef_editorial_meta', array( 'hide_empty' => false ) );

		foreach( $terms as $term ) {
			$properties = unserialize( base64_decode( $term->description ) );
			$efterms[ '_'.$term->taxonomy.'_'.$properties['type'].'_'.$term->slug ] = array_merge( (array) $term, $properties );
		}

		return $efterms;
	}
	/* 
	* Gathers and builds the output for all makers
	*
	* @access private
	* =====================================================================*/
	private function build_maker_export() {

		//NONCE CHECK
		if ( isset( $_GET['_wpnonce'] ) && !wp_verify_nonce( $_GET['_wpnonce'], 'mf_export_check' ) )
			return false;
		//CAP CHECK
		if ( !current_user_can( 'edit_others_posts' ) )
			return false;
			
		$posts  = $this->get_all_forms();
		$data   = array();
		
		$header = "Firstname\tLastname\tBio\tPhoto\tEmail\tStatus\tType\tID\tProject\tShort Description\tProject Website\tProject Video\tCategories\tTags\tGroup Name\tGroup Bio\tGroup Phone\tGroup Website\tOrganization\tJob Title\tPhone 1\tPhone 1 Type\tPhone 2\tPhone 2 Type\tOnsite Phone\tContact Firstname\tContact Lastname\tContact Email\tCity\tState\tZip\tCountry\r\n";
		
		foreach( $posts as $post ) {
			$form  = (array) json_decode( str_replace( "\'", "'", $post->post_content ) );
			
			$fname = substr( $form['name'], 0, strpos( $form['name'], ' ' ) )."\t";
			$lname = substr( $form['name'], strpos( $form['name'], ' ' ) + 1 )."\t";
			
			$line  = $fname.$lname; //FIRSTNAME & LASTNAME
			$line .= $form[$this->merge_fields( 'user_bio', $form['form_type'] )]."\t"; //BIO
			$line .= $form[$this->merge_fields( 'form_photo', $form['form_type'] )]."\t"; //PHOTO
			$line .= $form['email']."\t"; //EMAIL
			$line .= strtoupper( $post->post_status )."\t"; //STATUS
			$line .= strtoupper( $form['form_type'] )."\t"; //TYPE
			$line .= strtoupper( $post->ID )."\t"; //ID
			$line .= $form[$this->merge_fields( 'project_name', $form['form_type'] )]."\t"; //PROJECT NAME
			$line .= $form['public_description']."\t"; //SHORT DESCRIPTOIN
			$line .= $form[$this->merge_fields( 'project_wesbite', $form['form_type'] )]."\t"; //PROJECT WEBSITE
			$line .= $form[$this->merge_fields( 'project_video', $form['form_type'] )]."\t"; //PROJECT VIDEO
			$line .= ( isset( $form['categories'] ) && is_array( $form['categories'] ) ? implode( ',', $form['categories'] ) : "" )."\t"; //CATEGORIES
			$line .= ( isset( $form['tags'] ) && is_array( $form['tags'] ) ? implode( ',', $form['tags'] ) : "" )."\t"; //TAGS
			//GROUP DATA
			$line .= ( isset( $form['group_name'] )      ? $form['group_name'] : "" )."\t"; //GROUP NAME
			$line .= ( isset( $form['group_bio'] )       ? $form['group_bio'] : "" )."\t"; //GROUP BIO
			$line .= ( isset( $form['group_photo'] )     ? $form['group_photo'] : "" )."\t"; //GROUP PHOTO
			$line .= ( isset( $form['group_websit'] )    ? $form['group_website'] : "" )."\t"; //GROUP WEBSITE
			$line .= ( isset( $form['presenter_org'] )   ? $form['presenter_org'] : "" )."\t"; //ORG
			$line .= ( isset( $form['presenter_title'] ) ? $form['presenter_title'] : "" )."\t"; //JOB TITLE
			//CONTACT DATA
			$line .= $form['phone1']."\t"; //PHONE1
			$line .= $form['phone1_type']."\t"; //PHONE1 TYPE
			$line .= $form['phone2']."\t"; //PHONE2
			$line .= $form['phone2_type']."\t"; //PHONE2 TYPE
			$line .= ( isset( $form['onsite_phone'] ) ? $form['onsite_phone'] : "" )."\t"; //ONESITE PHONE
			$line .= $fname.$lname; //CONTACT FNAME & CONTACT LNAME
			$line .= $form['email']."\t"; //CONTACT EMAIL
			$line .= $form['private_city']."\t"; //CITY
			$line .= $form['private_state']."\t"; //STATE
			$line .= $form['private_zip']."\t"; //ZIP
			$line .= $form['private_country']; //COUNTRY
			
			$body .= $line."\r\n";
			
			foreach( array( 'exhibit' => 'm_maker_', 'presenter' => 'presenter' ) as $type => $prefix ) {
			
				if ( $form['form_type'] == $type && is_array( $form[$prefix.'name'] ) && is_array( $form[$prefix.'email'] ) ) {
					
					for( $i = 1; $i < count( $form[$prefix.'name'] ); $i++) {
	
						$add_fname = substr( $form[$prefix.'name'][$i], 0, strpos( $form[$prefix.'name'][$i], ' ' ) )."\t";
						$add_lname = substr( $form[$prefix.'name'][$i], strpos( $form[$prefix.'name'][$i], ' ' ) + 1 )."\t";
						
						$add_line  = str_replace( $fname.$lname, $add_fname.$add_lname, $line );						
						$add_line  = str_replace( $form[$prefix.'email'][$i], $form['email'],  $add_line );
						
						$body .= $add_line."\r\n";
					}
				}
			}
		}
		$time_offset = time() - ( 3600 * 7 );
		$this->output_csv( 'ALLMAKERS_'.date('M-d-Y', $time_offset).'_'.date('G-i', $time_offset), $header.$body );
	}
	/* 
	* Gathers and builds the output for EDITORIAL COMMENTS
	*
	* @access private
	* =====================================================================*/
	private function build_comments_export() {
		
		//NONCE CHECK
		if ( isset( $_GET['_wpnonce'] ) && !wp_verify_nonce( $_GET['_wpnonce'], 'mf_export_check' ) )
			return false;
		//CAP CHECK
		if ( !current_user_can( 'edit_others_posts' ) )
			return false;
		
		global $wpdb;
 
		$sql = "SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE  comment_type = 'editorial-comment' AND post_type='mf_form' ORDER BY comment_date_gmt DESC LIMIT 1999";
 
		$comments        = $wpdb->get_results( $sql );
		$output          = "Project ID\tProject Name\tUsers & Groups Flagged\tDate Timestamp\tUser Name\tComment Text\r\n";
		$following_users = array();
		
		foreach( $comments as $comment ) {
			
			if( isset( $following_users[ $comment->ID ] ) ) {
				$users = $following_users[ $comment->ID ];
			} else {
				$users = get_the_terms( $comment->ID, 'following_users' );
				$following_users[ $comment->ID ] = $users;
			}

			$user_list = "";
			foreach( $users as $user ) {
				$uo = get_user_by( 'login', $user->name );
				$user_list .= ", ".$uo->display_name;
			}
			
			$txt = str_replace( '"', '\'', iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $comment->comment_content ) );

			$line  = intval( $comment->ID )."\t";
			$line .= $comment->post_title."\t";
			$line .= substr( $user_list, 2 )."\t";
			$line .= $comment->comment_date."\t";
			$line .= $comment->comment_author."\t";
			$line .= '"'.$txt."\"\t";
			
			$output .= $line."\r\n";
		}

		$time_offset = time() - ( 3600 * 7 );
		$this->output_csv( 'EDITORIAL_COMMENTS_'.date('M-d-Y', $time_offset).'_'.date('G-i', $time_offset), $output );
	}
	/* 
	* Gathers and builds the output for PRESENTER EXPORTS
	*
	* @access private
	* =====================================================================*/
	private function build_presentation_exports( $type = 'manager' ) {
		
		//NONCE CHECK
		if ( isset( $_GET['_wpnonce'] ) && !wp_verify_nonce( $_GET['_wpnonce'], 'mf_export_check' ) )
			return false;
		//CAP CHECK
		if ( !current_user_can( 'edit_others_posts' ) )
			return false;

		//EXPORT TYPES
		if( $type == 'manager' ) {
			$output = "Start Time\tEnd Time\tDate\tLocation\tProject ID\tProject Name\tType\tFirst Name\tLast Name\tEmail\tPhone\tSpecial Requests\r\n";
			$title  = 'MANAGER_REPORT_';
		} elseif( $type == 'signage' ) {
			$output = "Location\tStart Time\tEnd Time\tDay\tProject Title\tPresenter Name(s)\r\n";
			$title  = 'STAGE_SIGNAGE_';
		} elseif( $type == 'checkin' ) {
			$output = "Presenter ID\tPresenter Last name\tPresenter First name\tProject Title\tLocation\tDate\tStart Time\tEnd Time\r\n";
			$title  = 'PRESENTER_CHECKIN_';
		} else {
			return false;
		}
		
		//GET PRESENTER FORMS
		$args = array(
			'posts_per_page' => 1999,
			'post_type' 	 => 'mf_form',
			'meta_query' 	 => array( array( 'key' => '_mf_form_type', 'value' => 'presenter' ) )
		);

		$ps    = new WP_Query($args);
		$forms = array();
		
		foreach( $ps->posts as $post ) {
			$forms[ $post->ID ] = $post;	
		}
		
		//GET EVENT ITEMS
		$mfeis = get_posts( array( 'post_type' => 'event-items', 'numberposts' => 1999 ) );

		//BUILD THE 3 FORMS
		foreach( $mfeis as $mfei ) {
			
			$data = get_post_custom( $mfei->ID );
			
			if( !isset( $forms[ $data['mfei_record'][0] ] ) )
				continue;

			$form  = (array) json_decode( str_replace( "\'", "'", $forms[ $data['mfei_record'][0] ]->post_content ) );
			$locs  = get_the_terms( $mfei->ID, 'location' );
			$locst = "";
			
			foreach( $locs as $loc ) {
				$locst .= ", ".$loc->name;
			}
			
			$locst = htmlspecialchars_decode( substr( $locst, 2 ) );
			
			$fname = substr( $form['name'], 0, strpos( $form['name'], ' ' ) );
			$lname = substr( $form['name'], strpos( $form['name'], ' ' ) + 1 );
			
			if( $type == 'manager' ) {
				
				if( !is_array( $form['presenter_name'] ) )
					$form['presenter_name'] = array( $form['presenter_name'] );
					
				$line = '';

				foreach( $form['presenter_name'] as $name ) {				
					$fname = substr( $name, 0, strpos( $name, ' ' ) );
					$lname = substr( $name, strpos( $name, ' ' ) + 1 );
				
					$line .= $data['mfei_start'][0]."\t";
					$line .= $data['mfei_stop'][0]."\t";
					$line .= $data['mfei_day'][0]."\t";
					$line .= $locst."\t";
					$line .= intval( $data['mfei_record'][0] )."\t";
					$line .= $form['presentation_name'] . "\t";
					$line .= "Presentation\t";
					$line .= $fname."\t";
					$line .= $lname."\t";
					$line .= $form['email']."\t";
					$line .= $form['phone1']."\t";
					$line .= '"'.$form['special_requests']."\"\r\n";				
				}
				
				$line = substr( $line, 0, -4 );
				
			} elseif( $type == 'signage' ) {
				$line  = $locst."\t";
				$line .= $data['mfei_start'][0]."\t";
				$line .= $data['mfei_stop'][0]."\t";
				$line .= $data['mfei_day'][0]."\t";
				$line .= $form['presentation_name']."\t";
				$line .= ( is_array( $form['presenter_name'] ) ? implode( ', ', $form['presenter_name'] ) : $form['presenter_name'] )."\t";
				
			} elseif( $type == 'checkin' ) {
				
				if( !is_array( $form['presenter_name'] ) )
					$form['presenter_name'] = array( $form['presenter_name'] );
				
				$line = '';

				foreach( $form['presenter_name'] as $name ) {				
					$fname = substr( $name, 0, strpos( $name, ' ' ) );
					$lname = substr( $name, strpos( $name, ' ' ) + 1 );
					
					$line .= intval( $data['mfei_record'][0] ) . "\t";
					$line .= $fname."\t";
					$line .= $lname."\t";
					$line .= $form['presentation_name']."\t";
					$line .= $locst."\t";
					$line .= $data['mfei_day'][0]."\t";
					$line .= $data['mfei_start'][0]."\t";
					$line .= $data['mfei_stop'][0]."\r\n";
				}
				
				$line = substr( $line, 0, -4 );
				
			} else {
				return false;
			}
			
			$output .= $line."\r\n";			 	
		}
		
		$time_offset = time() - ( 3600 * 7 );
		$this->output_csv( $title.date('M-d-Y', $time_offset).'_'.date('G-i', $time_offset), $output );
	
	}
	
	
	/*
	* Combines certain attributes into single for output
	*
	* @access private
	* @param string $key The key to look for
	* @param boolean|string $reverse The form type to reverse look up or false
	* =====================================================================*/
	private function merge_fields( $key, $reverse = false ) {
		$conv = array( 
			'project_name'     => array( 
				'exhibit'   => 'project_name', 
				'performer' => 'performer_name', 
				'presenter' => 'presentation_name' 
			),
			'form_photo'       => array( 
				'exhibit'   => 'project_photo', 
				'performer' => 'performer_photo', 
				'presenter' => 'presentation_photo'
			),
			'form_photo_thumb' => array( 
				'exhibit'   => 'project_photo_thumb', 
				'performer' => 'performer_photo_thumb', 
				'presenter' => 'presentation_photo_thumb'
			),
			'project_website'  => array( 
				'exhibit'   => 'project_website', 
				'performer' => 'performer_website', 
				'presenter' => 'presentation_website'
			),
			'project_video'    => array( 
				'exhibit'   => 'project_video', 
				'performer' => 'performer_video', 
				'presenter' => 'video'
			),
			'user_photo'       => array( 
				'exhibit'   => 'maker_photo', 
				'performer' => 'performer_photo', 
				'presenter' => 'presenter_photo' 
			),
			'user_photo_thumb' => array( 
				'exhibit'   => 'maker_photo_thumb', 
				'performer' => 'performer_photo_thumb', 
				'presenter' => 'presenter_photo_thumb' 
			),
			'user_bio'         => array( 
				'exhibit'   => 'maker_bio', 
				'performer' => 'private_description',
				'presenter' => 'presenter_bio' 
			),
		);

		if ( $reverse && isset( $conv[$key][$reverse] ) )
			return $conv[$key][$reverse];

		if ( $reverse && !isset( $conv[$key][$reverse] ) )
			return false;

		foreach( $conv as $conv_key => $conv_a) {
			if (  !$reverse && in_array( $key, $conv_a ) )
				return $conv_key;
		}

		return false;
	}
	/*
	* Sets CSV headers and outputs all data
	*
	* @access private
	* @param string $name The name of the ouput CSV
	* @param string $data The data to be in the CSV
	* =====================================================================*/
	private function output_csv( $name, $data ) {
		header( 'Content-Type: application/ms-excel' );
		header( 'Content-Disposition: attachment; filename=' . str_replace( ' ', '-', $name ) . '.xls' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );
		echo $data;
		exit();
	}
	/*
	* Get all posts with type mf_form
	*
	* @access private
	* @param string|null $sort Whether and how the forms should be sorted.
	* @param string $status The status of the application
	* @return array Maker Faire Forms
	* =====================================================================*/
	private function get_all_forms( $sort = NULL, $status = 'all', $args = array(), $faire = 'world-maker-faire-new-york-2013' ) {

		$defaults = array(
			'posts_per_page' => 1999,
			'post_type'      => 'mf_form',
			'faire'			 => $faire
		);

		$args = wp_parse_args( $args, $defaults );

		if( $status != 'all' )
      		$args['post_status'] = esc_attr( $status );

		$ps      = new WP_Query( $args );
		$posts   = $ps->get_posts();

		if ( is_null( $sort ) )
			return $posts;

		$res = array();

		foreach( $posts as $post ) {
			$form = (array) json_decode( str_replace( "\'", "'", $post->post_content ) );

			if ( ! isset( $form[$sort] ) ) {
				continue;
			} elseif ( ! isset( $res[ $form[ $sort ] ] ) ) {
				$res[ $form[ $sort ] ] = array();
			}

			foreach( $form as $key => $data ) {
				if($mkey = $this->merge_fields( $key ) )
					$form[$mkey] = $data;

				$form[ $key ] = is_array( $data ) ? implode( ',', $data ) : $data;
			}

			$res[ $form[ $sort ] ][ $post->ID ] = array_merge( 
				$form, array(
					'status'     => $post->post_status,
					'project_id' => $post->ID
				) ); 
		}

		return $res;
	}
	/*
	* Get all posts that have failed to sync with JDB
	*
	* @access private
	* @return array WP Posts
	* =====================================================================*/
	private function get_failed_syncs() {
		$args = array(
			'posts_per_page' => 1999,
			'post_type'      => 'mf_form',
			'meta_key'       => 'mf_jdb_sync_fail'
		);

		$ps      = new WP_Query( $args );
		$posts   = $ps->get_posts();
		
		return $posts;
	}
	/*
	* Determines if a field is textarea
	*
	* @access private
	* @param string $key The key to check
	* @return boolean If the key is a textarea
	* =====================================================================*/
	private function is_textarea( $key ) {
		$text_areas = array( 
			'public_description', 
			'private_description', 
			'food_details',
			'sales_details',
			'booth_size_details',
			'tables_chairs_details',
			'placement',
			'what_are_you_powering',
			'amps_details',
			'radio_detais',
			'safety_details',
			'maker_bio',
			'large_non_profit',
			'references',
			'anything_else',
			'equipment',
			'additional_info',
			'special_requests',
			'promotion' 
		);
		
		return in_array( (string) $key, $text_areas );
	}
	/*
	* Fix newlines saving improperly to at least display correctly.
	*
	* @access private
	* @param string $str String to search
	* @param string $replace The string to replace the bad characters with.
	* =====================================================================*/
	private function convert_newlines( $str, $replace = '<br />' ) {
		$s = array('nn-', ' nn', '.nn', '<br />rn');
		return str_replace($s, $replace, $str);
	}
	/*
	* Sync all MakerFiare Application Objects with External JDB
	*
	* @access private
	* @param int $id Post id to SYNC
	* =====================================================================*/
	private function sync_jdb( $id = 0 ) {
		
		//DONT SYNC FROM OUR SERVER
		if( $_SERVER['SERVER_ADDR_NAME'] == 'iscrackweb1' )
			return false;
	
		if( !$id ) {
			$posts = $this->get_all_forms();
		} else {
			$post  = get_post( $id ); 
			
			if( is_null( $post ) )
				return false;
			if( $post->post_type != 'mf_form' )
				return false;
			
			//ABORT SYNC IF IT HAS ALREADY HAPPENED
			$sync = get_post_meta( $id, 'mf_jdb_sync', true );
			
			if( $sync == '' )
				return false;
			
			$posts = array( $post );
		}
		
		$total = count( $posts );

		foreach( $posts as $post ) {
			
			$form = (array) json_decode( str_replace( "\'", "'", $post->post_content ) );
			$res  = wp_remote_post( 'http://ec2-23-22-142-64.compute-1.amazonaws.com/updateExhibitInfo', array( 'body' => array_merge( array( 'eid' => $post->ID, 'mid' => $form['uid'] ), (array) $form ) ) );
	
			if ( 200 == $res['response']['code'] ) {
				$body = json_decode( $res['body'] );
				if ( $body->exhibit_id == '' && $body->exhibit_id == 0 ) {
					update_post_meta( $post->ID, 'mf_jdb_sync_fail', time() );
				} else {
					update_post_meta( $post->ID, 'mf_jdb_sync', time() );
					delete_post_meta( $post->ID, 'mf_jdb_sync_fail' );
				}
			} else {
				update_post_meta( $post->ID, 'mf_jdb_sync_fail', time() );
			}
		}
		
		if( !$id )	
			update_option( 'mf_full_jdb_sync', date( 'M jS, Y g:s A', ( time() - ( 3600 * 7 ) ) ) );
	}
	/*
	* Sync MakerFiare Application Statuses
	*
	* @access private
	* @param int $id Post id to SYNC
	* @param string $status Post status
	* =====================================================================*/
	private function sync_status_jdb( $id = 0, $status = '' ) {

		$res = wp_remote_post( 'http://ec2-23-22-142-64.compute-1.amazonaws.com/updateExhibitStatusForJSON', array( 'body' => array( 'eid' => intval( $id ), 'status' => esc_attr( $status ) ) ) );	
		$er  = 0; 
		
		if ( 200 == $res['response']['code'] ) {
			$body = json_decode( $res['body'] );
			if ( 'ERROR' != $body->status ) {
				$er = time();
			}
		}
		
		update_post_meta( $id, 'mf_jdb_status_sync', $er );
		
		return $er;
	}
	/*
	* Sync MakerFiare Application Statuses
	*
	* @access private
	* @param int $offset Offset of posts to sync
	* @param int $length Length of sync batch
	* =====================================================================*/
	private function sync_all_status_jdb( $offset = 0, $length = 100 ) {
		
		$args = array(
			'posts_per_page' => intval( $length ),
			'offset'         => intval( $offset ),
			'post_type'      => 'mf_form'
		);

		$ps      = new WP_Query( $args );
		$posts   = $ps->get_posts();
		$success = 0;

		foreach( $posts as $post ) {
			$r = $this->sync_status_jdb( $post->ID, $post->post_status );	
			
			if( $r )
				$success++;
		}
		
		return $success;
	}
	
	/*
	* Updgrade plugin apporpriatly.
	*
	* @access private
	* =====================================================================*/
	private function upgrade() {
		global $wpdb;

		$opt = 'mf_plugin_version';
		$ver = get_option( $opt, 1 );
		
		//UPDATE POST STATUSES TO MATCH EDIT FLOW STATUSES
		if ( $ver < 2 )
		{
			$wpdb->update(
				$wpdb->posts,
				array( 'post_status' => 'proposed' ),
				array( 'post_status' => 'mf_complete' )
			);
	
			$wpdb->update(
				$wpdb->posts,
				array( 'post_status' => 'in-progress' ),
				array( 'post_status' => 'mf_pending' )
			);
			
			update_option( $opt, 2 );
		}
	}
}

$mfform = new MAKER_FAIRE_FORM();