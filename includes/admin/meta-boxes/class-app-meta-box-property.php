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
		
		$data['property_reference']			= get_post_meta( $post->ID, '_property_reference', 1 );
		$data['property_rooms']				= get_post_meta( $post->ID, '_property_rooms', 1 );
		$data['property_baths']				= get_post_meta( $post->ID, '_property_baths', 1 );
		$data['property_price']				= get_post_meta( $post->ID, '_property_price', 1 );
		$data['property_area']				= get_post_meta( $post->ID, '_property_area', 1 );
		$data['property_energy']			= get_post_meta( $post->ID, '_property_energy', 1 );
		$data['property_energy_letter']		= get_post_meta( $post->ID, '_property_energy_letter', 1 );
		$data['property_position']			= get_post_meta( $post->ID, '_property_position', 1 );
		$data['property_featured']			= get_post_meta( $post->ID, '_property_featured', 1 );
		
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
		$property_reference		= sanitize_text_field( $_POST['property_reference'] );
		$property_rooms			= preg_replace( '/\D/', "", $_POST['property_rooms'] );
		$property_baths			= preg_replace( '/\D/', "", $_POST['property_baths'] );		
		$property_price			= preg_replace( '/\D/', "", $_POST['property_price'] );
		$property_area			= preg_replace( '/\D/', "", $_POST['property_area'] );
		$property_energy		= preg_replace( '/\D/', "", $_POST['property_energy'] );
		$property_energy_letter	= $_POST['property_energy_letter'];
		$property_position		= preg_replace( '/\D/', "", $_POST['property_position'] );
		$property_featured		= isset( $_POST['property_featured'] ) ? 1 : 0;
		
		update_post_meta( $post_id, '_property_reference', $property_reference );
		update_post_meta( $post_id, '_property_rooms', $property_rooms );
		update_post_meta( $post_id, '_property_baths', $property_baths );
		update_post_meta( $post_id, '_property_price', $property_price );
		update_post_meta( $post_id, '_property_area', $property_area );
		update_post_meta( $post_id, '_property_energy', $property_energy );
		update_post_meta( $post_id, '_property_energy_letter', $property_energy_letter );
		update_post_meta( $post_id, '_property_position', $property_position );
		update_post_meta( $post_id, '_property_featured', $property_featured );
	}

} // end class APP_Meta_Box_Property