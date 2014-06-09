<?php
/**
 * Sponsor Class
 */
class MF_Sponsors {

	/**
	 * THE CONSTRUCT.
	 *
	 * All Hooks and Filter here.
	 * Anything else that needs to run when the class is instantiated, place them here.
	 * Maybe you'll get a Dr. Pepper if you do.
	 *
	 * @return  void
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'load_resources' ), 30 );
		add_action( 'init', array( $this, 'sponsor_init' ) );
		add_filter( 'post_updated_messages', array( $this, 'sponsor_updated_messages' ) );
		add_action( 'add_meta_boxes', array( $this, 'mf_sponsor_add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'mf_save_sponsor_meta' ) );
	}

	/**
	 * Let's add all of our resouces to make our magic happen.
	 *
	 * @return  void
	 */
	public function load_resources() {

	}
	function sponsor_init() {
		register_post_type( 'sponsor', array(
			'hierarchical'      => false,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
			'has_archive'       => false,
			'query_var'         => true,
			'rewrite'           => true,
			'taxonomies'		=> array( 'category', 'post_tag' ),
			'labels'            => array(
				'name'                => __( 'Sponsors', 'makerfaire' ),
				'singular_name'       => __( 'Sponsor', 'makerfaire' ),
				'all_items'           => __( 'Sponsors', 'makerfaire' ),
				'new_item'            => __( 'New Sponsor', 'makerfaire' ),
				'add_new'             => __( 'Add New', 'makerfaire' ),
				'add_new_item'        => __( 'Add New Sponsors', 'makerfaire' ),
				'edit_item'           => __( 'Edit Sponsor', 'makerfaire' ),
				'view_item'           => __( 'View Sponsor', 'makerfaire' ),
				'search_items'        => __( 'Search Sponsors', 'makerfaire' ),
				'not_found'           => __( 'No Sponsors found', 'makerfaire' ),
				'not_found_in_trash'  => __( 'No Sponsors found in trash', 'makerfaire' ),
				'parent_item_colon'   => __( 'Parent Sponsor', 'makerfaire' ),
				'menu_name'           => __( 'Sponsors', 'makerfaire' ),
			),
		) );

	}

	function sponsor_updated_messages( $messages ) {
		global $post;

		$permalink = get_permalink( $post );

		$messages['sponsor'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __('Sponsors updated. <a target="_blank" href="%s">View Sponsor</a>', 'makerfaire'), esc_url( $permalink ) ),
			2 => __('Custom field updated.', 'makerfaire'),
			3 => __('Custom field deleted.', 'makerfaire'),
			4 => __('Sponsors updated.', 'makerfaire'),
			/* translators: %s: date and time of the revision */
			5 => isset($_GET['revision']) ? sprintf( __('Sponsors restored to revision from %s', 'makerfaire'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __('Sponsors published. <a href="%s">View Sponsors</a>', 'makerfaire'), esc_url( $permalink ) ),
			7 => __('Sponsors saved.', 'makerfaire'),
			8 => sprintf( __('Sponsors submitted. <a target="_blank" href="%s">Preview Sponsors</a>', 'makerfaire'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
			9 => sprintf( __('Sponsors scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Sponsors</a>', 'makerfaire'),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
			10 => sprintf( __('Sponsors draft updated. <a target="_blank" href="%s">Preview Sponsors</a>', 'makerfaire'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		);

		return $messages;
	}


	/**
	 * Add meta boxes to the sponsor edit screen
	 * @return void
	 */
	function mf_sponsor_add_meta_boxes() {
		add_meta_box( 'mf-sponsor-url', __( 'Sponsor Details', 'makerfaire' ), array( $this, 'mf_sponsor_details_mb' ), 'sponsor' );
	}


	/**
	 * Adds the details meta box.
	 * @param  object $post The post object
	 * @return string
	 */
	function mf_sponsor_details_mb( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'mf-sponsor-url' );
		$details = get_post_meta( absint( $post->ID ), 'sponsor-url', true );

		$output  = '<p><label for="sponsor-url" style="width:100px;display:inline-block">URL</label>';
		$output .= '<input type="text" name="sponsor-url" id="sponsor-url" value="' . ( ! empty( $details ) ? esc_url( $details ) : '' ) . '" style="width:100%;" /></p>';

		echo $output;
	}


	/**
	 * Saves our meta boxes
	 * @param  int $post_id The post ID
	 * @return void
	 */
	function mf_save_sponsor_meta( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( ! isset( $_POST['mf-sponsor-url'] ) || ! wp_verify_nonce( $_POST['mf-sponsor-url'], basename( __FILE__ ) ) )
			return;

		if ( ! current_user_can( 'edit_post', absint( $post_id ) ) )
			return;

		if ( get_post_type() == 'sponsor' && isset( $_POST['sponsor-url'] ) )
			update_post_meta( absint( $post_id ), 'sponsor-url', esc_url( $_POST['sponsor-url'] ) );
	}
}

$sponsors = new MF_Sponsors();