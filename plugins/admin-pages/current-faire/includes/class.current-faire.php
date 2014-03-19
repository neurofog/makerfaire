<?php

	/**
	 * Current Faire Dashboard.
	 *
	 * A custom list table to display all posts under a list of post types.
	 *
	 * @package    makerfaire
	 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
	 * @author     Cole Geissinger <cgeissinger@makermedia.com>
	 */
	class Make_List_Tables_Current_Faire {

		/**
		 * Contains all information for creating our submenu page, plus some extra data used through out the class
		 * @var array
		 */
		public $submenu_data = array(
			'parent_slug' => 'edit.php?post_type=mf_form',
			'page_title'  => 'Current Maker Faire',
			'menu_title'  => 'Current Faire',
			'capability'  => 'delete_others_pages',
			'menu_slug'   => 'current_faire',
			'page_url'	  => 'edit.php?post_type=mf_form&page=current_faire',
		);


		/**
		 * We like nonces. Nonces keep us safe. <3
		 * @var string
		 */
		public $nonce_name = 'maker-faire-current-faire';


		/**
		 * Grab the current_faire global and define it within the class in the constructor
		 * @var string
		 */
		private $current_faire;


		/**
		 * Set the user capability needed in order for them to edit and view this awesome-sauce
		 * @var string
		 */
		private $user_capabilities = 'delete_others_pages';


		/**
		 * Set our pages screen ID for wide useage
		 * @var string
		 */
		public $screen_id = 'mf_form_page_current_faire';


		/**
		 * The post type we want to use.
		 * @var string
		 */
		public $post_type = 'mf_form';


		/**
		 * Setup the type of applications we need
		 * @var array
		 */
		public $application_types = array(
			'Exhibit' 	=> 'exhibit',
			'Performer' => 'performer',
			'Presenter' => 'presenter',
		);


		/**
		 * The list of application statuses we want listed in our list tables
		 * @var array
		 */
		public $post_status = array(
			'All'	   	  	   => 'all',
			'Accepted'         => 'accepted',
			'In Progress'      => 'in-progress',
			'Proposed' 	  	   => 'proposed',
			'Rejected'         => 'rejected',
			'Cancelled'		   => 'cancelled',
			'More Info'        => 'more-info',
			'Wait List'		   => 'wait-list',
			'Draft' 	  	   => 'draft',
		);


		/**
		 * A list of post statuses we DO NOT want returned
		 * @var array
		 */
		public $disallowed_post_statuses = array(
			'trash',
			'spam',
			'inherit',
			'private',
			'auto-draft',
		);


		/**
		 * List all the of the columns to be outputted.
		 * Used in the Screen Options and table header/footer
		 * @var array
		 */
		public $columns = array(
			'post_photo' => array(
				'label'    => 'Photo',
				'sortable' => true,
				'default'  => true,
			),
			'post_id' => array(
				'label'	   => 'ID',
				'sortable' => true,
				'default'  => true,
			),
			'post_status' => array(
				'label'    => 'Status',
				'sortable' => true,
				'default'  => true,
			),
			'post_title' => array(
				'label'    => 'Project Name',
				'sortable' => true,
				'default'  => true,
			),
			'post_author' => array(
				'label'    => 'Maker Name',
				'sortable' => true,
				'default'  => true,
			),
			'post_type' => array(
				'label'    => 'Type',
				'sortable' => true,
				'default'  => true,
			),
			'post_description' => array(
				'label'    => 'Description',
				'sortable' => true,
				'default'  => true,
			),
			'cats' => array(
				'label'    => 'Categories',
				'sortable' => true,
				'default'  => true,
			),
			'tags' => array(
				'label'    => 'Tags',
				'sortable' => true,
				'default'  => true,
			),
			'location' => array(
				'label'    => 'Location',
				'sortable' => true,
				'default'  => true,
			),
			'featured_maker' => array(
				'label'    => 'Featured Maker',
				'sortable' => true,
				'default'  => true,
			),
			'post_date' => array(
				'label'    => 'Date',
				'sortable' => true,
				'default'  => true,
			),
			'commercial' => array(
				'label'    => 'Commercial',
				'sortable' => true,
				'default'  => true,
			),
			'education_day' => array(
				'label'    => 'Edu Day',
				'sortable' => true,
				'default'  => true,
			),
		);


		/**
		 * The initilizer.
		 *
		 * Loads all hooks/filters and magic here.
		 */
		public function __construct() {

			// Define our current faire
			$this->current_faire = MF_CURRENT_FAIRE;

			// Load our admin page
			add_action( 'admin_menu', array( $this, 'add_menu_page' ) );

			// Load our ajax processor
			add_action( 'wp_ajax_current_faire_screen_opt', array( $this, 'ajax_save_user_screen_options' ) );

			// Initialize our screen options
			add_action( 'admin_head', array( $this, 'init_screen_options' ) );

			// Load our resources
			add_action( 'admin_enqueue_scripts', array( $this, 'add_resources' ) );
		}


		/**
		 * Registers our submenu.
		 * Do not adjust directly, except for the callback function. Other wise, use the $submenu_data variable to adjust.
		 */
		function add_menu_page() {
			add_submenu_page( $this->submenu_data['parent_slug'], $this->submenu_data['page_title'], $this->submenu_data['menu_title'], $this->submenu_data['capability'], $this->submenu_data['menu_slug'], array( $this, 'display_current_faire_page' ) );
		}


		/**
		 * Loads all required JavaScript/CSS to make our list table work.
		 */
		function add_resources() {
			$screen = get_current_screen();

			if ( $screen->id == $this->screen_id ) {
				wp_enqueue_style( 'make-current-faire-css', get_stylesheet_directory_uri() . '/plugins/admin-pages/current-faire/css/dashboard.css' );

				wp_enqueue_script( 'make-sort-table', get_stylesheet_directory_uri() . '/js/jquery.tablesorter.min.js', array( 'jquery' ) );
				wp_enqueue_script( 'make-current-faire', get_stylesheet_directory_uri() . '/plugins/admin-pages/current-faire/js/dashboard-scripts.js', array( 'make-sort-table' ) );
			}
		}


		/**
		 * Centeralize all of our query variables into an easy to use array
		 * @return array
		 */
		function get_query_vars() {
			$order_by_options = array(
				'date',
				'modified',
			);

			$query_vars = array(
				'paged' 		 => ( isset( $_GET['paged'] ) ) ? absint( $_GET['paged'] ) : 1,
				'app_type'		 => ( isset( $_GET['app_type'] ) && in_array( $_GET['app_type'], $this->application_types ) ) ? sanitize_text_field( $_GET['app_type'] ) : '',
				'post_status' 	 => ( isset( $_GET['post_status'] ) && $_GET['post_status'] != '' && $_GET['post_status'] != 'all' ) ? sanitize_text_field( $_GET['post_status'] ) : $this->get_post_statuses(),
				'category' 		 => ( isset( $_GET['category'] ) && $_GET['category'] != '0' ) ? absint( $_GET['category'] ) : '',
				'tag'			 => ( isset( $_GET['tag'] ) && $_GET['tag'] != 'all' ) ? sanitize_text_field( $_GET['tag'] ) : '',
				'edu_day'        => ( isset( $_GET['edu_day'] ) && $_GET['edu_day'] == 'true' ) ? '_ef_editorial_meta_checkbox_education-day' : '',
				'order_by'		 => ( isset( $_GET['order_by'] ) && in_array( $_GET['order_by'], $order_by_options ) ) ? sanitize_text_field( $_GET['order_by'] ) : '',
				'posts_per_page' => ( isset( $_GET['posts_per_page'] ) && $_GET['posts_per_page'] <= 1000 ) ? absint( $_GET['posts_per_page'] ) : 40,
				'search' 		 => ( isset( $_GET['s'] ) && ! empty( $_GET['s'] ) ) ? sanitize_text_field( $_GET['s'] ) : '',
				'post_id'		 => ( isset( $_GET['p'] ) && ! empty( $_GET['p'] ) ) ? absint( $_GET['p'] ) : '',
			);

			return $query_vars;
		}


		/**
		 * Handles our Ajax requests for the custom screen options. Called from dashboard-scripts.js. Only runs when a user is logged in (hence the wp_ajax_* action);
		 * @return void
		 */
		function ajax_save_user_screen_options() {

			// Ensure that users with a role of Editor or higher can save these options
			if ( ! current_user_can( $this->user_capabilities ) )
				return;

			// Make sure everything is as it's supposed to.
			if ( isset( $_POST['submission'] ) && $_POST['submission'] == 'submit-current-faire-screen-options' && wp_verify_nonce( $_POST['nonce'], 'current-faire-screen-save' ) ) {

				// Turn our query string into an array
				parse_str( sanitize_text_field( $_POST['data'] ), $data );

				$user_id = get_current_user_id();
				$updates = update_user_attribute( $user_id, 'metaboxhidden_current_faire', $data );
			}
		}


		/**
		 * Handles any additional query string data
		 */
		function add_additional_queries() {
			$query_vars = $this->get_query_vars();
			$additionals = '';

			// Append other query variables in our filters if they are present
			if ( ! empty( $query_vars['app_type'] ) || $query_vars['app_type'] != '' )
				$additionals .= '&app_type=' . $query_vars['app_type'];

			if ( ! empty( $query_vars['search'] ) || $query_vars['search'] != '' )
				$additionals .= '&s=' . $query_vars['search'];

			if ( ! empty( $query_vars['edu_day'] ) || $query_vars['edu_day'] != '' )
				$additionals .= '&edu_day=true';

			if ( ! empty( $query_vars['category'] ) )
				$additionals .= '&category=' . $query_vars['category'];

			if ( ! empty( $query_vars['order_by'] ) )
				$additionals .= '&order_by=' . $query_vars['order_by'];

			if ( ! empty( $query_vars['tag'] ) )
				$additionals .= '&tag=' . $query_vars['tag'];

			if ( ! empty( $query_vars['posts_per_page'] ) )
				$additionals .= '&posts_per_page=' . $query_vars['posts_per_page'];

			return sanitize_text_field( $additionals );
		}


		/**
		 * Counts all post statuses and returns a link that we can use to filter by
		 */
		function count_post_status() {
			$query_vars = $this->get_query_vars();
			$results = array();
			$new_post_status = array_slice( $this->post_status, 1 ); // Remove the first array option which is 'all'
			$output = '';

			foreach ( $this->post_status as $k => $type ) {
				$args = array(
					'faire'			 => $this->current_faire,
					'post_type'		 => $this->post_type,
					'post_status'	 => ( $type == 'all' ) ? $new_post_status : $type,
					'tag'			 => $query_vars['tag'],
					'category'		 => $query_vars['category'],
					's'				 => $query_vars['search'],
					'p'				 => $query_vars['post_id'],
					'type'			 => $query_vars['app_type'],
					'meta_key'		 => $query_vars['edu_day'],
					'order_by'		 => $query_vars['order_by'],
					'posts_per_page' => 0,
					'return_fields'	 => 'ids',
				);
				$query = new WP_Query( $args );

				$query_results = array(
					'post_status'  => $k,
					'type_uri'   => $type,
					'post_count' => $query->found_posts,
				);

				array_push( $results, $query_results );

			}

			foreach ( $results as $result ) {
				// Check the current results and apply our current class if we are currently filtering by that post type.
				$class = ( ( $result['type_uri'] == $query_vars['post_status'] ) || $result['type_uri'] == 'all' && empty( $query_vars['post_status'] ) ) ? ' class="current"' : '';

				$output .= ' | <li><a href="' . esc_url( $this->submenu_data['page_url'] . '&post_status=' . sanitize_text_field( $result['type_uri'] ) ) . $this->add_additional_queries() . '"' . $class . '>' . esc_html( $result['post_status'] ) . '</a><span class="count">(' . absint( $result['post_count'] ) . ')</span> </li>';
			}

			// Remove the first two characters of our string and return it
			return substr( $output, 2 );
		}


		/**
		 * Function to generate the pagination links. Just a wrapper for paginate links
		 */
		function get_pagination_link( $total, $paged ) {
			$links = paginate_links( array(
					'base' 		=> get_pagenum_link() . '%_%',
					'format' 	=> '&paged=%#%',
					'current' 	=> max( 1, sanitize_text_field( $paged ) ),
					'total' 	=> absint( $total )
				)
			);

			return $links;
		}


		/**
		 * Creates a dropdown for our application types
		 * @return string
		 */
		function application_type_dropdown() {
			$query_vars = $this->get_query_vars();
			$types 		= $this->application_types;

			$output = '<select name="app_type" id="app_type">';
			$output .= '<option value="all">App Type</option>';

			foreach( $types as $type => $val ) {
				if ( ! in_array( $type, $types ) )
					$output .= '<option value="' . esc_attr( $val ) . '"' . selected( $query_vars['app_type'], esc_attr( $val ), false ) . '>' . esc_html( $type ) . '</option>';
			}

			$output .= '</select>';

			return $output;
		}


		/**
		 * Creates a dropdown for the Education Day filter
		 * @return string
		 */
		function post_edu_dropdown() {

			$query_vars = $this->get_query_vars();

			$output = '<select name="edu_day" id="edu-day">';
			$output .= '<option value="all">Education Day</option>';
			$output .= '<option value="true"' . selected( $query_vars['edu_day'], '_ef_editorial_meta_checkbox_education-day', false ) . '>Yes</option>';
			$output .= '</select>';

			return $output;
		}


		/**
		 * Generates the sort by submission or modified dates
		 * @return string
		 */
		function orderby_dropdown() {

			$query_vars = $this->get_query_vars();

			$output = '<select name="order_by" id="order-by">';
			$output .= '<option value="none">Sort By</option>';
			$output .= '<option value="date"' . selected( $query_vars['order_by'], 'date', false ) . '>Submission Date</option>';
			$output .= '<option value="modified"' . selected( $query_vars['order_by'], 'modified', false ) . '>Modified Date</option>';
			$output .= '</select>';

			return $output;
		}


		/**
		 * Generates a dropdown of how many pages we want to display on each page
		 * @param  array $posts_per_page an array of integers to be outputted as options
		 * @return html
		 */
		function posts_per_page_dropdown( $posts_per_page ) {
			$query_vars = $this->get_query_vars();

			$output = 'Apps Per Page <select name="posts_per_page" id="posts-per-page">';

			foreach ( $posts_per_page as $post_count ) {
				$output .= '<option value="' . absint( $post_count ) . '"' . selected( $query_vars['posts_per_page'], absint( $post_count ), false ) . '>' . absint( $post_count ) . '</option>';
			}

			$output .= '</select>';

			echo $output;
		}


		/**
		 * Generate a dropdown to filter tags
		 * @return html
		 */
		function tags_dropdown() {

			$query_vars = $this->get_query_vars();
			$terms = get_terms( 'post_tag', array( 'hide_empty' => false ) );

			$output = '<select name="tag" id="tag-dropdown">';
			$output .= '<option value="all">All Tags</option>';

			foreach ( $terms as $term ) {
				$output .= '<option value="' . sanitize_text_field( $term->slug ) . '"' . selected( sanitize_text_field( $query_vars['tag'] ), sanitize_text_field( $term->slug ), false ) . '>' . esc_html( $term->name ) . '</option>';
			}

			$output .= '</select>';

			return $output;
		}


		/**
		 * Generate a dropdown to filter categories
		 * @return html
		 */
		function categories_dropdown() {

			$query_vars = $this->get_query_vars();
			$cats = wp_dropdown_categories( array(
				'hide_empty' 		=> false,
				'selected'   		=> $query_vars['category'],
				'name'		  		=> 'category',
				'show_option_all'   => 'All Categories',
				'sort_column' 		=> 'menu_order, post_title',
				'hierarchical'		=> true,
				'echo'				=> false,
			) );

			return $cats;
		}


		/**
		 * Return a list of all the post statuses
		 * @return array
		 */
		function get_post_statuses() {
			global $wp_post_statuses;

			foreach ( $wp_post_statuses as $status => $name ) {
				if ( ! in_array( $status, $this->disallowed_post_statuses ) )
					$statuses[] = $status;
			}

			return $statuses;
		}


		/**
		 * Initialize our screen options
		 */
		function init_screen_options() {
			$screen = get_current_screen();

			if ( $screen->id == $this->screen_id ) {
				add_filter( 'screen_layout_columns', array( $this, 'display_screen_options' ) );
				$screen->add_option( 'make_screen_options', '' );
			}
		}


		/**
		 * Processes the data returned in user meta and allows us to control our table and screen optinos metabox
		 * @param  string  $option  The name of the option to check against (ie post_title, ef_pc, etc, etc)
		 * @param  boolean $metabox Configures the way this function handles the data being outputted. Use this if we are checking for data used in the screen options metabox
		 * @param  boolean $default Some columns we want shown by default. Set this to true to have our metabox checkboxes checked by default
		 * @return string
		 */
		function check_screen_options( $option, $metabox = false, $default = false ) {

			$user_id = get_current_user_id();
			$screen_options = get_user_attribute( $user_id, 'metaboxhidden_current_faire', true );
			$output = '';

			// Let's make sure we have data in DB before requesting it. If there isn't, setup the defaults.
			if ( ! empty( $screen_options ) ) {
				// Process the options for our metaboxes
				if ( $metabox ) {
					// Check if we want something checked by default, do it as long as our data isn't set in the database yet
					if ( $default && isset( $screen_options[ $option . '-hide' ] ) ) {
						$output = ' checked="checked"';
					} else {
						$output = checked( $screen_options[ $option . '-hide' ], $option, false );
					}
				} else { // This code is used when we are not dealing with the screen options metabox (ie our table rows)
					if ( ! isset( $screen_options[ $option . '-hide' ] ) && $screen_options[ $option . '-hide' ] != $option )
						$output = ' style="display:none;"';
				}
			} else {
				if ( $default && $metabox ) {
					$output = ' checked="checked"';
				} elseif ( ! $default && ! $metabox ) {
					$output = ' style="display:none;"';
				}
			}

			return $output;
		}


		/**
		 * Display a list of columns to drop (TODO: find a way to output these easily via WP_Screen classs)
		 */
		function display_screen_options() { ?>
			<div id="screen-options-wrap" class="hidden" tabindex="-1" aria-label="Screen Options Tab">
				<form id="current-faire-screen-options" name="make_blog_dashboard_options" method="get">
					<?php wp_nonce_field( 'current-faire-screen-save', $this->nonce_name, false ); ?>
					<input type="hidden" name="submission" value="submit-current-faire-screen-options">

					<h5>Show on screen</h5>
					<div class="metabox-prefs">
						<?php foreach ( $this->columns as $column => $details ) : ?>
							<label for="<?php echo $column; ?>-hide">
								<input type="checkbox" class="hide-column-tog" id="<?php echo $column; ?>-hide" name="<?php echo $column; ?>-hide" value="<?php echo $column; ?>"<?php echo $this->check_screen_options( $column, true, $details['default'] ); ?>> <?php echo $details['label']; ?>
							</label>
						<?php endforeach; ?>

					</div>
					<div class="screen-options"></div>
				</form>
			</div>
		<?php }


		/**
		 * Helper functino to easily convert Unix time to a perfered date settings
		 * @param  string  $time      The time to conver
		 * @param  boolean $is_string Allows us to convert a string to time
		 * @return string
		 */
		function convert_to_pretty_time( $time, $is_string = false ) {

			if ( empty( $time ) )
				return;

			if ( $is_string )
				$time = strtotime( $time );

			return date( 'm/d/y', absint( $time ) );
		}


		/**
		 * Helper function to convert integer equivilent boolean values to text
		 * @param  integer $boolean An integer value (0 or 1) that will be converted to text on output
		 * @return string
		 */
		function convert_boolean( $boolean ) {
			// Convert the words yes and no to boolean values
			if ( $boolean == 'Yes' ) {
				$boolean = 1;
			} elseif ( $boolean == 'No' ) {
				$boolean = 0;
			}

			if ( $boolean ) {
				$answer = 'Yes';
			} else {
				$answer = 'No';
			}

			return $answer;
		}


		/**
		 * Helper function to convert author ID into a linked author name
		 * @param  integer $author_id The author ID
		 * @return string
		 */
		function convert_author_id( $author_id ) {
			// Make sure we actually passed some data..
			if ( empty( $author_id ) )
				return;

			$user = get_userdata( absint( $author_id ) );

			return '<a href="' . get_author_posts_url( absint( $author_id ) ) . '">' . esc_html( $user->display_name ) . '</a>';
		}


		/**
		 * Helper function to process integers and return numbers or an empty string. We use this function because absint will return 0 other wise.. and we don't always want that.
		 * @param  string $integer The integer we want to process. If the string is empty, we return nothing rather than 0
		 * @return integer/void
		 */
		function get_integer( $integer ) {

			// Check is we are actuall passing something or if the string is NOT an integer.
			if ( empty( $integer ) || ! absint( $integer ) )
				return;

			$integer = ( $integer != 0 ) ? absint( $integer ) : '';

			return $integer;
		}


		/**
		 * Process both submission and modified dates into a block of HTML
		 * @param  integer $post_date      The post date
		 * @param  integer  $post_modified The modified date
		 * @return string
		 */
		function process_dates( $post_date, $post_modified ) {

			$output = '';

			if ( ! empty( $post_date ) ) {
				$post_date = strtotime( $post_date );
				$output .= '<p><strong>Submitted</strong>: ' . date( 'F j, Y @ g:i a', $post_date ) . '</p>';
			}

			if ( ! empty( $post_modified ) ) {
				$post_modified = strtotime( $post_modified );
				$output .= '<p><strong><em>Modified</strong>: ' . date( 'F j, Y @ g:i a', $post_modified ) . '</em></p>';
			}

			return $output;
		}


		/**
		 * Current Faire Page
		 */
		function display_current_faire_page() {

			//must check that the user has the required capability
			if ( ! current_user_can( $this->user_capabilities ) )
				wp_die( __( 'You do not have sufficient permissions to access this page.', 'make' ) );

			// Get any query variables if set
			$query_vars = $this->get_query_vars();

			// Check if we are filtering our results by post type.
			if ( empty( $query_vars['post_status'] ) || $query_vars['post_status'] == 'all' ) {
				$post_status = array_slice( $this->post_status, 1 );
			} else {
				$post_status = $query_vars['post_status'];
			}

			$args = array(
				'faire'			 => $this->current_faire,
				'post_type'		 => $this->post_type,
				'post_status'	 => $post_status,
				'posts_per_page' => $query_vars['posts_per_page'],
				'paged'			 => $query_vars['paged'],
				'cat'	 	 	 => $query_vars['category'],
				'tag'			 => $query_vars['tag'],
				'type'			 => $query_vars['app_type'],
				'meta_key'		 => $query_vars['edu_day'],
				'orderby'		 => $query_vars['order_by'],
				's'				 => $query_vars['search'],
				'p'				 => $query_vars['post_id'],
			);
			$query = new WP_Query( $args ); ?>
			<div class="wrap">
				<h1><?php echo $this->submenu_data['page_title']; ?></h1>
				<ul class="subsubsub">
					<?php echo $this->count_post_status(); ?>
				</ul>

				<form method="get" class="posts-filter">
					<input type="hidden" name="post_type" value="<?php echo esc_attr( $_REQUEST['post_type'] ); ?>" />
					<input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ); ?>" />
					<?php wp_nonce_field( 'overview-form-save', $this->nonce_name, false ); ?>

					<p class="search-box">
						<label for="post-search-input" class="screen-reader-text">Search All Applications</label>
						<input type="search" id="post-search-input" name="s" value="<?php echo ( isset( $query_vars['search'] ) ) ? esc_attr( $query_vars['search'] ) : ''; ?>">
						<input type="submit" name="" id="search-submit" class="button" value="Search All Applications">
					</p>

					<div class="tablenav top">
						<?php echo $this->application_type_dropdown(); ?>
						<?php echo $this->categories_dropdown(); ?>
						<?php echo $this->tags_dropdown(); ?>
						<?php echo $this->orderby_dropdown(); ?>
						<?php echo $this->posts_per_page_dropdown( array( 20, 30, 40, 50, 60, 70, 80, 90, 100, 200, 300, 400, 1000 ) ); ?>
						<label for="post-search-id" class="screen-reader-text">Search by Project ID</label>
						<input type="search" id="post-search-id" name="p" placeholder="Project ID" value="<?php echo ( isset( $_GET['p'] ) && ! empty( $_GET['p'] ) ) ? esc_attr( $_GET['p'] ) : ''; ?>">
						<input type="submit" name="" id="filter-submit" class="button" value="Filter All Content">
						<button class="button"><a href="<?php echo esc_url( admin_url( $this->submenu_data['page_url'] ) ); ?>">Reset Filters</a></button>
						<div class="tablenav-pages">
							<span class="displaying-num"><?php echo absint( $query->found_posts ); ?> Items</span>
							<?php echo $this->get_pagination_link( $query->max_num_pages, $query_vars['paged'] ); ?>
						</div>

					</div>

					<table id="current-faire" class="wp-list-table widefat fixed pages">
						<thead>
							<tr>
								<?php foreach( $this->columns as $column => $details ) : ?>
									<th scope="col" id="<?php echo $column; ?>" class="manage-column column-<?php echo $column; ?><?php echo ( $details['sortable'] ) ? ' table-sortable' : ''; ?>"<?php echo $this->check_screen_options( $column, false, $details['default'] ); ?>><?php echo $details['label']; ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<?php foreach( $this->columns as $column => $details ) : ?>
									<th scope="col" id="<?php echo $column; ?>" class="manage-column column-<?php echo $column; ?><?php echo ( $details['sortable'] ) ? ' table-sortable' : ''; ?>"<?php echo $this->check_screen_options( $column, false, $details['default'] ); ?>><?php echo $details['label']; ?></th>
								<?php endforeach; ?>
							</tr>
						</tfoot>
						<tbody id="the-list">
							<?php
								global $post, $wp_post_statuses;
								if( ! empty( $query->posts ) ) {
									foreach ( $query->posts as $post ) {
										setup_postdata( $post );

										// Set just a couple of variables.... :/
										$json        = json_decode( str_replace( '\\', '\\\\', $post->post_content ) );
										$post_id     = absint( $post->ID );
										$app_image   = mf_get_the_maker_image( $json );
										$post_status = $wp_post_statuses[ get_post_status() ]->label;
										$maker_name  = ( ! empty( $json->name ) ) ? $json->name : '';
										$app_type 	 = get_the_term_list( $post_id, 'type', '', ', ', '' );
										$description = ( ! empty( $json->public_description) ) ? mf_clean_content( $json->public_description ) : '';
										$cats        = get_the_category_list( ', ', '', $post_id );
										$tags 		 = get_the_term_list( $post_id, 'post_tag', null, ', ' );
										$location    = mf_get_locations( $post_id );
										$featured 	 = get_post_meta( $post_id, '_ef_editorial_meta_checkbox_featured', true );
										$commercial  = ( ! empty( $json->sales ) ) ? sanitize_text_field( $this->convert_boolean( $json->sales ) ) : '';
										$edu_day 	 = get_post_meta( $post_id, '_ef_editorial_meta_checkbox_education-day', true );

										echo '<tr id="post-' . absint( $post->ID ) . '" valign="top">';
										echo '<td class="post_photo column-post_photo"' . $this->check_screen_options( 'post_photo', false, true ) . '>';
											if ( ! empty( $app_image ) )
												echo '<img src="' . wpcom_vip_get_resized_remote_image_url( esc_url( $app_image ), 130, 130, true ) . '" width="130" height="130">';
										echo '</td>';
										echo '<td class="post_id column-post_id"' . $this->check_screen_options( 'post_id', false, true ) . '>' . $post_id . '</td>';
										echo '<td class="post_status column-post_status"' . $this->check_screen_options( 'post_status', false, true ) . '>' . $post_status . '</td>';
										echo '<td class="post_title column-post_title"' . $this->check_screen_options( 'post_title', false, true ) . '><strong><a href="' . get_edit_post_link( absint( $post->ID ) ) . '">' . esc_html( get_the_title() ) . '</a></strong>
												<div class="row-actions">
													<span class="inline hide-if-no-js"><a href="' . get_edit_post_link( absint( $post->ID ) ) . '">Edit</a> | </span>
													<span class="view"><a href="' . get_permalink() . '">View</a></span>
												</div>
											  </td>';
										echo '<td class="post_author column-post_author"' . $this->check_screen_options( 'post_author', false, true ) . '>' . esc_html( $maker_name ) . '</td>';
										echo '<td class="post_type column-post_type"' . $this->check_screen_options( 'post_type', false, true ) . '>' . $app_type . '</td>';
										echo '<td class="post_description column-post_description"' . $this->check_screen_options( 'post_description', false, true ) . '>' . wp_trim_words( Markdown( wp_kses_post( $description ) ), 15 ) . '</td>';
										echo '<td class="cats column-cats"' . $this->check_screen_options( 'cats', false, true ) . '>' . $cats. '</td>';
										echo '<td class="tags column-tags"' . $this->check_screen_options( 'tags', false, true ) . '>' . $tags . '</td>';
										echo '<td class="location column-location"' . $this->check_screen_options( 'location', false, true ) . '>' . esc_html( $location ) . '</td>';
										echo '<td class="featured_maker column-featured_maker"' . $this->check_screen_options( 'featured_maker', false, true ) . '>' . $this->convert_boolean( $featured ) . '</td>';
										echo '<td class="post_date column-post_date"' . $this->check_screen_options( 'post_date', false, true ) . '>' . $this->process_dates( $post->post_date, $post->post_modified ) . '</td>';
										echo '<td class="commercial column-commercial"' . $this->check_screen_options( 'commercial', false, true ) . '>' . $commercial . '</td>';
										echo '<td class="education_day column-education_day"' . $this->check_screen_options( 'education_day', false, true ) . '>' . $this->convert_boolean( $edu_day ) . '</td>';
										echo '</tr>';
									}
								} else {
									echo '<tr class="no-items"><td class="colspanchange" colspan="3">No content found.</td></tr>';
								} ?>
						</tbody>

					</table>
					<div class="tablenav bottom">

						<div class="tablenav-pages">
							<span class="displaying-num"><?php echo absint( $query->found_posts ); ?> Items</span>
							<?php echo $this->get_pagination_link( $query->max_num_pages, $query_vars['paged'] ); ?>
						</div>

					</div>
				</form>
			</div>
		<?php }
	}