<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Assets' ) ) :

/**
 * APP_Assets
 *
 * APP_Assets
 *
 * @class 		APP_Assets
 * @version		1.0.0
 * @package		application/includes/APP_Assets
 * @category	Class
 * @author 		cbmarc
 */
class APP_Assets
{
	// --------------------------------------------------------------------
	
	/**
	 * init method
	 *
	 * @access public
	 */
	public static function init()
	{
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'styles' ) );
	}

	// --------------------------------------------------------------------

	/**
	 * includes method
	 *
	 * @access public
	 */
	public static function styles()
	{
		global $wp_scripts;
		
		wp_enqueue_style( 'app-bootstrap-style', APP()->plugin_url() . '/assets/lib/bootstrap-3.3.4/css/bootstrap-prefixed.min.css' );
		wp_enqueue_style( 'app-style', APP()->plugin_url() . '/assets/css/style.css' );
	}

	// --------------------------------------------------------------------
	
	/**
	 * includes method
	 *
	 * @access public
	 */
	public static function scripts()
	{
		global $wp_query, $post, $current_user;
		
		wp_enqueue_script( 'app-autoNumeric-script', APP()->plugin_url() . '/assets/lib/autoNumeric/autoNumeric.js', array( 'jquery' ) );
		wp_enqueue_script( 'app-default-script', APP()->plugin_url() . '/assets/js/default.js', array( 'jquery' ) );
		
		wp_enqueue_script( 'maps-googleapis-com', 'http://maps.googleapis.com/maps/api/js' );
	}
}

endif;

APP_Assets::init();