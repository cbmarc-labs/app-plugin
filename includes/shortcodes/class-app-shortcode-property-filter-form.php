<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'APP_Gallery' ) ) :

/**
 * APP_Shortcode_Property_Filter_Form
 *
 * @class 		APP_Shortcode_Property_Filter_Form
 * @version		1.0.0
 * @package		Application/includes/APP_Shortcode_Property_Filter_Form
 * @category	Class
 * @author 		marc
 */
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
		App::load_template( 'property-form-filter.php' );
	}
}
