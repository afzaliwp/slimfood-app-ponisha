<?php

namespace AfzaliWP\SlimFood\Includes;

defined( 'ABSPATH' ) || die();

class SMS {

	private $url;

	private $patterns = [
		'admin' => 167030,
		'user'  => 167031,
	];

	public function __construct() {
		$this->url = get_option( 'melipayamak_api_address' );
	}

	/**
	 * @param $to string
	 * @param $body string : can be user or admin
	 * @param $args array
	 *
	 * @return array|\WP_Error
	 */
	public function send_sms( $to, $body, $args ) {
		$body_id     = $this->patterns[ $body ];
		$data        = [ 'bodyId' => $body_id, 'to' => $to, 'args' => $args ];
		$data_string = json_encode( $data );

		$response = wp_remote_post( $this->url, [
			'method'    => 'POST',
			'headers'   => [ 'Content-Type' => 'application/json' ],
			'body'      => $data_string,
			'sslverify' => false,
		] );

		return $response;
	}

}