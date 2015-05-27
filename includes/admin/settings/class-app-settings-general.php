<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Settings_General' ) ) :

/**
 * APP_Settings_General
 *
 * APP_Settings_General
 *
 * @class 		APP_Settings_General
 * @version		1.0.0
 * @package		application/includes/admin/settings/APP_Settings_General
 * @category	Class
 * @author 		cbmarc
 */
class APP_Settings_General extends APP_Settings_Page
{
	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->id    = 'general';
		$this->label = __( 'General', 'app' );

		add_filter( 'app_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		add_action( 'app_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'app_settings_save_' . $this->id, array( $this, 'save' ) );
	}

	// --------------------------------------------------------------------

	/**
	 * get_settings method
	 *
	 * @access public
	 */
	public function get_settings()
	{
		$settings = apply_filters(
				'app_general_settings', 
				array(
						array(
								'title' => __( 'General Options', 'app' ),
								'type' => 'title',
								'desc' => '',
								'id' => 'general_options'
						),
						array(
								'title'    => __( 'Store Notice Text', 'app' ),
								'desc'     => '',
								'id'       => 'app_demo_store_notice',
								'default'  => __( 'This is a demo store for testing purposes &mdash; no orders shall be fulfilled.', 'app' ),
								'type'     => 'text',
								'css'      => 'min-width:300px;',
								'autoload' => false
						),
				)
		);

		return apply_filters( 'app_get_settings_' . $this->id, $settings );
	}

	// --------------------------------------------------------------------

	/**
	 * add_settings_page method
	 *
	 * @access public
	 */
	public function save()
	{
		$settings = $this->get_settings();

		APP_Admin_Settings::save_fields( $settings );
	}

}

endif;

return new APP_Settings_General();
