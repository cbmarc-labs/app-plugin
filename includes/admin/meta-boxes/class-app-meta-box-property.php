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

		wp_nonce_field( 'app_meta_box_nonce', 'app_meta_box_nonce' );
		
		$data['property_rooms']	= get_post_meta( $post->ID, '_property_rooms', 1 );
		$data['property_baths']	= get_post_meta( $post->ID, '_property_baths', 1 );
		$data['property_price']	= get_post_meta( $post->ID, '_property_price', 1 );
		$data['property_m2']	= get_post_meta( $post->ID, '_property_m2', 1 );
		
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
		// OK, we're authenticated: we need to find and save the data		
		$property_rooms	= preg_replace( '/\D/', "", $_POST['property_rooms'] );
		$property_baths	= preg_replace( '/\D/', "", $_POST['property_baths'] );		
		$property_price	= preg_replace( '/\D/', "", $_POST['property_price'] );
		$property_m2	= preg_replace( '/\D/', "", $_POST['property_m2'] );
		
		update_post_meta( $post_id, '_property_rooms', $property_rooms );
		update_post_meta( $post_id, '_property_baths', $property_baths );
		update_post_meta( $post_id, '_property_price', $property_price );
		update_post_meta( $post_id, '_property_m2', $property_m2 );
	}

} // end class APP_Meta_Box_Property