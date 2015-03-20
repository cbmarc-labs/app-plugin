<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Metabox_Gallery' ) ) :

/**
 * APP_Metabox_Gallery
*
* Galeria de imagenes en un metabox.
* Thanks to: https://github.com/wp-plugins/featured-galleries
*
* @class 		APP_Metabox_Gallery
* @version		1.0.0
* @package		application/includes/admin/metaboxes/APP_Metabox_Gallery
* @category	Class
* @author 		cbmarc
*/
class APP_Metabox_Gallery
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
		App::log("APP_Metabox_Gallery Class Initialized");

		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( &$this, 'save_post' ), 1, 2 );
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
		wp_enqueue_style( 'app-metabox-gallery-style', APP_TEMPLATE_DIR . 'assets/css/app-metabox-gallery.css' );
		
		wp_enqueue_script( 'app-metabox-gallery-script', APP_TEMPLATE_DIR . 'assets/js/app-metabox-gallery.js', array( 'jquery' ) );	
	}

	// --------------------------------------------------------------------

	/**
	 * add_meta_boxes method
	 *
	 * @access public
	 */
	public function add_meta_boxes()
	{
		add_meta_box(
				'app_metabox_gallery',
				__( 'Galeria de imagenes' ), 
				array( &$this, 'meta_box_callback' )
		);
	}

	// --------------------------------------------------------------------

	/**
	 * meta_box_callback method
	 *
	 * @access public
	 */
	public function meta_box_callback()
	{
		$galleryHTML = '';		
		$galleryString = $this->get_gallery();
		
		if (!empty( $galleryString ))
		{
			$galleryArray = explode( ',', $galleryString );
		
			foreach ($galleryArray as &$id)
			{
				$galleryHTML .= '<img src="' . wp_get_attachment_url( $id ) . '">';
			}
		}
		?>

<input type="hidden" name="app_metabox_gallery_noncedata" id="app_metabox_gallery_noncedata" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
<input type="hidden" name="app_metabox_gallery_metadata" id="app_metabox_gallery_metadata" value="<?php echo $galleryString; ?>" />

<button class="button" id="app_metabox_gallery_select">Seleccionar</button>
<button class="button" id="app_metabox_gallery_removeall">Remover</button>

<div id="app_metabox_gallery_images"><?php echo $galleryHTML; ?></div>

		<?php
	}

	// --------------------------------------------------------------------

	/**
	 * get_post_gallery_ids method
	 *
	 * @access public
	 */
	public function get_gallery()
	{
		global $post;
		
		$ids = get_post_meta( $post->ID, 'app_metabox_gallery_metadata', 1);
		
		return $ids;

		//return explode( ',', $ids );
	}

	// --------------------------------------------------------------------

	/**
	 * save_post method
	 *
	 * @access public
	 */
	public function save_post($post_id, $post)
	{
		if ( empty( $_POST["app_metabox_gallery_noncedata"] ) )
		{
			return;
		}
		
		if ( !wp_verify_nonce( $_POST['app_metabox_gallery_noncedata'], plugin_basename(__FILE__) ) )
		{
			return;
		}
		
		// Verification of User
		if ( !current_user_can( 'edit_post', $post->ID ) )
		{
			return;
		}
		
		// OK, we're authenticated: we need to find and save the data
		$imagenes = $_POST['app_metabox_gallery_metadata'];
				
		if ( get_post_meta( $post->ID, 'app_metabox_gallery_metadata', FALSE ) )
		{
			update_post_meta( $post->ID, 'app_metabox_gallery_metadata', $imagenes );
		}
		else
		{
			add_post_meta( $post->ID, 'app_metabox_gallery_metadata', $imagenes );
		}
	}

} // end class APP_Metabox_Gallery

endif;

/**
 * Create instance
 */
global $APP_Metabox_Gallery;
if( class_exists( 'APP_Metabox_Gallery' ) && !$APP_Metabox_Gallery )
{
	$APP_Metabox_Gallery = APP_Metabox_Gallery::instance();
}