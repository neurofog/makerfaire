<?php

	/**
	 * Our core class.
	 *
	 * This contains all the cool jazz that makes this plugin work.
	 *
	 * @author  Cole Geissinger <cgeissinger@makermedia.com>
	 * @version 0.1
	 * @since   0.1
	 */
	class MF_Applications {

		/**
		 * Allow us to set the demo settings and forms. This will also enable debugging for the form outputs
		 * @var boolean
		 *
		 * @version  0.1
		 * @since    0.1
		 */
		private $form_debug = false;


		/**
		 * Default Settings when no settings exist
		 * @var associate multidimensional array
		 *
		 * @version  0.1
		 * @since    0.1
		 */
		private $demo_settings = array(
			'title' => 'Form Title',
			'description' => 'This is my form description, if I want one...',
			'label_left' => false,				// Define where if you want labels to left or stacked
			'args' => array(
				'class' => 'form-class',
				'id' => ''
			),
			'submission' => 'refresh', // Two options. 'ajax' or 'refresh'
			'method' => 'post', // The method to use when submitting, POST or GET.
			'security' => array(
				'input_id' => 'ff-submitted', // The value to set when submitting our form.
				'nonce_action' => 'save_form', // Action name. Should give the context to what is taking place.
				'nonce_name' => 'formflow_nonce', // Nonce name. This is the name of the nonce hidden form field to be created.
			),
			'create-post' => array(  // We can setup our form to create a new post on save. YAY!
				'form_title' => 'first-text', // The NAME FIELD of the form field we want to set as our post title
				'post_type' => 'page', // Pass the post type name
				'post_status' => 'draft', // Pass the post status. If empty or not set, 'publish' is default
				'tax_query' => array( // You can also set taxonomies when saving post. TODO: Finish this.
					'faire' => 'world-maker-faire-new-york-2013' // Taxonomy ID or slug
				),
			),
		);


		/**
		 * Default Form when no fields exist
		 * @var associate multidimensional array
		 *
		 * @version  0.1
		 * @since    0.1
		 */
		private $demo_form = array(
			array(
				'id'   	   => 1,
				'type' 	   => 'text',
				'required' => true,
				'args' 	   => array(
					'w_id'  	  => 'form-title',
					'w_class' 	  => 'form-title-class, hotdogs',
					'id'		  => 'text-field',
					'class'		  => 'text-input',
					'label' 	  => 'Text Field',
					'placeholder' => 'TEXT sdagusdhgsuh',
					'name'	  	  => 'first-text',
					'description' => 'asfddsf',
					'maxlength'   => 50,
				),
			),
			array(
				'id'   	   => 2,					// integer. The ID associated to this input field.
				'type' 	   => 'text',				// string.  options - text, textarea, dropdown, multiselect, number, checkbox, radio, image, file, date, phone, hidden, html, section, page-break
				'required' => true,					// boolean. Enables a field to be required for input.
				'args' 	   => array(				// array.	Arguments to pass for customizing the field.
					'w_id'  	  => 'form-title',  // string.  The ID to apply to the wrapper element of the input field.
					'w_class' 	  => 'form-class',  // string.  The class to apply to the wrapper element of the input field.
					'id'		  => 'text-field',  // string.  The ID to apply to the input field itself.
					'class'		  => 'text-input',  // string.  The class to apply to the input field itself.
					'label' 	  => 'Text Field',  // string.  The label to add to the front-end of the form.
					'placeholder' => 'placeholder', // string.  The default value. If added to text field, this is added into the placeholder attribute.
					'name'	  	  => 'text[]',		// string.  The name field. If not set, the label is used instead. To create an array use []
					'description' => '',			// string.  The description of the field. Normally useful for explaining the field for users on the front-end.
					'maxlength'   => 50,		    // integer. Enables max-length functionality.
				),
				'conditional' => array(	  // array.  Allows us to set conditional show/hiding of input fields based on certain conditions.
					'action'  => 'show',  // string. The action to take such as displaying or hiding an input field. opts - show, hide
					'logic'   => 'all',   // string. The logic we are looking for conditions to be met. opts - all, any
					'rules'   => array(   // array.  The actual rules we are looking for. Set multiple rules in separate arrays.
						array(
							'form_id'  => 1,      // integer. The ID of the form that we will conditionally check for.
							'operator' => 'is',   // string.  The detailed logic we are searching for. opts is, is not, greater than, less than, contains, starts with, ends with
							'value'    => 'taco', // string.  Match a value to make statement true. Use * to symbolize 'any thing'.
						),
					),
				),
			),
			array(
				'id'   	   => 3,
				'type' 	   => 'textarea',
				'required' => false,
				'args' 	   => array(
					'w_id'  	  => 'form-title',
					'w_class' 	  => 'form-title-class',
					'id'		  => 'text-field',
					'class'		  => 'text-input',
					'label' 	  => 'TEXTAREA',
					'placeholder' => 'textarea placeholder',
					'name'	  	  => 'textarea',
					'description' => 'My awesome textarea yo.',
					'maxlength'   => 250,
					'cols'		  => 30, // integer.  Set a column width if needed.
					'rows'		  => 10, // integer.  Set a row width if needed.
				),
			),
			array(
				'id'   	   => 4,
				'type' 	   => 'dropdown',
				'required' => false,
				'args' 	   => array(
					'w_id'  	  => 'form-title',
					'w_class' 	  => 'form-title-class',
					'id'		  => 'text-field',
					'class'		  => 'text-input',
					'label' 	  => 'DROPDOWN',
					'name'	  	  => 'dropdown',
					'description' => 'dropdown',
					'options'	  => array(	// Sets up our select drop down. Set each option field with $value => $label
						'value1' => 'Value 1',
						'value2' => 'Value 2',
						'value3' => 'Value 3',
						'value4' => 'Value 4',
						'value5' => 'Value 5',
					),
				),
			),
			array(
				'id'   	   => 5,
				'type' 	   => 'multiselect',
				'required' => false,
				'args' 	   => array(
					'w_id'  	  => 'form-title',
					'w_class' 	  => 'form-title-class',
					'id'		  => 'text-field',
					'class'		  => 'text-input',
					'label' 	  => 'MULTISELECT',
					'name'	  	  => 'multiselect',
					'description' => 'dropdown',
					'size'	  => 2, // New field, unique to Multiselect. This allows us to specify how many fields we want to show before the rest is shown with scrolling
					'options'	  => array(	// Sets up our select drop down. Set each option field with $value => $label
						'value1' => 'Value 1',
						'value2' => 'Value 2',
						'value3' => 'Value 3',
						'value4' => 'Value 4',
						'value5' => 'Value 5',
					),
				),
			),
			array(
				'id'   	   => 6,
				'type' 	   => 'number',
				'required' => false,
				'args' 	   => array(
					'w_id'  	  => 'form-title',
					'w_class' 	  => 'form-title-class',
					'id'		  => 'text-field',
					'class'		  => 'text-input',
					'label' 	  => 'NUMBER',
					'name'	  	  => 'number',
					'description' => '',
					'options'	  => array(	// Add our minimum and maximum fields if we want to
						'minimum' => 1, // Should be positive integers only
						'maximum' => 10,
					),
				),
			),
			array(
				'id'   	   => 7,
				'type' 	   => 'checkbox',
				'required' => false,
				'args' 	   => array(
					'w_id'  	  => 'form-title',
					'w_class' 	  => 'form-title-class',
					'id'		  => 'text-field',
					'class'		  => 'text-input',
					'label' 	  => 'CHECKBOX',
					'name'	  	  => 'checkbox',
					'description' => '',
					'options'	  => array(	// Add the names of each checkbox. All of these will be saved to one field as an array
						'option-1' => 'Option 1',
						'option-2' => 'Option 2',
						'option-3' => 'Option 3',
					),
				),
			),
		);


		/**
		 * The current version of this plugin
		 * @var string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private $plugin_version = '0.1';


		/**
		 * Custom Settings when no settings exist
		 * @var associate multidimensional array
		 *
		 * @version  0.1
		 * @since    0.1
		 */
		private $settings;


		/**
		 * Custom Form Fields
		 * @var associate multidimensional array
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private $form;


		/**
		 * Main loader.
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		public function __construct( $settings = array(), $form = array() ) {

			// Pass our custom settings or else get the default (only for development)
			$this->settings = ( empty( $settings ) && $this->form_debug ) ? $this->demo_settings : $settings;

			// Pass our custom Form or else get the default (only for development)
			$this->form     = ( empty( $form ) && $this->form_debug ) ? $this->demo_form : $form;

			// If we want to save the form on refresh, let's do that
			if ( $this->settings['submission'] == 'refresh' )
				$this->form_action_refresh();

		}


		/**
		 * Whether the class has been given some form fields to process
		 * @return boolean
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		public function has_form_fields() {
			if ( empty( $this->form ) || is_null( $this->form ) ) {
				return false;
			} else {
				return true;
			}
		}


		/**
		 * Return an error message if nothing is passed
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		public function no_items() {
			$output = '<h3>These are not the forms you are looking for...</h3>';
			$output .= '<p>Whooooops! Looks like there are no forms to process..</p>';
			$output .= '<p>Make sure you provide an array of form fields to output.</p>';

			echo $output;
		}


		/**
		 * Handles how we want to process our forms. Ajax, or on page refresh
		 * @return void
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function form_action_refresh() {

			// Check if the user is even logged in
			if ( ! is_user_logged_in() )
				return;

			// Check that we even passed anything to process...
			if ( empty( $_POST ) )
				return;

			// Lastly, we'll make sure something was submitted the form and check we passed the correct nonce
			if ( ! isset( $_POST['ff-submitted'] ) && ! $_POST['ff-submitted'] && ! isset( $_POST['formflow_nonce'] ) && ! wp_verify_nonce( $_POST['formflow_nonce'], 'save_form' ) )
				return;

			// Check if we want our form to create a post on save.
			if ( isset( $this->settings['create-post'] ) ) {
				
				// Call our save post method
				$results = $this->form_save_post( $_POST );

				if ( ! $this->form_debug ) {
					return $results;
				} else {
					var_dump( $results );
				}
			}
		}


		/**
		 * Process our form data and saves it into a post.
		 * @param  array  $data  The data saved from the form
		 * @return void
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function form_save_post( $data ) {

			// Make sure we submitted our form one more time...
			if ( ! isset( $data['ff-submitted'] ) && ! $data['ff-submitted'] && ! isset( $data['formflow_nonce'] ) && ! wp_verify_nonce( $data['formflow_nonce'], 'save_form' ) )
				return;

			// First we want to clean everything...
			$data = $this->form_clean_data( $data );

			// We'll want to get our post information we set in the settings too.
			$post_info = $this->settings['create-post'];

			$post = array(
				'post_title'   => ( isset( $post_info['form_title'] ) && ! empty( $post_info['form_title'] ) ) ? sanitize_text_field( $data[ $post_info['form_title'] ] ) : '',
				'post_content' => json_encode( $data ),
				'post_status'  => ( isset( $post_info['post_status'] ) && ! empty( $post_info['post_status'] ) ) ? esc_attr( $post_info['post_status'] ) : 'publish',
				'post_type'	   => ( isset( $post_info['post_type'] ) && ! empty( $post_info['post_type'] ) ) ? esc_attr( $post_info['post_type'] ) : 'post',
			);

			if ( ! $this->form_debug ) {
				$new_post = wp_insert_post( $post );

				return $new_post;
			} else {
				return $post;
			}

		}


		/**
		 * Clean and validate all content passed.
		 * @param  array $data The array that contains our content we want to addd
		 * @return array
		 *
		 * @version  0.1
		 * @since    0.1
		 */
		private function form_clean_data( $data ) {

			$form_fields = $this->form;
			$clean_data = array();

			if ( is_array( $data ) ) {
				$count = 0;
				foreach ( $data as $key => $value ) {

					// Check that the data being passed is what we want. Rmove the rest.
					if ( $this->in_array_r( $key, $form_fields, true ) ) {

						// Sanitize the $key
						$key = sanitize_title_with_dashes( $key );

						switch( $form_fields[ $count ]['type'] ) {
							case 'textarea':
								$clean_data[ $key ] = esc_textarea( $value );
								break;
							case 'number':
							case 'date':
							case 'phone':
								$clean_data[ $key ] = intval( $value );
								break;
							case 'image':
							case 'url':
								$clean_data[ $key ] = esc_url( $value );
								break;
							case 'text':
							case 'dropdown':
							case 'multiselect':
							case 'checkbox':
							case 'radio':
							case 'hidden':
							default:
								$clean_data[ $key ] = sanitize_text_field( $value );
						}
						$count++;
					}
				}
			}

			return $clean_data;
		}


		/**
		 * Processes all of our form fields
		 * @param  boolean
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function fields( $alignment_left = false ) {

			// Get the form data
			$fields = $this->form;
			$output = '';

			// Check if we are viewing an existing application and pull it's data into the form fields
			$set_values = $this->get_existing_application();

			// Check if the application we are building already exists and we have data to display
			// if ( ! $set_values )
			// 	$args = wp_parse_args( $set_values, $field['args'] );

			// var_dump($set_values);

			foreach ( $fields as $field ) {
				$args         = ( isset( $field['args'] ) ) ? $field['args'] : '';
				$conditionals = ( isset( $field['conditional'] ) ) ? $field['conditional'] : '';

				// Add our left class if the option is set
				if ( $alignment_left && ! empty( $args['w_class'] ) ) {
					$args['w_class']   .= ' left';
					$args['label_left'] = true;
				} elseif ( $alignment_left && empty( $args['w_class'] ) ) {
					$args['w_class']   .= 'left';
					$args['label_left'] = true;
				}

				// Start our field wrapper, which is an LI.
				$output .= '<li';

					// Set a wrapper ID if present.
					if ( isset( $args['w_id'] ) && ! empty( $args['w_id'] ) )
						$output .= ' id="' . esc_attr( $args['w_id'] ) . '"';

					// Set a wrapper class if present.
					if ( isset( $args['w_class'] )  && ! empty( $args['w_class'] ) )
						$output .= ' class="' . esc_attr( $args['w_class'] ) . '"';

					// Check if the field is required
					if ( $field['required'] )
						$output .= ' data-formflow-required="true"';

					// Check if a conditional is set
					if ( isset( $conditionals ) && is_array( $conditionals ) )
						$this->check_conditionals( $conditionals );

				// Close the opening li tag.
				$output .= '>';

					// Create the opening label.
					$output .= '<label';

						// Set our for value if a form id.
						if ( isset( $args['id'] ) && ! empty( $args['id'] ) )
							$output .= ' for="' . esc_attr( $args['id'] ) . '"';

					// Close the opening label tag.
					$output .= '>';

						// Check that a label exists...
						if ( isset( $args['label'] ) && ! empty( $args['label'] ) )
							$output .= wp_kses_post( $args['label'] );

					// Close the label tag
					$output .= '</label>';

					// Add our description if left aligned form fields is NOT set.
					if ( isset( $args['description'] ) && ! empty( $args['description'] ) && ! $alignment_left )
						$output .= '<div class="ff_description">' . wp_kses_post( $args['description'] ) . '</div>';

					// Return the proper form field
					$output .= $this->get_field( $field['type'], $args, $set_values );

					// If left aligned form fields are set, let's add the description below the form field
					if ( isset( $args['description'] ) && ! empty( $args['description'] ) && $alignment_left )
						$output .= '<div class="ff_description">' . wp_kses_post( $args['description'] ) . '</div>';

				// Close the field wrapper.
				$output .= '</li>';
			}

			return $output;

		}


		/**
		 * Check our conditionals and setup the right data attribute for use in JavaScript validation
		 * @param  string  $type  The type of input field we want to return
		 * @param  array   $args  An array of arguments to pass to the input field functions
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function check_conditionals( $conditionals ) {

			if ( isset( $conditionals ) && is_array( $conditionals ) ) {

			}

		}


		/**
		 * Return an error message if nothing is passed
		 * @param string  $type  The type of input field we want to return
		 * @param array   $args  An array of arguments to pass to the input field functions
		 * @return void
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_field( $type, $args ) {

			switch ( $type ) {
				case 'text':
					return $this->get_text_field( $args );
					break;
				case 'textarea':
					return $this->get_textarea( $args );
					break;
				case 'dropdown':
					return $this->get_dropdown( $args );
					break;
				case 'multiselect':
					return $this->get_multiselect( $args );
					break;
				case 'number':
					return $this->get_number_field( $args );
					break;
				case 'checkbox':
					return $this->get_checkbox( $args );
					break;
				case 'radio':
					return $this->get_radio( $args );
					break;
				case 'image':
					return $this->get_image_upload( $args );
					break;
				case 'file':
					return $this->get_file_upload( $args );
					break;
				case 'date':
					return $this->get_date_field( $args );
					break;
				case 'phone':
					return $this->get_phone_field( $args );
					break;
				case 'url':
					return $this->get_url_field( $args );
					break;
				case 'hidden':
					return $this->get_hidden_field( $args );
					break;
				case 'html':
					return $this->get_html_block( $args );
					break;
				case 'section-end':
				case 'section-start':
					return $this->get_section_wrapper( $args );
					break;
				case 'page-break':
					return $this->get_page_break( $args );
					break;
			}

		}


		/**
		 * Return the text input field
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_text_field( $args ) {

			if ( ! empty( $args ) ) {
				$output = '<input type="text"';

					// Set our name field, if one doesn't exist, use the label
					if ( isset( $args['name'] ) ) {
						$output .= ' name="' . esc_attr( $args['name'] ) . '"';
					} else {
						$output .= ' name="' . esc_attr( sanitize_title( $args['label'] ) ) . '"';
					}

					// Check for an ID
					if ( isset( $args['id'] ) )
						$output .= ' id="' . esc_attr( $args['id'] ) . '"';

					// Check for a class
					if ( isset( $args['class'] ) )
						$output .= ' class="' . esc_attr( $args['class'] ) . '"';

					// Add our placeholder when a value is set
					if ( isset( $args['placeholder'] ) )
						$output .= ' placeholder="' . esc_attr( $args['placeholder'] ) . '"';

				$output .= ' />';

				return $output;
			}

		}


		/**
		 * Return the textarea field
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_textarea( $args ) {

			if ( ! empty( $args ) ) {
				$output = '<textarea';

					// Set our name field, if one doesn't exist, other wise use the label
					if ( isset( $args['name'] ) ) {
						$output .= ' name="' . esc_attr( $args['name'] ) . '"';
					} else {
						$output .= ' name="' . esc_attr( sanitize_title( $args['label'] ) ) . '"';
					}

					// Check for an ID
					if ( isset( $args['id'] ) )
						$output .= ' id="' . esc_attr( $args['id'] ) . '"';

					// Check if a column size is set
					if ( isset( $args['cols'] ) )
						$output .= ' cols="' . esc_attr( $args['cols'] ) . '"';

					// Check if a row size is set
					if ( isset( $args['rows'] ) )
						$output .= ' rows="' . esc_attr( $args['rows'] ) . '"';

					// Add a placeholder if set
					if ( isset( $args['placeholder'] ) )
						$output .= ' placeholder="' . esc_attr( $args['placeholder'] ) . '"';

				$output .= '></textarea>';

				return $output;
			}

		}


		/**
		 * Return the dropdown field
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_dropdown( $args ) {

			if ( ! empty( $args ) ) {
				$output = '<select';

					// Set our name field
					if ( isset( $args['name'] ) ) {
						$output .= ' name="' . esc_attr( $args['name'] ) . '"';
					} else {
						$output .= ' name="' . esc_attr( sanitize_title( $args['label'] ) ) . '"';
					}

					// Check if an ID is set
					if ( isset( $args['id'] ) )
						$output .= ' id="' . esc_attr( $args['id'] ) . '"';

					// Check if a class is set
					if ( isset( $args['class'] ) )
						$output .= ' class="' . esc_attr( $args['class'] ) . '"';

				$output .= '>';

					foreach ( $args['options'] as $value => $label ) {
						$output .= '<option value="' . esc_attr( $value ) . '">' . esc_html( $label ) . '</option>';
					}

				$output .= '</select>';

				return $output;
			}

		}


		/**
		 * Return the multiselect field
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_multiselect( $args ) {

			if ( ! empty( $args ) ) {
				$output = '<select';

					// Set our name field
					if ( isset( $args['name'] ) ) {
						$output .= ' name="' . esc_attr( $args['name'] ) . '"';
					} else {
						$output .= ' name="' . esc_attr( sanitize_title( $args['label'] ) ) . '"';
					}

					// Check if an ID is set
					if ( isset( $args['id'] ) )
						$output .= ' id="' . esc_attr( $args['id'] ) . '"';

					// Check if a class is set
					if ( isset( $args['class'] ) )
						$output .= ' class="' . esc_attr( $args['class'] ) . '"';

				$output .= ' multiple size="' . absint( $args['size'] ) . '">';

					foreach ( $args['options'] as $value => $label ) {
						$output .= '<option value="' . esc_attr( $value ) . '">' . esc_html( $label ) . '</option>';
					}

				$output .= '</select>';

				return $output;
			}
		}


		/**
		 * Return an input field that only handles integers
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_number_field( $args ) {

			if ( ! empty( $args ) ) {
				$output = '<input type="number"';

					// Set our name field, if one doesn't exist, use the label
					if ( isset( $args['name'] ) ) {
						$output .= ' name="' . esc_attr( $args['name'] ) . '"';
					} else {
						$output .= ' name="' . esc_attr( sanitize_title( $args['label'] ) ) . '"';
					}

					// Check for an ID
					if ( isset( $args['id'] ) )
						$output .= ' id="' . esc_attr( $args['id'] ) . '"';

					// Check for a class
					if ( isset( $args['class'] ) )
						$output .= ' class="' . esc_attr( $args['class'] ) . '"';

					// Add some options for setting a minimum and maximum
					if ( isset( $args['options'] ) ) {

						// Add our min field if we set it
						if ( isset( $args['options']['minimum'] ) && ! empty( $args['options']['minimum'] ) )
							$output .= ' min="' . esc_attr( $args['options']['minimum'] ) . '"';

						// Add our max field if we set it
						if ( isset( $args['options']['maximum'] ) && ! empty( $args['options']['maximum'] ) )
							$output .= ' max="' . esc_attr( $args['options']['maximum'] ) . '"';
					}

				$output .= ' />';

				return $output;
			}

		}


		/**
		 * Return a checkbox input field
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_checkbox( $args ) {

			if ( ! empty( $args ) ) {

				// Process our checkbox and labels
				if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {

					$output = '<ul class="checkboxes">';

					foreach ( $args['options'] as $id => $name ) {

						$output .= '<li>';

							$output .= '<input type="checkbox"';

								/// Set our name field, if one doesn't exist, use the label
								if ( isset( $args['name'] ) ) {
									$output .= ' name="' . esc_attr( $args['name'] ) . '"';
								} else {
									$output .= ' name="' . esc_attr( sanitize_title( $args['label'] ) ) . '"';
								}

								// Check for an ID
								if ( isset( $args['id'] ) )
									$output .= ' id="' . esc_attr( $id ) . '"';

								// Check for a class
								if ( isset( $args['class'] ) )
									$output .= ' class="' . esc_attr( $args['class'] ) . '"';

							$output .= ' /> ';

							$output .= '<label for="' . esc_attr( $id ) . '">' . esc_html( $name ) . '</label>';

						$output .= '</li>';

					}

					$output .= '</ul>';

				}

				return $output;

			}

		}


		/**
		 * Return a radio input field
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_radio( $args ) {

			if ( ! empty( $args ) ) {

				// Process our checkbox and labels
				if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {

					$output = '<ul class="radio">';

					foreach ( $args['options'] as $id => $name ) {

						$output .= '<li>';

							$output .= '<input type="radio"';

								/// Set our name field, if one doesn't exist, use the label
								if ( isset( $args['name'] ) ) {
									$output .= ' name="' . esc_attr( $args['name'] ) . '"';
								} else {
									$output .= ' name="' . esc_attr( sanitize_title( $args['label'] ) ) . '"';
								}

								// Check for an ID
								if ( isset( $args['id'] ) )
									$output .= ' id="' . esc_attr( $id ) . '"';

								// Check for a class
								if ( isset( $args['class'] ) )
									$output .= ' class="' . esc_attr( $args['class'] ) . '"';

							$output .= ' /> ';

							$output .= '<label for="' . esc_attr( $id ) . '">' . esc_html( $name ) . '</label>';

						$output .= '</li>';

					}

					$output .= '</ul>';

				}

				return $output;

			}

		}


		/**
		 * Return a file upload field that only checks against image types
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_image_upload( $args ) {

			if ( ! empty( $args ) ) {
				$output = '<input type="file"';

					// Set our name field, if one doesn't exist, use the label
					if ( isset( $args['name'] ) ) {
						$output .= ' name="' . esc_attr( $args['name'] ) . '"';
					} else {
						$output .= ' name="' . esc_attr( sanitize_title( $args['label'] ) ) . '"';
					}

					// Check for an ID
					if ( isset( $args['id'] ) )
						$output .= ' id="' . esc_attr( $args['id'] ) . '"';

					// Check for a class
					if ( isset( $args['class'] ) )
						$output .= ' class="' . esc_attr( $args['class'] ) . '"';

				$output .= ' />';

				return $output;
			}

		}


		/**
		 * Return a file upload field that only checks against file types
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_file_upload( $args ) {

		}


		/**
		 * Return a date picker field
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_date_field( $args ) {

		}


		/**
		 * Return an input field that only handles integers
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_phone_field( $args ) {

		}


		/**
		 * Return an input field that only handles URLs
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_url_field( $args ) {

			if ( ! empty( $args ) ) {
				$output = '<input type="text"';

					// Set our name field, if one doesn't exist, use the label
					if ( isset( $args['name'] ) ) {
						$output .= ' name="' . esc_attr( $args['name'] ) . '"';
					} else {
						$output .= ' name="' . esc_attr( sanitize_title( $args['label'] ) ) . '"';
					}

					// Check for an ID
					if ( isset( $args['id'] ) )
						$output .= ' id="' . esc_attr( $args['id'] ) . '"';

					// Check for a class
					if ( isset( $args['class'] ) )
						$output .= ' class="' . esc_attr( $args['class'] ) . '"';

					// Add our placeholder when a value is set
					if ( isset( $args['placeholder'] ) )
						$output .= ' placeholder="' . esc_attr( $args['placeholder'] ) . '"';

				$output .= ' />';

				return $output;
			}

		}


		/**
		 * Return a hidden input field
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_hidden_field( $args ) {

			if ( ! empty( $args ) ) {
				$output = '<input type="hidden"';

					// Set our name field, if one doesn't exist, use the label
					if ( isset( $args['name'] ) ) {
						$output .= ' name="' . esc_attr( $args['name'] ) . '"';
					} else {
						$output .= ' name="' . esc_attr( sanitize_title( $args['label'] ) ) . '"';
					}

					// Check for an ID
					if ( isset( $args['id'] ) )
						$output .= ' id="' . esc_attr( $args['id'] ) . '"';

					// Check for a class
					if ( isset( $args['class'] ) )
						$output .= ' class="' . esc_attr( $args['class'] ) . '"';

					// Add our value
					if ( isset( $args['value'] ) )
						$output .= ' value="' . esc_attr( $args['value'] ) . '"';

				$output .= ' />';

				return $output;
			}

		}


		/**
		 * Return an HTML block
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_html_block( $args ) {

		}


		/**
		 * Return the section wrapper
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_section_wrapper( $args ) {

		}


		/**
		 * Return the page break
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_page_break( $args ) {

		}


		/**
		 * Calling this method will Check for a $_GET URL that contains the ID of an application.
		 * This will then process the existing fields and append them to the application form.
		 * @return Array/Boolean
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private function get_existing_application() {

			// Check if we are passing an ID (must be a positive number!)
			if ( ! isset( $_GET['id'] ) || ! absint( $_GET['id'] ) )
				return false;

			return true;
		}


		/**
		 * The grand-daddy. This method will process all the data we have created and will output them into an actual working form.
		 * @return mixed
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		public function display_form() { 

			// Get our custom form settings
			$settings = $this->settings;

			if ( $this->has_form_fields() ) : ?>
				<form method="<?php echo $settings['method']; ?>" class="formflow-form">
					<fieldset>
						
						<?php if ( isset( $settings['title'] ) && ! empty( $settings['title'] ) ) : ?>
							<legend class="form-title"><?php echo $settings['title']; ?></legend>
						<?php endif; ?>

						<?php if ( isset( $settings['description'] ) && ! empty( $settings['description'] ) ) : ?>
							<p class="form-description"><?php echo $settings['description']; ?></p>
						<?php endif; ?>

						<ol>
							<?php echo $this->fields( $settings['label_left'] ); ?>
						</ol>
					</fieldset>
					<fieldset class="submit">
						<input type="hidden" name="<?php echo $settings['security']['input_id']; ?>" value="true">
						<?php wp_nonce_field( $settings['security']['nonce_action'], $settings['security']['nonce_name'], false ); ?>
						<input type="submit" value="Submit" class="submit" />
					</fieldset>
				</form>
			<?php else : ?>
				<?php echo $this->no_items(); ?>
			<?php endif;
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
		private function in_array_r( $needle, $haystack, $strict = false ) {
		    foreach ( $haystack as $item ) {
		        if ( ( $strict ? $item === $needle : $item == $needle ) || ( is_array( $item ) && $this->in_array_r( $needle, $item, $strict ) ) ) {
		            return true;
		        }
		    }

		    return false;
		}

	}
	