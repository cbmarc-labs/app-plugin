<?php
/*
 * Plugin Name:       App
 * Description:       Wordpress general plugin
 * Version:           1.0.4
 * Author:            Marc Costa
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'App' ) ) :

define( 'APP_FILE', __FILE__ );
define( 'APP_TEMPLATE_PATH', plugin_dir_path( __FILE__ ) );
define( 'APP_TEMPLATE_DIR', plugin_dir_url( __FILE__ ) );

/**
 * Application
 *
 * Application
 *
 * @class 		App
 * @version		1.0.4
 * @package		App
 * @category	Class
 * @author 		marc
 */
final class App
{
	/**
	 * @var string
	 */
	public $version = '1.0.4';

	// The single instance of the class
	private static $_instance = null;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct() {		
		App::log( 'App Class Initialized' );
		
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
	 * plugin_setup method
	 *
	 * @access public
	 */
	public function plugins_loaded() {		
		// Controllers
		include_once( 'includes/admin/class-app-gallery.php' );
		
		add_action( 'app_daily_hook_event', array( &$this, 'app_daily_cron_event' ) );
	}

	// --------------------------------------------------------------------

	/**
	 * instance method
	 *
	 * @access public
	 */
	public static function instance() {
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
	public static function app_daily_cron_event() {
		App::log( 'App Class : app_daily_cron_event' );
	}

	// --------------------------------------------------------------------
	
	/**
	 * register_activation_hook method
	 *
	 * @access public
	 */
	public static function register_activation_hook() {
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
	public static function register_deactivation_hook() {
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
	public static function register_uninstall_hook() {
		if ( ! current_user_can( 'activate_plugins' ) )	{
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
	
	// --------------------------------------------------------------------
	
	/**
	 * log_app method
	 * 
	 * Example: App::log( "Test message" );
	 * 
	 * Change permissions on: wp-admin/error_log
	 * Change definition on wp-config.php: define('WP_DEBUG', true);
	 *
	 * @access public
	 */
	public static function log( $message ) {
		if ( WP_DEBUG === TRUE ) {
			if ( is_array( $message ) || is_object( $message ) ) {
				$message =  print_r( $message, TRUE );
			}
			
			error_log( date("d/m/Y H:i:s") . " - " . $message . "\n", 3, 'error_log' );
		}
	}

} // end class App

endif;

/**
 * Create instance
 */
global $App;
if ( class_exists( 'App' ) && !$App ) {
	$App = App::instance();
}
