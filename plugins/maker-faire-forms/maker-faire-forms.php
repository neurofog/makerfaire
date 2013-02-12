<?php
	
/*
Plugin Name: Maker Faire Form
Plugin URI: http://insourcecode.com
Description: Select the type of form and embed into post or page.
Version: 0.0.1
Author: inSourceCode
Author URI: http://insourcecode.com
License:  GPL2
*/

/* DEFINE MAKER_FAIRE_FORM CLASS
=====================================================================*/
class MAKER_FAIRE_FORM
{
	const GIGYA_API_KEY    = '3_nUMOBEBpLoLnfNUbwAo9FCwTqzd6vTjpVt3Ojd807EIT5IcF94eM9hoV8vcqjoe8';
	const GIGYA_SECRET_KEY = 'GlvZcbxIY6Oy7lnWJheh56DXj3wKAiG3yVqhv++VLZM=';
	
	var $fields = array(
			'exhibit'=>array(
				's1'=>array(
					'project_name'          => 1,
					'private_description'   => 1,
					'public_description'    => 1,
					'project_photo'         => 1,
					'project_photo_thumb'   => 0,
					'project_website'       => 0, 
					'project_video'         => 0,
					'food'                  => 1,
					'food_details'          => 0,
					'sales'                 => 0,
					'sales_details'         => 0,
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
					'safety_details'        => 0
					),
				's2'=>array(
					'email'               => 1,
					'name'                => 1,
					'maker'               => 1,
					
					'maker_name'          => 0,
					'maker_email'         => 0,
					'maker_photo'         => 0,
					'maker_photo_thumb'   => 0,
					'maker_bio'           => 0,
					
					'm_maker_name'        => 0,
					'm_maker_email'       => 0,
					'm_maker_photo'       => 0,
					'm_maker_photo_thumb' => 0,
					'm_maker_bio'         => 0,
					
					'group_name'          => 0,
					'group_bio'           => 0,
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
				's3'=>array(
					'org_type'             => 1,
                    'large_non_profit'     => 0,
					'supporting_documents' => 0,
					
					'references'           => 0,
					'referrals'            => 0,
					'hear_about'           => 0,
					'first_time'           => 0,
					'anything_else'        => 0				
				)
			),
			'performer'=>array(
				's1'=>array(
					'performer_name'        => 1,
					'private_description'   => 1,
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
					'guest_tickets'         => 1
				),
				's2'=>array(
					'email'            => 1,
					'name'             => 1,

					'phone1'           => 1,
					'phone1_type'      => 1,
					'phone2'           => 0,
					'phone2_type'      => 0,
					'onsite_phone'     => 1,
					
					'private_address'  => 1,
                    'private_address2' => 0, 
                    'private_city'     => 1,
                    'private_state'    => 0,
                    'private_zip'      => 0,
                    'private_country'  => 1
				),
				's3'=>array(
					'first_makerfaire' => 0,
                    'exhibit'          => 0,
					'promotion'        => 0,
                    'additional_info'  => 0
				)),
			'presenter'=>array(
				's1'=>array(
					'presentation_name'        => 1,
					'presentation_type'        => 1,
					'private_description'      => 1,
					'special_requests'         => 0,
					'public_description'       => 1,
					'presentation_photo'       => 1,
					'presentation_photo_thumb' => 0,
					'presentation_website'     => 0, 
					'video'                    => 0
				),
				's2'=>array(
					'email'                 => 1,
					'name'                  => 1,

					'phone1'                => 1,
					'phone1_type'           => 1,
					'phone2'                => 0,
					'phone2_type'           => 0,		
					'onsite_phone'          => 1,
					
					'presenter_name'        => 1,
					'presenter_email'       => 1,
					'presenter_bio'         => 1,
					'presenter_org'         => 0,
					'presenter_title'       => 0,
					'presenter_photo'       => 1,
					'presenter_photo_thumb' => 0,
					
					'private_address'       => 1,
                    'private_address2'      => 0, 
                    'private_city'          => 1,
                    'private_state'         => 0,
                    'private_zip'           => 0,
                    'private_country'       => 1
				),
				's3'=>array(
					'maker_ask'        => 0,
					'first_makerfaire' => 0,			
					'exhibit'          => 0,
					'promotion'        => 0,
                    'additional_info'  => 0
				)),
			'makerprofile'=>array()
		);
	
	var $maker_faire = '2013_bayarea';
	var $type        = 'exhibit';
	var $form        = array(
		'id'          => 0,
		'uid'         => 0,
		'maker_faire' => '2013_bayarea',
		'tags'        => array(),
		'cats'        => array());
	var $user;
	 

	/* __construct()
	@Description: Creates MAKER FAIRE FORM Class
	@Parameters: N/A
	@Returns: N/A
	=====================================================================*/
	public function __construct() 
	{
		add_action('init', 		 					array(&$this, 'init'));	
		add_action('admin_init', 		 			array(&$this, 'admin_init'));
		add_action('add_meta_boxes', 	            array(&$this, 'add_meta_boxes'));	
		
		add_shortcode('mfform', 					array(&$this, 'shortcode_handler'));
		
		add_action('wp_ajax_nopriv_mfform_step', 	array(&$this, 'ajax_handler'));  
  	 	add_action('wp_ajax_mfform_step', 			array(&$this, 'ajax_handler'));  
		
		add_action('wp_ajax_nopriv_mfform_getforms',array(&$this, 'ajax_getforms'));  
  	 	add_action('wp_ajax_mfform_getforms', 		array(&$this, 'ajax_getforms')); 
		
		if(!is_admin())
		{
			add_action( 'wp_enqueue_scripts',       array(&$this, 'enqueue'));	
		}
	}
	
	
	/* init()
	@Description: Hooks into WP INIT to register post type
	@Parameters: N/A
	@Returns: N/A
	=====================================================================*/
	public function init() 
	{
		$labels = array('name' => _x('Maker Faire Bay Area 2013 Applications', 'post type general name'),
						'singular_name' => _x('Applications', 'post type singular name'),
						'add_new' => _x('Add Applications', 'mf_form'),
						'add_new_item' => __('Add New Applications'),
						'edit_item' => __('Edit Applications'),
						'new_item' => __('New Applications'),
						'all_items' => __('All Applications'),
						'view_item' => __('View Applications'),
						'search_items' => __('Search Applications'),
						'not_found' =>  __('No forms found'),
						'not_found_in_trash' => __('No forms found in Trash'), 
						'parent_item_colon' => '',
						'menu_name' => __('Applications'));
		
		$args =   array('labels' => $labels,
						'public' => false,
						'publicly_queryable' => false,
						'show_ui' => true, 
						'show_in_menu' => true, 
						'query_var' => true,
						'capability_type' => 'post',
						'has_archive' => false, 
						'hierarchical' => true,
						'menu_position' => null,
						'menu_icon'=> plugins_url( 'assets/i/admin-icon.png', __FILE__ ),
						'supports' => false); 
		
		//REGISTER MF FORM CUSTOM POST TYPE
		register_post_type('mf_form', $args);
		
		//REGISTER MF FORM STATUS - PENDING
		register_post_status('mf_pending', array(
			'label'                     => _x( 'In Progress', 'mf_form' ),
			'public'                    => true,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'In Progress <span class="count">(%s)</span>', 'In Progress <span class="count">(%s)</span>' ),
		));
		
		//REGISTER MF FORM STATUS - COMPLETE
		register_post_status('mf_complete', array(
			'label'                     => _x( 'Proposed', 'mf_form' ),
			'public'                    => true,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Proposed <span class="count">(%s)</span>', 'Proposed <span class="count">(%s)</span>' ),
		));
	}
	
