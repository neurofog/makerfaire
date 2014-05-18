<?php
/**
 * Instagram class for MAKE
 */
class Make_Instagram {

	/**
	 * THE CONSTRUCT.
	 *
	 * @return  void
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'load_resources' ), 30 );

	}

	/**
	 * Let's add all of our resouces to make our magic happen.
	 */
	public function load_resources() {

	}

	/**
	 * Load the Maker Faire data feed.
	 * Might update this at some point so that you can pass in any user.
	 *
	 * @return OBJECT Instagram response
	 */
	public function load_data() {

		$base_url = 'https://api.instagram.com/v1/users/227901753/media/recent';
		$params = array(
			'access_token' => '227901753.1fb234f.3be9baa7c6d34efa821b9bf79641374e',
		);

		// Build the URL
		$url = add_query_arg( $params, $base_url );

		// Request the data
		$json = wpcom_vip_file_get_contents( $url );

		// Parse the JSON
		$data = json_decode( $json );

		// Send it off...
		return $data->data;
	}

	public function show_images() {
		$ps = $this->load_data();
		$output = '<h2 class="red" style="color:red">Live from <a href="http://instagram.com/makerfaire/">@makerfaire</a> Bay Area 2014 on Instagram</h2>';
		$output .= '<div class="row-fluid instagram-rows">';
		for ( $i = 0; $i <= 2; $i++ ) {
			$output .= '<div class="span4">';
			$output .= '<a href="' . esc_url( $ps[ $i ]->link ) . '" class="instagram-link">';
			$output .= '<div class="thumbnail">';
			$output .= '<img style="max-width:180px; height: auto;" src="' . esc_url( $ps[ $i ]->images->standard_resolution->url ) . '">';
			$output .= '<div class="caption insta-caption">';
			$output .= wp_kses_post( Markdown( wp_trim_words( $ps[ $i ]->caption->text, 10, '...' ) ) );
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</a>';
			$output .= '</div>';
		}
		$output .= '</div>';
		$output .= '<div class="spacer" style="height: 20px;"></div>';
		$output .= '<div class="row-fluid instagram-rows">';
		for ( $i = 3; $i <= 5; $i++ ) {
			$output .= '<div class="span4">';
			$output .= '<a href="' . esc_url( $ps[ $i ]->link ) . '" class="instagram-link">';
			$output .= '<div class="thumbnail">';
			$output .= '<img style="max-width:180px; height: auto;" src="' . esc_url( $ps[ $i ]->images->standard_resolution->url ) . '">';
			$output .= '<div class="caption insta-caption">';
			$output .= wp_kses_post( Markdown( wp_trim_words( $ps[ $i ]->caption->text, 10, '...' ) ) );
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</a>';
			$output .= '</div>';
		}
		$output .= '</div>';
		$output .= '<div class="spacer"></div>';
		return $output;
	}

}

$instagram = new Make_Instagram();

function make_show_images() {
	$instagram = new Make_Instagram();
	return $instagram->show_images();
}

add_shortcode( 'show_instagram', 'make_show_images' );