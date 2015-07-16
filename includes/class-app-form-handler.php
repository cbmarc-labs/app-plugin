<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Form_Handler
 *
 * APP_Form_Handler
 *
 * @class 		APP_Form_Handler
 * @version		1.0.0
 * @package		application/includes/APP_Form_Handler
 * @category	Class
 * @author 		cbmarc
 */
class APP_Form_Handler
{

	// --------------------------------------------------------------------

	/**
	 * init method
	 *
	 * @access public
	 */
	public static function init()
	{
		add_action( 'wp_loaded', array( __CLASS__, 'process_login' ), 20 );
	}

	// --------------------------------------------------------------------
	
	/**
	 * process_login method
	 *
	 * @access public
	 */
	public static function process_login()
	{
		if( ! empty( $_POST['login'] ) && ! empty( $_POST['_wpnonce'] ) 
				&& wp_verify_nonce( $_POST['_wpnonce'], 'app-login' ) ) {
			// do something
		}
	}
}

APP_Form_Handler::init();
