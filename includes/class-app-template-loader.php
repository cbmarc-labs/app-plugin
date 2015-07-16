<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Template_Loader
 *
 * Clase APP_Template_Loader
 *
 * @class 		APP_Template_Loader
 * @version		1.0.0
 * @package		Application/includes/APP_Template_Loader
 * @category	Class
 * @author 		marc
 */
class APP_Template_Loader
{
	// --------------------------------------------------------------------

	/**
	 * init method
	 *
	 * @access public
	 */
	public static function init()
	{
		add_filter( 'template_include', array( __CLASS__, 'template_loader' ) );
		//add_filter( 'comments_template', array( __CLASS__, 'comments_template_loader' ) );
	}
	
	// --------------------------------------------------------------------

	/**
	 * template_loader method
	 *
	 * @access public
	 */
	public static function template_loader( $template )
	{
		$find = array( 'app.php' );
		$file = '';

		if ( is_single() && get_post_type() == 'project' ) {

			$file 	= 'single-project.php';
			$find[] = $file;
			$find[] = APP()->template_path() . $file;

		} elseif ( is_tax( get_object_taxonomies( 'project' ) ) ) {

			$term   = get_queried_object();

			$file = 'archive-project.php';

			$find[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] = APP()->template_path() . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] = 'taxonomy-' . $term->taxonomy . '.php';
			$find[] = APP()->template_path() . 'taxonomy-' . $term->taxonomy . '.php';
			$find[] = $file;
			$find[] = APP()->template_path() . $file;

		} elseif ( is_post_type_archive( 'project' ) ) {

			$file 	= 'archive-project.php';
			$find[] = $file;
			$find[] = APP()->template_path() . $file;

		}

		if ( $file ) {
			$template = locate_template( array_unique( $find ) );
			
			if ( ! $template ) {
				$template = APP()->plugin_path() . '/templates/' . $file;
			}
		}

		return $template;
	}
	
	// --------------------------------------------------------------------

	/**
	 * comments_template_loader method
	 *
	 * @access public
	 */
	public static function comments_template_loader( $template )
	{
		if ( get_post_type() !== 'project' ) {
			return $template;
		}

		$check_dirs = array(
			trailingslashit( get_stylesheet_directory() ) . APP()->template_path(),
			trailingslashit( get_template_directory() ) . APP()->template_path(),
			trailingslashit( get_stylesheet_directory() ),
			trailingslashit( get_template_directory() ),
			trailingslashit( APP()->plugin_path() ) . 'templates/'
		);

		foreach ( $check_dirs as $dir ) {
			if ( file_exists( trailingslashit( $dir ) . 'single-project-reviews.php' ) ) {
				return trailingslashit( $dir ) . 'single-project-reviews.php';
			}
		}
	}
}

APP_Template_Loader::init();
