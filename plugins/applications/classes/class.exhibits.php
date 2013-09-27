<?php

	/**
	 * The class that controls the data for the exhibits
	 *
	 * Contains all the form options and settings for the exhibits
	 *
	 * @author  Cole Geissinger <cgeissinger@makermedia.com>
	 * @version 0.1
	 * @since   0.1
	 */
	class MF_Applications_Exhibits {

		/**
		 * The settings for the exhibit forms
		 * @var associate multidimensional array
		 *
		 * @version  0.1
		 * @since    0.1
		 */
		public $settings = array(
			'title' => 'Maker Faire Exhibit Application',
			'description' => '* Indicates a required field.',
			'label_left' => false,	// Define if you want labels to be left or stacked
			'args' => array(
				'class' => 'mf-exhibits',
				'id' => 'mf-exhibits-form'
			),
			'submission' => 'refresh', // Two options. 'ajax' or 'refresh'
			'method' => 'post', // The method to use when submitting, POST or GET.
			'security' => array(
				'input_id' => 'ff-submitted', // The value to set when submitting our form.
				'nonce_action' => 'save_form', // Action name. Should give the context to what is taking place.
				'nonce_name' => 'formflow_nonce', // Nonce name. This is the name of the nonce hidden form field to be created.
			),
			'create-post' => array(  // We can setup our form to create a new post on save. YAY!
				'form_title' => 'project_name', // The NAME FIELD of the form field we want to set as our post title
				'post_type' => 'mf_form', // Pass the post type name
				'post_status' => 'proposed', // Pass the post status. If empty or not set, 'publish' is default
			),
		);


		/**
		 * Default Form when no fields exist
		 * @var associate multidimensional array
		 *
		 * @version  0.1
		 * @since    0.1
		 */
		public $form = array(
			array(
				'id'   	   => 1,
				'type' 	   => 'hidden',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'form-type',
					'name'	  	  => 'form_type',
					'value'		  => 'exhibit',
				),
			),
			array(
				'id'   	   => 2,
				'type' 	   => 'hidden',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'faire',
					'name'	  	  => 'maker_faire',
					'value'		  => '2013_newyork',
				),
			),
			array(
				'id'   	   => 3,
				'type' 	   => 'hidden',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'uid',
					'name'	  	  => 'uid',
				),
			),
			array(
				'id'   	   => 3,
				'type' 	   => 'text',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'project-name',
					'label' 	  => 'Project Name',
					'name'	  	  => 'project_name',
					'description' => 'Provide a short, catchy name for your project. Response limited to 50 characters',
					'maxlength'   => 50,
				),
			),
			array(
				'id'   	   => 4,
				'type' 	   => 'textarea',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'private-description',
					'label' 	  => 'Tell us about your project',
					'name'	  	  => 'private_description',
					'description' => 'For the Maker Faire team, explain what your project is and describe what you will actually be bringing to Maker Faire. This information will not be made public. Be as descriptive as possible.',
				),
			),
			array(
				'id'   	   => 5,
				'type' 	   => 'textarea',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'public-description',
					'label' 	  => 'Short Project Description',
					'name'	  	  => 'public_description',
					'description' => 'We need a short, concise description. Limited to 225 characters.',
					'maxlength'   => 250,
				),
			),
			array(
				'id'   	   => 6,
				'type' 	   => 'image',
				'required' => true,
				'args' 	   => array(
					'w_id'  	  => 'project-photo',
					'label' 	  => 'Project Photo',
					'name'	  	  => 'project_photo',
					'description' => 'File must be at least 500px wide or larger. PNG, JPG or GIF formats only.',
				),
			),
			array(
				'id'   	   => 7,
				'type' 	   => 'url',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'project-website',
					'label' 	  => 'Project Website',
					'name'	  	  => 'project_website',
					'description' => 'Example: http://www.makerfaire.com/',
				),
			),
			array(
				'id'   	   => 8,
				'type' 	   => 'url',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'project-video',
					'label' 	  => 'Project Video',
					'name'	  	  => 'project_video',
					'description' => 'Example: http://www.youtube.com/watch?v=RD_JpGgUFQQ',
				),
			),
			array(
				'id'   	   => 9,
				'type' 	   => 'radio',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'food',
					'label' 	  => 'Will you be giving away, selling, or sampling food (packaged or unpackaged) at Maker Faire?',
					'name'	  	  => 'food',
					'description' => 'Including food in your exhibit may require a Health Permit and fees. Details will be emailed to you after acceptance.',
					'options'	  => array(
						'Yes',
						'No',
					),
				),
			),
			array(
				'id'   	   => 10,
				'type' 	   => 'radio',
				'required' => true,
				'args' 	   => array(
					'id'		  => 'org-type',
					'label' 	  => 'Are you a:',
					'name'	  	  => 'org_type',
					'options'	  => array(
						'Non-Profit',
						'Cause or Mission-Based Organization',
						'Established Company or Commercial Entity',
						'None of the Above',
					),
				),
			),
			array(
				'id'   	   => 11,
				'type' 	   => 'radio',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'sales',
					'label' 	  => 'Will you be selling or marketing a product at Maker Faire?',
					'name'	  	  => 'sales',
					'options'	  => array(
						'Yes',
						'No',
					),
				),
			),
			array(
				'id'   	   => 12,
				'type' 	   => 'radio',
				'required' => false,
				'args' 	   => array(
					'id'		  => 'crowdsource_funding',
					'label' 	  => 'At Maker Faire, will you soliciting any crowdsource funding (Kickstarter, Indiegogo, PiggyBackr, etc?)',
					'name'	  	  => 'sales',
					'options'	  => array(
						'Yes',
						'No',
					),
				),
			),
		);
	}

	$mf_application_exhibits = new MF_Applications_Exhibits();
