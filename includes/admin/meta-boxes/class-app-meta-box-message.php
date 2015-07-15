<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Meta_Box_Message
*
* @class 		APP_Meta_Box_Message
* @version		1.0.0
* @package		application/includes/admin/meta-boxes/APP_Meta_Box_Message
* @category     Class
* @author 		cbmarc
*/
class APP_Meta_Box_Message
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
		
		$data['message_name']			= get_post_meta( $post->ID, '_message_name', 1 );
		$data['message_phone']			= get_post_meta( $post->ID, '_message_phone', 1 );
		$data['message_email']			= get_post_meta( $post->ID, '_message_email', 1 );
		$data['message_property_id']	= get_post_meta( $post->ID, '_message_property_id', 1 );
		
		include_once( 'views/html-meta-box-message.php' );
	}

} // end class APP_Meta_Box_Property