<?php
class GSRequestWP extends GSRequest  {

	protected function curl($url, $params, $timeout=null, $options = array())
	{
		foreach($params->getKeys() as $key)
		{
			$value = $params->getString($key);
			$postData[$key] = $value;
		}

		$qs = http_build_query($postData);

		/* POST */
		$args = array(
			'body'      => $postData,
			'headers'   => array( 'Expect:'),
			'sslverify' => true,
			'proxy'     => $this->proxy,
			'timeout'   => $timeout
		);

		$response = wp_remote_post( $url, $args );

		if( is_wp_error( $response ) ) {
   			$error_message = $response->get_error_message();
			throw new Exception($error_message);
		}

		return wp_remote_retrieve_body( $response );
	}
}
?>