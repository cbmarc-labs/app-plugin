<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Gallery' ) ) :

/**
 * APP_Gallery
 *
 * La clase APP_Reserva controla el proceso del calendario de los eventos
 *
 * @class 		APP_Gallery
 * @version		1.0.0
 * @package		Application/includes/admin/APP_Gallery
 * @category	Class
 * @author 		marc
 */
class APP_Gallery
{
	// The single instance of the class
	private static $_instance = null;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct ()
	{
		App_Log::log( 'APP_Gallery Class Initialized' );

		// Metabox
		include_once( 'admin/meta-boxes/class-app-meta-box-gallery.php' );
		
		add_action( 'save_post', array( &$this, 'save_post' ), 1, 2 );
	}
	
	// --------------------------------------------------------------------

	/**
	 * instance method
	 *
	 * @access public
	 */
	public static function instance()
	{
		if(!self::$_instance) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	// --------------------------------------------------------------------

	/**
	 * save_post method
	 *
	 * @access public
	 */
	public function save_post( $post_id, $post )
	{
		/*
		 * We need to verify this came from our screen and with proper authorization,
		* because the save_post action can be triggered at other times.
		*/
		
		// Check if our nonce is set.
		if ( ! isset( $_POST['app_meta_box_gallery_nonce'] ) ) {
			return;
		}
		
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['app_meta_box_gallery_nonce'], 'app_meta_box_gallery' ) ) {
			return;
		}
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 
				( 'post' == $_POST['post_type'] || 'page' == $_POST['post_type'] ) ) {		
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		
		// OK, we're authenticated: we need to find and save the data
		$imgs = $_POST['app_meta_box_gallery_metadata'];
				
		update_post_meta( $post_id, '_app_gallery_imgs', $imgs );
	}
	
}

endif;

/**
 * Create instance
 */
global $APP_Gallery;
if( class_exists( 'APP_Gallery' ) && ! $APP_Gallery ) {
	$APP_Gallery = APP_Gallery::instance();
}