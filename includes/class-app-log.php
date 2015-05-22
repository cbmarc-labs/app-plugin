<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Log
 *
 * APP_Log
 *
 * @class 		APP_Log
 * @version		1.0.0
 * @package		application/includes/APP_Log
 * @category	Class
 * @author 		cbmarc
 */
class APP_Log
{
	/**
	 * init
	 *
	 * @access public
	 */
	public static function init()
	{
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * log_app method
	 * 
	 * Example: APP_Log::log( "Test message" );
	 * 
	 * Change permissions on: wp-admin/error_log
	 * Change definition on wp-config.php: define('WP_DEBUG', true);
	 *
	 * @access public
	 */
	public static function log( $message )
	{
		if( WP_DEBUG === TRUE ) {
			if( is_array( $message ) || is_object( $message ) ) {
				$message =  print_r( $message, TRUE );
			}
			
			error_log( date( "d/m/Y H:i:s" ) . " - " . $message . "\n", 3, APP()->plugin_path() . 'app.log' );
		}
	}
}

APP_Log::init();