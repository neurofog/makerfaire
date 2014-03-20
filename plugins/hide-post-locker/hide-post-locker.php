<?php
/**
 * A little script that will allow us to hide the "post locker" window.
 * When our team is reviewing applications, normally there are multiple people looking at an application.
 * Unfortunately WordPress loads this screen that stops people from accessing the application.
 * This little plugin will add an option for us to be able to add an option to remove that window and at least review the application.
 *
 * This plugin was built by Cole Geissinger and is available on the wordpress.org plugin repo. Slightly adjusted for Maker Media, Inc.
 * @since Mechani-Kong
 */

	class CG_Hide_Post_Locker {

		/**
		 * Set the plugins version for use within our code.
		 * @var string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		private $version = '0.1';


		/**
		 * Our constructor. Any hooks, filters and other fun stuff goes here.
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		public function __construct() {

			// Enqueue our scriptzzzz
			add_action( 'admin_enqueue_scripts', array( $this, 'resources' ) );

			// Hook our custom button and text to the locker window
			add_action( 'post_locked_dialog', array( $this, 'hide_locker_message' ) );

			// Hook our custom button and text to the locker "taken over" window
			add_action( 'post_lock_lost_dialog', array( $this, 'hide_locker_message' ) );

			// Add in a custom box that displays at the top so we know we are view previewing the editor
			add_action( 'admin_footer', array( $this, 'add_preview_message' ) );
		}


		/**
		 * Load any JavaScript or CSS we need
		 * @return void
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		public function resources( $hook ) {

			// Only load this when we are viewing the post editor on applications!
			if ( $hook != 'post.php' && get_post_type() == 'mf_form' )
				return;

			// Load our styles
			wp_enqueue_style( 'geissinger-hpl-main-styles', get_stylesheet_directory_uri() . '/plugins/hide-post-locker/css/hide-post-locker.css', null, $this->version );

			// Enqueue our custom script that makes the magix happen.
			wp_enqueue_script( 'geissinger-hpl-main-script', get_stylesheet_directory_uri() . '/plugins/hide-post-locker/js/hide-post-locker.js', array( 'jquery' ), $this->version );
		}


		/**
		 * The function that contains the message to hide the login.
		 * @return string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		public function hide_locker_message() {

			// For easy customizations, allow users to over ride these messages.
			$content = array(
				'text' 		=> __( 'Want to view the application?', 'geissinger-hpl' ),
				'btn-text' 	=> __( 'Review', 'geissinger-hpl' ),
				'btn-class' => '',
			);
			$content = apply_filters( 'geissinger-hpl-locker-messages', $content );

			// Sanitize and display!
			echo wp_kses_post( $content['text'] ) . ' <a href="#" class="hide-post-locker-btn ' . esc_attr( $content['btn-class'] ) . '">' . wp_kses_post( $content['btn-text'] ) .'</a>';
		}


		/**
		 * Adds a block of content we can use to notify the user they are currently previewing the editor window
		 * and will not be able to save or make edits. Just preview.
		 * @return  string
		 *
		 * @version 0.1
		 * @since   0.1
		 */
		public function add_preview_message() {
			$screen = get_current_screen();

			// Make this filterable of course
			$content = array(
				'title' 	=> __( 'Previewing Application', 'geissinger-hpl' ),
				'text' 		=> __( 'Any edits made will <strong>not</strong> be saved as another user is currently editing.', 'geissinger-hpl' ),
				'btn-text' 	=> __( 'See who is editing', 'geissinger-hpl' ),
				'btn-class' => '',
			);
			$content = apply_filters( 'geissinger-hpl-preview-messages', $content );

			// Output our HTML and content
			$output = '<div class="cg-hpl-preview-wrapper">';
				$output .= '<p><strong>' . wp_kses_post( $content['title'] ) . '</strong> - ' . wp_kses_post( $content['text'] ) . ' ';
				$output .= '<a href="#" class="show-post-locker-btn ' . esc_attr( $content['btn-class'] ) . '">' . wp_kses_post( $content['btn-text'] ) . '</a></p>';
			$output .= '</div>';

			// Make sure we are viewing the post.php page...
			if ( $screen->id == 'mf_form' )
				echo $output;
		}
	}
	$geissinger_hpl = new CG_Hide_Post_Locker();
