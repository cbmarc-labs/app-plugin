<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Metabox_Real_Estate' ) ) :

/**
 * APP_Metabox_Real_Estate
*
* @class 		APP_Metabox_Real_Estate
* @version		1.0.0
* @package		application/includes/admin/metaboxes/APP_Metabox_Real_Estate
* @category     Class
* @author 		cbmarc
*/
class APP_Metabox_Real_Estate
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
		App::log("APP_Metabox_Real_Estate Class Initialized");

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
	 * add_meta_boxes method
	 *
	 * @access public
	 */
	public function add_meta_boxes()
	{
		// The type of writing screen on which to show the edit screen section
		$screens = array( APP_Post_Type_Real_Estate::POST_TYPE );
		
		foreach ( $screens as $screen )
		{
			add_meta_box(
				'app_meta_box_real_estate',
				__( 'Dades' ), 
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
	public function meta_box_callback()
	{
		$fields = $this->get_form_values();
		$fields[ 'nonce' ] = wp_create_nonce( plugin_basename(__FILE__) );
		
		include_once( 'views/html-meta-box-real-estate.php' );
	}

	// --------------------------------------------------------------------

	/**
	 * get_form_values method
	 *
	 * @access public
	 */
	public function get_form_values()
	{
		global $post;
		
		$data[ 'rooms' ] = get_post_meta( $post->ID, 'app_meta_box_real_estate_rooms', 1 );
		
		return $data;
	}

	// --------------------------------------------------------------------

	/**
	 * save_post method
	 *
	 * @access public
	 */
	public function save_post($post_id, $post)
	{
		//TODO mirar perque no funciona aixo
		/*if ( APP_Post_Type_Real_Estate::POSTTYPE != $post->post_type )
		{
			return;
		}*/
		
		if ( empty( $_POST[ "app_meta_box_real_estate_noncedata" ] ) )
		{
			return;
		}
		
		if ( !wp_verify_nonce( $_POST[ 'app_meta_box_real_estate_noncedata' ], plugin_basename(__FILE__) ) )
		{
			return;
		}
		
		// Verification of User
		if ( !current_user_can( 'edit_post', $post_id ) )
		{
			return;
		}
		
		// OK, we're authenticated: we need to find and save the data
		$rooms = $_POST['app_meta_box_real_estate_rooms'];
				
		if ( get_post_meta( $post_id, 'app_meta_box_real_estate_rooms', FALSE ) )
		{
			update_post_meta( $post_id, 'app_meta_box_real_estate_rooms', $rooms );
		}
		else
		{
			add_post_meta( $post_id, 'app_meta_box_real_estate_rooms', $rooms );
		}
	}

} // end class APP_Metabox_Real_Estate

endif;

/**
 * Create instance
 */
global $APP_Metabox_Real_Estate;
if( class_exists( 'APP_Metabox_Real_Estate' ) && !$APP_Metabox_Real_Estate )
{
	$APP_Metabox_Real_Estate = APP_Metabox_Real_Estate::instance();
}