<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/** Single Property ********************************************************/

if ( ! function_exists( 'app_show_property_images' ) ) {
	function app_show_property_images() {
		app_get_template( 'single-property/property-image.php' );
	}
}

/**
 * When the_post is called, put property data into a global.
 *
 * @param mixed $post
 * @return APP_Property
 */
function app_setup_property_data( $post ) {
	unset( $GLOBALS['property'] );

	if ( is_int( $post ) )
		$post = get_post( $post );

	if ( empty( $post->post_type ) || ! in_array( $post->post_type, array( 'property' ) ) )
		return;

	$GLOBALS['property'] = app_get_property( $post );

	return $GLOBALS['property'];
}
add_action( 'the_post', 'app_setup_property_data' );