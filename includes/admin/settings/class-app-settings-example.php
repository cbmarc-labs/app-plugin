<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Settings_Example' ) ) :

/**
 * APP_Settings_Example
 *
 * APP_Settings_Example
 *
 * @class 		APP_Settings_Example
 * @version		1.0.0
 * @package		application/includes/admin/settings/APP_Settings_Example
 * @category	Class
 * @author 		cbmarc
 */
class APP_Settings_Example extends APP_Settings_Page
{
	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->id    = 'example';
		$this->label = __( 'Example', 'app' );

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
				'app_example_settings', 
				array(
						array(
								'title' => __( 'Example Options', 'app' ),
								'type' => 'title',
								'desc' => '',
								'id' => 'example_options'
						),
						array(
								'title'    => __( 'Store Notice Text', 'app' ),
								'desc'     => '',
								'id'       => 'app_example_field_a',
								'default'  => __( '', 'app' ),
								'type'     => 'text',
								'css'      => 'min-width:300px;',
								'autoload' => false
						),
						array( 'type' => 'sectionend' )
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

return new APP_Settings_Example();