	/* admin_init()
	@Description: Hooks into WP ADMIN INIT to register post type
	@Parameters: N/A
	@Returns: N/A
	=====================================================================*/
	public function admin_init() 
	{
		//ADD COLUMNS TO MF FORM SUBMISSION LIST
		add_filter('manage_mf_form_posts_columns',         array(&$this, 'columns'));
		add_filter('manage_edit-mf_form_sortable_columns', array(&$this, 'columns_sortable'));
		add_action('manage_mf_form_posts_custom_column',   array(&$this, 'custom_columns'), 10, 2);

		
		//REMOVE ABILITY TO EDIT FORM
		remove_meta_box('submitdiv', 'mf_form', 'side');
	}
	
	/* columns()
	@Description: Add Custom Columns to MF FORM LIST
	@Parameters: $cs | init columns
	@Returns: N/A
	=====================================================================*/
	public function columns( $cs ) 
	{
		unset(
			$cs['author'],
			$cs['title'],
			$cs['date']
		);

		$ncs = array(  
			'id'     => 'ID',		 
			'title'  => 'Project Name',
			'maker'  => 'Maker',
			'type'   => 'Application Type',
			'status' => 'Status',
			'date'   => 'Date',
		);
		return array_merge($cs, $ncs);
	}
	
	/* columns_sortable()
	@Description: Add Custom Sortable Columns to MF FORM LIST
	@Parameters: $cs | init columns
	@Returns: N/A
	=====================================================================*/
	public function columns_sortable( $cs ) 
	{
		$cs['id'] ='ID';
		
		return $cs;
	}
	
