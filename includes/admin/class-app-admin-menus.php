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
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );
	}

	// --------------------------------------------------------------------

	/**
	 * admin_menu method
	 *
	 * @access public
	 */
	public function admin_menu()
	{
		global $submenu;
		
		unset( $submenu['edit.php?post_type=message'][10] );
	}

}

endif;

return new APP_Admin_Menus();
