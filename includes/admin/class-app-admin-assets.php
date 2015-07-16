<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Admin_Assets' ) ) :

/**
 * APP_Admin_Assets
*
* APP_Admin_Assets
*
* @class 		APP_Admin_Assets
* @version		1.0.0
* @package		application/includes/admin/APP_Admin_Assets
* @category		Class
* @author 		marc
*/
class APP_Admin_Assets
{

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	// --------------------------------------------------------------------

	/**
	 * includes method
	 *
	 * @access public
	 */
	public function admin_styles()
	{
		global $wp_scripts;
		
		wp_enqueue_style( 'app-admin-style', APP()->plugin_url() . '/assets/css/admin.css' );
	}

	// --------------------------------------------------------------------
	
	/**
	 * includes method
	 *
	 * @access public
	 */
	public function admin_scripts()
	{
		global $wp_query, $post, $current_user;
		
		$screen = get_current_screen();
		
		wp_enqueue_script( 'app-default-script', APP()->plugin_url() . '/assets/js/default.js', array( 'jquery' ) );
	}
}

endif;

return new APP_Admin_Assets();