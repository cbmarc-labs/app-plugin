<?php
/**
 * WC_Shortcodes class.
 *
 * @class 		WC_Shortcodes
 * @version		2.1.0
 * @package		WooCommerce/Classes
 * @category	Class
 * @author 		WooThemes
 */
class APP_Shortcodes {

	/**
	 * Init shortcodes
	 */
	public static function init() {
		// Define shortcodes
		$shortcodes = array(
			'product'	=> __CLASS__ . '::product',
		);

		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}

		// Alias for pre 2.1 compatibility
		//add_shortcode( 'woocommerce_messages', __CLASS__ . '::shop_messages' );
	}

	/**
	 * Shortcode Wrapper
	 *
	 * @param mixed $function
	 * @param array $atts (default: array())
	 * @return string
	 */
	public static function shortcode_wrapper( $function ) {
		ob_start();

		call_user_func( $function );

		return ob_get_clean();
	}

	/**
	 * Cart page shortcode.
	 *
	 * @return string
	 */
	public static function form_filter() {
		return self::shortcode_wrapper( array( 'APP_Shortcode_Property_Filter_Form', 'output' ) );
	}
}
