<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Admin_Meta_Boxes
 *
 * APP_Admin_Meta_Boxes
 *
 * @class 		APP_Admin_Meta_Boxes
 * @version		1.0.0
 * @package		application/includes/admin/APP_Admin_Meta_Boxes
 * @category	Class
 * @author 		cbmarc
 */
class APP_Admin_Meta_Boxes
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( &$this, 'save_post' ), 1, 2 );
	}

	// --------------------------------------------------------------------

	/**
	 * add_meta_boxes method
	 *
	 * @access public
	 */
	public function add_meta_boxes()
	{
		// The type of writing screen on which to show the edit screen section
		$screens = array( 'property' );
		
		foreach ( $screens as $screen ) {
			add_meta_box(
				'app_meta_box_property',
				App::lang( 'property_meta_box_title' ), 
				'APP_Meta_Box_Property::output',
				$screen
			);
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * save_post method
	 * 
	 * TODO save_post general
	 *
	 * @access public
	 */
	public function save_post( $post_id, $post )
	{
		/*
		 * We need to verify this came from our screen and with proper authorization,
		* because the save_post action can be triggered at other times.
		*/
		
		// Check if our nonce is set.
		if ( ! isset( $_POST['app_meta_box_property_nonce'] ) ) {
			return;
		}
		
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['app_meta_box_property_nonce'], 'app_meta_box_property' ) ) {
			return;
		}
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'property' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		
		// OK, we're authenticated: we need to find and save the data		
		$rooms	= preg_replace( '/\D/', "", $_POST['app_meta_box_property_rooms'] );
		
		$price = preg_replace( "/[^0-9\,.]/", "", $_POST['app_meta_box_property_price'] );
		$price = str_replace( ',', '.', str_replace( '.', '', $price ) );
		
		$m2		= preg_replace( '/\D/', "", $_POST['app_meta_box_property_m2'] ) / 100;
		
		update_post_meta( $post_id, '_app_property_rooms', $rooms );
		update_post_meta( $post_id, '_app_property_price', $price );
		update_post_meta( $post_id, '_app_property_m2', $m2 );
	}
}

new APP_Admin_Meta_Boxes();