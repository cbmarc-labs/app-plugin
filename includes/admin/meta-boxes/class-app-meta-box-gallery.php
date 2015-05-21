<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Meta_Box_Gallery
*
* Galeria de imagenes en un metabox.
* Thanks to: https://github.com/wp-plugins/featured-galleries
*
* @class 		APP_Meta_Box_Gallery
* @version		1.0.0
* @package		application/includes/admin/meta-boxes/APP_Meta_Box_Gallery
* @category		Class
* @author 		cbmarc
*/
class APP_Meta_Box_Gallery
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
		
		$data['_gallery_ids'] = get_post_meta( $post->ID, '_gallery_ids', 1 );
		$data['_gallery_img'] = '';
		
		if( !empty( $data['_gallery_ids'] ) ) {
			$galleryArray = explode( ',', $data['_gallery_ids'] );
		
			foreach( $galleryArray as &$id ) {
				$data['_gallery_img'] .= '<img src="' . wp_get_attachment_url( $id ) . '" style="width:100px;margin:10px;">';
			}
		}
		
		include_once( 'views/html-meta-box-gallery.php' );
	}

	// --------------------------------------------------------------------
	
	/**
	 * save_post method
	 *
	 * @access public
	 */
	public static function save_post( $post_id, $post )
	{		
		update_post_meta( $post_id, '_gallery_ids', $_POST['_gallery_ids'] );
	}

} // end class APP_Meta_Box_Gallery