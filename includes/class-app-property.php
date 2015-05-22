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
	
	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct( $property )
	{
		if ( is_numeric( $property ) ) {
			$this->id   = absint( $property );
			$this->post = get_post( $this->id );
		} elseif ( isset( $property->ID ) ) {
			$this->id   = absint( $property->ID );
			$this->post = $property;
		}
	}

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
}