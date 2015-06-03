<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Settings_Page' ) ) :

/**
 * APP_Settings_Page
 *
 * APP_Settings_Page
 *
 * @class 		APP_Settings_Page
 * @version		1.0.0
 * @package		application/includes/admin/settings/APP_Settings_Page
 * @category		Class
 * @author 		cbmarc
 */
abstract class APP_Settings_Page
{

	protected $id    = '';
	protected $label = '';

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		add_filter( 'app_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		//add_action( 'app_sections_' . $this->id, array( $this, 'output_sections' ) );
		add_action( 'app_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'app_settings_save_' . $this->id, array( $this, 'save' ) );
	}

	// --------------------------------------------------------------------

	/**
	 * add_settings_page method
	 *
	 * @access public
	 */
	public function add_settings_page( $pages )
	{
		$pages[ $this->id ] = $this->label;

		return $pages;
	}

	// --------------------------------------------------------------------

	/**
	 * get_settings method
	 *
	 * @access public
	 */
	public function get_settings()
	{
		return apply_filters( 'app_get_settings_' . $this->id, array() );
	}

	// --------------------------------------------------------------------

	/**
	 * get_sections method
	 *
	 * @access public
	 */
	public function get_sections()
	{
		return apply_filters( 'app_get_sections_' . $this->id, array() );
	}

	// --------------------------------------------------------------------

	/**
	 * output_sections method
	 *
	 * @access public
	 */
	public function output_sections()
	{
		global $current_section;

		$sections = $this->get_sections();

		if ( empty( $sections ) ) {
			return;
		}

		echo '<ul class="subsubsub">';

		$array_keys = array_keys( $sections );

		foreach ( $sections as $id => $label ) {
			echo '<li><a href="' . admin_url( 'admin.php?page=app-settings&tab=' . $this->id . '&section=' . sanitize_title( $id ) ) . '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . $label . '</a> ' . ( end( $array_keys ) == $id ? '' : '|' ) . ' </li>';
		}

		echo '</ul><br class="clear" />';
	}

	// --------------------------------------------------------------------

	/**
	 * output method
	 *
	 * @access public
	 */
	public function output()
	{
		$settings = $this->get_settings();

		APP_Admin_Settings::output_fields( $settings );
	}

	// --------------------------------------------------------------------

	/**
	 * save method
	 *
	 * @access public
	 */
	public function save()
	{
		global $current_section;

		$settings = $this->get_settings();
		APP_Admin_Settings::save_fields( $settings );

		if ( $current_section ) {
			do_action( 'app_update_options_' . $this->id . '_' . $current_section );
		}
	}
}

endif;
