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

		if ( empty( $_POST[ 'action' ] ) || 'enquire_now' !== $_POST[ 'action' ] 
				|| empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'app-enquire_now' ) ) {
			return;
		}
		
		$data = array(
				'post_title'   => $_POST[ 'title' ],
				'post_content' => $_POST[ 'message' ] . '<br><a href="' . $_POST[ 'permalink' ] . '">' . $_POST[ 'permalink' ] . '</a>',
				'post_status'  => 'publish',
				'post_type'    => 'message'
		);
		
		$post_id = wp_insert_post( $data );
		
		update_post_meta( $post_id, '_message_name', $_POST['name'] );
		update_post_meta( $post_id, '_message_email', $_POST['email'] );
		update_post_meta( $post_id, '_message_phone', $_POST['phone'] );
		
		$received_url = add_query_arg( 'status', 'sent', $_POST[ 'permalink' ] );
		
		wp_safe_redirect( $received_url );
		
		exit;
	}
}

APP_Form_Handler::init();
