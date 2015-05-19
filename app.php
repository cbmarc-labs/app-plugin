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
define( 'APP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'APP_TEMPLATE_DIR', plugin_dir_url( __FILE__ ) );

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
	public $version = '1.0.3';

	// The single instance of the class
	private static $_instance = null;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{		
		$this->includes();
		
		add_action( 'init', array( &$this, 'init' ) );
		add_action( 'init', array( 'APP_Shortcodes', 'init' ) );
		add_action( 'init', array( 'APP_Lang', 'init' ) );
		add_action( 'init', array( 'APP_Log', 'init' ) );
		
		// Activate after plugins loaded
		add_action( 'plugins_loaded', array( &$this, 'plugins_loaded' ) );
		
		// Methods for activation/desactivation this plugin
		register_activation_hook( __FILE__, array( &$this, 'register_activation_hook' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'register_deactivation_hook' ) );
		
		// Error ?
		// register_uninstall_hook was called incorrectly...
		// https://wordpress.org/support/topic/register_uninstall_hook-was-called-incorrectly
		register_uninstall_hook( __FILE__, array( 'App', 'register_uninstall_hook' ) );
	}

	// --------------------------------------------------------------------

	/**
	 * includes method
	 *
	 * @access public
	 */
	public function includes()
	{
		include_once( 'includes/app-functions.php' );
		
		if ( $this->is_request( 'admin' ) ) {
			include_once( 'includes/admin/class-app-admin.php' );
		}

		if ( $this->is_request( 'frontend' ) ) {
			$this->frontend_includes();
		}
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
	}

	// --------------------------------------------------------------------

	/**
	 * init method
	 *
	 * @access public
	 */
	public function init()
	{
		// Bootstrap front-end integration
		if ( ! is_admin() && 
				! in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
			wp_enqueue_style( 'app-bootstrap-style', APP_TEMPLATE_DIR . 'assets/lib/bootstrap-3.3.4/css/bootstrap-prefixed.min.css' );
		}
		
		wp_enqueue_style( 'app-style', APP_TEMPLATE_DIR . 'assets/css/style.css' );
		
		wp_enqueue_script( 'app-autoNumeric-script', APP_TEMPLATE_DIR . 'assets/lib/autoNumeric/autoNumeric.js', array( 'jquery' ) );
		wp_enqueue_script( 'app-default-script', APP_TEMPLATE_DIR . 'assets/js/default.js', array( 'jquery' ) );
		
		wp_enqueue_script( 'maps-googleapis-com', 'http://maps.googleapis.com/maps/api/js' );
	}

	// --------------------------------------------------------------------
	
	/**
	 * load_template_part method
	 *
	 * @access public
	 */
	public static function load_template_part( $slug, $name = '' )
	{
		$template = '';
		
		// Get default slug-name.php
		if ( $name && file_exists( APP_PLUGIN_PATH . "templates/{$slug}-{$name}.php" ) ) {
			$template = APP_PLUGIN_PATH . "templates/{$slug}-{$name}.php";
		}
		
		// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/app/slug.php
		if ( ! $template ) {
			$template = locate_template( array( "{$slug}.php", APP_PLUGIN_PATH . "{$slug}.php" ) );
		}
		
		if ( $template ) {
			load_template( $template, false );
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * load_template method
	 *
	 * @access public
	 */
	public static function load_template(
			$template_name, $args = array(), $template_path = '', $default_path = '' )
	{
		if ( $args && is_array( $args ) ) {
			extract( $args );
		}
		
		// Look within passed path within the theme - this is priority
		$located = locate_template(
				array(
						trailingslashit( $template_path ) . $template_name,
						$template_name
				)
		);
		
		// Get default template
		if ( ! $located ) {
			$located = $default_path . $template_name;
		}
		
		//$located = wc_locate_template( $template_name, $template_path, $default_path );
		
		if ( ! file_exists( $located ) ) {
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
			return;
		}
		
		include( $located );
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
	 * plugin_setup method
	 *
	 * @access public
	 */
	public function plugins_loaded()
	{
		include_once( 'includes/class-app-autoloader.php' );		
		include_once( 'includes/class-app-post-types.php' );
		
		// Controllers
		include_once( 'includes/class-app-gallery.php' );
		
		add_action( 'app_daily_hook_event', array( &$this, 'app_daily_cron_event' ) );
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
	 * app_daily_cron_event method
	 *
	 * @access public
	 */
	public static function app_daily_cron_event()
	{
		App_Log::log( 'App Class : app_daily_cron_event' );
	}

	// --------------------------------------------------------------------
	
	/**
	 * register_activation_hook method
	 *
	 * @access public
	 */
	public static function register_activation_hook()
	{
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		
		$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
		check_admin_referer( "activate-plugin_{$plugin}" );
	
		# Uncomment the following line to see the function in action
		#exit( var_dump( $_GET ) );
		
		wp_schedule_event( time(), 'daily', 'app_daily_hook_event' );
	}

	// --------------------------------------------------------------------
	
	/**
	 * on_deactivation method
	 *
	 * @access public
	 */
	public static function register_deactivation_hook()
	{
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		
		$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
		check_admin_referer( "deactivate-plugin_{$plugin}" );
	
		# Uncomment the following line to see the function in action
		#exit( var_dump( $_GET ) );
		
		wp_clear_scheduled_hook( 'app_daily_hook_event' );
	}

	// --------------------------------------------------------------------
	
	/**
	 * on_uninstall method
	 * 
	 * thanks to: 
	 * http://wordpress.stackexchange.com/questions/25910/uninstall-activate-deactivate-a-plugin-typical-features-how-to
	 *
	 * @access public
	 */
	public static function register_uninstall_hook()
	{
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		
		check_admin_referer( 'bulk-plugins' );
	
		// Important: Check if the file is the one
		// that was registered during the uninstall hook.
		if ( __FILE__ != WP_UNINSTALL_PLUGIN ) {
			return;
		}
	
		# Uncomment the following line to see the function in action
		#exit( var_dump( $_GET ) );
		
		wp_clear_scheduled_hook( 'app_daily_hook_event' );
	}

} // end class App

endif;

/**
 * Create instance
 */
global $App;
if( class_exists( 'App' ) && !$App ) {
	$App = App::instance();
}