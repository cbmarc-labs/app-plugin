<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Lang
 *
 * APP_Lang
 *
 * @class 		APP_Lang
 * @version		1.0.0
 * @package		application/includes/APP_Lang
 * @category	Class
 * @author 		cbmarc
 */
class APP_Lang
{
	/**
	 * init
	 *
	 * @access public
	 */
	public static function init()
	{		
		$currentlang = get_bloginfo('language');
		$default_file = APP_PLUGIN_PATH . 'lang/en-US.php';
		$lang_file = APP_PLUGIN_PATH . 'lang/' . $currentlang . '.php';
		
		if( file_exists( $lang_file ) ) {
			include_once( $lang_file );
		} else {
			include_once( $default_file );
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * __ method
	 *
	 * @access public
	 */	
	public static function __( $text, $domain = 'default' )
	{
		global $lang;
		
		return $lang[ $text ];
	}

	// --------------------------------------------------------------------
	
	/**
	 * _x method
	 *
	 * @access public
	 */
	public static function _x( $text, $context = 'app', $domain = 'default' )
	{
		global $lang;
		
		return $lang[ $text ];
	}

	// --------------------------------------------------------------------

	/**
	 * _ex method
	 *
	 * @access public
	 */
	public static function _ex( $text, $context = 'app', $domain = 'default' )
	{
		echo APP_Lang::_x( $text, $context, $domain );
	}
}