	/* custom_columns()
	@Description: Populate Custom Columns with Data
	@Parameters: $c | columns, $pid | POST ID
	@Returns: N/A
	=====================================================================*/
	public function custom_columns( $c, $pid ) 
	{
		global $post;
		$data = json_decode(str_replace("\'", "'", $post->post_content)); 

		switch ( $c ) 
		{
			case 'id':
				echo '<strong>'.intval($pid).'</strong>';
				break;
			case 'type':
				echo '<strong>'.esc_html(strtoupper($data->form_type)).'</strong>';
				break;
			case 'maker':
				echo esc_html($data->name);
				break;
			case 'status':
				echo '<strong>'.esc_html(($post->post_status == 'mf_pending' ? 'IN PROGRESS' : 'PROPOSED')).'</strong>';
				break;
		}
	}
	
	/* add_meta_boxes()
	@Description: Add MF FORM Meta Box to Edit Screen
	@Parameters: N/A
	@Returns: N/A
	=====================================================================*/
	public function add_meta_boxes() 
	{
		add_meta_box('mf_form_data', 'Form Fields', array( &$this, 'meta_box' ), 'mf_form', 'normal', 'default');	
	}
	
	/* meta_box()
	@Description: Builds Editor Meta Boxes
	@Parameters: $post | POST
	@Returns: N/A
	=====================================================================*/
	public function meta_box($post) 
	{ 
	
		$data = json_decode(str_replace("\'", "'", $post->post_content)); ?>
		<table class="wp-list-table widefat fixed posts">
        	<thead>
            	<tr style="background:#FFF;">
                	<td><strong>FORM FIELD</strong></td>
                    <td><strong>USER INPUT</strong></td>
                </tr>
            </thead>
            <tbody>
        	<?php foreach($data as $k=>$v) : if(strpos($k, '_thumb') !== false) continue;
			
					if(($k == 'tags' || $k == 'cats' || $k == 'radio_frequency' || $k == 'booth_options') && is_array($v)) :
						$esc_v = esc_html(implode(', ', $v));
						
					elseif($k == 'presenter_name') :
					
						for($i = 0; $i < count((array)$v); $i++) :
							foreach(array('presenter_name','presenter_email','presenter_bio','presenter_org','presenter_title','presenter_photo') as $j=>$pk) : if($i && $j > 1) continue; ?>
								<tr>
									<td><strong><?php echo esc_html(strtoupper(str_replace('_', ' ', $pk)).'['.($i + 1).']'); ?></strong></td>
									<td><?php echo $pk != 'presenter_photo' ? esc_html($data->{$pk}[$i]) : '<a href="'.esc_url($data->{$pk}).'">'.esc_url($data->{$pk}).'</a>'; ?></td>
								</tr>				
			<?php endforeach; endfor; continue;
						
					elseif($k == 'm_maker_name') :
						for($i = 0; $i < count((array)$v); $i++) :
							foreach(array('m_maker_name','m_maker_email','m_maker_bio','m_maker_photo') as $j=>$pk) :  if($i && $j > 1) continue; (array)$data->{$pk}; ?>
								<tr>
									<td><strong><?php echo esc_html(strtoupper(str_replace(array('m_', '_'), array('', ' '), substr($pk, 2))).'['.($i + 1).']'); ?></strong></td>
									<td><?php echo $pk != 'm_maker_photo' ? esc_html($data->{$pk}[$i]) : '<a href="'.esc_url($data->{$pk}).'">'.esc_url($data->{$pk}).'</a>'; ?></td>
								</tr>				
			<?php endforeach; endfor; continue;
						
					elseif(in_array($k, array('m_maker_name','m_maker_email','m_maker_bio','m_maker_photo','presenter_name','presenter_email','presenter_bio','presenter_org','presenter_title','presenter_photo'))) :
						continue;						
					else :
						$esc_v = strpos($v, 'http://') === false ? esc_html($v) : '<a href="'.esc_url($v).'">'.esc_url($v).'</a>';
					endif; ?>                  
                    <tr>
                        <td><strong><?php echo esc_html(strtoupper(str_replace('_', ' ', $k))); ?></strong></td>
                        <td><?php echo $esc_v; ?></td>
                    </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            	<tr style="background:#FFF;">
                	<td><strong>FORM FIELD</strong></td>
                    <td><strong>USER INPUT</strong></td>
                </tr>
            </tfoot>
        </table>
    <?
	}
	
