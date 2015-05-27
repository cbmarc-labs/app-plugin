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
		add_filter( 'plugin_action_links_' . APP_PLUGIN_BASENAME, array( __CLASS__, 'plugin_action_links' ) );
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

		self::create_roles();

		// Update version
		delete_option( 'app_version' );
		add_option( 'app_version', APP()->version );
	}

	// --------------------------------------------------------------------

	/**
	 * create_roles method
	 *
	 * @access public
	 */
	public static function create_roles()
	{
		global $wp_roles;

		if ( ! class_exists( 'WP_Roles' ) ) {
			return;
		}

		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}

		$capabilities = self::get_core_capabilities();

		foreach ( $capabilities as $cap_group ) {
			foreach ( $cap_group as $cap ) {
				$wp_roles->add_cap( 'administrator', $cap );
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * get_core_capabilities method
	 *
	 * @access public
	 */
	 private static function get_core_capabilities()
	 {
		$capabilities = array();

		$capabilities['core'] = array(
			'manage_app'
		);

		$capability_types = array( 'property' );

		foreach ( $capability_types as $capability_type ) {

			$capabilities[ $capability_type ] = array(
				// Post type
				"edit_{$capability_type}",
				"read_{$capability_type}",
				"delete_{$capability_type}",
				"edit_{$capability_type}s",
				"edit_others_{$capability_type}s",
				"publish_{$capability_type}s",
				"read_private_{$capability_type}s",
				"delete_{$capability_type}s",
				"delete_private_{$capability_type}s",
				"delete_published_{$capability_type}s",
				"delete_others_{$capability_type}s",
				"edit_private_{$capability_type}s",
				"edit_published_{$capability_type}s",

				// Terms
				"manage_{$capability_type}_terms",
				"edit_{$capability_type}_terms",
				"delete_{$capability_type}_terms",
				"assign_{$capability_type}_terms"
			);
		}

		return $capabilities;
	}

	// --------------------------------------------------------------------

	/**
	 * remove_roles method
	 *
	 * @access public
	 */
	public static function remove_roles() {
		global $wp_roles;

		if ( ! class_exists( 'WP_Roles' ) ) {
			return;
		}

		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}

		$capabilities = self::get_core_capabilities();

		foreach ( $capabilities as $cap_group ) {
			foreach ( $cap_group as $cap ) {
				$wp_roles->remove_cap( 'administrator', $cap );
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * plugin_action_links method
	 *
	 * @access public
	 */
	public static function plugin_action_links( $links )
	{
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=app-settings' ) . '" title="' . esc_attr( __( 'View APP Settings', 'app' ) ) . '">' . __( 'Settings', 'app' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}
}

APP_Install::init();
