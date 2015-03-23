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
		App::log( 'APP_Gallery Class Initialized' );

		// Metabox del calendari per seleccionar dates aleatoriament
		include_once( 'meta-boxes/class-app-meta-box-gallery.php' );
		
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
		if(!self::$_instance)
		{
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
		// Verify if this is an auto save routine.
		if( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) )
		{
			return;
		}
		
		if ( empty( $_POST[ "app_meta_box_gallery_noncedata" ] ) )
		{
			return;
		}
		
		if ( !wp_verify_nonce( $_POST['app_meta_box_gallery_noncedata'], plugin_basename( APP_FILE ) ) )
		{
			return;
		}
		
		// Verification of User
		if ( !current_user_can( 'edit_post', $post->ID ) )
		{
			return;
		}
		
		// OK, we're authenticated: we need to find and save the data
		$imagenes = $_POST[ 'app_meta_box_gallery_metadata' ];
				
		if ( get_post_meta( $post->ID, 'app_meta_box_gallery_metadata', FALSE ) )
		{
			update_post_meta( $post->ID, 'app_meta_box_gallery_metadata', $imagenes );
		}
		else
		{
			add_post_meta( $post->ID, 'app_meta_box_gallery_metadata', $imagenes );
		}
	}
	
}

endif;

/**
 * Create instance
 */
global $APP_Gallery;
if( class_exists( 'APP_Gallery' ) && !$APP_Gallery )
{
	$APP_Gallery = APP_Gallery::instance();
}