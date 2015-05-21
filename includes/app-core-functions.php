<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include( 'app-property-functions.php' );

// --------------------------------------------------------------------

/**
 * app_get_template_part method
 */
function app_get_template_part( $slug, $name = '' )
{
	$template = '';
	
	// Get default slug-name.php
	if ( $name && file_exists( APP_PLUGIN_PATH . "templates/{$slug}-{$name}.php" ) ) {
		$template = APP_PLUGIN_PATH . "templates/{$slug}-{$name}.php";
	}
	
	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/app/slug.php
	if ( ! $template ) {
		$template = locate_template( array( "{$slug}.php", APP_PLUGIN_PATH . "{$slug}.php" ) );
	}
	
	if ( $template ) {
		load_template( $template, false );
	}
}

// --------------------------------------------------------------------

/**
 * app_get_template method
 */
function app_get_template(
		$template_name, $args = array(), $template_path = '', $default_path = '' )
{
	if ( $args && is_array( $args ) ) {
		extract( $args );
	}
	
	// Look within passed path within the theme - this is priority
	$located = locate_template(
			array(
					trailingslashit( $template_path ) . $template_name,
					$template_name
			)
	);
	
	// Get default template
	if ( ! $located ) {
		$located = $default_path . $template_name;
	}
	
	$located = app_locate_template( $template_name, $template_path, $default_path );
	
	if ( ! file_exists( $located ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
		return;
	}
	
	include( $located );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 *
 * @access public
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function app_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	/*if ( ! $template_path ) {
		$template_path = WC()->template_path();
	}

	if ( ! $default_path ) {
		$default_path = WC()->plugin_path() . '/templates/';
	}*/

	// Look within passed path within the theme - this is priority
	$template = locate_template(
			array(
					trailingslashit( $template_path ) . $template_name,
					$template_name
			)
	);

	// Get default template
	if ( ! $template || WC_TEMPLATE_DEBUG_MODE ) {
		$template = $default_path . $template_name;
	}

	// Return what we found
	//return apply_filters( 'woocommerce_locate_template', $template, $template_name, $template_path );
	return $template;
}
