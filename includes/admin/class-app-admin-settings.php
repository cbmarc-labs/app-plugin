<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Admin_Settings' ) ) :

/**
 * APP_Admin_Settings
 *
 * APP_Admin_Settings
 *
 * @class 		APP_Admin_Menus
 * @version		1.0.0
 * @package		application/includes/admin/APP_Admin_Settings
 * @category	Class
 * @author 		cbmarc
 */
class APP_Admin_Settings
{
	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{	
		include( 'settings/class-app-settings-general.php' );
	}
}

endif;

return new APP_Admin_Settings();