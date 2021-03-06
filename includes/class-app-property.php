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
	 * get_related_ids method
	 *
	 * @access public
	 */
	public function get_related( $limit = 5 ) {
		global $wpdb;
	
		$limit = absint( $limit );
	
		// Related properties are found from taxonomies
		$type_array = array(0);
		$feature_array = array(0);
		$transaction_array = array(0);

		// Get types
		$terms = wp_get_post_terms( $this->id, 'property-type' );
		foreach ( $terms as $term ) {
			$type_array[] = $term->term_id;
		}
		
		// Get features
		$terms = wp_get_post_terms( $this->id, 'property-feature' );
		foreach ( $terms as $term ) {
			$feature_array[] = $term->term_id;
		}
		
		// Get transaction
		$terms = wp_get_post_terms( $this->id, 'property-transaction' );
		foreach ( $terms as $term ) {
			$transaction_array[] = $term->term_id;
		}
		
		// Don't bother if none are set
		if ( sizeof( $type_array ) == 1 && sizeof( $feature_array ) == 1 && 
				sizeof( $transaction_array ) == 1 ) {
			return array();
		}
		
		// Sanitize
		$type_array  = array_map( 'absint', $type_array );
		$feature_array  = array_map( 'absint', $feature_array );
		$transaction_array  = array_map( 'absint', $transaction_array );
		
		$myposts = get_posts(
			array(
				'numberposts'	=> $limit,
				'post_type'		=> 'property',
				'post__not_in'         => array( $this->id ),
				'tax_query'		=> array(
						'relation' => 'OR',
						array(
								'taxonomy'	=> 'property-type',
								'terms'		=> $type_array,
								'operator'	=> 'IN'
						),
						array(
								'taxonomy'	=> 'property-feature',
								'terms'		=> $feature_array,
								'operator'	=> 'IN'
						),
						array(
								'taxonomy'	=> 'property-transaction',
								'terms'		=> $transaction_array,
								'operator'	=> 'IN'
						)
				)
			)
		);
		
		$ids = array();
		foreach ($myposts as $mypost) {
			$ids[] = $mypost->ID;
		}
		
		return $ids; //implode( ",", $ids );
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

	// --------------------------------------------------------------------
	
	/**
	 * get_post_thumbnail method
	 *
	 * @access public
	 */
	public function get_post_thumbnail( $size = 'medium' )
	{
		$image_id = get_post_thumbnail_id( $this->id );
		
		if( $image_id ) {
			$image_attributes = wp_get_attachment_image_src( $image_id, $size );
			$image_src = $image_attributes[0];
		} else {
			$image_src = APP()->plugin_url() . '/assets/img/no_photo_available.jpg';
		}
		
		$thumbnail = '<img src="' . $image_src . '" style="width:100%;min-height:250px;" />';
		
		return $thumbnail;
	}

	// --------------------------------------------------------------------
	
	/**
	 * get_gallery_attachment_ids method
	 *
	 * @access public
	 */
	public function get_gallery_attachment_ids()
	{
		$image_ids = NULL;
		
		if( $thumbnail_id = get_post_thumbnail_id( $this->id ) ) {
			$image_ids = $thumbnail_id;
		}
		
		if( $image_gallery = get_post_meta( $this->id, '_property_image_gallery', 1 ) ) {
			$image_ids .=  ',' . $image_gallery;
		}
		
		return $image_ids; 
	}
}