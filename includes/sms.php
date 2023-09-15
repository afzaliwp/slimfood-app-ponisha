<?php

namespace AfzaliWP\SlimFood\Includes;

defined( 'ABSPATH' ) || die();

class SMS {

	private $url = 'https://console.melipayamak.com/api/send/shared/65646f5909b042ecb74f52cd1beb2f69';

	private $patterns = [
		'admin' => 162159,
		'user'  => 162158,
	];

	public function __construct() {}

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