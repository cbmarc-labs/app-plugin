<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Shortcodes
 *
 * APP_Shortcodes
 *
 * @class 		APP_Shortcodes
 * @version		1.0.0
 * @package		application/includes/APP_Shortcodes
 * @category	Class
 * @author 		cbmarc
 */
class APP_Shortcodes
{
	/**
	 * init
	 *
	 * @access public
	 */
	public static function init()
	{		
		// Define shortcodes
		$shortcodes = array(
			'app_form_filter'	=> __CLASS__ . '::form_filter',
		);

		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}
	}

	// --------------------------------------------------------------------

	/**
	 * shortcode_wrapper method
	 *
	 * @access public
	 */
	public static function shortcode_wrapper( $function, $atts = array() ) {
		ob_start();

		call_user_func( $function, $atts );

		return ob_get_clean();
	}

	// --------------------------------------------------------------------

	/**
	 * form_filter method
	 *
	 * @access public
	 */
	public static function form_filter()
	{
		return self::shortcode_wrapper( array( 'APP_Shortcode_Property_Filter_Form', 'output' ) );
	}
}
