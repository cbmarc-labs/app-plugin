<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function app_get_property( $the_property = false, $args = array() ) {
	return APP()->property->get_property( $the_property, $args );
}