<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Meta_Box_Property' ) ) :

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
	// The single instance of the class
	private static $_instance;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct() {
		App::log( "APP_Meta_Box_Property Class Initialized" );

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
		if ( is_null( self::$_instance ) ) {
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
		$screens = array( APP_Post_Type_Property::POST_TYPE );
		
		foreach ( $screens as $screen ) {
			add_meta_box(
				'app_meta_box_property',
				App::lang( 'property_meta_box_title' ), 
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
		
		include_once( 'views/html-meta-box-property.php' );
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
		
		$data['rooms']	= get_post_meta( $post->ID, '_app_property_rooms', 1 );
		$data['price']	= get_post_meta( $post->ID, '_app_property_price', 1 );
		$data['m2']		= get_post_meta( $post->ID, '_app_property_m2', 1 );
		
		return $data;
	}

} // end class APP_Meta_Box_Property

endif;

/**
 * Create instance
 */
global $APP_Meta_Box_Property;
if( class_exists( 'APP_Meta_Box_Property' ) && ! $APP_Meta_Box_Property ) {
	$APP_Meta_Box_Property = APP_Meta_Box_Property::instance();
}