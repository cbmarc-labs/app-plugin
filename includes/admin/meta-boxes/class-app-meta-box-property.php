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
		
		$data['rooms']	= get_post_meta( $post->ID, '_app_property_rooms', 1 );
		$data['baths']	= get_post_meta( $post->ID, '_app_property_baths', 1 );
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
		// OK, we're authenticated: we need to find and save the data		
		$rooms	= preg_replace( '/\D/', "", $_POST['app_meta_box_property_rooms'] );
		$baths	= preg_replace( '/\D/', "", $_POST['app_meta_box_property_baths'] );		
		$price	= preg_replace( '/\D/', "", $_POST['app_meta_box_property_price'] );
		$m2		= preg_replace( '/\D/', "", $_POST['app_meta_box_property_m2'] );
		
		update_post_meta( $post_id, '_app_property_rooms', $rooms );
		update_post_meta( $post_id, '_app_property_baths', $baths );
		update_post_meta( $post_id, '_app_property_price', $price );
		update_post_meta( $post_id, '_app_property_m2', $m2 );
	}

} // end class APP_Meta_Box_Property