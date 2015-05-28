<?php
/*
 * Plugin Name:       App
 * Description:       Wordpress general plugin
 * Version:           1.0.0
 * Author:            Marc Costa
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !class_exists( 'App' ) ) :

define( 'APP_FILE', __FILE__ );

/**
 * Application
 *
 * Application
 *
 * @class 		App
 * @version		1.0.3
 * @package		App
 * @category	Class
 * @author 		marc
 */
final class App
{
	/**
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * @var The single instance of the class
	 */
	private static $_instance = null;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		$this->define_constants();
		$this->includes();		
		$this->init_hooks();
	}

	// --------------------------------------------------------------------

	/**
	 * instance method
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
	 * define_constants method
	 *
	 * @access private
	 */
	private function define_constants()
	{
		$this->define( 'APP_PLUGIN_FILE', __FILE__ );
		$this->define( 'APP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
	}

	// --------------------------------------------------------------------
	
	/**
	 * define method
	 *
	 * @access private
	 */
	private function define( $name, $value )
	{
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * init_hooks method
	 *
	 * @access private
	 */
	private function init_hooks()
	{
		add_action( 'after_setup_theme', array( $this, 'include_template_functions' ), 11 );
		add_action( 'init', array( $this, 'init' ), 0 );
		add_action( 'init', array( 'APP_Shortcodes', 'init' ) );
	}

	// --------------------------------------------------------------------
	
	/**
	 * include_template_functions method
	 *
	 * @access private
	 */
	public function include_template_functions()
	{
		include_once( 'includes/app-template-functions.php' );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * init method
	 *
	 * @access public
	 */
	public function init()
	{
	}

	// --------------------------------------------------------------------

	/**
	 * plugin_url method
	 *
	 * @access public
	 */
	public function plugin_url()
	{
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	// --------------------------------------------------------------------

	/**
	 * plugin_path method
	 *
	 * @access public
	 */
	public function plugin_path()
	{
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	// --------------------------------------------------------------------

	/**
	 * template_path method
	 *
	 * @access public
	 */
	public function template_path()
	{
		return apply_filters( 'app_template_path', 'app/' );
	}

	// --------------------------------------------------------------------
	
	/**
	 * ajax_url method
	 *
	 * @access public
	 */
	public function ajax_url()
	{
		return admin_url( 'admin-ajax.php' );
	}

	// --------------------------------------------------------------------
	
	/**
	 * is_request method
	 *
	 * @access public
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'cron' :
				return defined( 'DOING_CRON' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	// --------------------------------------------------------------------

	/**
	 * includes method
	 *
	 * @access public
	 */
	public function includes()
	{
		include_once( 'includes/class-app-autoloader.php' );
		include_once( 'includes/app-core-functions.php' );
		include_once( 'includes/class-app-lang.php' );
		include_once( 'includes/class-app-log.php' );
		include_once( 'includes/app-widget-functions.php' );
		include_once( 'includes/class-app-install.php' );
		
		if ( $this->is_request( 'admin' ) ) {
			include_once( 'includes/admin/class-app-admin.php' );
		}
		
		if ( $this->is_request( 'ajax' ) ) {
			include_once( 'includes/class-app-ajax.php' );
		}

		if ( $this->is_request( 'frontend' ) ) {
			$this->frontend_includes();
		}
		
		include( 'includes/class-app-query.php' );

		include_once( 'includes/class-app-post-types.php' );
		include_once( 'includes/class-app-property.php' );
	}

	// --------------------------------------------------------------------
	
	/**
	 * includes method
	 *
	 * @access public
	 */
	public function frontend_includes()
	{
		include_once( 'includes/class-app-template-loader.php' );
		include_once( 'includes/class-app-assets.php' );
		include_once( 'includes/class-app-shortcodes.php' );
		
		// Walkers
		include_once( 'includes/walkers/mc-walker-taxonomy-dropdown.php' );
	}

} // end class App

endif;

function APP() {
	return App::instance();
}

// Global for backwards compatibility.
$GLOBALS['app'] = APP();