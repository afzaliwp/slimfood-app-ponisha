<?php
function afzaliwp_slimfood_autoload( $class_name ) {
	if ( ! str_contains( $class_name, 'AfzaliWP\SlimFood' ) ) {
		return;
	}

	$class_name = strtolower( $class_name );
	$file = str_replace( [ '_', strtolower( 'AfzaliWP\SlimFood' ), '\\' ], [ '-', __DIR__, '/' ], $class_name ) . '.php';

	require_once $file;
}

function slimfood_get_image($name, $echo = true) {
	$image_url = AFZALIWP_SF_IMAGES . '/' . $name;

	if ($echo) {
		echo $image_url;
	}

	return $image_url;
}

function mylog($data, $other_data = '') {
	error_log( PHP_EOL . '-----------------------------------' );
	error_log( '-------------$data: .'. $other_data .'---------------' );
	if ( is_array($data) || is_object($data) ) {
		error_log( print_r($data, true) );
	} else {
		error_log($data);
	}
	error_log( '-----------------------------------' );
	error_log( '-----------------------------------'.PHP_EOL );
}