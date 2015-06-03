<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Meta_Box_Property_Location
 *
 * @class 		APP_Meta_Box_Property_Location
 * @version		1.0.0
 * @package		application/includes/admin/meta-boxes/APP_Meta_Box_Property_Location
 * @category     Class
 * @author 		cbmarc
 */
class APP_Meta_Box_Property_Location
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
		
		$data['property_location_address']	= get_post_meta( $post->ID, '_property_location_address', 1 );
		$data['property_location_map']	= get_post_meta( $post->ID, '_property_location_map', 1 );
		$data['property_location_marker']	= get_post_meta( $post->ID, '_property_location_marker', 1 );
		
		include_once( 'views/html-meta-box-property-location.php' );
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
		update_post_meta( $post_id, '_property_location_address', $_POST['property_location_address'] );
		update_post_meta( $post_id, '_property_location_map', $_POST['property_location_map'] );
		update_post_meta( $post_id, '_property_location_marker', $_POST['property_location_marker'] );
	}

} // end class APP_Meta_Box_Property_Location