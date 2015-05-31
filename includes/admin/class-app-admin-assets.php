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
* @author 		cbmarc
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
		wp_enqueue_style( 'app-style', APP()->plugin_url() . '/assets/css/style.css' );
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
		
		wp_enqueue_script( 'app-autoNumeric-script', APP()->plugin_url() . '/assets/lib/autoNumeric/autoNumeric.js', array( 'jquery' ) );
		wp_enqueue_script( 'app-default-script', APP()->plugin_url() . '/assets/js/default.js', array( 'jquery' ) );
		wp_enqueue_script( 'app-meta-boxes-property-script', APP()->plugin_url() . '/assets/js/admin/meta-boxes-property.js', array( 'jquery', 'jquery-ui-sortable' ) );
		
		wp_enqueue_script( 'maps-googleapis-com', 'http://maps.googleapis.com/maps/api/js' );
		
		if ( in_array( $screen->id, array( 'edit-property' ) ) ) {
			wp_enqueue_script( 'app_quick-edit', APP()->plugin_url() . '/assets/js/admin/quick-edit.js', array( 'jquery' ) );
		}
	}
}

endif;

return new APP_Admin_Assets();