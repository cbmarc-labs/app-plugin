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
		
		$data['location_address']	= get_post_meta( $post->ID, '_app_property_location_address', 1 );
		$data['location_city']		= get_post_meta( $post->ID, '_app_property_location_city', 1 );
		$data['location_province']	= get_post_meta( $post->ID, '_app_property_location_province', 1 );
		$data['location_geocode']	= get_post_meta( $post->ID, '_app_property_location_geocode', 1 );
		
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
		update_post_meta( $post_id, '_app_property_location_address', $_POST['meta_box_property_location_address'] );
		update_post_meta( $post_id, '_app_property_location_city', $_POST['meta_box_property_location_city'] );
		update_post_meta( $post_id, '_app_property_location_province', $_POST['meta_box_property_location_province'] );
		update_post_meta( $post_id, '_app_property_location_geocode', $_POST['meta_box_property_location_geocode'] );
	}

} // end class APP_Meta_Box_Property_Location