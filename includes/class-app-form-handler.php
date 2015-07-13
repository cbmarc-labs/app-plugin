<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Form_Handler
 *
 * Clase APP_Form_Handler
 *
 * @class 		APP_Form_Handler
 * @version		1.0.0
 * @package		Application/includes/APP_Form_Handler
 * @category	Class
 * @author 		cbmarc
 */
class APP_Form_Handler
{
	/**
	 * Hook in methods
	 */
	public static function init()
	{
		add_action( 'wp_loaded', array( __CLASS__, 'process_contact' ), 20 );
	}

	// --------------------------------------------------------------------

	/**
	 * process_contact method
	 *
	 * @access public
	 */
	public static function process_contact()
	{
		global $wp;

		if ( 'POST' !== strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ) ) {
			return;
		}

		if ( empty( $_POST[ 'action' ] ) || 'enquire_now' !== $_POST[ 'action' ] || empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'woocommerce-edit_address' ) ) {
			return;
		}
		
		$data = array(
				'post_title'   => 'Test',
				'post_content' => 'This is a test content',
				'post_status'  => 'publish',
				'post_type'    => 'message'
		);
		
		$variation_id = wp_insert_post( $data );
	}
}

APP_Form_Handler::init();
