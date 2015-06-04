<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Install
 *
 * APP_Install
 *
 * @class 		APP_Install
 * @version		1.0.0
 * @package		application/includes/APP_Install
 * @category	Class
 * @author 		cbmarc
 */
class APP_Install
{

	// --------------------------------------------------------------------

	/**
	 * init method
	 *
	 * @access public
	 */
	public static function init()
	{
		add_action( 'admin_init', array( __CLASS__, 'check_version' ), 5 );
	}

	// --------------------------------------------------------------------

	/**
	 * check_version method
	 *
	 * @access public
	 */
	public static function check_version()
	{
		if ( ! defined( 'IFRAME_REQUEST' ) && ( get_option( 'app_version' ) != APP()->version ) ) {
			self::install();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * install method
	 *
	 * @access public
	 */
	public static function install()
	{
		if ( ! defined( 'APP_INSTALLING' ) ) {
			define( 'APP_INSTALLING', true );
		}
		
		self::create_cron_jobs();

		// Update version
		delete_option( 'app_version' );
		add_option( 'app_version', APP()->version );
	}

	// --------------------------------------------------------------------

	/**
	 * create_cron_jobs method
	 *
	 * @access public
	 */
	private static function create_cron_jobs()
	{
		wp_clear_scheduled_hook( 'app_cron_daily' );
		
		wp_schedule_event( time(), 'daily', 'app_cron_daily' );
	}
}

APP_Install::init();