	/* shortcode_handler()
	@Description: Builds Form From Shortcode
	@Parameters: $atts | shortcode attributes
	@Returns: N/A
	=====================================================================*/
	public function shortcode_handler( $atts ) 
	{
		foreach($atts as $k=>$v)
			if(isset($this->fields[$v])) //Check and Allow only White Labeled Attributes and Values
				$this->{$k} = $v;
		
		//Only allow forms that exist in folder
		if(!file_exists(plugin_dir_path(__FILE__).'forms/'.$this->type.'.php'))
			return '';

		ob_start();
		
		if($this->type == 'makerprofile')
		{
			$forms = $this->getforms();
			include(plugin_dir_path(__FILE__).'forms/makerprofile.php'); 
		}
		else
		{			
			//GET FORM BY ID
			if(isset($_GET['id']))
			{
				$p = get_post($_GET['id']);

				if($p->post_type = 'mf_form')
				{
					$frm = json_decode(str_replace("\'", "'", $p->post_content));
					if($frm->form_type != $this->type || $frm->maker_faire != $this->maker_faire)
						unset($frm);
				}
			}
			
			//SET DEFAULT VALUES
			foreach($this->fields[$this->type] as $sn=>$s)
				foreach(array_keys($s) as $k)
				{
					$v = isset($frm) && isset($frm->$k) ? $frm->$k : '';

					if(gettype($v) == 'object')
						$v = (array)$v;
					elseif(gettype($v) == 'array')
						$v = (array)$v;

					if($v == '' && $k == 'private_country')
						$v = 'US';	
					elseif($v == '' && in_array($k, array('presenter_bio', 'presenter_org', 'presenter_title', 'm_maker_bio')))
						$v = array('');
					
					$this->form['data['.$sn.']['.$k.']'] = $v;
				}
			
			//SET SOME GENERIC VALUES
			if(isset($frm))
			{
				$this->form['id']          = $p->ID;
				$this->form['maker_faire'] = $frm->maker_faire;			
				
				foreach($frm->tags as $t)
					$this->form['tags'][] = $t;
					
				foreach($frm->cats as $c)
					$this->form['cats'][] = $c;
			}

			//Show Requested Form
			include(plugin_dir_path(__FILE__).'forms/'.$this->type.'.php'); 
		}
		
		$c = ob_get_contents();
		
		ob_end_clean();	
	
		return $c;
	}
	
	/* ajax_getforms()
	@Description: Grabs all the forms submitted by this user
	@Parameters:
	@Returns: N/A
	=====================================================================*/
	public function getforms()
	{	
		$args = array(
			'post_type'  => 'mf_form',
			'meta_query' => array(
				'relation' => 'OR',
				array('key' => 'mf_gigya_id',        'value' => sanitize_text_field($_GET['uid'])),
				array('key' => 'mf_additional_user', 'value' => sanitize_text_field(urldecode($_GET['e'])))
			)
		);

		$q = new WP_Query($args);		
		$f = array('exhibit'=>array(), 'presenter'=>array(), 'performer'=>array());

		foreach($q->posts as $p)
		{
			$d = json_decode(str_replace("\'", "'", $p->post_content));
			$p->data = $d;
			$f[$d->form_type][$p->ID] = $p;
		}
		
		return $f;
	}
	
