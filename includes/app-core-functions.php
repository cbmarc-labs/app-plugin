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
	
	// Look in yourtheme/slug-name.php and yourtheme/woocommerce/slug-name.php
	if ( $name ) {
		$template = locate_template( array( "{$slug}-{$name}.php", APP()->template_path() . "{$slug}-{$name}.php" ) );
	}
	
	// Get default slug-name.php
	if ( ! $template && $name && file_exists( APP()->plugin_path() . "/templates/{$slug}-{$name}.php" ) ) {
		$template = APP()->plugin_path() . "/templates/{$slug}-{$name}.php";
	}
	
	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/woocommerce/slug.php
	if ( ! $template ) {
		$template = locate_template( array( "{$slug}.php", APP()->template_path() . "{$slug}.php" ) );
	}
	
	// Allow 3rd party plugin filter template file from their plugin
	if ( $template ) {
		$template = apply_filters( 'app_get_template_part', $template, $slug, $name );
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

	$located = app_locate_template( $template_name, $template_path, $default_path );

	if ( ! file_exists( $located ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
		return;
	}

	// Allow 3rd party plugin filter template file from their plugin
	$located = apply_filters( 'app_get_template', $located, $template_name, $args, $template_path, $default_path );

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
function app_locate_template( $template_name, $template_path = '', $default_path = '' )
{
	if ( ! $template_path ) {
		$template_path = APP()->template_path();
	}

	if ( ! $default_path ) {
		$default_path = APP()->plugin_path() . '/templates/';
	}

	// Look within passed path within the theme - this is priority
	$template = locate_template(
			array(
					trailingslashit( $template_path ) . $template_name,
					$template_name
			)
	);

	// Get default template
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}

	// Return what we found
	//return apply_filters( 'woocommerce_locate_template', $template, $template_name, $template_path );
	return $template;
}
