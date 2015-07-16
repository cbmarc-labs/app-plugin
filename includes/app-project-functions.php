<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function app_get_project( $the_project = false, $args = array() ) {
	return new APP_Project( $the_project );
}