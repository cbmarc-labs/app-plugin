<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class APP_Shortcode_Property_Latest
{
	// --------------------------------------------------------------------

	/**
	 * output method
	 *
	 * @access public
	 */
	public static function output()
	{
		app_get_template( 'single-property/latest.php' );
	}
}
