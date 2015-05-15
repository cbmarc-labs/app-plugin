<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class APP_Shortcode_Property_Filter_Form
{
	// --------------------------------------------------------------------

	/**
	 * output method
	 *
	 * @access public
	 */
	public static function output()
	{
		App::load_template( 'property-form-filter' );
	}
}
