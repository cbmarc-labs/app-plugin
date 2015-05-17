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
	}

} // end class APP_Meta_Box_Property_Location