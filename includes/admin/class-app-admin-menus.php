<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Admin_Menus' ) ) :

/**
 * APP_Admin_Menus
 *
 * APP_Admin_Menus
 *
 * @class 		APP_Admin_Menus
 * @version		1.0.0
 * @package		application/includes/admin/APP_Admin_Menus
 * @category	Class
 * @author 		cbmarc
 */
class APP_Admin_Menus
{
	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'settings_menu' ), 50 );
	}

	// --------------------------------------------------------------------
	
	/**
	 * settings_menu method
	 *
	 * @access public
	 */
	public function settings_menu() {
		$settings_page = add_submenu_page(
				'edit.php?post_type=property',
				'Property Settings',
				'Settings',
				'manage_options',
				'app-settings',
				array( $this, 'settings_page' )
		);
	}

	// --------------------------------------------------------------------
	
	/**
	 * settings_page method
	 *
	 * @access public
	 */
	public function settings_page()
	{
		APP_Admin_Settings::output();
	}
}

endif;

return new APP_Admin_Menus();