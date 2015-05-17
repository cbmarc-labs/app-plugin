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
		add_action( 'save_post', array( $this, 'save_post' ), 1, 2 );
		
		add_action( 'app_save_post', 'APP_Meta_Box_Property::save_post', 10, 2 );
		add_action( 'app_save_post', 'APP_Meta_Box_Property_Location::save_post', 10, 2 );
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
			
			add_meta_box(
				'app_meta_box_property_location',
				APP_Lang::_x( 'app_meta_box_property_location_title' ), 
				'APP_Meta_Box_Property_Location::output',
				$screen
			);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * add_meta_boxes method
	 *
	 * @access public
	 */
	public function save_post( $post_id, $post )
	{
		// $post_id and $post are required
		if ( empty( $post_id ) || empty( $post ) ) {
			return;
		}

		// Dont' save meta boxes for revisions or autosaves
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		// Verify that the nonce is valid.
		if ( empty( $_POST['app_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['app_meta_box_nonce'], 'app_meta_box_nonce' ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}

		// Check user has permission to edit
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		
		do_action( 'app_save_post', $post_id, $post );
	}
}

new APP_Admin_Meta_Boxes();