	/* ajax_handler()
	@Description: Handle Ajax Calls from the Form Step Process
	@Parameters:
	@Returns: N/A
	=====================================================================*/
	public function ajax_handler() 
	{	
		//POTENTIAL FILES TO BE UPLOADED
		$files  = array(
			'exhibit'=>array(
				's1'=>array('project_photo', 'layout'),
				's2'=>array('maker_photo', 'm_maker_photo', 'group_photo'), 
				's3'=>array('supporting_documents')),
			'performer'=>array(
				's1'=>array('performer_photo')),
			'presenter'=>array(
				's1'=>array('presentation_photo'), 
				's2'=>array('presenter_photo')));
		
		//ALL FIELDS FOR ALL 3 FORMS - BINARY IF FIELD IS REQUIRED OR NOT
		$errors = array();
		$res    = array(
			'form_type'   => sanitize_text_field($_POST['form']),
			'maker_faire' => sanitize_text_field($_POST['maker_faire']),
			'uid'         => sanitize_text_field($_POST['uid']),
			'tags'        => array(),
			'cats'        => array()
		);

		
		/****************************************/
		/*  ERROR CHECK FORM SPECIFIC SITUATIONS
		/****************************************/
		
		//EXHIBIT STEP 1
		if($_POST['form'] == 'exhibit' && $_POST['step'] == 1)
		{
			if(isset($_POST['data']['s1']['booth_size']) && $_POST['data']['s1']['booth_size'] == 'Other')
				$this->fields['exhibit']['s1']['booth_size_details'] = 1;
				
			if(isset($_POST['data']['s1']['power']) && $_POST['data']['s1']['power'] == 'Yes' && isset($_POST['data']['s1']['amps']) && $_POST['data']['s1']['amps'] == 'special')
				$this->fields['exhibit']['s1']['amps_details'] = 1;
				
			if(isset($_POST['data']['s1']['hands_on']) && $_POST['data']['s1']['hands_on'] == 'Yes')
				$this->fields['exhibit']['s1']['safety_details'] = 1;
		}
		//EXHIBIT STEP 2
		elseif($_POST['form'] == 'exhibit' && $_POST['step'] == 2)
		{
			if(isset($_POST['data']['s2']['maker']) && $_POST['data']['s2']['maker'] == 'One maker')
				$this->fields['exhibit']['s2']['maker_name'] = $this->fields['exhibit']['s2']['maker_email'] = $this->fields['exhibit']['s2']['maker_photo'] = $this->fields['exhibit']['s2']['maker_bio'] = 1;
			if(isset($_POST['data']['s2']['maker']) && $_POST['data']['s2']['maker'] == 'A list of makers')
				$this->fields['exhibit']['s2']['m_maker_name'] = $this->fields['exhibit']['s2']['m_maker_email'] = $this->fields['exhibit']['s2']['m_maker_photo'] = $this->fields['exhibit']['s2']['m_maker_bio'] = 1;
			if(isset($_POST['data']['s2']['maker']) && $_POST['data']['s2']['maker'] == 'A group or association')
				$this->fields['exhibit']['s2']['group_name'] = $this->fields['exhibit']['s2']['group_photo'] = $this->fields['exhibit']['s2']['group_bio'] = 1;
		}
		//PERFORMER STEP 1
		elseif($_POST['form'] == 'performer' && $_POST['step'] == 1)
		{
			if(isset($_POST['data']['s1']['compensation_type']) && strpos($_POST['data']['s1']['compensation_type'], '$') !== false)
				$this->fields['performer']['s1']['compensation'] = 1;
		}

		/****************************************/
		/*  ERROR CHECK GENERIC 
		/****************************************/
		foreach($files[$_POST['form']]['s'.$_POST['step']] as $n)
		{
			if($this->fields[$_POST['form']]['s'.$_POST['step']][$n] && !isset($_FILES[$n]) && !isset($_POST['data']['s'.$_POST['step']][$n]))
				$errors['s'.$_POST['step']][$n] = 'Photo Required.';	
		}


		foreach($this->fields[$_POST['form']] as $s=>$f)
		{
			foreach($f as $k=>$r)
			{
				$v = isset($_POST['data'][$s][$k]) ? $_POST['data'][$s][$k] : '';
				
				if(is_array($v))
					$v = array_values($v);
				
				//CHECK ERRORS ON THIS STEP ONLY
				if($s == 's'.$_POST['step'])
				{				
					//FILE UPLOAD ERROR CHECK
					if(is_array($v))
					{
						foreach($v as $i=>$av)
						{
							if($r && !in_array($k, $files[$_POST['form']][$s]) && $av == '') //Empty / Not Set / Blank
								$errors[$s][$k][$i] = 'Required.';
							elseif($r && strpos($k, 'email') !== false && !is_email($av))  //Check Email
								$errors[$s][$k][$i] = 'Valid Email Required.';
						}
					}
					elseif($r && !in_array($k, $files[$_POST['form']][$s]) && $v == '') //Empty / Not Set / Blank
						$errors[$s][$k] = 'Required.';
					elseif(($k == 'public_description' && strlen($v) > 255) || ($k == 'bio' && strlen($v) > 200))  //Input too many characters.
						$errors[$s][$k] = 'Too Long.';
					elseif($r && $k == 'email' && !is_email($v))  //Check Email
						$errors[$s][$k] = 'Valid Email Required.';
					//elseif(($k == 'zip' || $k == 'private_zip') && !$this->is_zip($v))  //Check Zip
						//$errors[$s][$k] = 'Valid Zip Required.';
//					elseif(($k == 'phone1' || $k == 'onsite_phone') && !$this->is_phone($v))  //Check Phone
//						$errors[$s][$k] = 'Valid Phone Please.';
					elseif($r && $k == 'compensation' && !is_numeric($v))  //Check Value
						$errors[$s][$k] = 'Number Required.';
				}
				
				//SPECIAL DATA FORMATS
				if($k == 'equipment') //Make Sure NewLines are Preserved on Equipment List
					$v = nl2br($v);
				
				//SANATIZE ALL DATA
				$res[$k] = wp_filter_post_kses($v);
			}	
		}
		
		if(isset($_POST['radio_frequency']))
			foreach($_POST['radio_frequency'] as $rf)
				$res['radio_radio_frequency'][] = $rf;
		
		if(isset($_POST['tag']))
			foreach($_POST['tag'] as $t)
				$res['tags'][] = $t;
			
		if(isset($_POST['cat']))	
			foreach($_POST['cat'] as $c)
				$res['cats'][] = $c;

		//IF THERE ARE ERRORS DIE WITH ERRORS
		if(!empty($errors))
			die(json_encode(array('status'=>'ERROR', 'errors'=>$errors)));

		$file_res = $thumbs_res = array();

		//ERROR CHECK AND UPLOAD FILES
		foreach($files[$_POST['form']]['s'.$_POST['step']] as $n)
		{			
			if(empty($errors) && ((isset($_POST[$n]) && $_POST[$n] != '') || isset($_FILES[$n])))
			{
				if(isset($_FILES[$n]) && $_FILES[$n]['name'] != '')
				{
					if($r = $this->upload($_FILES[$n], !in_array($n, array('layout', 'supporting_documents'))))
					{
						$file_res[$n]     = $r['url'];
						$thumbs_res[$n]   = $r['thumb'];
						$res[$n]          = $r['url'];
						$res[$n.'_thumb'] = $r['thumb'];
					}
					else
						$errors['s'.$_POST['step']][$n] = 'Valid 500px or Wider Image Required.';
				}
			}
			elseif(empty($errors) && $res[$n] == '' && $this->fields[$_POST['form']]['s'.$_POST['step']][$n])
			{
				$errors['s'.$_POST['step']][$n] = 'Photo Required.';	
			}
		}

		//IF THERE ARE ERRORS DIE WITH ERRORS
		if(!empty($errors))
			die(json_encode(array('status'=>'ERROR', 'errors'=>$errors)));
		
		//IF THERE ARE NO ERRORS SAVE AND DIE WITH ID
		if(isset($_POST['id']) && $_POST['id'])
			$id = $this->update_mf_form($_POST['form'], $_POST['id'], $res, $_POST['step']);
		else
			$id = $this->create_mf_form($res, $_POST['form']);
			
		die(json_encode(array('status'=>'OK', 'id'=>$id, 'files'=>$file_res, 'thumbs'=>$thumbs_res)));
	}
	
