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
		
		$title		= $_POST[ 'title' ];
		$permalink	= $_POST[ 'permalink' ];
		
		$name		= ! empty( $_POST[ 'name' ] ) ? sanitize_text_field( $_POST[ 'name' ] ) : '';
		$email		= ! empty( $_POST[ 'email' ] ) ? sanitize_email( $_POST[ 'email' ] ) : '';
		$phone		= ! empty( $_POST[ 'phone' ] ) ? sanitize_text_field( $_POST[ 'phone' ] ) : '';
		$message	= ! empty( $_POST[ 'message' ] ) ? sanitize_text_field( $_POST[ 'message' ] ) : '';
		
		$message .= '<br><a href="' . $_POST[ 'permalink' ] . '">' . $_POST[ 'permalink' ] . '</a>';
		
		// TODO check and display form errors
		if ( empty( $name ) ) {}		
		if ( ! is_email( $email ) ) {}
		
		$data = array(
				'post_title'   => $title,
				'post_content' => $message,
				'post_status'  => 'publish',
				'post_type'    => 'message'
		);
		
		$post_id = wp_insert_post( $data );
		
		update_post_meta( $post_id, '_message_name', $name );
		update_post_meta( $post_id, '_message_email', $email );
		update_post_meta( $post_id, '_message_phone', $phone );
		
		$received_url = add_query_arg( 'status', 'sent', $permalink );
		
		wp_safe_redirect( $received_url );
		
		exit;
	}
}

APP_Form_Handler::init();
