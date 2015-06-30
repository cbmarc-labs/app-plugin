<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_AJAX
 *
 * APP_AJAX
 *
 * @class 		APP_AJAX
 * @version		1.0.0
 * @package		application/includes/APP_AJAX
 * @category	Class
 * @author 		cbmarc
 */
class APP_AJAX
{
	/**
	 * init
	 *
	 * @access public
	 */
	public static function init()
	{
		// app_EVENT => nopriv
		$ajax_events = array(
			'test' => true,
		);
		
		foreach( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_app_' . $ajax_event, array( __CLASS__, $ajax_event ) );
		
			if( $nopriv ) {
				add_action( 'wp_ajax_nopriv_app_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * test method
	 *
	 * @access private
	 */
	public static function test()
	{		
		//ob_start();
		
		check_ajax_referer( 'app-params', 'security' );
		
		$data = array( 'test' => 'success' );
		
		wp_send_json( $data );
		
		die();
	}
}

APP_AJAX::init();