	/* upload()
	@Description: Upload images / documents and save as WP attachments
	@Parameters: $ufile | upload file
	@Returns: array(attachment_id, file_url)
	=====================================================================*/
	private function upload($ufile, $require_size)
	{
		if (!function_exists( 'wp_handle_upload')) 
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			
		$info = pathinfo($ufile['name']); 
		if(!in_array(strtolower($info["extension"]), array('jpg', 'jpeg', 'gif', 'png', 'doc', 'docx', 'pdf', 'ai', 'psd')))
			return false;
	
		if($require_size)
		{
			list($w, $h) = getimagesize($ufile['tmp_name']);	

			if($w < 500)
				return false;
		}
		
		$overrides = array( 'test_form' => false );
		$file      = wp_handle_upload($ufile, $overrides);
		
		if(!$file)
			return false;

		$wp_upload_dir = wp_upload_dir();
		
		$attachment = array(
			'guid'           => $file['url'], 
			'post_mime_type' => $file['type'],
			'post_title'     => preg_replace('/\.[^.]+$/', '', basename($ufile['name'])),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
		
		//CREATE THUMBNAIL
		$thumb = image_make_intermediate_size($file['file'], 500, 500); 
		
		$attach_id = wp_insert_attachment($attachment, $file['file']);

		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata($attach_id, $ufile['name']);
		
		wp_update_attachment_metadata($attach_id, $attach_data);
		
		return array('id'=>$attach_id, 'url'=>$file['url'], 'thumb'=>($thumb ? $wp_upload_dir['url'].'/'.$thumb['file'] : $file['url']));
	}
	
	
	/* create_mf_form()
	@Description: Create MF FORM POST TYPE
	@Parameters: $r | All input data
	@Returns: post ID
	=====================================================================*/
	private function create_mf_form($r, $t)
	{
		$n = $r['form_type'] == 'exhibit' ? $r['project_name'] : ($r['form_type'] == 'performer' ? $r['performer_name'] : $r['presentation_name']);
		
		$d = array(
			'post_author'  => 0,
			'post_content' => json_encode($r),
			'post_title'   => $n,
			'post_status'  => 'mf_pending',
			'post_type'    => 'mf_form'
		);

		$pid = wp_insert_post( $d );
		
		update_post_meta($pid, 'mf_gigya_id', $r['uid']);
		
		return $pid;
	}
	
	/* update_mf_form()
	@Description: UDPATE Form Data
	@Parameters: $id | post id, $r | All input data, $s | form step
	@Returns: post ID
	=====================================================================*/
	private function update_mf_form($t, $id, $r, $s)
	{
		$n = $r['form_type'] == 'exhibit' ? $r['project_name'] : ($r['form_type'] == 'performer' ? $r['performer_name'] : $r['presentation_name']);
		
		$d = array(
			'ID'           => $id,
			'post_content' => json_encode($r),
			'post_title'   => $n,
		);
		
		//SUBMIT FINAL FORM
		if($s == 4)
		{
			$d['post_status'] = 'mf_complete';
			$emails           = $r['form_type'] == 'exhibit' ? array_slice($r['m_maker_email'], 1) : ($r['form_type'] == 'presenter' ? array_slice($r['presenter_email'], 1) : array());
			
			foreach($r as $k=>$v)
				if(is_array($v))
					$r[$k] = implode(', ', $v);

			//SYNC WITH MAKE DB
			$res = wp_remote_post('http://makedb.makezine.com/updateExhibitInfo', array('body'=>array_merge(array('eid'=>$id, 'mid'=>$r['uid']), (array)$r)));
		
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));

			$i = '';
			foreach($r as $k=>$v)
			{
				$v  = is_array($v) ? implode(', ', $v) : $v;
				$i .= '<tr><td><strong>' . ucwords(str_replace("_"," ",$k)) . '</strong></td><td>'.$v.'</td></tr>';
			}

			//SEND CONFIRMATION EMAIL TO MAKER
			$this->send_maker_email($r, $i, $n);
			
			//SEND EMAILS TO ADDITIONAL USERS
			if($r['form_type'] == 'exhibit' || $r['form_type'] == 'presenter')
			{
				if(!empty($emails))
				{
					foreach($emails as $e)
						add_post_meta($id, 'mf_additional_user', $e);
					$this->send_maker_invite_email($id, $emails, $r, $i, $n);						
				}
			}
		}
		
