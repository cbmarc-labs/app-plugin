<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Meta_Box_Property
*
* @class 		APP_Meta_Box_Property
* @version		1.0.0
* @package		application/includes/admin/meta-boxes/APP_Meta_Box_Property
* @category     Class
* @author 		cbmarc
*/
class APP_Meta_Box_Property
{	
	// --------------------------------------------------------------------

	/**
	 * output method
	 *
	 * @access public
	 */
	public static function output()
	{
		global $post;
		
		$data['rooms']	= get_post_meta( $post->ID, '_app_property_rooms', 1 );
		$data['price']	= get_post_meta( $post->ID, '_app_property_price', 1 );
		$data['m2']		= get_post_meta( $post->ID, '_app_property_m2', 1 );
		
		include_once( 'views/html-meta-box-property.php' );
	}

	// --------------------------------------------------------------------
	
	/**
	 * save_post method
	 * 
	 * TODO save_post general
	 *
	 * @access public
	 */
	public static function save_post( $post_id, $post )
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

} // end class APP_Meta_Box_Property