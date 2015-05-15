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
	 * meta_box_callback method
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

} // end class APP_Meta_Box_Property