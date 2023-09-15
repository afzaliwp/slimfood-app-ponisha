<?php
function afzaliwp_slimfood_autoload( $class_name ) {
	if ( ! str_contains( $class_name, 'AfzaliWP\SlimFood' ) ) {
		return;
	}

	$file = str_replace( [ '_', 'AfzaliWP\SlimFood', '\\' ], [ '-', __DIR__, '/' ], $class_name ) . '.php';

	require_once strtolower( $file );
}

function slimfood_get_image($name, $echo = true) {
	$image_url = AFZALIWP_SF_IMAGES . '/' . $name;

	if ($echo) {
		echo $image_url;
	}

	return $image_url;
}