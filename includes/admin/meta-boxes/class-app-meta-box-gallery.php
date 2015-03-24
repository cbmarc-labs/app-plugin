<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Meta_Box_Gallery' ) ) :

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
	// The single instance of the class
	private static $_instance;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		App::log("APP_Meta_Box_Gallery Class Initialized");

		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );
	}

	// --------------------------------------------------------------------

	/**
	 * getInstance method
	 *
	 * @access public
	 */
	public static function instance()
	{
		if ( is_null( self::$_instance ) )
		{
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}

	// --------------------------------------------------------------------

	/**
	 * admin_init method
	 *
	 * @access public
	 */
	public function admin_init()
	{
		wp_enqueue_style( 'app-meta-box-gallery-style', APP_TEMPLATE_DIR . 'assets/css/app-meta-box-gallery.css' );
		
		wp_enqueue_script( 'app-meta-box-gallery-script', APP_TEMPLATE_DIR . 'assets/js/app-meta-box-gallery.js', array( 'jquery' ) );
	}

	// --------------------------------------------------------------------

	/**
	 * add_meta_boxes method
	 *
	 * @access public
	 */
	public function add_meta_boxes()
	{
		$screens = array( 'post', 'page' );
		
		foreach ( $screens as $screen )
		{		
			add_meta_box(
				'app_meta_box_gallery',
				__( 'Galeria de imagenes', 'app_textdomain' ),
				array( &$this, 'meta_box_callback' ),
				$screen
			);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * meta_box_callback method
	 *
	 * @access public
	 */
	public function meta_box_callback( $post )
	{
		$galleryHTML = '';		
		$galleryString = get_post_meta( $post->ID, '_app_gallery_imgs', 1 );
		
		if( !empty( $galleryString ) )
		{
			$galleryArray = explode( ',', $galleryString );
		
			foreach( $galleryArray as &$id )
			{
				$galleryHTML .= '<img src="' . wp_get_attachment_url( $id ) . '">';
			}
		}
		
		include_once( 'views/html-meta-box-gallery.php' );
	}

} // end class APP_Meta_Box_Gallery

endif;

/**
 * Create instance
 */
global $APP_Meta_Box_Gallery;
if( class_exists( 'APP_Meta_Box_Gallery' ) && !$APP_Meta_Box_Gallery )
{
	$APP_Meta_Box_Gallery = APP_Meta_Box_Gallery::instance();
}