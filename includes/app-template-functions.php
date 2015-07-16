<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * When the_post is called, put project data into a global.
 *
 * @param mixed $post
 * @return APP_Project
 */
function app_setup_project_data( $post ) {
	unset( $GLOBALS['project'] );

	if ( is_int( $post ) )
		$post = get_post( $post );

	if ( empty( $post->post_type ) || ! in_array( $post->post_type, array( 'project' ) ) )
		return;

	$GLOBALS['project'] = app_get_project( $post );

	return $GLOBALS['project'];
}
add_action( 'the_post', 'app_setup_project_data' );