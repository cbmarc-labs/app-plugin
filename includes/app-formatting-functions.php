<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Clean variables
 *
 * @param string $var
 * @return string
 */
function app_clean( $var )
{
	return sanitize_text_field( $var );
}
