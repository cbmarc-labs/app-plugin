<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Admin_Meta_Boxes
 *
 * APP_Admin_Meta_Boxes
 *
 * @class 		APP_Admin_Meta_Boxes
 * @version		1.0.0
 * @package		application/includes/admin/APP_Admin_Meta_Boxes
 * @category	Class
 * @author 		cbmarc
 */
class APP_Admin_Meta_Boxes
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );
		add_action( 'save_post', 'APP_Meta_Box_Property::save_post', 1, 2 );
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
		$screens = array( 'property' );
		
		foreach ( $screens as $screen ) {
			add_meta_box(
				'app_meta_box_property',
				APP_Lang::_x( 'property_meta_box_title' ), 
				'APP_Meta_Box_Property::output',
				$screen
			);
		}
	}
}

new APP_Admin_Meta_Boxes();