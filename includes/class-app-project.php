<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * APP_Project
 *
 * Clase APP_Project
 *
 * @class 		APP_Project
 * @version		1.0.0
 * @package		Application/includes/APP_Project
 * @category	Class
 * @author 		marc
 */
class APP_Project
{
	/**
	 * The project (post) ID.
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
	public function __construct( $project )
	{
		if ( is_numeric( $project ) ) {
			$this->id   = absint( $project );
			$this->post = get_post( $this->id );
		} elseif ( isset( $project->ID ) ) {
			$this->id   = absint( $project->ID );
			$this->post = $project;
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * exists method
	 *
	 * @access public
	 */
	public function exists()
	{
		return empty( $this->post ) ? false : true;
	}
}