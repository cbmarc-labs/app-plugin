<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include_once( 'widgets/class-app-widget-property-filter-form.php' );
include_once( 'widgets/class-app-widget-property-type.php' );

// --------------------------------------------------------------------

/**
 * app_register_widgets method
 */
function app_register_widgets()
{
	register_widget( 'APP_Widget_Property_Filter_Form' );
	register_widget( 'APP_Widget_Property_Type' );
}
add_action( 'widgets_init', 'app_register_widgets' );
