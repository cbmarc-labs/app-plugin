<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Autoloader
 *
 * Clase APP_Autoloader
 *
 * @class 		APP_Autoloader
 * @version		1.0.0
 * @package		Application/includes/APP_Autoloader
 * @category	Class
 * @author 		cbmarc
 */
class APP_Autoloader
{

	/**
	 * Path to the includes directory
	 * @var string
	 */
	private $include_path = '';

	/**
	 * The Constructor
	 */
	public function __construct()
	{
		if ( function_exists( "__autoload" ) ) {
			spl_autoload_register( "__autoload" );
		}

		spl_autoload_register( array( $this, 'autoload' ) );

		$this->include_path = untrailingslashit( plugin_dir_path( APP_FILE ) ) . '/includes/';
	}

	// --------------------------------------------------------------------

	/**
	 * output method
	 *
	 * @access private
	 */
	private function get_file_name_from_class( $class )
	{
		return 'class-' . str_replace( '_', '-', strtolower( $class ) ) . '.php';
	}

	// --------------------------------------------------------------------

	/**
	 * load_file method
	 *
	 * @access private
	 */
	private function load_file( $path )
	{
		if ( $path && is_readable( $path ) ) {
			include_once( $path );
			
			return true;
		}
		
		return false;
	}

	// --------------------------------------------------------------------

	/**
	 * autoload method
	 *
	 * @access public
	 */
	public function autoload( $class )
	{
		$class = strtolower( $class );
		$file  = $this->get_file_name_from_class( $class );
		$path  = '';

		if ( strpos( $class, 'app_shortcode_' ) === 0 ) {
			$path = $this->include_path . 'shortcodes/';
		} elseif ( strpos( $class, 'app_meta_box' ) === 0 ) {
			$path = $this->include_path . 'admin/meta-boxes/';
		} elseif ( strpos( $class, 'app_admin' ) === 0 ) {
			$path = $this->include_path . 'admin/';
		}

		if ( empty( $path ) || ( ! $this->load_file( $path . $file ) && strpos( $class, 'app_' ) === 0 ) ) {
			$this->load_file( $this->include_path . $file );
		}
	}
}

new APP_Autoloader();