		return wp_update_post( $d ); 
	}
	
	/* send_maker_email()
	@Description: Send Confirmation Email to Maker
	@Parameters: $r | all form data, $n | Form Name
	@Returns: boolean | email sent successfully
	=====================================================================*/
	private function send_maker_email($r, $i, $n) 
	{
		$m = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body><p>Dear ' . ucfirst($r['name']) .',</p><br /><p>Thanks for your interest in participating in Maker Faire! Your application has been received.</p><br /><p>You can update your application anytime until the application deadline - just login to your maker account from makerfaire.com. On your profile page, you\'ll see a link to edit any applications you\'ve started or finished and submitted. You\'ll hear from us shortly after the application deadline. If we accept your application, we\'ll do our best to accommodate all your requests but can\'t guarantee it. Details will be confirmed in a follow-up letter after acceptance.</p><br /><p>Your Application: </p><br /><table style="font-family: Verdana,sans-serif; font-size: 11px; color: #374953; width: 600px;"><thead><tr style="background:#FFF;"><td><strong>FORM FIELD</strong></td><td><strong>USER INPUT</strong></td></tr></thead><tbody>'.$i.'</tbody></table></body></html>';

		return wp_mail($r['email'], 'Maker Faire ' . ucfirst($r['form_type']) . ' Application Received: ' . $n, $m, 'From: Maker Faire <makers@makerfaire.com>' . '\r\n');
	}
	/* send_maker_invite_email()
	@Description: Send Confirmation Email to Maker
	@Parameters: $r | all form data, $n | Form Name
	@Returns: boolean | email sent successfully
	=====================================================================*/
	private function send_maker_invite_email($id, $emails, $r, $i, $n) 
	{		
		$m = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body><p>Thanks for your interest in participating in Maker Faire Bay Area 2013!</p><br /><p>'.ucwords($r['name']).' has submitted an application and indicated you were part of their exhibit or presentation. We need you to create a maker account at <a href="'.home_url().'/?register=1" alt="Maker Faire">makerfaire.com</a> and provide some additional details that we can include about you.</p><br /><p>Spread the word - Like us on <a href="http://facebook.com/makerfaire" alt="Like Maker Faire Facebook">Facebook</a> and follow us on <a href="https://twitter.com/#%21/makerfaire" alt="Follow Maker Faire Twitter">Twitter</a> and <a href="https://plus.google.com/+MAKE/posts" alt="Maker Faire Google+">G+</a></p><p>Your Application: </p><br /><table style="font-family: Verdana,sans-serif; font-size: 11px; color: #374953; width: 600px;"><thead><tr style="background:#FFF;"><td><strong>FORM FIELD</strong></td><td><strong>USER INPUT</strong></td></tr></thead><tbody>'.$i.'</tbody></table></body></html>';

		return wp_mail($emails, 'Maker Faire Application: '.$id.': ' . $n, $m, array('From: Maker Faire <makers@makerfaire.com>','Bcc: Maker Faire <makers@makerfaire.com>'));
	}
	
	/* is_phone()
	@Description: Phone Validator
	@Parameters: $phone | phone number
	@Returns: boolean | is phone
	=====================================================================*/
	private function is_phone($phone) 
	{
		$phone = preg_replace('/[^0-9]/', '', $phone);
		
		return strlen($phone) == 10 || strlen($phone) == 11;
	}
	
	/* is_zip()
	@Description: Zip Validator
	@Parameters: $zip | zip code
	@Returns: boolean | is zip
	=====================================================================*/
	private function is_zip($zip) 
	{
		return preg_match('/^[0-9]{5}(-[0-9]{4}){0,1}$/', $zip);
	}
		
	/* text()
	@Description: Build text field
	@Parameters: $n | field name, $attr | input attributes
	@Returns: N/A
	=====================================================================*/
	public function text($n, $attr = array()) 
	{ ?>
		<input type="text" name="<?php echo esc_attr($n); ?>" value="<?php echo esc_attr($this->form[$n]); ?>" <?php foreach($attr as $a=>$av) : echo esc_html($a);?>="<?php echo esc_attr($av); ?>" <?php endforeach;?> />
<?php
	}
	
	/* radio()
	@Description: Build radio inputes
	@Parameters: $n | field name, $set | array of radio inputs
	@Returns: N/A
	=====================================================================*/
	public function radio($n, $set) 
	{ 
		foreach($set as $k=>$v) : $k = is_numeric($k) ? $v : $k; ?>
        <div><input name="<?php echo esc_attr($n); ?>" type="radio" value="<?php echo esc_attr($k); ?>" <?php checked($k, $this->form[$n]); ?> /> <?php echo esc_html($v); ?></div>
<?php	endforeach;
	}
	
	/* checkbox()
	@Description: Build checkbox inputes
	@Parameters: $n | field name, $set | array of checkbox inputs
	@Returns: N/A
	=====================================================================*/
	public function checkbox($n, $set) 
	{ 
		foreach($set as $k=>$v) : $k = is_numeric($k) ? $v : $k; ?>
        <div><input name="<?php echo esc_attr($n); ?>[]" type="checkbox" value="<?php echo esc_attr($k); ?>" <?php checked(in_array($v, $this->form[$n])); ?> /> <?php echo esc_html($v) ?></div>
<?php	endforeach;
	}
	
	
	/* textarea()
	@Description: Build text field
	@Parameters: $n | field name, $attr | input attributes
	@Returns: N/A
	=====================================================================*/
	public function textarea($n, $attr = array()) 
	{ ?>
		<textarea name="<?php echo esc_attr($n); ?>" <?php foreach($attr as $a=>$av) : echo esc_html($a); ?>="<?php echo esc_attr($av); ?>" <?php endforeach;?>><?php echo esc_html($this->form[$n]); ?></textarea>
<?php 
	}
	
	/* select()
	@Description: Build select input
	@Parameters: $n | field name, $set | array of select options
	@Returns: N/A
	=====================================================================*/
	public function select($n, $set) 
	{ ?>
		<select name="<?php echo esc_attr($n); ?>">
        	<option value="">-- Select One</option>
			<?php foreach($set as $v=>$lbl) : ?>
                <option value="<?php echo esc_attr($v); ?>" <?php selected($v, $this->form[$n]); ?>> <?php echo esc_html($lbl); ?></option>
            <?php endforeach; ?>
        </select>
<?php
	}
	
	/* file()
	@Description: Build file upload field
	@Parameters: $n | field name, $rn | real name of field
	@Returns: N/A
	=====================================================================*/
	public function file($n, $rn) 
	{ 
		if($this->form[$n] == '') : ?>
    	<input name="<?php echo esc_attr($rn); ?>" type="file" />
        <?php else : $v = $this->form[$n]; $thumb = $this->form[substr($n, 0, -1).'_thumb]'];  ?>
            <?php if($rn == 'supporting_documents' || $rn == 'layout') : ?>
				<a href"<?php echo esc_attr($v); ?>" /><?php echo esc_url($v); ?></a>
            <?php else : ?>
            <img src="<?php echo esc_attr($this->form[substr($n, 0, -1).'_thumb]']); ?>" style="max-width:600px" />
            <?php endif; ?>
            <input type="hidden" name="<?php echo esc_attr($n); ?>" value="<?php echo esc_attr($v); ?>" />
            <input type="hidden" name="<?php echo esc_attr(substr($n, 0, -1).'_thumb]'); ?>" value="<?php echo esc_attr($thumb); ?>" />
            <div id="<?php echo esc_attr($rn); ?>" class="info overwrite">Overwrite File</div>
		<?php
		endif;
	}

	/* enqueue()
	@Description: Enqueue JS
	@Parameters: N/A
	@Returns: N/A
	=====================================================================*/
	function enqueue() 
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('mff_js',             plugins_url('assets/js/mff.js', __FILE__ ));
		wp_enqueue_script('mff_jquery_form_js', plugins_url('assets/js/jquery.form.js', __FILE__ ));
		wp_enqueue_script('mff_gigya',          'http://cdn.gigya.com/JS/socialize.js?apikey='.self::GIGYA_API_KEY);
		wp_enqueue_script('mff_gigya_login',    plugins_url('assets/js/gigya-login.js', __FILE__ ));
		
		wp_enqueue_style('mff_css', plugins_url( 'assets/css/style.css', __FILE__ ));
	}  
}

	$mfform = new MAKER_FAIRE_FORM();

?>