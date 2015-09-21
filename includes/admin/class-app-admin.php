<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Admin_Post_Types
 *
 * APP_Admin_Post_Types
 *
 * @class 		APP_Admin_Post_Types
 * @version		1.0.0
 * @package		application/includes/admin/APP_Admin_Post_Types
 * @category	Class
 * @author 		cbmarc
 */
class APP_Admin
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		add_action( 'init', array( $this, 'includes' ) );
	}

	// --------------------------------------------------------------------

	/**
	 * includes method
	 *
	 * @access public
	 */
	public function includes()
	{
		// Classes
		include_once( 'class-app-admin-post-types.php' );		
		include_once( 'class-app-admin-meta-boxes.php' );
		include_once( 'class-app-admin-settings.php' );
		
		if ( ! is_ajax() ) {
			include_once( 'class-app-admin-menus.php' );
			include_once( 'class-app-admin-assets.php' );
		}
	}
}

new APP_Admin();