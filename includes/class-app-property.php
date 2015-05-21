<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Property
 *
 * Clase APP_Property
 *
 * @class 		APP_Property
 * @version		1.0.0
 * @package		Application/includes/APP_Property
 * @category	Class
 * @author 		cbmarc
 */
class APP_Property
{
	/**
	 * The property (post) ID.
	 *
	 * @var int
	 */
	public $id = 0;
	
	/**
	 * $post Stores post data
	 *
	 * @var $post WP_Post
	 */
	public $post = null;

	// --------------------------------------------------------------------
	
	/**
	 * get_gallery_attachment_ids method
	 *
	 * @access public
	 */
	public function get_gallery_attachment_ids()
	{
		print_r($this->post);
	}

	/**
	 * Get the product object
	 * @param  mixed $the_product
	 * @uses   WP_POST
	 * @return WP_Post|bool false on failure
	 */
	public function get_property( $the_property ) {
		if ( false === $the_property ) {
			$the_property = $GLOBALS['post'];
		} elseif ( is_numeric( $the_property ) ) {
			$the_property = get_post( $the_property );
		} elseif ( $the_property instanceof APP_Property ) {
			$the_property = get_post( $the_property->id );
		} elseif ( ! ( $the_property instanceof WP_Post ) ) {
			$the_property = false;
		}
		
		return $the_property;
	}
}